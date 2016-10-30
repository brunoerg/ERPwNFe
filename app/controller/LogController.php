<?php
class LogController extends Controller {
	function __construct() {
		parent::__construct ();

	}

	function index() {

		if (!isset($_POST["data"])) {
			$_POST["data"]=date("d-m-Y");
		}
		$this->listar();
		$this->view->render ( 'logs/index' );
	}

	protected function listar() {

		//pasta
		$pasta = "app/public/logs/";

		$data = explode("-",$_POST["data"]);
		$ano = $data[2];
		$ano = substr($ano, 2,4);
		$data[2]=$ano;
		$data = implode("-", $data);
		//Nome do arquivo:
		$arquivo = $pasta."Log_".$data.".txt";



		//ABRE O ARQUIVO TXT
		$ponteiro = fopen ($arquivo,"r");

		$i=1;
		//L� O ARQUIVO AT� CHEGAR AO FIM
		while (!feof ($ponteiro)) {
			//L� UMA
			//LINHA DO ARQUIVO
			$linha = fgets($ponteiro,4096);
			//IMPRIME NA TELA
			//O RESULTADO
			$log = explode(">", $linha);

			$dados = explode("]", $log[0]);

			$usuario = substr($dados[1], 1,strlen($dados[1]));

			if (strstr($usuario, "Desconhecido")) {
				$usuario = "<span style='color: red;'>".$usuario."</span>";
			}
			
			$txt[$i]= "
			<li style='margin-left:20px;'><b>$i.</b> <span style='color: red;'>".substr($dados[0], 1,8)."</span> - 
				<span style='color: blue; font-weight: bold;'> ".$usuario." :</span>
				<span style='color: blue; font-weight: bold;'> ".substr($dados[2], 1,strlen($dados[2]))." :</span>
				<span style='color: blue; font-weight: bold;'> ".substr($dados[3], 1,strlen($dados[3]))." :</span>
				<span style='color: #000; font-style:italic;'>
					".$log[1]."
				</span>
			</li>";

			$i++;
		}//FECHA WHILE

		//FECHA
		//O PONTEIRO DO ARQUIVO
		fclose ($ponteiro);

		
		krsort($txt);

		$txt = implode("<br>", $txt);


		$this->view->log= $txt;
	}


}