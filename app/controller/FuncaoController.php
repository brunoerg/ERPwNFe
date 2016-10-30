<?php
class FuncaoController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

			if (isset($_POST["nome"])) {
				if (!isset($_POST["comissao"])) {
					$_POST["comissao"]=0;
				}
				$this->cadastrar("funcoes");
			}

			$this->view->render ( 'funcoes/novo' );
			break;

			case "Editar":

			if (isset($_POST["nome"])) {
				if (!isset($_POST["comissao"])) {
					$_POST["comissao"]=0;
				}
				$this->editar($_GET["var3"],"funcoes");
			}

			$this->pegaId("funcoes",$_GET["var3"]);
			$this->view->render ( 'funcoes/novo' );
			break;

			case "Deletar":
			$this->deletar($_GET["var3"], "funcoes");
			break;

			default:

			$this->listar();
			$this->view->render ( 'funcoes/index' );
			break;
		}
	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA funcao NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {

		$lista="";
		
		$query = "SELECT * FROM funcoes ORDER BY nome";

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
				<td class='center'>".$linha["nome"]."</td>
				<td class='center'>".($linha["comissao"]=="0"? "Não" : "Sim")."</td>
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
}