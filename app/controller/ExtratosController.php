<?php
class ExtratosController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		switch ($_GET["var2"]) {

			case 'Transferir':
			switch ($_POST["banco"]) {
				case 'Itau':
				$this->cadastrarDebitoItau();
				break;

				case 'BB':

				break;
			}
			break;

			case 'BB':

			//print_r($_POST);
			
			if ($_POST["id"]!="false") {
				$dados = $this->pegaDados("extratos",$_POST["id"]);
			}else{
				$dados = $this->pegaDadosLinha($_POST["data"]);
			}

			$this->BB($dados["doc"],$dados["mes"]);
			
			break;

			case 'Itau':

			if ($_POST["id"]!="false") {
				$dados = $this->pegaDados("extratos",$_POST["id"]);
			}else{
				$dados = $this->pegaDadosLinha($_POST["data"]);
			}

			$this->Itau($dados["doc"],$dados["mes"]);
			
			break;

			case 'FormatRs':
			echo number_format($_POST["number"],2,",",".");
			break;

			case "Upload":
			$this->Upload();
			break;

			case 'Visualizar':
			if (isset($_POST["mes"]) && isset($_POST["ano"])) {
				$this->listAll();
			}elseif ($_GET["var3"]) {
				$this->lists();
				$this->pegaId("extratos", $_GET["var3"]);
			}

			$this->listas();
			
			$this->view->render ( 'extratos/visualizar' );
			break;

			case "Deletar":
			$dados = $this->pegaDados("extratos",$_GET["var3"]);
			if (unlink("app/public/documentos/extratos/".$dados["doc"])) {
				$this->deletar($_GET["var3"], "extratos");
			}
			break;

			case "Adicionar":

			if (isset($_POST["banco"])) {
				foreach ($_POST as $key => $value) {
					if (strstr($key,"_name") || strstr($key,"_status") || strstr($key,"_count")) {
						unset($_POST[$key]);
					}
				}
				$this->cadastrar("extratos");
			}

			$this->bancos();
			$this->view->render ( 'extratos/novo' );
			break;

