<?php
class ChequesController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		switch ($_GET["var2"]) {
			case "Adicionar":

			if ($_POST["banco"]) {

				$this->cadastrar("cheques");

			}
			$this->bancos();
			$this->view->render ( 'cheques/novo' );
			break;

			case "Editar":

			if ($_POST["banco"]!=0 && isset($_POST["data"])) {
				$this->editar($_GET["var3"],"cheques");
			}

			$this->pegaId("cheques",$_GET["var3"]);
			$this->bancos();
			$this->view->render ( 'cheques/novo' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "cheques");

			$this->listar();

			$this->view->render ( 'cheques/index' );
			break;

			case "Numero":

			$query = "SELECT * FROM cheques WHERE banco='".$_POST["banco"]."' ORDER BY numero DESC";

			$sql = $this->model->query($query);

			$linha = mysql_fetch_array($sql);

			$numero =  $linha["numero"]+1;

			echo $numero;

			break;

			case "Pago":


			if (strstr($_GET["var3"], "-")) {
				$url = explode("-", $_GET["var3"]);
				$redirect = $url[1];
			}else{
				$redirect = false;
			}

			$this->atualizar();


			$this->ativar($_GET["var3"], "cheques",$redirect);

			$this->listar();

			$this->view->render ( 'cheques/index' );
			break;

			case "Aberto":


			$this->desativar($_GET["var3"], "cheques");

			$this->listar();
			$this->view->render ( 'cheques/index' );
			break;

			
			default:


