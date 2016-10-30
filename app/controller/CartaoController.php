<?php
class CartaoController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

			if ($_POST["bandeira"]!="0" && $_POST["vencimento"]!="") {


				$this->cadastrar("cartao");
			}else{

				if (isset($_POST["vencimento"])) {
					$this->error("Selecione uma Bandeira");
				}
			}

			$this->bandeira();
			$this->view->render ( 'cartao/novo' );
			break;

			case "Editar":

			if ($_POST["bandeira"]!=0 && isset($_POST["vencimento"])) {
				$this->editar($_GET["var3"],"cartao");
			}else{
				if (isset($_POST["vencimento"])) {
					$this->error("Selecione um bandeira");
				}elseif(isset($_POST["total"])){
					$this->error("Selecione uma Data");
				}
			}

			$this->pegaId("cartao",$_GET["var3"]);
			$this->bandeira();
			$this->view->render ( 'cartao/novo' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "cartao");

			$this->listar();

				//Futuramente criar lista com os cartao
				//$this->view->pdf = $this->pdf();
			$this->view->render ( 'cartao/index' );
			break;

			default:

			$this->listar();
			$this->view->render ( 'cartao/index' );
			break;
		}
	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA cartao NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM cartao";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$bandeira = $this->pegaDados("bandeiras", $linha["bandeira"]);

			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".htmlspecialchars($linha["nome"])."</td>
			<td class='center'>".htmlspecialchars($bandeira["nome"])."</td>
			<td class='center'>".$linha["vencimento"]."</td>
			<td class='center'>".$linha["fechamento"]."</td>
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


	private function bandeira(){

		$query = "SELECT * FROM bandeiras ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->bandeira) && $linha["id"]==$this->view->bandeira) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->bandeiras = $lista;
	}

}