			default:
			$this->listar();
			$this->view->render ( 'extratos/index' );
			break;
		}
	}


	protected function listas(){

		$this->pagamentos = array(0=>"A Vista", 1=>"Boleto", 5=>"Debito em Conta");
		$this->tipos = array(0=>"Administrativo",1=>"Fixa",2=>"Imposto",3=>"Juros/Taxas",7=>"Escritório");

		$this->pagamentos();

		$this->fornecedores();
		
		$this->tipos();
	}

	private function fornecedores(){

		$query = "SELECT * FROM fornecedores ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->fornecedor) && $linha["id"]==$this->view->fornecedor) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->fornecedores = $lista;
	}

	protected function tipos(){
		$tipos = $this->tipos;
		$html = "<p>";
		$i=0;
		foreach ($tipos as $key => $value) {
			if (isset($this->view->tipo) && $this->view->tipo==$key) {
				$html .= '<input type="radio" id="tp'.$key.'" class="tipo" name="tipo" value="'.$key.'" checked/><label for="tp'.$key.'">'.$value.'</label>';
			}else{
				$html .= '<input type="radio" id="tp'.$key.'" class="tipo" name="tipo" value="'.$key.'" /><label for="tp'.$key.'">'.$value.'</label>';
			}
			if ($i==3) {
				$html.="</p><br><p>";
			}
			$i++;
		}
		$html.="</p>";

		$this->view->tipos = $html;
	}
	

	private function pagamentos(){
		$pagamentos = $this->pagamentos;

		foreach ($pagamentos as $key => $value) {

			
			if (isset($this->view->pagamento) && $key==$this->view->pagamento) {
				$lista .='<input id="pg'.$key.'" type="radio" name="pagamento" class="formaDePagamento" value="'.$key.'" checked/><label for="pg'.$key.'">'.$value.'</label>';
			}else{
				$lista .='<input id="pg'.$key.'" type="radio" name="pagamento" class="formaDePagamento" value="'.$key.'" /><label for="pg'.$key.'">'.$value.'</label>';
			}
		}


		$this->view->pagamentos = $lista;
	}



	protected function lists(){
		$dados = $this->pegaDados("extratos",$_GET["var3"]);
		$banco = $this->pegaDados("bancos",$dados["banco"]);
		$this->view->lists = '
		<fieldset id="'.$banco["abv"].'" style="width: 80%; min-width: 200px; margin:0px auto; padding: 10px;">
			<div class="widget lista'.$banco["abv"].'" banco="'.$banco["abv"].'">
				<div class="title exp topo'.$banco["abv"].'">
					<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Extrato '.$banco["nome"].' <span class="load'.$banco["abv"].'"></span></h6>
					<span class="refresh" banco="'.$banco["abv"].'"  style="margin:0px auto;display:block;cursor:pointer; float:right;"><img src="'.Folder.'images/icons/color/arrow-circle-double.png" style="margin:10px;"></span>
				</div>
				<div class="extrato'.$banco["abv"].' extratos">
				</div>
			</div>
		</fieldset>';
	}

	protected function listAll(){
		$query = "SELECT * FROM extratos WHERE mes='".$_POST["mes"]."' AND ano='".$_POST["ano"]."' ORDER BY banco";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_assoc($sql)){
			$banco = $this->pegaDados("bancos",$linha["banco"]);
			$this->view->lists .= '
			<fieldset id="'.$banco["abv"].'" style="width: 45%; min-width: 200px; margin:0px auto; padding: 10px; float:left;">
				<div class="widget lista'.$banco["abv"].'" banco="'.$banco["abv"].'">
					<div class="title exp topo'.$banco["abv"].'">
						<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
						<h6>Extrato '.$banco["nome"].' <span class="load'.$banco["abv"].'"></span></h6>
						<span class="refresh" banco="'.$banco["abv"].'" style="margin:0px auto;display:block;cursor:pointer; float:right;"><img src="'.Folder.'images/icons/color/arrow-circle-double.png" style="margin:10px;"></span>
					</div>
					<div class="extrato'.$banco["abv"].' extratos">
					</div>
				</div>
			</fieldset>';
		}
	}

	private function bancos(){

		$query = "SELECT * FROM bancos WHERE agencia!='0' AND conta!='0' ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_assoc($sql)){

			if (isset($this->view->banco) && $linha["id"]==$this->view->banco) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->bancos = $lista;
	}

	protected function Itau($file,$mes){

		//pasta
		$pasta = "app/public/documentos/extratos/";


		//Nome do arquivo:
		$nome = $file;//"773be5242ee598d700bf26b55b610c29.txt";

		//$nome = "extrato.txt";


		$arquivo = $pasta.$nome;




		//ABRE O ARQUIVO TXT
		$ponteiro = fopen ($arquivo,"r");

		$this->linha=1;
		//L� O ARQUIVO AT� CHEGAR AO FIM
		//$old = "$('.Transferir').click(function(){  var banco = $(this).attr('banco');  var dados = $(this).attr('dados'); var elemento = $(this);$.post('".URL."Extratos/Transferir', { banco:banco, dados: dados },function(data){ alert(data);					elemento.fadeOut(500); });});";
		$html = "<script type='text/javascript'>
		$(function(){ 
			$('.listaItau .exp').next().hide(); 

			$('.listaItau .exp').click(function(){ 
				$(this).next().slideToggle(500); 
			});

$('.TransferirItau').click(function(){

	var d = $(this).attr('dados');
	var dados = d.split(';');

	var data = dados[0].replace('/', '-');
	var data = data.replace('/', '-');

	$('#data').val(data);
	$('#vencimento').val(data);
	$('#titulo').val(dados[1]);
	$('#valor').val((parseFloat(dados[2]))*(-1));


	$('#bgDark').fadeIn('slow',function(){
		$('.Transferir').show(1000);
	});
				//alert();
});

}); </script>";

while (!feof ($ponteiro)) {

	$linha = fgets($ponteiro,4096);

	$dados = explode(";", $linha);
	$data = explode("/", $dados[0]);
	if ($data[1]==$mes) {
		$this->lerLinhaItau($dados);
	}

	$this->linha++;
}

$saldoMensal = $this->operacoesItau["credito"]["total"] - $this->operacoesItau["debito"]["total"];

$html .= '
<div class="title exp" style="border:1px solid #CCC;">
	<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
	<h6>Operações de Crédito ( Total: R$ <span id="itauCredTotal" value="'.($this->operacoesItau["credito"]["total"]).'">'.number_format($this->operacoesItau["credito"]["total"],2,",",".").'</span> )</h6>
</div>
<div class="dados" style="display:none;">';
	unset($this->operacoesItau["credito"]["total"]);
	foreach ($this->operacoesItau["credito"] as $key => $value) {
		$html .= str_replace("{index}", ($key+1), $value);
	} 

	$html .= '
</div>
<br>
<div class="title exp" style="border:1px solid #CCC;">
	<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
	<h6>Operações de Débito ( Total: R$ <span id="itauDebTotal" value="'.$this->operacoesItau["debito"]["total"].'">'.number_format($this->operacoesItau["debito"]["total"],2,",",".").'</span> )</h6>
</div>
<div class="dados" style="display:none;">';
	unset($this->operacoesItau["debito"]["total"]);
	foreach ($this->operacoesItau["debito"] as $key => $value) {

		$html .= str_replace("{index}", ($key+1), $value);

	}

	$html .= '</div>
	<br>
	<div class="title exp" style="border:1px solid #CCC;">
		<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
		<h6>Saldo Mensal : R$ <span style="color:'.($saldoMensal>=0 ? 'green' : 'red' ).';" >'.number_format($saldoMensal,2,",",".").'</span> </h6>
	</div>
</div><br>';

fclose ($ponteiro);

echo $html;

}

