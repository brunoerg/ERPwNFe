<?php
class LogController extends Controller {
	function __construct() {
		parent::__construct ();

	}

	function index() {

		if (isset($_POST["data"])) {
			$this->listar();
		}

		$this->view->render ( 'logs/index' );
	}

	protected function listar() {

		//pasta
		$pasta = URL."app/public/logs/";

		$data = $_POST["data"];
		$ano = explode("-",$data);
		$ano = $ano[2];
		$ano = substr($ano, 2);
		$data[2]=$ano;
		$data = implode("-", $data);
		//Nome do arquivo:
		$arquivo = $pasta."Log_".$data.".txt";

		$contents = file_get_contents($arquivo);
		
		$lines = count($contents);

		while($lines != 0) {
			$txt .= "<li style='color: red'>";
			foreach($contents as $field) {
				$txt .= "<td> 14:30:02 - <span
				style='color: blue; font-weight: bold;'>Wilker J. Ferreira Adorno:</span>
				<span
				style='color: #000; font-style:italic;'>Text in a pre element
					is displayed in a fixed-width
					font, and it preserves
					both      spaces and
					line breaks</span></td>";
			}
			$txt .= "</li>";
			$lines--;
		}
		
		$this->view->log= $txt;
	}


}