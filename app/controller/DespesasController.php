<?php
class DespesasController extends Controller {

	public $pagamentos;
	public $tipos;

	function __construct() {
		parent::__construct ();

		$this->pagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cartão","Debito em Conta");
		$this->tipos = array("Administrativo","Fixa","Imposto","Juros/Taxas","Combustivel","Viagem","Mecânico","Escritório");
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

			if (isset($_POST["titulo"])) {
				$this->adicionar();
			}
			$this->listas();
			$this->view->render ( 'despesas/novo' );	
			break;

			case "Editar":

			if (isset($_POST["titulo"])) {

				$this->editarDespesa();
			}

			$this->pegaId("despesas",$_GET["var3"]);

			$this->listas();

			$this->view->render ( 'despesas/novo' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "despesas");

			$this->listar();

				//Futuramente criar lista com os despesas
				//$this->view->pdf = $this->pdf(); bandeiras
			$this->view->render ( 'despesas/index' );
			break;



			case "Relatorio":

			$this->relatorio();

			$this->view->render ( 'despesas/relatorio' );
			break;

			default:

			$this->listar();
			$this->view->render ( 'despesas/index' );
			break;
		}
	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA despesas NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {

		$pagamentos = $this->pagamentos;
		$tipos = $this->tipos;

		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM despesas";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}


			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".($linha["id"])."</td>
			<td class='center'>".htmlspecialchars($linha["titulo"])."</td>
			<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
			<td class='center'>".$linha["data"]."</td>
			<td class='center'>".$tipos[$linha["tipo"]]."</td>
			<td class='center'>".$pagamentos[$linha["pagamento"]]."</td>";


			if ($linha["vencimento"]!="") {
				$lista.= "
				<td class='center'>".$linha["vencimento"]."</td>";
			}else{
				$lista.= "
				<td class='center'>".$linha["data"]."</td>";
			}

			$lista.= "
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
			<img src='". Folder."images/icons/control/16/pencil.png' alt='' /> 
			</a> 
			<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
			<img src='". Folder."images/icons/control/16/clear.png' alt='' />
			</a>
			</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}

	protected function listas(){

		if ($this->view->pagamento==2) {
			$this->pegaCheque($this->view->cheque);
		}


		$this->listaCheques();
		$this->pagamentos();
		$this->fornecedores();
		$this->bancos();
		$this->bancos(true);
		$this->cartoes();
		
		$this->tipos();
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

	private function bancos($deb = false){

		if ($deb) {
			
			$query = "SELECT * FROM bancos WHERE agencia!='0' AND conta!='0' AND agencia!='' AND conta!=''  ORDER BY nome";

			$sql = $this->model->query($query);

			while($linha = mysql_fetch_array($sql)){

				if (isset($this->view->banco) && $linha["id"]==$this->view->banco) {
					$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
				}else{
					$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
				}
			}
			$this->view->bancosD = $lista;
		}else{

			$query = "SELECT * FROM bancos ORDER BY nome";

			$sql = $this->model->query($query);

			while($linha = mysql_fetch_array($sql)){

				if (isset($this->view->banco) && $linha["id"]==$this->view->banco) {
					$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
				}else{
					$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
				}
			}
			$this->view->bancos = $lista;
		}

		
	}

	private function cartoes(){

		$query = "SELECT * FROM cartao ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->cartao) && $linha["id"]==$this->view->cartao) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->cartoes = $lista;
	}


	private function listaCheques(){

		$lista="";
		if (isset($this->view->chqcliente) && $this->view->pagamento==3) {
			$cheques = explode(",", $this->view->chqcliente);
			foreach ($cheques as $value) {
				$dadosCheque = $this->pegaDados("chqclientes",$value);
				$lista .='
				<fieldset style="border:1px #ccc solid; padding-left:10px;margin:10px;">
				<input type="checkbox" name="chqcliente[]" value="'.$value.'" id="'.$value.'" checked/> <label for="'.$value.'">Valor: <b>R$ '.number_format($dadosCheque["valor"],2,",",".").' </b> / Numero: <b>'.$dadosCheque["numero"].'</b> / Compensacao: <b>'.$dadosCheque["para"].'</b></label>
				</fieldset>';
			}

		}else{
			$query = "SELECT id,numero,para,valor FROM chqclientes WHERE quem='' ORDER BY valor ASC";

			$sql = $this->model->query($query);

			while($linha = mysql_fetch_array($sql)){

				$lista .='
				<fieldset style="border:1px #ccc solid; padding-left:10px;margin:10px;">
				<input type="checkbox" name="chqcliente[]" class="chqclientes" valor="'.$linha["valor"].'" value="'.$linha["id"].'" id="'.$linha["id"].'"/> <label for="'.$linha["id"].'">Valor: <b>R$ '.number_format($linha["valor"],2,",",".").' </b> / Numero: <b>'.$linha["numero"].'</b> / Compensacao: <b>'.$linha["para"].'</b></label>
				</fieldset>';
			}
		}



		$this->view->listaCheques = $lista;
	}


































































	protected function adicionar(){

		switch ($_POST["pagamento"]) {
					////// AVISTA
			case '0':
			unset($_POST["pago"]);
			$this->pagamentoAvista();
			break;

					//// BOLETO
			case '1':

			$this->pagamentoBoleto();

			break;

			//// CHEQUE DA EMPRESA
			case '2':
			unset($_POST["pago"]);

			$this->pagamentoCheque();


			break;
			//// CHEQUE DE CLIENTE
			case '3':
			unset($_POST["pago"]);
			$this->pagamentoChqCliente();

			break;
			//// CARTAO
			case '4':
			unset($_POST["pago"]);
			$this->pagamentoCartao();
			break;

			//// DEBITO
			case '5':
			unset($_POST["pago"]);
			$this->pagamentoDebito();
			break;

		}
	}

	protected function pagamentoAvista(){
		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);
		$this->cadastrar("despesas");
	}

