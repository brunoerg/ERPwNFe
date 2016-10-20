<?php
class FiadoController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

			if ($_POST["vendedor"]!=0 && isset($_POST["data"]) && isset($_POST["balanco"])) {


				$this->cadastrar("fiados");
			}else{

				if (isset($_POST["data"]) && isset($_POST["balanco"])) {
					$this->error("Selecione um Vendedor");
				}elseif(isset($_POST["total"]) && isset($_POST["balanco"])){
					$this->error("Selecione uma Data");
				}elseif(!isset($_POST["balanco"])){
					$this->error("Selecione a ID de um Balanco");
				}
			}

			$this->vendedor();
			$this->view->render ( 'fiados/novo' );
			break;

			case "Editar":

			if ($_POST["vendedor"]!=0 && isset($_POST["data"]) && isset($_POST["balanco"])) {
				$this->editar($_GET["var3"],"fiados");
			}else{
				if (isset($_POST["data"]) && isset($_POST["balanco"])) {
					$this->error("Selecione um Vendedor");
				}elseif(isset($_POST["total"]) && isset($_POST["balanco"])){
					$this->error("Selecione uma Data");
				}elseif(!isset($_POST["balanco"])){
					$this->error("Selecione a ID de um Balanco");
				}
			}

			$this->pegaId("fiados",$_GET["var3"]);
			$this->vendedor();
			$this->view->render ( 'fiados/novo' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "fiados");

			$this->listar();

				//Futuramente criar lista com os fiados
				//$this->view->pdf = $this->pdf();
			$this->view->render ( 'fiados/index' );
			break;

			default:

			$this->listar();
			$this->view->render ( 'fiados/index' );
			break;
		}
	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA fiados NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM fiados";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$vendedor = $this->pegaDados("funcionarios", $linha["vendedor"]);

			$lista.= "

			<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".htmlspecialchars($vendedor["nome"])."</td>
				<td class='center'>R$ ".number_format($linha["ida"],2)."</td>
				<td class='center'>R$ ".number_format($linha["volta"],2)."</td>
				<td class='center'>".$linha["data"]."</td>
				<td class='center'>".$linha["balanco"]."</td>
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


	private function vendedor(){

		$query = "SELECT * FROM funcionarios WHERE funcao=1";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->vendedor) && $linha["id"]==$this->view->vendedor) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->vendedores = $lista;
	}

}