<?php
class ReducoesController extends Controller {

	
	function __construct() {


		parent::__construct ();	
	}



	function index() {

		switch ($_GET["var2"]) {


			case "Cadastrar":
			


			if (isset($_POST["id"])) {
				$this->cadastrar("reducoes",$_GET["var3"]);
			}


			
			$this->view->render ( 'reducoes/cadastrar' );

			break;



			case "Editar":
			


			if (isset($_POST["valor"])) {
				$this->editar($_GET["var3"],"reducoes",false);
				header("Location: ".URL."Reducoes");
			}


			$this->pegaId("reducoes",$_GET["var3"]);
			$this->view->render ( 'reducoes/cadastrar' );

			break;




			case "Deletar":


			$query = "DELETE FROM reducoes WHERE id=".$_GET["var3"];
			


			if ($this->model->query ( $query )) {
				header("Location: ".URL."Reducoes");
			}else{
				die(mysql_error());
			}


			break;


			default:
			

			$this->listar();
			
			$this->view->render ( 'reducoes/index' );
			break;
		}

	}
	protected function listar() {



		$lista="";

		$query = "SELECT * FROM reducoes";

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
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".$linha["contador"]."</td>
				<td class='center'>".($linha["data"])."</td>
				<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
				<td class='actBtns'>
					<a href='".URL.$_GET["var1"]."/EditarReducao/".$linha["id"]."' title='Editar' class='tipS'>
						<img src='". Folder."images/icons/control/16/pencil.png' alt='' /> 
					</a> 
					<a href='".URL.$_GET["var1"]."/DeletarReducao/".$linha["id"]."' title='Deletar' class='tipS'>
						<img src='". Folder."images/icons/control/16/clear.png' alt='' />
					</a>
				</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}
}