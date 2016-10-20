<?php
class BancosController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

			if ($_POST["nome"]!="" && $_POST["numero"]!="") {
				$this->cadastrar("bancos");
			}

			$this->view->render ( 'bancos/novo' );
			break;

			case "Editar":

			if ($_POST["nome"]!="0" && $_POST["numero"]!="") {
				$this->editar($_GET["var3"],"bancos");
			}

			$this->pegaId("bancos",$_GET["var3"]);
			$this->view->render ( 'bancos/novo' );
			break;

			case "Deletar":
			$this->deletar($_GET["var3"], "bancos");
			break;

			default:

			$this->listar();
			$this->view->render ( 'bancos/index' );
			break;
		}
	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA bancos NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		
		$query = "SELECT * FROM bancos ORDER BY nome";

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
				<td class='center'>".($linha["numero"]=="0"? "" : $linha["numero"])."</td>
				<td class='center'>".htmlspecialchars($linha["nome"])."</td>
				<td class='center'>".htmlspecialchars($linha["abv"])."</td>
				<td class='center'>".($linha["agencia"]=="0"? "" : $linha["agencia"])."</td>
				<td class='center'>".($linha["conta"]=="0"? "" : $linha["conta"])."</td>
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