protected function lerLinhaItau($dados){

		// $dados[0] = DATA
		// $dados[1] = DESCRICAO
		// $dados[2] = VALOR
	$dados[2] = str_replace(",", ".", $dados[2]);
	if ($dados[0]!="") {
		if ($dados[2]<0) {
			/// OPERACOES DE DEBITO

			$valor = $dados[2]*-1;

			if(strstr($dados[1], "CH COMPENSADO")){

				$txt = explode(" ", preg_replace('/\s\s+/', ' ', $dados[1]));

				$cheque = $this->GetCheque(end($txt));
				if ($cheque["pago"]=="0") {
					$Transferir = true;
				}else{
					$Transferir = false;
				}
				$detalhe.= "
				<div>
					<li style='list-style: none;  padding:5px;' >
						<span>Número do Cheque: ".(int) end($txt)."</span><br>
						<span>Depositante: ".$cheque["quem"]."</span><br>
						<span>Data do Cheque: ".$cheque["data"]."</span><br>
						<span>Data para Compensação: ".$cheque["para"]."</span><br>
						<span>Data de Depósito: ".$dados[0]."</span><br>
					</li>
				</div>";
			}elseif(strstr($dados[1], "PAGAMENTO CHEQUE")){

				$txt = explode(" ", preg_replace('/\s\s+/', ' ', $dados[1]));

				$cheque = $this->GetCheque(end($txt));
				if ($cheque["pago"]=="0") {
					$Transferir = true;
				}else{
					$Transferir = false;
				}
				$detalhe.= "
				<div>
					<li style='list-style: none;  padding:5px;' >
						<span>Número do Cheque: ".(int) end($txt)."</span><br>
						<span>Depositante: ".$cheque["quem"]."</span><br>
						<span>Data do Cheque: ".$cheque["data"]."</span><br>
						<span>Data para Compensação: ".$cheque["para"]."</span><br>
						<span>Data de Depósito: ".$dados[0]."</span><br>
					</li>
				</div>";
			}elseif(strstr($dados[1], "TED")){

				if (strstr($dados[1], "TAR ")){
					$Transferir = $this->verificaDespesas($dados[0],$valor);
				}else{
					$Transferir = false;
				}

			}elseif(strstr($dados[1], "CEI") && strstr($dados[1], "EST")){

				$Transferir = false;

			}elseif(strstr($dados[1], "ESTORNO")){

				$Transferir = false;

			}else{
				$Transferir = $this->verificaDespesas($dados[0],$valor);
			}




			$this->operacoesItau["debito"]["total"] += (float) $valor;


			$html = "
			<ul>
				<li style='list-style: none;  padding:5px;' class='exp'>
					<h6 style='font-size:12px;'>";
						if ($Transferir) {
							$html .="
							<span title='Transferir' class='tipS TransferirItau' style='cursor:pointer;' dados='".implode($dados, ";")."' banco='Itau'>
								<img src='". Folder."images/icons/dark/alert2.png' width='20' style='padding-right:10px;'/> 
							</span>";
						}else{
							$html .="
							<span title='Transferir' class='tipS' dados='".implode($dados, ";")."' banco='Itau'>
								<img src='". Folder."images/icons/dark/check.png' style='padding-right:10px;'/> 
							</span>";
						}
						$html .="<span style='font-size:12px;'>
						{index}.: $dados[0] | ".ucwords(strtolower(utf8_encode($dados[1])))." ( <span style='color:red;'> R$ ".number_format( floatval($valor) ,2,",",".")." </span> )</h6>
					</span>
				</li>
				$detalhe
			</ul>";
			$this->operacoesItau["debito"][] = $html;
		}else{
			/// OPERACOES DE CREDITO

			$this->operacoesItau["credito"]["total"] += (float)$dados[2];

			$dados[1] = str_replace("CEI", "Depósito em Conta", $dados[1]);

			$html = "
			<ul>
				<li style='list-style: none;  padding:5px;' class='exp'>
					<h6 style='font-size:12px;'>
						{index}.: $dados[0] | ".ucwords(strtolower(($dados[1])))." ( <span style='color:green;'> R$ ".number_format((float)$dados[2],2,",",".")." </span> )</h6>
					</li>
				</ul>";
				$this->operacoesItau["credito"][] = $html;
			}
		}

	}


	protected function verificaDespesas($data,$valor){

		$valor = str_replace(".00", "", $valor);
		$valor = str_replace(",00", "", $valor);
		$valor = str_replace(",", ".", $valor);
		$valor = (float) $valor;

		$query = "SELECT * FROM despesas WHERE (vencimento='".str_replace("/", "-", $data)."' AND valor LIKE ('".$valor."%')) OR (data='".str_replace("/", "-", $data)."' AND valor LIKE ('".$valor."%'))";
		$sql = $this->model->query($query);
		$despesas = mysql_fetch_assoc($sql);


		$querys = "SELECT * FROM compras WHERE (vencimento='".str_replace("/", "-", $data)."' AND valor LIKE ('".$valor."%')) OR (data='".str_replace("/", "-", $data)."' AND valor LIKE ('".$valor."%'))";
		$sqls = $this->model->query($querys);
		$compras = mysql_fetch_assoc($sqls);

		$queryx = "SELECT * FROM vencimentos WHERE vencimento='".str_replace("/", "-", $data)."' AND valor LIKE ('".$valor."%')";
		$sqlx = $this->model->query($queryx);
		$vencimentos = mysql_fetch_assoc($sqlx);

		//echo $query."<br>";

		if ($despesas["id"]>0 || $compras["id"]>0 || $vencimentos["id"]>0) {
			//echo $query." ---- ".$querys." ---- ".$queryx."<br>";
			return false;
		}else{
			//echo $query." ---- ".$querys." ---- ".$queryx."<br>";
			return true;
		}
	}



	protected function BB($file,$mes){

		//pasta
		$pasta = "app/public/documentos/extratos/";


		//Nome do arquivo:
		$nome = $file;
		//$nome = "extrato.txt";


		$arquivo = $pasta.$nome;




		//ABRE O ARQUIVO TXT
		$ponteiro = fopen ($arquivo,"r");

		$this->linha=1;
		//L� O ARQUIVO AT� CHEGAR AO FIM

		while (!feof ($ponteiro)) {

			$linha = fgets($ponteiro,4096);

			$dados = explode(";", $linha);

			if (substr($dados[3],2,2)==$mes || $dados[8]=="000" || $dados[8]=="999") {
				$this->lerLinhaBB($dados);
			}

			$this->linha++;
		}

		$html = "<script type='text/javascript'>
		$(function(){ 
			$('.listaBB .exp').next().hide(); 

			$('.listaBB .exp').click(function(){ 
				$(this).next().slideToggle(500); 
			}); 


$('.TransferirBB').click(function(){
	
	var d = $(this).attr('dados');
	var dados = d.split(';');

	var valor = parseInt(dados[10].substring(0,15))+'.'+parseInt(dados[10].substring(15));

	var data = dados[3].substring(0,2)+'-'+dados[3].substring(2,4)+'-'+dados[3].substring(4);


	$('#data').val(data);
	$('#vencimento').val(data);
	$('#titulo').val(dados[9]+' - '+dados[12]);
	$('#valor').val(parseFloat(valor));


	$('#bgDark').fadeIn('slow',function(){
		$('.Transferir').show(1000);
	});
				//alert();
});
}); 
</script><div>";

$saldoMensal = $this->operacoesBB["credito"]["total"] - $this->operacoesBB["debito"]["total"];

$html .= $this->operacoesBB["saldoInicial"].'
<br>
<div class="title exp" style="border:1px solid #CCC;">
	<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
	<h6>Operações de Crédito ( Total: R$ <span id="bbCredTotal" value="'.$this->operacoesBB["credito"]["total"].'">'.number_format($this->operacoesBB["credito"]["total"],2,",",".").' </span>)</h6>
</div>
<div class="dados" style="display:none;">';
	unset($this->operacoesBB["credito"]["total"]);
	foreach ($this->operacoesBB["credito"] as $key => $value) {
		$html .= str_replace("{index}", ($key+1), $value);
	}

	$html .= '
</div>
<br>
<div class="title exp" style="border:1px solid #CCC;">
	<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
	<h6>Operações de Débito ( Total: R$ <span id="bbDebTotal" value="'.$this->operacoesBB["debito"]["total"].'">'.number_format($this->operacoesBB["debito"]["total"],2,",",".").'</span>)</h6>
</div>
<div class="dados" style="display:none;">';
	unset($this->operacoesBB["debito"]["total"]);
	foreach ($this->operacoesBB["debito"] as $key => $value) {
		$html .= str_replace("{index}", ($key+1), $value);
	}

	$html .= '</div></div><br>'.$this->operacoesBB["saldoFinal"].'
	<br>
	<div class="title exp" style="border:1px solid #CCC;">
		<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
		<h6>Saldo Mensal : R$ <span style="color:'.($saldoMensal>=0 ? 'green' : 'red' ).';" >'.number_format($saldoMensal,2,",",".").'</span> </h6>
	</div>
</div><br>';

fclose ($ponteiro);

echo $html;

}

