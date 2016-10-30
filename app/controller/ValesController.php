<?php
class ValesController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		switch ($_GET["var2"]) {
			case "Adicionar":

				if ($_POST["funcionario"]) {

					$this->cadastrar("vales");

				}
				$this->funcionarios();
				$this->view->render ( 'vales/novo' );
				break;

			case "Editar":

				if ($_POST["funcionario"]) {
					$this->editar($_GET["var3"],"vales");
				}
				$this->funcionarios();
				$this->pegaId("vales",$_GET["var3"]);
				$this->view->render ( 'vales/novo' );
				break;

			case "Deletar":

				$this->deletar($_GET["var3"], "vales");

				$this->listar();

				//Futuramente criar lista com os vales
				//$this->view->pdf = $this->pdf();
				$this->view->render ( 'vales/index' );
				break;

					
					
			default:

				$this->listar();
				$this->view->render ( 'vales/index' );
				break;
		}
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

		$query = "SELECT * FROM vales";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$funcionario = $this->pegaDados("funcionarios", $linha["funcionario"]);

			$lista.= "
		
			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".htmlspecialchars($funcionario["nome"])."</td>
			<td class='center'>".htmlspecialchars($linha["descricao"])."</td>
			<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
			<td class='center'> ".$linha["data"]."</td>
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

	private function funcionarios(){

		$query = "SELECT * FROM funcionarios";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->funcionario) && $linha["id"]==$this->view->funcionario) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->funcionarios = $lista;
	}
}