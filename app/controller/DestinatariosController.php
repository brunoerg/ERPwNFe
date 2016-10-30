<?php
class DestinatariosController extends Controller {

	
	function __construct() {


		parent::__construct ();	
	}



	function index() {

		switch ($_GET["var2"]) {


			case "Cadastrar":

			if (isset($_POST["xNome"])) {

				$this->limpar();

				$_POST["UF"] =strtoupper($_POST["UF"]); 
				$this->cadastrar("destinatarios");
			}
			$this->listas();

			$this->view->render ( 'destinatarios/novo' );
			break;






			case "Editar":
			$this->pegaId("destinatarios",$_GET["var3"]);
			if (isset($_POST["xNome"])) {

				$this->limpar();

				$_POST["UF"] =strtoupper($_POST["UF"]); 

				$this->editar($_GET['var3'],"destinatarios");
			}
			$this->listas();

			$this->view->render ( 'destinatarios/novo' );
			break;




			case "Deletar":


			$this->deletar($_GET['var3'],"destinatarios");



			$this->view->render ( 'destinatarios/index' );
			break;


			default:
			$this->listar();
			$this->view->render ( 'destinatarios/index' );
			break;
		}

	}


	protected function listas() {
		$this->cMun();

		$this->cPais();
	}

	protected function limpar() {

		$retirar = array("/",".",","," ","-","(",")","+55","+");

		$variaveis = array("CNPJ","CPF","IE","CEP","fone",);

		foreach ($variaveis as $value) {
			foreach ($retirar as $tirar) {
				$_POST[$value] = str_replace ( $tirar, "", $_POST[$value] );
			}
		}
	}


	protected function cMun() {

		$query = "SELECT * FROM municipios ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->cMun) && $linha["codigo"]==$this->view->cMun) {
				$lista .="<option value='".$linha["codigo"]."' selected>".$linha["codigo"]."</option>";
				$listax .="<option value='".$linha["codigo"]."' selected>".utf8_encode($linha["nome"])."</option>";
			}else{
				$lista .="<option value='".$linha["codigo"]."'>".$linha["codigo"]."</option>";
				$listax .="<option value='".$linha["codigo"]."' >".utf8_encode($linha["nome"])."</option>";

			}
		}


		$this->view->cMun = $lista;
		$this->view->xMun = $listax;
	}

	protected function cPais() {


		$lista .="<option value='1058' selected>1058</option>";
		$listax .="<option value='Brasil' selected>Brasil</option>";


		$this->view->cPais = $lista;
		$this->view->xPais = $listax;
	}






	protected function listar() {

		$lista="";

		$query = "SELECT * FROM destinatarios";

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
				<td class='center'>".htmlspecialchars($linha["xNome"])."</td>
				<td class='center'>".$linha["CNPJ"]."</td>
				<td class='center'>".$linha["email"]."</td>
				<td class='actBtns'>
					<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
						<img src='". Folder."images/icons/control/new/pencil-2.png' width='16' alt='' />
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