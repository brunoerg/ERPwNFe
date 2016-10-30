<?php
class ErrorController extends Controller {
	protected  $paginaError;

	function __construct() {
		parent::__construct ();
		//$this->paginaError = $pg;
	}

	function index() {
		

		
		$pg = $_GET["var2"];

		$pagina = $_GET["var3"];
		
		

		switch ($pg) {
			case 1:
			$this->Log("Erro numero 1. Acesso negado!");
			$this->view->render ( 'error/negado',true );
			break;

			case 2:
			$this->Log("Erro numero 2 (404). Pagina $pagina nao encontrada!");
			$this->view->render ( 'error/404',true );
			break;

			case 3:
			$this->view->render ( 'error/405' ,true);
			break;

			case 4:
			$this->view->render ( 'error/500',true );
			break;

			case 5:
			$this->view->render ( 'error/503' ,true);
			break;

			default:
			$this->view->render ( 'error/index',true );
			break;
		}

	}
}