	protected function pagamentoBoleto(){


		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);


		$_POST["cedente"] = $_POST["titulo"];


		$tipo = $_POST["tipo"];
		$titulo = $_POST["titulo"];
		$pagamento = $_POST["pagamento"];
		$data = $_POST["data"];
		$valor = $_POST["valor"];
		$vencimento = $_POST["vencimento"];

		unset($_POST["titulo"]);
		unset($_POST["data"]);
		unset($_POST["tipo"]);
		unset($_POST["pagamento"]);
		$_POST["fornecedor"] = 0;

		$this->cadastrar("vencimentos");

		$_POST["boleto"] = $this->pegaBoleto();
		$_POST["vencimento"] = $vencimento;
		$_POST["titulo"] = $titulo;
		$_POST["pagamento"] = $pagamento;
		$_POST["valor"] = $valor;
		$_POST["data"] = $data;
		$_POST["tipo"] = $tipo;

		$this->cadastrar("despesas");




	}

	protected function pagamentoCheque(){

		if ($_POST["tipoChq"]=="1") {

			if ($this->VerificaRelacao()) {
				$query = "SELECT * FROM cheques WHERE numero=".$_POST["numero"];
				$sql = $this->model->query($query);
				$linha = mysql_fetch_assoc($sql);

				$tipo = $_POST["tipo"];
				$titulo = $_POST["titulo"];
				$pagamento = $_POST["pagamento"];
				$valor = $_POST["valor"];
				$data = $_POST["data"];
				$cheque = $_POST["numero"];
				$vencimento = $linha["para"];

				unset($_POST["tipo"]);
				unset($_POST["banco"]);
				unset($_POST["para"]);
				unset($_POST["numero"]);
				unset($_POST["tipoChq"]);
				unset($_POST["vencimento"]);
				unset($_POST["cartao"]);
				unset($_POST["parcelas"]);
				unset($_POST["pagamento"]);


				$_POST["vencimento"] = $vencimento;
				$_POST["cheque"] = $cheque;
				$_POST["titulo"] = $titulo;
				$_POST["pagamento"] = $pagamento;
				$_POST["valor"] = $valor;
				$_POST["data"] = $data;
				$_POST["tipo"] = $tipo;

				$this->cadastrar("despesas");
			}else{
				$this->view->erro = "Cheque de numero ".$_POST["numero"]." n&atilde;o relacionado ainda!";
			}

		}else{

			unset($_POST["tipoChq"]);


			$_POST["numero"] = preg_replace("/[^0-9]/", "",$_POST["numero"]);


			$_POST["quem"] = $_POST["titulo"];

			$tipo = $_POST["tipo"];
			$titulo = $_POST["titulo"];
			$pagamento = $_POST["pagamento"];
			$valor = $_POST["valor"];
			$data = $_POST["data"];
			$cheque = $_POST["numero"];
			$vencimento = $_POST["para"];


			unset($_POST["tipo"]);
			unset($_POST["vencimento"]);
			unset($_POST["cartao"]);
			unset($_POST["parcelas"]);
			unset($_POST["pagamento"]);
			unset($_POST["titulo"]);

			$this->cadastrar("cheques");

			$_POST["titulo"] = $titulo;
			$_POST["vencimento"] = $vencimento;
			$_POST["cheque"] = $cheque;
			$_POST["titulo"] = $titulo;
			$_POST["pagamento"] = $pagamento;
			$_POST["valor"] = $valor;
			$_POST["data"] = $data;
			$_POST["tipo"] = $tipo;

			$this->cadastrar("despesas");
		}


	}

	protected function pagamentoChqCliente(){
		unset($_POST["oldPagamento"]);
		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);



		foreach ($_POST["chqcliente"] as $value) {
			$query = "UPDATE chqclientes SET quem = '".$_POST["titulo"]."' WHERE id=".$value;
			$sql = $this->model->query($query);
		}

		$_POST["chqcliente"] = implode(",", $_POST["chqcliente"]);
		$this->cadastrar("despesas");
	}

	protected function pagamentoCartao(){
		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		$_POST["valor"] = $_POST["valor"] / $_POST["parcelas"];
		$_POST["valor"] = number_format($_POST["valor"],2);
		$cartao = $this->pegaDados("cartao",$_POST["cartao"]);
		$mes = date("m");
		$ano = date("Y");
		$dataMes = explode("-", $_POST["data"]);
		if ($cartao["fechamento"] < $dataMes[0]) {
			$mes++;
		}else{
			$mes = number_format($mes,0);
		}
		for ($i=0; $i < $_POST["parcelas"]; $i++) {
			if ($i==0) {

			}else{
				$mes++;	
			}

			if ($mes>12) {
				$ano++;
				$mes-=12;
			}
			if ($mes<10) {
				$mes = "0".$mes;
			}
			$_POST["vencimento"]=$cartao["vencimento"]."-".$mes."-".$ano; 
			$this->cadastrar("despesas",false);
		}
		$this->view->erro = "Cadastro Feito com Sucesso!";

	}

	protected function pagamentoDebito(){
		
		$_POST["vencimento"] = $_POST["data"];
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);

		$this->cadastrar("despesas");

	}






































































	protected function editarDespesa(){


		switch ($_POST["oldPagamento"]) {

			//// BOLETO
			case '1':
			$oldDados = $this->pegaDados("despesas",$_GET["var3"]);
			$this->model->query("DELETE FROM vencimentos WHERE id=".$oldDados["boleto"]);

			break;

			//// CHEQUE DA EMPRESA
			case '2':

			$oldDados = $this->pegaDados("despesas",$_GET["var3"]);
			$this->model->query("DELETE FROM cheques WHERE numero=".$oldDados["cheque"]);


			break;

			//// CHEQUE DE CLIENTE
			case '3':
			$oldDados = $this->pegaDados("despesas",$_GET["var3"]);
			$cheques = explode(",", $oldDados["chqcliente"]);
			foreach ($cheques as $value) {
				$this->model->query("UPDATE chqclientes SET quem='' WHERE id=".$value);
			}

			break;
			//// CARTAO
			case '4':
			$oldDados = $this->pegaDados("despesas",$_GET["var3"]);
			$query = "SELECT id FROM despesas WHERE titulo='".$oldDados["titulo"]."' AND valor='".$oldDados["valor"]."' AND pagamento='".$oldDados["pagamento"]."' AND parcelas='".$oldDados["parcelas"]."'";
			$sql = $this->model->query($query);
			while ($linha=mysql_fetch_assoc($sql)) {
				$this->model->query("DELETE FROM despesas WHERE id=".$linha["id"]);	
			}

			switch ($_POST["pagamento"]) {
				////// AVISTA
				case '0':
				$this->pagamentoAvista();
				break;

				//// BOLETO
				case '1':

				$this->pagamentoBoleto();

				break;

				//// CHEQUE DA EMPRESA
				case '2':

				$this->pagamentoCheque();


				break;
				//// CHEQUE DE CLIENTE
				case '3':
				$this->pagamentoChqCliente();

				break;
				//// CARTAO
				case '4':
				$this->pagamentoCartao();
				break;

				////// AVISTA
				case '5':
				$this->pagamentoDebito();
				break;

			}

			header("Location: ".URL.$_GET["var1"]);

			break;

		}


		switch ($_POST["pagamento"]) {
					////// AVISTA
			case '0':

			$this->EditarPagamentoAvista();
			break;

					//// BOLETO
			case '1':

			$this->EditarPagamentoBoleto();

			break;

			//// CHEQUE DA EMPRESA
			case '2':

			if ($this->VerificaRelacaoEditar()) {
				$this->EditarPagamentoCheque();
			}else{
				$this->view->erro = "Cheque de numero ".$_POST["numero"]." n&atilde;o relacionado ainda ou j&aacute; relacionado em outra despesa!";
			}

			break;
			//// CHEQUE DE CLIENTE
			case '3':
			$this->EditarPagamentoChqCliente();

			break;
			//// CARTAO
			case '4':
			$this->EditarPagamentoCartao();
			break;
			//// CARTAO
			case '5':
			$this->EditarPagamentoDebito();
			break;

		}


	}


	protected function EditarPagamentoAvista(){


		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);
		unset($_POST["oldPagamento"]);

		$this->editar($_GET["var3"],"despesas");
	}

	protected function EditarPagamentoDebito(){


		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);
		unset($_POST["oldPagamento"]);

		$this->editar($_GET["var3"],"despesas");
	}
	

	protected function EditarPagamentoBoleto(){

		unset($_POST["oldPagamento"]);

		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);
		$_POST["cedente"] = $_POST["titulo"];


		$tipo = $_POST["tipo"];
		$titulo = $_POST["titulo"];
		$pagamento = $_POST["pagamento"];
		$data = $_POST["data"];
		$valor = $_POST["valor"];
		$vencimento = $_POST["vencimento"];

		unset($_POST["titulo"]);
		unset($_POST["data"]);
		unset($_POST["tipo"]);
		unset($_POST["pagamento"]);
		$_POST["fornecedor"] = 0;

		$this->cadastrar("vencimentos");

		$_POST["boleto"] = $this->pegaBoleto();
		$_POST["vencimento"] = $vencimento;
		$_POST["titulo"] = $titulo;
		$_POST["pagamento"] = $pagamento;
		$_POST["valor"] = $valor;
		$_POST["data"] = $data;
		$_POST["tipo"] = $tipo;

		$this->editar($_GET["var3"],"despesas");

	}

	protected function EditarPagamentoCheque(){

		unset($_POST["oldPagamento"]);


		unset($_POST["tipoChq"]);


		$_POST["quem"] = $_POST["titulo"];

		$titulo = $_POST["titulo"];
		$pagamento = $_POST["pagamento"];
		$valor = $_POST["valor"];
		$data = $_POST["data"];
		$cheque = $_POST["numero"];
		$vencimento = $_POST["para"];
		$tipo = $_POST["tipo"];



		unset($_POST["vencimento"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);
		unset($_POST["pagamento"]);
		unset($_POST["titulo"]);

		$this->cadastrar("cheques");

		$_POST["tipo"] = $tipo;
		$_POST["titulo"] = $titulo;
		$_POST["vencimento"] = $vencimento;
		$_POST["cheque"] = $cheque;
		$_POST["titulo"] = $titulo;
		$_POST["pagamento"] = $pagamento;
		$_POST["valor"] = $valor;
		$_POST["data"] = $data;

		$this->editar($_GET["var3"],"despesas");



	}

	protected function EditarPagamentoChqCliente(){
		unset($_POST["oldPagamento"]);
		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);



		foreach ($_POST["chqcliente"] as $value) {
			$query = "UPDATE chqclientes SET quem = '".$_POST["titulo"]."' WHERE id=".$value;
			$sql = $this->model->query($query);
		}

		$_POST["chqcliente"] = implode(",", $_POST["chqcliente"]);
		$this->editar($_GET["var3"],"despesas");
	}

	protected function EditarPagamentoCartao(){
		unset($_POST["oldPagamento"]);
		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		$_POST["valor"] = $_POST["valor"] / $_POST["parcelas"];
		$_POST["valor"] = number_format($_POST["valor"],2);
		$cartao = $this->pegaDados("cartao",$_POST["cartao"]);
		$mes = date("m");
		$ano = date("Y");
		$dataMes = explode("-", $_POST["data"]);
		if ($cartao["fechamento"] < $dataMes[0]) {
			$mes++;
		}else{
			$mes = number_format($mes,0);
		}
		for ($i=0; $i < $_POST["parcelas"]; $i++) {
			if ($i==0) {

			}else{
				$mes++;	
			}

			if ($mes>12) {
				$ano++;
				$mes-=12;
			}
			if ($mes<10) {
				$mes = "0".$mes;
			}
			$_POST["vencimento"]=$cartao["vencimento"]."-".$mes."-".$ano; 
			$this->cadastrar("despesas",false);
		}

		$this->model->query("DELETE FROM despesas WHERE id=".$_GET["var3"]);
		header("Location: ".URL.$_GET["var1"]);
		$this->view->erro = "Cadastro Feito com Sucesso!";

	}


	protected function VerificaRelacao(){

		$query = "SELECT * FROM cheques WHERE numero=".$_POST["numero"];
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);

		if ($linha["numero"]==true) {
			$query = "SELECT id FROM despesas WHERE cheque=".$_POST["numero"];
			$sql = $this->model->query($query);
			$linhax = mysql_fetch_assoc($sql);
			if ($linhax["id"]) {
				return false;
			}else{
				return $linha;
			}
		}else{
			return false;
		}

	}

	protected function VerificaRelacaoEditar(){

		$query = "SELECT id FROM despesas WHERE cheque=".$_POST["numero"];
		$sql = $this->model->query($query);
		$linhax = mysql_fetch_assoc($sql);
		if ($linhax["id"]) {
			return false;
		}else{
			return true;
		}


	}




	protected function pegaBoleto(){

		$query = "SELECT id FROM vencimentos ORDER BY id DESC";
		$sql = $this->model->query($query);

		$linha = mysql_fetch_assoc($sql);
		return $linha["id"];
	}

	protected function pegaDebito($dados){

		$query = "SELECT id FROM debitos WHERE banco=".$dados["banco"]." AND vencimento='".$dados["vencimento"]."' AND titulo='".$dados["titulo"]."' ORDER BY id DESC";
		$sql = $this->model->query($query);

		$linha = mysql_fetch_assoc($sql);
		return $linha["id"];
	}











	protected function relatorio(){
		if (isset($_POST["mes"])&&isset($_POST["ano"])) {
			$mes = $_POST["mes"];
			$ano = $_POST["ano"];
		}else{
			$mes = date("m");
			$ano = date("Y");
			if (date("d")<10) {

				if ($mes=="01") {
					$ano--;
					$mes="12";
				}else{
					$mes--;
				}

			}
		}

		$this->view->mes = $mes;
		$this->view->ano = $ano;


		$this->view->Administrativas["valor"] = 0;
		$this->view->Fixas["valor"] = 0;
		$this->view->Imposto["valor"] = 0;
		$this->view->Juros["valor"] = 0;
		$this->view->Combustivel["valor"] = 0;
		$this->view->Viagem["valor"] = 0;
		$this->view->Mecanico["valor"] = 0;
		$this->view->Escritorio["valor"] = 0;


		$this->Despesas($mes,$ano);

		$this->gerarChart();
	}


	protected function Despesas($mes,$ano){

		$query = "SELECT * FROM despesas ORDER BY id DESC";
		$sql = $this->model->query($query);
		$xhtml = "";

		//// para cada bloco dessa venda
		while ($linha=mysql_fetch_assoc($sql)) {

			$tipos = $this->tipos;



			// $data[1] = mes
			// $data[2] = ano
			if ($linha["vencimento"]=="") {
				$data = explode("-", $linha["data"]);	
			}else{
				$data = explode("-", $linha["vencimento"]);	
			}

			switch ($linha["tipo"]) {
					case '0': // Administrativo

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Administrativas["html"] .= $html["html"];
						$this->view->Administrativas["valor"] += $html["valor"];

					}
					break;

					case '1': // FIXA
					if ($data[1]==$mes && $data[2]==$ano) {
						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Fixas["html"] .= $html["html"];
						$this->view->Fixas["valor"] += $html["valor"];
					}
					break;

					case '2': // IMPOSTO
					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Imposto["html"] .= $html["html"];
						$this->view->Imposto["valor"] += $html["valor"];

					}
					break;

					case '3': // JUROS
					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Juros["html"] .= $html["html"];
						$this->view->Juros["valor"] += $html["valor"];

					}
					break;
					case '4': // COMBUSTIVEL
					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Combustivel["html"] .= $html["html"];
						$this->view->Combustivel["valor"] += $html["valor"];

					}
					break;

					case '5': // Viagem					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Viagem["html"] .= $html["html"];
						$this->view->Viagem["valor"] += $html["valor"];

					}
					break;

					case '6': // Mecanico					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Mecanico["html"] .= $html["html"];
						$this->view->Mecanico["valor"] += $html["valor"];

					}
					break;

					case '7': // Escritorio					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Escritorio["html"] .= $html["html"];
						$this->view->Escritorio["valor"] += $html["valor"];

					}
					break;


				}
			}
		}


		protected function GetDados($dados){

			$pagamentos = $this->pagamentos;

			switch ($dados["pagamento"]) {

					case '1': // BOLETO
					$detalhe = $this->getBoleto($dados);
					break;

					case '2': // CHEQUE DA EMPRESA
					$detalhe = $this->getCheque($dados);
					break;

					case '3': // CHEQUE DE CLIENTES
					$detalhe = $this->getChequeCliente($dados);
					break;

					case '4': // CARTAO
					$detalhe = $this->getCartao($dados);
					break;
				}

				$xhtml .= "<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
				<h6 style='font-size:14px;'>".substr($dados["titulo"], 0,30)." - R$ ".number_format($dados["valor"],2,",",".")."</h6>
				</li>
				<div style='padding-left:20px;'>
				<span>Titulo: ".$dados["titulo"]."</span><br>
				<span>Tipo de Pagamento: ".$pagamentos[$dados["pagamento"]]."</span><br>
				<span>Valor: R$ ".number_format($dados["valor"],2,",",".")."</span><br>
				<span>Data: ".$dados["data"]."</span><br>
				".$detalhe."
				<hr>
				</div>";


				$html["valor"] = $dados["valor"];
				$html["html"] = $xhtml;
				$this->TipoPagamento[$dados["pagamento"]] += $dados["valor"];
				return $html;
			}


			protected function getBoleto($dados){


				$boleto = $this->pegaDados("vencimentos",$dados["boleto"]);

				$detalhe .= "<li style='padding-left:10px;' class='exp' >
				<span>Vencimento do Boleto: ".$dados["vencimento"]."</span><br>
				</li>";


				return $detalhe;
			}

			protected function getCheque($dados){


				$cheque = $this->pegaCheque($dados["cheque"]);
				$banco = $this->pegaDados("bancos",$cheque["banco"]);

				$detalhe .= "<li style='padding-left:10px;' class='exp' >
				<span>Banco: ".$banco["nome"]."</span><br>
				<span>Numero: ".$cheque["numero"]."</span><br>
				<span>Compensa&ccedil;&atilde;o: ".$cheque["para"]."</span><br>
				</li>";


				return $detalhe;
			}

			protected function pegaCheque($numero) {

				$valores_db = $this->model->query("SELECT * FROM `cheques` WHERE numero=".$numero);
				$linha = mysql_fetch_array($valores_db);

				return $linha;

			}
			protected function getChequeCliente($dados){

				$cheques = explode(",", $dados["chqcliente"]);



				foreach ($cheques as $value) {
					$cheque = $this->pegaDados("chqclientes",$value);


					$banco = $this->pegaDados("bancos",$cheque["banco"]);
					$cliente = $this->pegaDados("clientes",$cheque["cliente"]);


					$detalheChqs .= "
					<span>Numero: ".$cheque["numero"]."</span><br>
					<span>Cliente: <b><a href='".URL."Clientes/Relatorio/".$cliente["id"]."' target='_blank'>".htmlspecialchars_decode($cliente["nome"])."</a></b></span><br>
					<span>Valor: R$ ".number_format($cheque["valor"],2,",",".")."</span><br>
					<span>Cheque para: ".$cheque["para"]."</span><br>
					<span>Banco: ".$banco["nome"]."</span><br>";

					$n++;
					$valorCheques +=$cheque["valor"];
				}
				if ($valorCheques<$dados["valor"]) {

					$avista["valor"] = $dados["valor"]-$valorCheques;
					$this->TipoPagamento[0] += $avista["valor"];
					$this->TipoPagamento[$dados["pagamento"]] -= $avista["valor"];

				}else{
					$Credito["valor"] = $valorCheques-$dados["valor"];
				}

				$detalhe .= "
				<li style='padding-left:10px;'>
				<span>Numero de Cheques: ".$n."</span><br>
				<span>Pagou em Dinheiro: R$ ".number_format($avista["valor"],2,",",".")."</span><br>
				<span>Ficou de Credito: R$ ".number_format($Credito["valor"],2,",",".")."</span><br>
				</li>
				<b  class='exp' style='cursor:pointer;'>[ Detalhar ]</b>
				<div>
				".$detalheChqs."</div>";



				return $detalhe;
			}

			protected function getCartao($dados){

				$cartao = $this->pegaDados("cartao",$dados["cartao"]);
				$bandeira = $this->pegaDados("bandeiras",$cartao["bandeira"]);

				$parcela = $this->pegaParcela($dados);
				$detalhe .= "
				<b  class='exp' style='cursor:pointer;'>[ Detalhar ]</b>
				<div>
				<li style='padding-left:10px;'>
				<span>Parcela: ".$parcela."/".$dados["parcelas"]."</span><br>
				<span>Vencimento: ".$dados["vencimento"]."</span><br>
				<span>Cart&atilde;o: ".$bandeira["nome"]."</span><br>
				</li>
				</div>";


				return $detalhe;
			}
			protected function pegaParcela($dados){
				$query = "SELECT * FROM despesas WHERE pagamento=4 AND titulo='".$dados["titulo"]."' AND data='".$dados["data"]."' AND parcelas=".$dados["parcelas"];
				$sql = $this->model->query($query);
				while ($linha=mysql_fetch_assoc($sql)) {
					$vencimento = explode("-", $linha["vencimento"]);
					$vencimentoCartao = explode("-", $dados["vencimento"]);
					if ($vencimento[1]<=$vencimentoCartao[1]) {
						$parcela++;
					}
				}
				return $parcela;
			}


			protected function gerarChart(){

				$Tipspagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cartão","Debito em Conta");

				$url .= "function vendaChart() {\n";
			//// REPARTICAO DAS COMPRAS POR MEIO DE PAGAMENTO
				$url .= "
				var data = google.visualization.arrayToDataTable([\n
					['Labels','Values'],\n
					['Administrativo', ".$this->view->Administrativas["valor"]."],\n
					['Fixo',".$this->view->Fixas["valor"]."],\n
					['Imposto',".$this->view->Imposto["valor"]."],\n
					['Juros/Taxas',".$this->view->Juros["valor"]."],\n
					['Combustível',".$this->view->Combustivel["valor"]."],\n
					['Viagem',".$this->view->Viagem["valor"]."],\n
					['Mecânico',".$this->view->Mecanico["valor"]."],\n
					['Escritório',".$this->view->Escritorio["valor"]."]\n
					]);\n var options = {\n	title: 'Despesas por Tipo',\n	is3D:true,\n	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n};\nvar chart = new google.visualization.PieChart(document.getElementById('chart_div'));chart.draw(data, options);\nvar data2 = google.visualization.arrayToDataTable([\n
					['Labels','Values'],\n";

					$i=0;


					foreach ($this->TipoPagamento as $key=>$value) {
						$pagamentos[$key] .= "['".$Tipspagamentos[$key]."', ".$value."]";
						$i++;
					}

					if ($i==0) {
						$html = "['Nenhuma Despesa', 1]";
					}else{
						$html = implode(",\n", $pagamentos);	
					}



					$url .= $html."	]);\nvar options2 = {\n	title: 'Despesas por Forma de Pagamento',\n	is3D:true,\n	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n};\nvar chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));chart2.draw(data2, options2);}";

$this->view->graficosVenda = $url;

}	


}/// FIM DA CLASSE