protected function lerLinhaBB($dados){

		// $dados[0] = agencia
		// $dados[1] = conta
		// $dados[2] = nada
		// $dados[3] = data (ddmmyyyy)
		// $dados[4] = repete data (ddmmyyyy)
		// $dados[5] = Agencia de Origem
		// $dados[8] = codigo da operacao
		// $dados[9] = Title
		// $dados[10] = Valor
		// $dados[11] = Tipo
		// $dados[12] = Detalhes
	$valor = substr($dados[10],0,15).".".substr($dados[10],15);

	if ($dados[11]=="C" && $dados[8]!="999" && $dados[8]!="000") {
		$this->operacoesBB["credito"][] = $this->creditoBB($dados);
	}elseif ($dados[11]=="D" && $dados[8]!="999" && $dados[8]!="000") {
		$this->operacoesBB["debito"][] = $this->debitoBB($dados);
	}elseif ($dados[8]=="000") {
		if ($dados[11]=="D") {
			$html.='
			<div class="title" style="border:1px solid #CCC;">
				<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
				<h6>Saldo Inical do Mês ( <span style="color:red;"> R$ -'.number_format((float)$valor,2,",",".").'</span> )</h6>
			</div>
			';
		}else{
			$html.='
			<div class="title" style="border:1px solid #CCC;">
				<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
				<h6>Saldo Inical do Mês ( <span style="color:green;"> R$ '.number_format((float)$valor,2,",",".").'</span> )</h6>
			</div>
			';
		}
		$this->operacoesBB["saldoInicial"] = $html;
	}elseif ($dados[8]=="999") {
		if ($dados[11]=="D") {
			$html.='
			<div class="title" style="border:1px solid #CCC;">
				<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
				<h6>Saldo Final do Mês ( <span style="color:red;"> R$ -'.number_format((float)$valor,2,",",".").'</span> )</h6>
			</div>
			';
		}else{
			$html.='
			<div class="title" style="border:1px solid #CCC;">
				<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
				<h6>Saldo Final do Mês ( <span style="color:green;"> R$ '.number_format((float)$valor,2,",",".").'</span> )</h6>
			</div>
			';
		}

		$this->operacoesBB["saldoFinal"]=$html;
	}
}

