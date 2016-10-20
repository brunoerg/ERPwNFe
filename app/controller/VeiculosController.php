<?php
class VeiculosController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

				if (isset($_POST["placa"])) {
					$_POST["placa"] = strtoupper($_POST["placa"]);
					$_POST["chassi"] = strtoupper($_POST["chassi"]);
					$this->cadastrar("veiculos");
				}
				$this->funcionarios();
				$this->ufs();
				$this->view->render ( 'veiculos/novo' );
				break;

			case "Editar":

				if (isset($_POST["placa"])) {
					$_POST["placa"] = strtoupper($_POST["placa"]);
					$_POST["chassi"] = strtoupper($_POST["chassi"]);
					$this->editar($_GET["var3"],"veiculos");
				}

				$this->pegaId("veiculos",$_GET["var3"]);
				$this->ufs();
				$this->funcionarios();
				$this->view->render ( 'veiculos/novo' );
				break;

			case "Deletar":

				$this->deletar($_GET["var3"], "veiculos");

				$this->listar();

				//Futuramente criar lista com os veiculos
				//$this->view->pdf = $this->pdf();
				$this->view->render ( 'veiculos/index' );
				break;
					
			default:

				$this->listar();
				$this->view->render ( 'veiculos/index' );
				break;
		}
	}





	private function funcionarios(){

		$query = "SELECT * FROM funcionarios ORDER BY funcao";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->motorista) && $linha["id"]==$this->view->motorista) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->funcionarios = $lista;
	}

	private function ufs(){

		$query = "SELECT * FROM estados ORDER BY sigla";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->motorista) && $linha["id"]==$this->view->motorista) {
				$lista .="<option value='".$linha["sigla"]."' selected>".$linha["sigla"]."</option>";
			}else{
				$lista .="<option value='".$linha["sigla"]."'>".$linha["sigla"]."</option>";
			}
		}


		$this->view->ufs = $lista;
	}

	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA veiculos NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM veiculos";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$motorista = $this->pegaDados("funcionarios", $linha["motorista"]);

			$lista.= "
		
			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".$linha["descricao"]." - ".$linha["fabricacao"]."/".$linha["modelo"]."</td>
			<td class='center'>".$motorista["nome"]."</td>
			<td class='center'>".$linha["placa"]."</td>
			<td class='center'>".$linha["renavam"]."</td>
			<td class='center'>".$linha["chassi"]."</td>
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