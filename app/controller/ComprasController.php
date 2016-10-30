<?php
class ComprasController extends Controller {
	function __construct() {
		parent::__construct ();

	}

	function index() {
		switch ($_GET["var2"]) {
			case "Adicionar":

			if ($_POST["fornecedor"]!="0" && isset($_POST["pagamento"])) {

				
				$this->adicionar();
			}


			$this->listas();

			$this->view->render ( 'compras/novo' );
			break;

			case "Editar":

			if ($_POST["fornecedor"]) {
				$this->editarDespesa();
			}

			$this->pegaId("compras",$_GET["var3"]);

			$this->listas();
			
			$this->view->render ( 'compras/novo' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "compras");

			$this->listar();

				//Futuramente criar lista com os compras
				//$this->view->pdf = $this->pdf();
			$this->view->render ( 'compras/index' );
			break;

			case "Pago":


			$this->ativar($_GET["var3"], "compras");

			$this->listar();


			$this->view->render ( 'compras/index' );
			break;

			case "Aberto":


			$this->ativar($_GET["var3"], "compras");

			$this->listar();


			$this->view->render ( 'compras/index' );
			break;

			case "ChequesCLientes":

			if ($_POST["chqcliente"]!="") {
				$this->view->chqcliente = $_POST["chqcliente"];
			}
			
			$this->view->pagamento = $_POST["pagamento"];

			$this->listaCheques();
			break;

			case "Relatorio":

			$this->relatorio();

			$this->view->render ( 'compras/relatorio' );
			break;

			default:

			$this->listar();
			$this->view->render ( 'compras/index' );
			break;
		}
	}

	protected function listas(){
		if ($this->view->pagamento==2) {
			$this->pegaCheque($this->view->cheque);
		}

		$this->pagamentos();
		$this->fornecedores();
		$this->bancos();
		$this->cartoes();
		
	}










































	protected function adicionar(){

		switch ($_POST["pagamento"]) {
			////// AVISTA
			case '0':
			unset($_POST["pago"]);
			$this->AdicionarPagamentoAvista();
			break;

			//// BOLETO
			case '1':
			$this->AdicionarPagamentoBoleto();
			break;

			//// CHEQUE DA EMPRESA
			case '2':
			unset($_POST["pago"]);
			$this->AdicionarPagamentoCheque();
			break;
			//// CHEQUE DE CLIENTE
			case '3':
			unset($_POST["pago"]);
			$this->AdicionarPagamentoChqCliente();
			
			break;
			//// CARTAO
			case '4':
			unset($_POST["pago"]);
			$this->AdicionarPagamentoCartao();
			break;

		}

	}

