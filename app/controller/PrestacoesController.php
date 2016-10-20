<?php
class PrestacoesController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		switch ($_GET["var2"]) {
			case "Adicionar":

				if (isset($_POST["descricao"])) {

					$this->cadastrar("prestacoes");

				}
				$this->view->render ( 'prestacoes/novo' );
				break;

			case "Editar":

				if (isset($_POST["descricao"])) {
					$this->editar($_GET["var3"],"prestacoes");
				}

				$this->pegaId("prestacoes",$_GET["var3"]);
				$this->view->render ( 'prestacoes/novo' );
				break;


			case "Abater":


				$this->abater($_GET["var3"]);

				$this->listar();

				$this->view->render ( 'prestacoes/index' );
				break;


			case "Deletar":

				$this->deletar($_GET["var3"], "prestacoes");

				$this->listar();

				//Futuramente criar lista com os prestacoes
				//$this->view->pdf = $this->pdf();
				$this->view->render ( 'prestacoes/index' );
				break;
					
			default:

				$this->listar();
				$this->view->render ( 'prestacoes/index' );
				break;
		}
	}


	protected function abater($id) {

		$prestacao = $this->pegaDados("prestacoes", $_GET["var3"]);

		$parcelas = $prestacao["parcelas"]-1;

		if ($parcelas==0) {
			$this->deletar($_GET["var3"], "prestacoes");
		}

		// VARIAVEIS DE DADOS JA CADASTRADOS
		$query = "UPDATE prestacoes SET parcelas=".$parcelas." WHERE id=".$_GET["var3"];

		//$this->error($query);
		if ($this->model->query ( $query )) {
				
			$this->Log("Abateu uma parcela da presta��o de id ".$_GET["var3"].". Restam $parcelas");
			header("Location: ".URL.$_GET["var1"]);
		}else{
			die(mysql_error());
		}


		//return true;
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

		$query = "SELECT * FROM prestacoes";

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
			<td class='center'>".htmlspecialchars($linha["descricao"])."</td>
			<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
			<td class='center'>".$linha["parcelas"]."</td>
			<td class='center'>".$linha["vencimento"]."</td>
			<td class='center'>
			";

			$lista.= "
			<a href='".URL.$_GET["var1"]."/Abater/".$linha["id"]."' title='Abater' class='tipS'>
			<img src='". Folder."images/icons/control/16/ticket.png' alt='' /> 
			</a>";


			$lista.= "</td>
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