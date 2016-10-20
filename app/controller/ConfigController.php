<?php
class ConfigController extends Controller {
	function __construct() {
		parent::__construct();
	}

	function index() {

		switch ($_GET["var2"]) {


			default:
				if (isset($_POST["nome"])) {
					$this -> editar(1, "config_empresa");
				}

				if (isset($_POST["agencia"])) {
					$this -> editar(1, "config_boletos_bb");
				}

				if (isset($_POST["xNome"])) {
					$this -> editar(1, "config_nfe");
				}

				$this -> pegaId("config_empresa", 1);
				$this -> pegaId("config_boletos_bb", 1);
				$this -> pegaId("config_nfe", 1);
				$this->listas();

				$this -> view -> render('config/index');
				break;
		}


	}

	protected function listas() {
		$this->cMun();

		$this->cPais();

		$this->CRT();
	}

	protected function cMun() {

		$query = "SELECT * FROM municipios ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->cMun) && $linha["codigo"]==$this->view->cMun) {
				$lista .="<option value='".$linha["codigo"]."' selected>".$linha["codigo"]."</option>";
				$listax .="<option value='".$linha["nome"]."' selected>".utf8_encode($linha["nome"])."</option>";
			}else{
				$lista .="<option value='".$linha["codigo"]."'>".$linha["codigo"]."</option>";
				$listax .="<option value='".$linha["codigo"]."' >".utf8_encode($linha["nome"])."</option>";

			}
		}


		$this->view->cMun = $lista;
		$this->view->xMun = $listax;
	}

	protected function cPais() {

		$query = "SELECT * FROM paises ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->cPais) && $linha["codigo"]==$this->view->cPais) {
				$lista .="<option value='".$linha["codigo"]."' selected>".$linha["codigo"]."</option>";
				$listax .="<option value='".$linha["nome"]."' selected>".utf8_encode($linha["nome"])."</option>";
			}else{
				$lista .="<option value='".$linha["codigo"]."'>".$linha["codigo"]."</option>";
				$listax .="<option value='".$linha["codigo"]."' >".utf8_encode($linha["nome"])."</option>";

			}
		}


		$this->view->cPais = $lista;
		$this->view->xPais = $listax;
	}

	protected function CRT() {

		$query = "SELECT * FROM crt";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->CRT) && $linha["id"]==$this->view->CRT) {
				$lista .="<option value='".$linha["id"]."' selected>".utf8_decode($linha["descricao"])."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".utf8_decode($linha["descricao"])."</option>";

			}
		}


		$this->view->CRT = $lista;
	}
}