	protected function AdicionarPagamentoAvista(){
		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);
		$this->cadastrar("compras");
	}

	protected function AdicionarPagamentoBoleto(){
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);
		$cedente = $this->pegaDados("fornecedores",$_POST["fornecedor"]);
		$_POST["cedente"] = $cedente["nome"];

		$fornecedor = $_POST["fornecedor"];
		$pagamento = $_POST["pagamento"];
		$data = $_POST["data"];
		$valor = $_POST["valor"];
		$vencimento = $_POST["vencimento"];

		unset($_POST["data"]);
		unset($_POST["pagamento"]);
		$_POST["fornecedor"] = 1;

		$this->cadastrar("vencimentos");

		$_POST["boleto"] = $this->pegaBoleto();
		$_POST["vencimento"] = $vencimento;
		$_POST["fornecedor"] = $fornecedor;
		$_POST["pagamento"] = $pagamento;
		$_POST["valor"] = $valor;
		$_POST["data"] = $data;
		unset($_POST["cedente"]);
		$this->cadastrar("compras");


	}

	protected function AdicionarPagamentoCheque(){
		unset($_POST["oldPagamento"]);
		if ($_POST["tipoChq"]=="1") {

			if ($this->VerificaRelacao()) {
				$query = "SELECT * FROM cheques WHERE numero=".$_POST["numero"];
				$sql = $this->model->query($query);
				$linha = mysql_fetch_assoc($sql);

				$fornecedor = $_POST["fornecedor"];
				$pagamento = $_POST["pagamento"];
				$valor = $_POST["valor"];
				$data = $_POST["data"];
				$cheque = $_POST["numero"];
				$vencimento = $linha["para"];

				unset($_POST["banco"]);
				unset($_POST["para"]);
				unset($_POST["numero"]);
				unset($_POST["tipoChq"]);
				unset($_POST["vencimento"]);
				unset($_POST["cartao"]);
				unset($_POST["parcelas"]);
				unset($_POST["pagamento"]);
				unset($_POST["fornecedor"]);


				$_POST["vencimento"] = $vencimento;
				$_POST["cheque"] = $cheque;
				$_POST["fornecedor"] = $fornecedor;
				$_POST["pagamento"] = $pagamento;
				$_POST["valor"] = $valor;
				$_POST["data"] = $data;

				$this->cadastrar("compras");
			}else{
				$this->view->erro = "Cheque de numero ".$_POST["numero"]." n&atilde;o relacionado ainda!";
			}
			
		}else{

			unset($_POST["tipoChq"]);

			$_POST["numero"] = preg_replace("/[^0-9]/", "",$_POST["numero"]);

			$cedente = $this->pegaDados("fornecedores",$_POST["fornecedor"]);
			$_POST["quem"] = $cedente["nome"];

			$fornecedor = $_POST["fornecedor"];
			$pagamento = $_POST["pagamento"];
			$valor = $_POST["valor"];
			$data = $_POST["data"];
			$cheque = $_POST["numero"];
			$vencimento = $_POST["para"];



			unset($_POST["vencimento"]);
			unset($_POST["cartao"]);
			unset($_POST["parcelas"]);
			unset($_POST["pagamento"]);
			unset($_POST["fornecedor"]);
			//echo $_POST["numero"];

			$this->cadastrar("cheques");

			$_POST["vencimento"] = $vencimento;
			$_POST["cheque"] = $cheque;
			$_POST["fornecedor"] = $fornecedor;
			$_POST["pagamento"] = $pagamento;
			$_POST["valor"] = $valor;
			$_POST["data"] = $data;
			
			//echo $_POST["numero"];

			$this->cadastrar("compras");
		}

	}

	protected function AdicionarPagamentoChqCliente(){
		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);

		$cedente = $this->pegaDados("fornecedores",$_POST["fornecedor"]);

		foreach ($_POST["chqcliente"] as $value) {
			$query = "UPDATE chqclientes SET quem = '".$cedente["nome"]."' WHERE id=".$value;
			$sql = $this->model->query($query);
		}

		$_POST["chqcliente"] = implode(",", $_POST["chqcliente"]);
		$this->cadastrar("compras");
	}

	protected function AdicionarPagamentoCartao(){
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
			$this->cadastrar("compras",false);
		}
		$this -> view -> erro = "Cadastro Feito com Sucesso!";

	}







































	protected function editarDespesa(){


		switch ($_POST["oldPagamento"]) {

			//// BOLETO
			case '1':
			$oldDados = $this->pegaDados("compras",$_GET["var3"]);
			$this->model->query("DELETE FROM vencimentos WHERE id=".$oldDados["boleto"]);

			break;

			//// CHEQUE DA EMPRESA
			case '2':

			$oldDados = $this->pegaDados("compras",$_GET["var3"]);
			$this->model->query("DELETE FROM cheques WHERE numero=".$oldDados["cheque"]);


			break;

			//// CHEQUE DE CLIENTE
			case '3':
			$oldDados = $this->pegaDados("compras",$_GET["var3"]);
			$cheques = explode(",", $oldDados["chqcliente"]);
			foreach ($cheques as $value) {
				$this->model->query("UPDATE chqclientes SET quem='' WHERE id=".$value);
			}

			break;
			//// CARTAO
			case '4':
			$oldDados = $this->pegaDados("compras",$_GET["var3"]);
			$query = "SELECT id FROM compras WHERE fornecedor='".$oldDados["fornecedor"]."' AND valor='".$oldDados["valor"]."' AND pagamento='".$oldDados["pagamento"]."' AND parcelas='".$oldDados["parcelas"]."'";
			$sql = $this->model->query($query);
			while ($linha=mysql_fetch_assoc($sql)) {
				$this->model->query("DELETE FROM compras WHERE id=".$linha["id"]);	
			}

			switch ($_POST["pagamento"]) {
					////// AVISTA
				case '0':
				$this->AdicionarPagamentoAvista();
				break;

					//// BOLETO
				case '1':

				$this->AdicionarPagamentoBoleto();

				break;

			//// CHEQUE DA EMPRESA
				case '2':

				$this->AdicionarPagamentoCheque();


				break;
			//// CHEQUE DE CLIENTE
				case '3':
				$this->AdicionarPagamentoChqCliente();

				break;
			//// CARTAO
				case '4':
				$this->AdicionarPagamentoCartao();
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
				$this->view->erro = "Cheque de numero ".$_POST["numero"]." n&atilde;o relacionado ainda ou j&aacute; relacionado em outra Compra!";
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

		$this->editar($_GET["var3"],"compras");
	}

	protected function EditarPagamentoBoleto(){

		unset($_POST["oldPagamento"]);

		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);
		$_POST["cedente"] = $_POST["fornecedor"];



		$fornecedor = $_POST["fornecedor"];
		$pagamento = $_POST["pagamento"];
		$data = $_POST["data"];
		$valor = $_POST["valor"];
		$vencimento = $_POST["vencimento"];

		unset($_POST["fornecedor"]);
		unset($_POST["data"]);

		unset($_POST["pagamento"]);
		$_POST["fornecedor"] = 0;

		$this->cadastrar("vencimentos");

		$_POST["boleto"] = $this->pegaBoleto();
		$_POST["vencimento"] = $vencimento;
		$_POST["fornecedor"] = $fornecedor;
		$_POST["pagamento"] = $pagamento;
		$_POST["valor"] = $valor;
		$_POST["data"] = $data;
		

		$this->editar($_GET["var3"],"compras");

	}

	protected function EditarPagamentoCheque(){

		unset($_POST["oldPagamento"]);
		

		unset($_POST["tipoChq"]);

		$fornecedor = $this->pegaDados("fornecedores", $_POST["fornecedor"]);
		$_POST["quem"] = $fornecedor["nome"];

		$fornecedor = $_POST["fornecedor"];
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
		unset($_POST["fornecedor"]);

		$this->cadastrar("cheques");

		
		$_POST["fornecedor"] = $fornecedor;
		$_POST["vencimento"] = $vencimento;
		$_POST["cheque"] = $cheque;
		$_POST["fornecedor"] = $fornecedor;
		$_POST["pagamento"] = $pagamento;
		$_POST["valor"] = $valor;
		$_POST["data"] = $data;

		$this->editar($_GET["var3"],"compras");
		


	}

	protected function EditarPagamentoChqCliente(){
		unset($_POST["oldPagamento"]);
		unset($_POST["vencimento"]);
		unset($_POST["banco"]);
		unset($_POST["numero"]);
		unset($_POST["para"]);
		unset($_POST["cartao"]);
		unset($_POST["parcelas"]);

		$fornecedor = $this->pegaDados("fornecedores",$_POST["fornecedor"]);

		foreach ($_POST["chqcliente"] as $value) {
			$query = "UPDATE chqclientes SET quem = '".$fornecedor["nome"]."' WHERE id=".$value;
			$sql = $this->model->query($query);
		}

		$_POST["chqcliente"] = implode(",", $_POST["chqcliente"]);
		$this->editar($_GET["var3"],"compras");
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
			$this->cadastrar("compras",false);
		}

		$this->model->query("DELETE FROM compras WHERE id=".$_GET["var3"]);
		header("Location: ".URL.$_GET["var1"]);
		$this->view->erro = "Cadastro Feito com Sucesso!";

	}

















	













	













	


	protected function VerificaRelacao(){

		$query = "SELECT * FROM cheques WHERE numero=".$_POST["numero"];
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);

		if ($linha["numero"]==true) {
			$query = "SELECT id FROM compras WHERE cheque=".$_POST["numero"];
			$sql = $this->model->query($query);
			$linhax = mysql_fetch_assoc($sql);
			if ($linhax["id"]) {
				return linha;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}

	protected function VerificaRelacaoEditar(){

		$query = "SELECT id FROM compras WHERE cheque=".$_POST["numero"];
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

	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA vendas NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {
		$pagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cart&atilde;o");


		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM compras";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}
			$fornecedor = $this->pegaDados("fornecedores",$linha["fornecedor"]);
			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".htmlspecialchars($fornecedor["nome"])."</td>
			<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
			<td class='center'>".$linha["data"]."</td>
			<td class='center'>".$pagamentos[$linha["pagamento"]]."</td>";
			
			
			if ($linha["vencimento"]!="") {
				$lista.= "
				<td class='center'>".$linha["vencimento"]."</td>";
			}else{
				$lista.= "
				<td class='center'>".$linha["data"]."</td>";
			}

			$lista.= "</td>
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



	/*
	 *
	 *
	 * FUNCAO PEGA ID - PEGA NOTICIA CADASTRADA NO BANCO BANCO
	 *
	 *
	 *
	 */
	protected function pegaId($tabela,$id) {


		$valores_db = $this->model->query("SELECT * FROM `".$tabela."` WHERE id=".$id);
		$linha = mysql_fetch_array($valores_db);


		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);


		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i]	= $linha[$variaveis[$i]];
		}
		if ($linha["fornecedor"]==1) {
			$this->view->fornecedor="checked";
		}

	}
	private function pagamentos(){
		$pagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cart&atilde;o");

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

	private function bancos(){

		$query = "SELECT * FROM bancos WHERE agencia!='0' AND conta!='0' ORDER BY nome";

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

	private function cartoes(){

		$query = "SELECT * FROM cartao ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->banco) && $linha["id"]==$this->view->banco) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->cartoes = $lista;
	}


	private function listaCheques(){

		$lista='
		<script type="text/javascript">
		$(function(){
			var atual = 0;
			$(".chqclientes").click(function(){
				var valor = $(this).attr("valor");
				if ($(this).attr("checked")) {
					atual = atual + parseFloat(valor);
				}else{
					atual = atual - parseFloat(valor);
				}

				var total = $("#valor").val();

				restante = (total)-(atual);

				$("#totalCheques").fadeIn("slow",function(){

					$("#total").text(atual);
					if (restante>=0) {
						$("#restante").css("color","red");
					}else{
						$("#restante").css("color","green");
					}
					$("#restante").text(restante);
				});

});


$("#valor").keyup(function(){
	var valor = $(this).val();

	var ValorCheques = $("#total").text();
	if (ValorCheques=="") {
		ValorCheques=0;
	}

	restante = valor-ValorCheques;


	$("#totalCheques").fadeIn("slow",function(){

		if (restante>=0) {
			$("#restante").css("color","red");
		}else{
			$("#restante").css("color","green");
		}
		$("#restante").text(restante);
	});

});
});
</script>';

if (isset($this->view->chqcliente) && $this->view->pagamento==3) {
	$cheques = explode(",", $this->view->chqcliente);
	foreach ($cheques as $value) {
		$dadosCheque = $this->pegaDados("chqclientes",$value);
		$lista .='<fieldset style="border:1px #ccc solid; padding-left:10px;margin:10px;">
		<input type="checkbox" name="chqcliente[]" value="'.$value.'" id="'.$value.'" checked/> <label for="'.$value.'">Valor: <b>R$ '.number_format($dadosCheque["valor"],2,",",".").' </b> / Numero: <b>'.$dadosCheque["numero"].'</b> / Compensacao: <b>'.$dadosCheque["para"].'</b></label>
		</fieldset>';
	}

}else{
	$query = "SELECT id,numero,para,valor FROM chqclientes WHERE quem='' ORDER BY valor ASC";

	$sql = $this->model->query($query);

	while($linha = mysql_fetch_array($sql)){

		$lista .='<fieldset style="border:1px #ccc solid; padding-left:10px;margin:10px;">
		<label for="'.$linha["id"].'"><input type="checkbox" name="chqcliente[]" class="chqclientes" valor="'.$linha["valor"].'" value="'.$linha["id"].'" id="'.$linha["id"].'"/> Valor: <b>R$ '.number_format($linha["valor"],2,",",".").' </b> / Numero: <b>'.$linha["numero"].'</b> / Compensacao: <b>'.$linha["para"].'</b></label>
		</fieldset>';
	}
}



echo $lista;


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


	$this->view->avista["valor"] = 0;
	$this->view->cheque["valor"] = 0;
	$this->view->chequeCliente["valor"] = 0;
	$this->view->boleto["valor"] = 0;
	$this->view->cartao["valor"] = 0;
	$this->Compras($mes,$ano);

	$this->gerarChart();
}
protected function compras($mes,$ano){

	$query = "SELECT * FROM compras ORDER BY data";
	$sql = $this->model->query($query);
	$xhtml = "";

		//// para cada bloco dessa venda
	while ($linha=mysql_fetch_assoc($sql)) {

		$pagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cart&atilde;o");




		switch ($linha["pagamento"]) {
					case '0': // AVISTA
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["data"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoAvista($linha);
						$this->view->avista["html"] .= $html["html"];
						$this->view->avista["valor"] += $html["valor"];

					}
					break;

					case '1': // BOLETO
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["vencimento"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoBoleto($linha);
						$this->view->boleto["html"] .= $html["html"];
						$this->view->boleto["valor"] += $html["valor"];
					}
					break;

					case '2': // CHEQUE DA EMPRESA
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["vencimento"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoCheque($linha);
						$this->view->cheque["html"] .= $html["html"];
						$this->view->cheque["valor"] += $html["valor"];
					}

					break;

					case '3': // CHEQUE DE CLIENTES
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["data"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoChqClientes($linha);
						$this->view->chequeCliente["html"] .= $html["htmlChq"];
						$this->view->avista["html"] .= $html["html"];
						$this->view->chequeCliente["valor"] += $html["valor"];
					}
					break;

					case '4': // CARTAO
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["vencimento"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoCartao($linha);
						$this->view->cartao["html"] .= $html["html"];
						$this->view->cartao["valor"] += $html["valor"];
					}

					break;
				}
			}
		}


		protected function PagamentoAvista($dadosCompra){

			$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

			$xhtml .= "<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($dadosCompra["valor"],2,",",".")."</h6>
			</li>
			<div style='padding-left:20px;'>
			<span>Valor: R$ ".number_format($dadosCompra["valor"],2,",",".")."</span><br>
			<span>Data: ".$dadosCompra["data"]."</span><br>
			<hr></div>";


			$html["valor"] = $dadosCompra["valor"];
			$html["html"] = $xhtml;
			return $html;
		}

		protected function PagamentoBoleto($dadosCompra){

			$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

			$boleto = $this->pegaDados("vencimentos",$dadosCompra["boleto"]);

			$detalhe .= "<li style='padding-left:10px;' class='exp' >
			<span>Vencimento: ".$dadosCompra["vencimento"]."</span><br>
			<span>Data: ".$dadosCompra["data"]."</span><br>
			<hr>
			</li>";

			$xhtml = "
			<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($dadosCompra["valor"],2,",",".")."</h6>
			</li>
			<div >
			".$detalhe."

			</div>";

			$html["valor"] = $dadosCompra["valor"];
			$html["html"] = $xhtml;
			return $html;
		}


		protected function PagamentoCheque($dadosCompra){

			$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

			$cheque = $this->pegaCheque($dadosCompra["cheque"]);
			$banco = $this->pegaDados("bancos",$cheque["banco"]);

			$detalhe .= "
			<li style='padding-left:10px;' class='exp' >
			<span>Numero: ".$cheque["numero"]."</span><br>
			<span>Vencimento: ".$cheque["para"]."</span><br>
			<span>Data: ".$dadosCompra["data"]."</span><br>
			<span>Banco: ".$banco["nome"]."</span><br>
			<hr>
			</li>";

			$xhtml = "
			<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($dadosCompra["valor"],2,",",".")."</h6>
			</li>
			<div >
			".$detalhe."

			</div>";

			$html["valor"] = $dadosCompra["valor"];
			$html["html"] = $xhtml;
			return $html;
		}

		protected function pegaCheque($numero) {

			$valores_db = $this->model->query("SELECT * FROM `cheques` WHERE numero=".$numero);
			$linha = mysql_fetch_array($valores_db);

			return $linha;

		}

		protected function PagamentoChqClientes($dadosCompra){

			$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

			$chequesCliente = explode(",", $dadosCompra["chqcliente"]);
			foreach ($chequesCliente as $id) {
				$cheque = $this->pegaChequeCliente($id);

				$banco = $this->pegaDados("bancos",$cheque["banco"]);
				$cliente = $this->pegaDados("clientes",$cheque["cliente"]);
				$detalhe .= "
				<li style='padding-left:10px;' >
				<span>Numero: ".$cheque["numero"]."</span><br>
				<span>Cliente: <b><a href='".URL."Clientes/Relatorio/".$cliente["id"]."' target='_blank'>".htmlspecialchars_decode($cliente["nome"])."</a></b></span><br>
				<span>Valor: R$ ".number_format($cheque["valor"],2,",",".")."</span><br>
				<span>Cheque para: ".$cheque["para"]."</span><br>
				<span>Banco: ".$banco["nome"]."</span><br>
				<hr>
				</li>";
				$n++;
				$valorCheques +=$cheque["valor"];
			}

			if ($valorCheques<$dadosCompra["valor"]) {

				$avista["valor"] = $dadosCompra["valor"]-$valorCheques;

			}else{
				$Credito["valor"] = $valorCheques-$dadosCompra["valor"];
			}
			

			$xhtml = "
			<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($valorCheques,2,",",".")."</h6>
			</li>
			<div >
			<li style='list-style: none;  padding:5px;' >
			<span>ID da Compra: ".$dadosCompra["id"]."</span><br>
			<span>Numero de Cheques: ".$n."</span><br>
			<span>Pagou em Dinheiro: R$ ".number_format($avista["valor"],2,",",".")."</span><br>
			<span>Ficou de Credito: R$ ".number_format($Credito["valor"],2,",",".")."</span><br>
			<span>Data: ".$dadosCompra["data"]."</span><br>
			<ul>
			<li style='list-style: none;  padding:5px;' class='exp'>
			<span style='font-weight:bold; cursor:pointer;'> [ Cheques ]</span>
			</li>
			<div >
			<ol style='list-style:decimal inside;'>
			".$detalhe."
			</ol>
			</div>

			</div>";
			if ($avista>0) {
				$html["html"] = "<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
				<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($avista["valor"],2,",",".")."</h6>
				</li>
				<div style='padding-left:20px;'>
				<span>Valor: R$ ".number_format($avista["valor"],2,",",".")."</span><br>
				<span>Data: ".$dadosCompra["data"]."</span><br>
				<span>Referente a Compra de ID : ".$dadosCompra["id"]."</span><br>
				<hr></div>"; 
				$this->view->avista["valor"] += $avista["valor"];
			}
			
			$html["valor"] = $valorCheques;
			$html["htmlChq"] = $xhtml;
			return $html;
		}

		protected function pegaChequeCliente($id) {

			$valores_db = $this->model->query("SELECT * FROM `chqclientes` WHERE id=".$id);
			$linha = mysql_fetch_array($valores_db);

			return $linha;

		}

		protected function PagamentoCartao($dadosCompra){

			$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

			$cartao = $this->pegaDados("cartao",$dadosCompra["cartao"]);

			$parcela = $this->pegaParcela($dadosCompra);
			$detalhe .= "<li style='padding-left:10px;' class='exp' >
			<span>Parcela: ".$parcela."/".$dadosCompra["parcelas"]."</span><br>
			<span>Vencimento: ".$dadosCompra["vencimento"]."</span><br>
			<span>Data: ".$dadosCompra["data"]."</span><br>
			<hr>
			</li>";

			$xhtml = "
			<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($dadosCompra["valor"],2,",",".")."</h6>
			</li>
			<div >
			".$detalhe."

			</div>";

			$html["valor"] = $dadosCompra["valor"];
			$html["html"] = $xhtml;
			return $html;
		}
		protected function pegaParcela($dadosCompra){
			$query = "SELECT * FROM compras WHERE pagamento=4 AND fornecedor=".$dadosCompra["fornecedor"]." AND data='".$dadosCompra["data"]."' AND parcelas=".$dadosCompra["parcelas"];
			$sql = $this->model->query($query);
			while ($linha=mysql_fetch_assoc($sql)) {
				$vencimento = explode("-", $linha["vencimento"]);
				$vencimentoCartao = explode("-", $dadosCompra["vencimento"]);
				if ($vencimento[1]<=$vencimentoCartao[1]) {
					$parcela++;
				}
			}
			return $parcela;
		}

		protected function gerarChart(){

			$this->Fornecedor[$linha["fornecedor"]];

			
			$url .= "function vendaChart() {\n";
			//// REPARTICAO DAS COMPRAS POR MEIO DE PAGAMENTO
			$url .= "
			var data = google.visualization.arrayToDataTable([\n
				['Labels','Values'],\n
				['A Vista', ".$this->view->avista["valor"]."],\n
				['Cheque',".$this->view->cheque["valor"]."],\n
				['Cheque de Cliente',".$this->view->chequeCliente["valor"]."],\n
				['Boleto',".$this->view->boleto["valor"]."],\n
				['Cartão',".$this->view->cartao["valor"]."]\n
				]);\n
var options = {\n
	title: 'Compras por Forma de Pagamento',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data, options);";

$url .= "
var data2 = google.visualization.arrayToDataTable([\n
	['Labels','Values'],\n";
	$i=0;
	foreach ($this->Fornecedor as $key => $value) {
		$fornecedor = $this->pegaDados("fornecedores",$key);
		$fornecedores[$key] = "['".htmlspecialchars_decode($fornecedor["nome"])."', ".$value."]";
		$i++;
	}
	if ($i==0) {
		$html = "['Nenhuma compra', 1]";
	}else{
		$html = implode(",\n", $fornecedores);	
	}


	$url .= $html."
	]);\n
var options2 = {\n
	title: 'Compras por Fornecedor',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
chart2.draw(data2, options2);

}";



$this->view->graficosVenda = $url;

}	
}