protected function creditoBB($dados) {
		// $dados[0] = agencia
		// $dados[1] = conta
		// $dados[2] = nada
		// $dados[3] = data (ddmmyyyy)
		// $dados[4] = repete data (ddmmyyyy)
		// $dados[5] = Agencia de Origem
		// $dados[8] = codigo da operacao
		// $dados[9] = Title
		// $dados[10] = Valor
		// $dados[11] = Tipo
		// $dados[12] = Detalhes
	$data = substr($dados[3],0,2)."/".substr($dados[3],2,2)."/".substr($dados[3],4);
	$valor = substr($dados[10],0,15).".".substr($dados[10],15);

	$this->operacoesBB["credito"]["total"] += $valor;

	$html.="
	<ul>
		<li style='list-style: none;  padding:5px;' class='exp'>
			<h6 style='font-size:12px;'>
				{index}.: $data | ".ucwords(strtolower(utf8_encode($dados[9])))." ( <span style='color:green;'>R$ ".number_format((float)$valor,2,",",".")."</span>)</h6>
			</li>
			<div>";
				switch ($dados[8]) {


					case 830:
					$html.= "
					<li style='list-style: none;  padding:5px;' >
						<span>Agência de Origem: ".$dados[5]." - ".$this->getAgenciaBB($dados[5])."</span><br>
						<span>Número do Depósito: ".(int) $dados[7]."</span><br>
						<span>Data: ".$data."</span><br>
					</li>";
					break;

					case 870:
					$html.= "
					<li style='list-style: none;  padding:5px;' >
						<span>Agência de Origem: ".$dados[5]." - ".$this->getAgenciaBB($dados[5])."</span><br>
						<span>Data: ".$data."</span><br>
						<span>Descrição: ".$dados[12]."</span><br>
					</li>";
					break;

					default:

					break;
				}


				$html.="
			</div>
		</ul>
		";

		return $html;
	}

	protected function debitoBB($dados) {

		// $dados[0] = agencia
		// $dados[1] = conta
		// $dados[2] = nada
		// $dados[3] = data (ddmmyyyy)
		// $dados[4] = repete data (ddmmyyyy)
		// $dados[5] = Agencia de Origem
		// $dados[7] = numero de titulo ou numero do cheque
		// $dados[8] = codigo da operacao
		// $dados[9] = Title
		// $dados[10] = Valor
		// $dados[11] = Tipo
		// $dados[12] = Detalhes
		$data = substr($dados[3],0,2)."/".substr($dados[3],2,2)."/".substr($dados[3],4);
		$valor = substr($dados[10],0,15).".".substr($dados[10],15);

		$this->operacoesBB["debito"]["total"] += $valor;



		switch ($dados[8]) {


			case 102:
			$cheque = $this->GetCheque($dados[7]);

			if ($cheque["pago"]=="0") {
				$Transferir = true;
			}else{
				$Transferir = false;
			}

			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Agência de Depósito: ".$dados[5]." - ".$this->getAgenciaBB((int) $dados[5])."</span><br>
				<span>Número do Cheque: ".(int) $dados[7]."</span><br>
				<span>Depositante: ".$cheque["quem"]."</span><br>
				<span>Data do Cheque: ".$cheque["data"]."</span><br>
				<span>Data para Compensação: ".$cheque["para"]."</span><br>
				<span>Data de Depósito: ".$data."</span><br>
			</li>";
			break;

			case 103:
			$cheque = $this->GetCheque($dados[7]);

			if ($cheque["pago"]=="0") {
				$Transferir = true;
			}else{
				$Transferir = false;
			}
			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Agência de Depósito: ".$dados[5]." - ".$this->getAgenciaBB((int) $dados[5])."</span><br>
				<span>Número do Cheque: ".(int) $dados[7]."</span><br>
				<span>Depositante: ".$cheque["quem"]."</span><br>
				<span>Data do Cheque: ".$cheque["data"]."</span><br>
				<span>Data para Compensação: ".$cheque["para"]."</span><br>
				<span>Data de Depósito: ".$data."</span><br>
			</li>";
			break;

			case 436:

			$Transferir = $this->verificaDespesas($data,$valor);

			$detalhes = explode("-", $dados[12]);
			$telefone = "(".substr($detalhes[0],0,2).") ".substr($detalhes[0],3,4)."-".substr($detalhes[0],7,4);
			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Data: ".$data."</span><br>
				<span>Valor do Crédito: R$ ".number_format((float)$valor,2,",",".")."</span><br>
				<span>Celular: ".$telefone."</span><br>
				<span>Descrição: Recarga de Celular, ".$detalhes[1]."</span><br>
			</li>";
			break;


			case 470:

			$Transferir = false;

			$detalhes = explode("-", $dados[12]);
			$dadosConta = explode(" ", preg_replace('/\s\s+/', ' ', $detalhes[0]));

			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Data: ".$data."</span><br>
				<span>Agência: ".$dadosConta[1]." - ".$this->getAgenciaBB($dadosConta[1])."</span><br>
				<span>Conta: ".$dadosConta[2]."-".substr($detalhes[1],0,1)."</span><br>
				<span>Titular da Conta: ".substr($detalhes[1],1)."</span><br>
			</li>";
			break;

			case 280:

			$Transferir = false;

			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Data: ".$data."</span><br>
				<span>Agência de Origem: ".$dados[5]." - ".$this->getAgenciaBB($dados[5])."</span><br>
				<span>Número do Depósito Estornado: ".(int) $dados[7]."</span><br>
			</li>";
			break;


			case 438:

			$Transferir = false;

			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Data: ".$data."</span><br>
				<span>Descrição: ".$dados[12]."</span><br>
			</li>";
			break;

			case 393:

			$Transferir = false;

			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Data: ".$data."</span><br>
				<span>Descrição: ".$dados[12]."</span><br>
			</li>";
			break;


			case "031":

			$Transferir = false;


			$detalhes = explode(":", $dados[12]);
			$dadosConta = explode(" ", $detalhes[0]);

			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Agência do Saque: ".$dados[5]." - ".$this->getAgenciaBB($dados[5])."</span><br>
				<span>Data de Saque: ".$data."</span><br>
				<span>Hora do Saque: ".$dadosConta[1].":".substr($detalhes[1],0,2)."hs</span><br>
				<span>Endereço do Terminal: ".substr($detalhes[1],2)."</span><br>
			</li>";
			break;

			case 331:

			$Transferir = false;

			$detalhes = explode(":", $dados[12]);
			$dadosConta = explode(" ", $detalhes[0]);

			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Agência do Saque: ".$dados[5]." - ".$this->getAgenciaBB($dados[5])."</span><br>
				<span>Data de Saque: ".$data."</span><br>
				<span>Hora do Saque: ".$dadosConta[1].":".substr($detalhes[1],0,2)."hs</span><br>
				<span>Endereço do Terminal: ".substr($detalhes[1],2)."</span><br>
			</li>";
			break;

			default:

			$Transferir = $this->verificaDespesas($data,$valor);

			$txt.= "
			<li style='list-style: none;  padding:5px;' >
				<span>Data: ".$data."</span><br>
				<span>Descrição: ".$dados[12]."</span><br>
			</li>";
			break;

		}
		$html.="
		<ul>
			<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:12px;'>";
					if ($Transferir) {
						$html .="
						<span title='Transferir' class='tipS TransferirBB' dados='".implode($dados, ";")."' banco='Itau'>
							<img src='". Folder."images/icons/dark/alert2.png' width='20' style='padding-right:10px;'/> 
						</span>";
					}else{
						$html .="
						<span title='Transferir' class='tipS' dados='".implode($dados, ";")."' banco='Itau'>
							<img src='". Folder."images/icons/dark/check.png' style='padding-right:10px;'/> 
						</span>";
					}
					$html .="{index}.: $data | ".ucwords(strtolower(utf8_encode($dados[9])))." ( <span style='color:red;'>R$ ".number_format((float)$valor,2,",",".")."</span> )</h6>
				</li>
				<div>
					".$txt."
				</div>
			</ul>
			";

			return $html;
		}



		protected function listar() {



			$lista="";

			$query = "SELECT * FROM extratos";

			$valores_db = $this->model->query($query);
			$letra = "B";


			while ($linha = mysql_fetch_assoc($valores_db)) {

				if ($letra=="B") {
					$letra="A";
				}elseif ($letra=="A") {
					$letra = "B";
				}

				$banco = $this->pegaDados("bancos",$linha["banco"]);

				$lista.= "

				<tr class='grade".$letra."'>
					<td class='center'>".$linha["id"]."</td>
					<td class='center'>".$linha["mes"]."</td>
					<td class='center'>".$linha["ano"]."</td>
					<td class='center'>".utf8_encode($banco["nome"])."</td>
					<td class='center'>".($banco["agencia"]=="0"? "" : $banco["agencia"])."</td>
					<td class='center'>".($banco["conta"]=="0"? "" : $banco["conta"])."</td>
					<td class='actBtns'>
						<a href='".URL.$_GET["var1"]."/Visualizar/".$linha["id"]."' title='Visualizar' class='tipS'>
							<img src='". Folder."images/icons/control/16/advertising.png' alt='' /> 
						</a> 
						<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
							<img src='". Folder."images/icons/control/16/clear.png' alt='' />
						</a>
					</td>
				</tr>";

			}

			$this->view->lista = $lista;

		}




		protected function Upload(){

			if (is_uploaded_file($_FILES["file"]['tmp_name'])) {

				$targetDir = "app/public/documentos/extratos/";


				$explode = explode(".", $_FILES["file"]['name']);
				$tipo = end($explode);

				if ($tipo=="txt" || $tipo=="bbt") {

					$arquivo = md5($_FILES["file"]['name'].date("d-m-Y/h:i")).".".$tipo;
					if (move_uploaded_file($_FILES['file']['tmp_name'], $targetDir.$arquivo)) {
						ob_end_clean();
						echo $arquivo;
					}
				}else{
					echo "Formato de Arquivo Invalido! <br>Atualize a página e reenvie um arquivo de extenção<br> .bbt (Banco do Brasil) ou .txt (Itau)!";
				}
			}else{
				echo "Nenhum Arquivo Enviado!";
			}

		}
		protected function GetCheque($numero){
			$valores_db = $this->model->query("SELECT * FROM `cheques` WHERE numero=".$numero);
			$dados = mysql_fetch_assoc($valores_db);


			return $dados;
		}

		protected function getAgenciaBB($agencia){
			if ($this->agencias[$agencia]==false) {
				$url = "http://www37.bb.com.br/portalbb/redeAtendimento/GetAgenciasPorPrefixo.bbx?str=".trim($agencia);
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$resultado = curl_exec($ch);
				curl_close($ch);

				$data = explode("<br/>", $resultado);
				foreach ($data as $key => $value) {
					if (strstr($value,"Cidade / UF")) {
						$label = $key." => ".$value;
						$span = explode(":", $label);
						$cidade = $span[1];
					}

				}
				$this->agencias[$agencia] = $cidade;
			}
			return $this->agencias[$agencia];
		}


		protected function getAgenciaItau($agencia){
			$vars = array(
				"texto1" => "6987",
				"campo1" => "agencia",

				"tipo"=>"",
				"Submit2"=>"Pesquisar"
				);
			$url = "http://www.buscabanco.com.br/AgenciasLista.asp";


			foreach($vars as $keys=>$values) { $fields_string .= $keys.'='.($values).'&'; }
			rtrim($fields_string, '&');

	  ////EXECUTA A URL
			$ch = curl_init($url);
			curl_setopt($ch,CURLOPT_POST, count($vars));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


	  /// $resultado  PEGA O XML COM OS RESULTADOS DA BUSCA
			$resultado = curl_exec($ch);

			$html = explode('<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bordamenu">', $resultado);
			curl_close($ch);

			foreach ($html as $key => $value) {
				if (strstr(utf8_encode($value),"ITAÚ UNIBANCO S.A")) {
					$data = explode(":", $value);

					echo str_replace("Telefone", "", $data[10]);
				}
			}
		}


		protected function pegaDadosLinha($data){

			$query = "SELECT id FROM bancos WHERE abv='".$_POST["banco"]."'";
			$sql = $this->model->query($query);
			$linha = mysql_fetch_assoc($sql);

			$date = explode("-", $data);

			$querys = "SELECT * FROM extratos WHERE mes='".$date[0]."' AND ano='".$date[1]."' AND banco='".$linha["id"]."'";
		//echo $querys;
			$sqls = $this->model->query($querys);
			$linhas = mysql_fetch_assoc($sqls);

			return $linhas;
		}


		protected function cadastrarDebitoItau(){

		// $dados[0] = DATA
		// $dados[1] = DESCRICAO
		// $dados[2] = VALOR

			$dados = explode(";", $_POST["dados"]);
			foreach ($_POST as $key => $value) {
				unset($_POST[$key]);
			}
			$_POST["data"] = str_replace("/", "-", $dados[0]);
			$_POST["vencimento"] = str_replace("/", "-", $dados[0]);
			$_POST["titulo"] = number_format($dados[2]);
			$_POST["valor"] = number_format($dados[2]);
		}

	}