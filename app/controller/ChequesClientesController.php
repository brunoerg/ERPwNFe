<?php
class ChequesClientesController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		switch ($_GET["var2"]) {
			case "Adicionar":


			if ($_POST["banco"]) {
				unset($_POST["idCliente"]);
				$this->cadastrar("chqclientes");

			}
			$this->bancos();
			$this->clientes();
			$this->view->render ( 'chqclientes/novo' );
			break;

			case "Editar":

			if ($_POST["numero"]!=0 && isset($_POST["data"])) {
				unset($_POST["idCliente"]);
				$this->editar($_GET["var3"],"chqclientes");
			}

			$this->pegaId("chqclientes",$_GET["var3"]);
			$this->bancos();
			$this->clientes();
			$this->view->render ( 'chqclientes/novo' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "chqclientes");

			$this->listar();

				//Futuramente criar lista com os chqclientes
				//$this->view->pdf = $this->pdf();
			$this->view->render ( 'chqclientes/index' );
			break;



			case "Voltou":



			$this->ativar($_GET["var3"], "chqclientes");

			$this->listar();


			$this->view->render ( 'chqclientes/index' );
			break;

			case "Pago":


			$this->desativar($_GET["var3"], "chqclientes");

			$this->listar();

			$this->view->render ( 'cheques/index' );
			break;
			
			case "LimiteDias":
			$this->LimiteDias();
			
			break;

			case "Relatorio":

			if (isset($_POST["mes"])) {
				$this->listar_mes();
			}

				//$this->listar();
			$this->view->render ( 'chqclientes/index' );
			break;

			default:

			$this->listar();
			$this->view->render ( 'chqclientes/index' );
			break;
		}
	}


	private function atualiza_id() {
		$query = "SELECT * FROM chqclientes WHERE numero>0";

		$sql = $this->model->query($query);
		$i=1;
		while($linha = mysql_fetch_array($sql)){
			$queri = "UPDATE chqclientes SET id='".$i."' WHERE numero=".$linha["numero"];
			$sqls = $this->model->query($queri);
			$i++;
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


		$this->view->bancos = $lista;
	}



	private function clientes(){

		$query = "SELECT * FROM clientes ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->cliente) && $linha["id"]==$this->view->cliente) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->clientes = $lista;
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

		$query = "SELECT * FROM chqclientes ORDER BY id DESC";

		$valores_db = $this->model->query($query);
		$letra = "B";



		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$cliente = $this->pegaDados("clientes", $linha["cliente"]);

			$compensados=0;

			
			//date[0] = dia
			//date[1] = mes
			//date[2] = ano
			$date = explode("-", $linha["para"]);

			if ($linha["quem"]=="" && $linha["voltou"]==0) {
				$total += $linha["valor"];
				$qnt++;

				
				

				if($date[1]<=date("m") && $date[2]<=date("Y")){

					if ($date[1]==date("m") && $date[0]<=date("d")) {
						$compensados++;
						$numeros .= ",".$linha["numero"]; 
						$vCompensados +=$linha["valor"];
					}elseif ($date[1]<date("m")) {
						$compensados++;
						$numeros .= ",".$linha["numero"];
						$vCompensados +=$linha["valor"];

					}
				}
			}

			$data = explode("-", $linha["data"]);
			$para = explode("-", $linha["para"]);

			if ($cliente["cidade"]!="") {
				$cidade = $this->pegaDadosCodigo("municipios",$cliente["cidade"]);	
			}else{
				$cidade["nome"] = "xxxxx";
			}

			if ($cliente["vendedor"]!="") {
				$vendedor = $this->pegaDados("funcionarios",$cliente["vendedor"]);
			}else{
				$vendedor["nome"] = "xxxxx";
			}

			
			

			$lista.= "

			<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".$linha["numero"]."</td>
				<td class='center'><a href='".URL."Clientes/Relatorio/".$linha["cliente"]."' target='_blank'>".html_entity_decode($cliente["nome"])." - ".$cidade["nome"]."</a></td>
				<td class='center'>".html_entity_decode($vendedor["nome"])."</td>
				<td class='center'>".html_entity_decode($linha["quem"])."</td>
				<td class='center'>R$ ".number_format($linha["valor"],2,",",".")."</td>
				<td class='center'>".$data[2]."-".$data[1]."-".$data[0]."</td>
				<td class='center'>".$para[2]."-".$para[1]."-".$para[0]."</td>
				<td class='actBtns'>
					";
					if ($linha["voltou"]==0) {
						$lista.= "
						<a href='".URL.$_GET["var1"]."/Voltou/".$linha["id"]."' title='Voltou' class='tipS'>
							<img src='". Folder."images/icons/control/16/check.png' alt='' /> 
						</a>";
					}else{
						$lista.= "
						<a href='".URL.$_GET["var1"]."/Pago/".$linha["id"]."' title='Voltou' class='tipS'>
							<img src='". Folder."images/icons/control/16/future-projects.png' alt='' /> 
						</a>";
					}

					$lista.= "

					<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
						<img src='". Folder."images/icons/control/16/pencil.png' alt='' /> 
					</a> 
					<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
						<img src='". Folder."images/icons/control/16/clear.png' alt='' />
					</a>
				</td>
			</tr>";

		}

		if ($vCompensados==0) {
			$vCompensados="0";
		}
		if ($total==0) {
			$total="0";
		}

		$this->view->compensados = $compensados;
		$this->view->numeros = $numeros;
		$this->view->vCompensados = $vCompensados;
		$this->view->total = $total." - ".$qnt." Cheques";
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

	protected function compensado($id,$compensado){

		if ($compensado==1) {
			
			$query = "UPDATE chqclientes SET compensado=1 WHERE id=".$id;

		}else{

			$query = "UPDATE chqclientes SET compensado=0 WHERE id=".$id;

		}
		

		$sql = $this->model->query($query);

		return true;

	}

	/*
	 *
	 *
	 * FUNCOES ATIVAR E DESATIVAR
	 *
	 *
	 *
	 */
	protected function ativar($id,$tabela) {



		if (!$tabela) {
			$tabela = $_GET["var1"];
		}
		// VARIAVEIS DE DADOS JA CADASTRADOS
		$query = "UPDATE ".$tabela." SET voltou=1 WHERE id=".$id;

		//$this->error($query);
		if ($this->model->query ( $query )) {

			$this->Log("Alteracao na tabela $tabela para pago a numero=$id; query($query)");


			header("Location: ".URL.$_GET["var1"]);

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
		$query = "UPDATE ".$tabela." SET voltou=0 WHERE id=".$id;

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
	protected function editar($id,$tabela=false) {

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
		$query .= "WHERE id=" . $id . "";
		//$query .= ";";
		//$query = "UPDATE `Noticias` SET `titulo_br`='Wilker' Where id = 1"; //  LINHA DE TESTE

		//$this->error($query);

		if ($this->model->query ( $query )) {

			$this->Log("Alterou o Cheque de id $id");

			unset($_POST);
			header("Location: ".URL.$_GET["var1"]);
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
		$query .= "WHERE id='" . $id . "'";
		$query .= ";";

		if ($this->model->query ( $query )) {

			$this->Log("Deletou o Cheque de id $id");

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


		$valores_db = $this->model->query("SELECT * FROM `".$tabela."` WHERE id=".$id);
		$linha = mysql_fetch_array($valores_db);


		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);

		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i]	= $linha[$variaveis[$i]];
		}

	}


	protected function LimiteDias(){

		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM chqclientes WHERE quem='' AND voltou=0 ORDER BY id DESC";

		$valores_db = $this->model->query($query);
		$letra = "B";


		$time_inicial = $this->geraTimestamp(date("d-m-Y"));



		while ($linha = mysql_fetch_array($valores_db)) {
			
			$diferenca = ($this->geraTimestamp($linha["para"]) - $time_inicial);

			$dias = (int)floor( $diferenca / (60 * 60 * 24));

			if ($dias<=$_POST["dias"]) {



				if ($letra=="B") {
					$letra="A";
				}elseif ($letra=="A") {
					$letra = "B";
				}

				$cliente = $this->pegaDados("clientes", $linha["cliente"]);


				$date = explode("-", $linha["para"]);



				$data = explode("-", $linha["data"]);
				$para = explode("-", $linha["para"]);

				if ($cliente["cidade"]!="") {
					$cidade = $this->pegaDadosCodigo("municipios",$cliente["cidade"]);	
				}else{
					$cidade["nome"] = "xxxxx";
				}

				if ($cliente["vendedor"]!="") {
					$vendedor = $this->pegaDados("funcionarios",$cliente["vendedor"]);
				}else{
					$vendedor["nome"] = "xxxxx";
				}




				$lista.= "

				<tr class='grade".$letra."'>
					<td class='center'>".$linha["id"]."</td>
					<td class='center'>".$linha["numero"]."</td>
					<td class='center'><a href='".URL."Clientes/Relatorio/".$cliente["id"]."' target='_blank'>".html_entity_decode($cliente["nome"])." - ".$cidade["nome"]."</a></td>
					<td class='center'>".html_entity_decode($vendedor["nome"])."</td>
					<td class='center'>".$dias."</td>
					<td class='center'>R$ ".number_format($linha["valor"],2,",",".")."</td>
					<td class='center'>".$data[2]."-".$data[1]."-".$data[0]."</td>
					<td class='center'>".$para[2]."-".$para[1]."-".$para[0]."</td>
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

		}

		

		echo $lista;


	}

	private function geraTimestamp($data) {

		$partes = explode('-', $data);

		return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);

	}

}