			$this->listar();
			$this->view->render ( 'cheques/index' );
			break;
		}
	}


	private function bancos(){

		$query = "SELECT * FROM bancos ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->banco) && $linha["id"]==$this->view->banco) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->vendedores = $lista;
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



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM cheques ORDER BY numero DESC";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$banco = $this->pegaDados("bancos", $linha["banco"]);

			$data = explode("-", $linha["data"]);
			$para = explode("-", $linha["para"]);


			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".$linha["numero"]."</td>
			<td class='center'>".html_entity_decode($linha["quem"])."</td>
			<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
			<td class='center'>".$data[2]."-".$data[1]."-".$data[0]."</td>
			<td class='center'>".$para[2]."-".$para[1]."-".$para[0]."</td>
			<td class='center'>".$banco["nome"]."</td>
			<td class='center'>
			";
			if ($linha["pago"]!=0) {
				$lista.= "
				<a href='".URL.$_GET["var1"]."/Aberto/".$linha["numero"]."' title='Aberto' class='tipS'>
				<img src='". Folder."images/icons/control/16/check.png' alt='' /> 
				</a>";
			}else{
				$lista.= "
				<a href='".URL.$_GET["var1"]."/Pago/".$linha["numero"]."' title='Pago' class='tipS'>
				<img src='". Folder."images/icons/control/16/busy.png' alt='' /> 
				</a>";
			}

			$lista.= "</td>
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Editar/".$linha["numero"]."' title='Editar' class='tipS'><img
			src='". Folder."images/icons/control/16/pencil.png'
			alt='' /> </a> <a href='".URL.$_GET["var1"]."/Deletar/".$linha["numero"]."' title='Deletar' class='tipS'><img
			src='". Folder."images/icons/control/16/clear.png' alt='' />
			</a>
			</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}




	/*
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * */


	protected function listar_mes() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM cheques ORDER BY numero DESC";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			$date = explode("-", $linha["para"]);

			if ($date[1]==$_POST["mes"] && $date[2]==$_POST["ano"]) {


				if ($letra=="B") {
					$letra="A";
				}elseif ($letra=="A") {
					$letra = "B";
				}

				$total += $linha["valor"];

				$banco = $this->pegaDados("bancos", $linha["banco"]);



				$lista.= "

				<tr class='grade".$letra."'>
				<td class='center'>".$linha["numero"]."</td>
				<td class='center'>".html_entity_decode($linha["quem"])."</td>
				<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
				<td class='center'>".$linha["para"]."</td>
				<td class='center'>".$banco["nome"]."</td>
				<td class='center'>
				";
				if ($linha["pago"]!=0) {
					$lista.= "
					<a href='".URL.$_GET["var1"]."/Aberto/".$linha["numero"]."' title='Aberto' class='tipS'>
					<img src='". Folder."images/icons/control/16/check.png' alt='' /> 
					</a>";
				}else{
					$lista.= "
					<a href='".URL.$_GET["var1"]."/Pago/".$linha["numero"]."' title='Pago' class='tipS'>
					<img src='". Folder."images/icons/control/16/busy.png' alt='' /> 
					</a>";
				}

				$lista.= "</td>
				<td class='actBtns'>
				<a href='".URL.$_GET["var1"]."/Editar/".$linha["numero"]."' title='Editar' class='tipS'><img
				src='". Folder."images/icons/control/16/pencil.png'
				alt='' /> </a> <a href='".URL.$_GET["var1"]."/Deletar/".$linha["numero"]."' title='Deletar' class='tipS'><img
				src='". Folder."images/icons/control/16/clear.png' alt='' />
				</a>
				</td>
				</tr>";

			}

		}

		$this->view->total = $total;
		$this->view->lista = $lista;

	}

	/*
	 *
	 *
	 * FUNCOES ATIVAR E DESATIVAR
	 *
	 *
	 *
	 */
	protected function ativar($id,$tabela,$redirect) {

		if ($redirect!=false) {
			$url = explode("-", $_GET["var3"]);
			$id = $url[0];

		}

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}
		// VARIAVEIS DE DADOS JA CADASTRADOS
		$query = "UPDATE ".$tabela." SET pago=1 WHERE numero=".$id;

		//$this->error($query);
		if ($this->model->query ( $query )) {

			$this->Log("Alteracao na tabela $tabela para pago a numero=$id; query($query)");

			if ($redirect!=false) {
				header("Location: ".URL.$redirect);
			}else{
				header("Location: ".URL.$_GET["var1"]);

			}
		}else{
			die(mysql_error());
		}


		//return true;
	}


	protected function desativar($id,$tabela) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}
		// VARIAVEIS DE DADOS JA CADASTRADOS
		$query = "UPDATE ".$tabela." SET pago=0 WHERE numero=".$id;

		//$this->error($query);
		if ($this->model->query ( $query )) {
			$this->Log("Alteracao na tabela $tabela para em aberto a numero=$id; query($query)");

			header("Location: ".URL.$_GET["var1"]);
		}else{
			die(mysql_error());
		}


		//return true;
	}


	/*
	 *
	 *
	 * FUNCAO EDITAR - EDITA NOTICIAS CADASTRADAS NO BANCO BANCO
	 *
	 *
	 *
	 */
	protected function editar($id,$tabela=false,$redirect=true) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}

		$campos = array_keys ( $_POST );
		$quant = count ( $campos );
		$quant = ($quant - 1);
		$query = "UPDATE ";
		$query .= "`" . $tabela . "` ";
		$query .= "SET ";
		for($i = 0; $i < $quant; $i ++) {
			$camp = $campos [$i];
			$query .= "`$campos[$i]`= '" . $this->string->preparar($_POST [$camp]) . "',";
		}
		$camp = $campos [$quant];
		$query .= "`$campos[$quant]`= '" . $this->string->preparar($_POST [$camp]) . "' ";
		$query .= "WHERE numero=" . $id . "";
		//$query .= ";";
		//$query = "UPDATE `Noticias` SET `titulo_br`='Wilker' Where id = 1"; //  LINHA DE TESTE

		//$this->error($query);

		if ($this->model->query ( $query )) {

			$this->Log("Alterou o Cheque de numero $id");

			unset($_POST);
			if ($redirect==true) {
				header("Location: ".URL.$_GET["var1"]);
			}
		}else{
			die(mysql_error());
		}

	}

	protected function deletar($id,$tabela) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}

		$query = "DELETE FROM ";
		$query .= "`" . $tabela . "` ";
		$query .= "WHERE numero='" . $id . "'";
		$query .= ";";

		if ($this->model->query ( $query )) {

			$this->Log("Deletou o Cheque de numero $id");

			header("Location: ".URL.$_GET["var1"]);
		}else{
			die(mysql_error());
		}
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


		$valores_db = $this->model->query("SELECT * FROM `".$tabela."` WHERE numero=".$id);
		$linha = mysql_fetch_array($valores_db);


		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);

		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i]	= $linha[$variaveis[$i]];
		}

	}

	protected function atualizar(){
		$bancos = array(1=>"Banco do Brasil",2=>"Itau");

		$Numero = explode("-", $_GET["var3"]);

		$cheque = $this->pegaDadosNumero("cheques",$Numero[0]);

		if ($cheque["para"]==date("d-m-Y",mktime(0,0,0,date("m"),date("d")-1,date("Y"))) || $cheque["para"]==date("d-m-Y",mktime(0,0,0,date("m"),date("d"),date("Y")))) {
			if ($cheque["valor"]>5000) {
				$_POST["titulo"]="Tarifa ".$bancos[$cheque["banco"]]." Valor Superior - Cheque N˚ ".$cheque["numero"];
				$_POST["valor"] = $cheque["valor"]*0.0011;
				$_POST["data"] = date("d-m-Y");
				$_POST["tipo"] = 3;
				$_POST["pagamento"] = 0;
				$this->cadastrar("despesas");
			}
		}else{

			$_POST["para"] = date("d-m-Y");

			$this->editar($Numero[0],"cheques",false);

			$this->updateCompras($Numero[0]);
			$this->updateDespesas($Numero[0]);


			if ($cheque["valor"]>5000) {
				$_POST["titulo"]="Tarifa ".$bancos[$cheque["banco"]]." Valor Superior - Cheque N˚ ".$cheque["numero"];
				$_POST["valor"] = $cheque["valor"]*0.0011;
				$_POST["data"] = date("d-m-Y");
				$_POST["tipo"] = 3;
				$_POST["pagamento"] = 0;
				$this->cadastrar("despesas");
			}
		}

	}
	
	protected function updateDespesas($cheque){
		$query = "UPDATE despesas SET vencimento='".date("d-m-Y")."' WHERE cheque=".$cheque;
		if($this->model->query($query)){
			return true;
		}else{
			die("Erro em atualizar o Cheque em Despesas");
		}

	}
	protected function updateCompras($cheque){
		$query = "UPDATE compras SET vencimento='".date("d-m-Y")."' WHERE cheque=".$cheque;
		if($this->model->query($query)){
			return true;
		}else{
			die("Erro em atualizar o Cheque em Compras");
		}

	}

}