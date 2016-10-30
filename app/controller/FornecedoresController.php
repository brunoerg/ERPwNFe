<?php
class FornecedoresController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

				if (isset($_POST["nome"])) {
					$this->cadastrar("fornecedores");
				}

				$this->view->render ( 'fornecedores/novo' );
				break;

			case "Editar":

				if (isset($_POST["nome"])) {
						
					if ($_POST["pagamento"]=="0") {
						unset($_POST["pagamento"]);
					}
						
					$this->editar($_GET["var3"],"fornecedores");
				}

				$this->pegaId("fornecedores",$_GET["var3"]);

				$this->view->render ( 'fornecedores/novo' );
				break;

			case "Deletar":

				$this->deletar($_GET["var3"], "fornecedores");

				$this->listar();

				//Futuramente criar lista com os fornecedores
				//$this->view->pdf = $this->pdf();
				$this->view->render ( 'fornecedores/index' );
				break;
					
			default:

				$this->listar();
				$this->view->render ( 'fornecedores/index' );
				break;
		}
	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA fornecedores NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM fornecedores";

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
			<td class='center'>".html_entity_decode($linha["nome"])."</td>
			<td class='center'>".html_entity_decode($linha["cidade"])."</td>
			<td class='center'>".$linha["fone"]."</td>
			<td class='center'>".$linha["email"]."</td>
				<td class='actBtns'>
				<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'><img
						src='". Folder."images/icons/control/16/pencil.png'
						alt='' /> </a> <a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'><img
						src='". Folder."images/icons/control/16/clear.png' alt='' />
				</a>
				</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}



}