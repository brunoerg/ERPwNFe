<?php
class RelatorioFiscalController extends Controller {

	public $ToolsNFe;
	

	function __construct() {

		$this->ambiente = array(1=>"Produ&ccedil;&atilde;o",2=>"Homologa&ccedil;&atilde;o");
		$this->TpNfe = array("Entrada","Saida");
		$this->pastaAmb = array(1=>"producao",2=>"homologacao");

		parent::__construct ();
		$this->ToolsNFe = new ToolsNFePHP();
	}

	private function Status() {

		$this->view->TipoDeAmbiente = $this->ToolsNFe->tpAmb;


		$uf = $this->ToolsNFe->UF;
		$return = $this->ToolsNFe->statusServico($uf);
		if ($return==false) {
			$this->info( "<span style='color:red;font-weight:bold;'>
				Servi&ccedil;o de ".$this->ambiente[$this->ToolsNFe->tpAmb]." 
				NFe est&aacute; Off Line!!! Servidor do SEFAZ ".$uf." Fora do Ar!!
			</span>");

			$this->Status = false;

			return  false;
		} else {
			$this->info(  "<span style='color:green;font-weight:bold;'>
				Servi&ccedil;o de ".$this->ambiente[$this->ToolsNFe->tpAmb]." 
				NFe est&aacute; ON line! Servidor do SEFAZ ".$uf." Funcionando!!
			</span>");
			if ($_GET["var2"]=="Status") {

				$this->info(  '<br><pre>');
				foreach ($return as $k => $v) {
					$this->info( $k."=>".$v."<br>" );
				}
				$this->info(  '</pre>');
			}
			$this->Status = true;
			return  true;
		}


	}






	function index() {

		switch ($_GET["var2"]) {



			case 'Zip':
			$this->Status();

			$vars = explode("-", $_GET["var3"]);

			if ($vars[0]=="Entradas") {
				$file = $this->ZipEntradas($vars[1].'-'.$vars[2]);
			}else{
				$file = $this->ZipSaidas($vars[1].'-'.$vars[2]);
			}

			if(ini_get('zlib.output_compression')){
				ini_set('zlib.output_compression', 'Off');
			}
			
			header("Content-Type: application/zip");
			header("Content-Disposition: attachment; filename=".basename($file)); 
			readfile($file); 
			exit; 


			break;




			default:
			$this->listasRelatorio();
			
			$this->view->render('relatoriofiscal/index');
			break;
		}

	}




	protected function listasRelatorio(){

		if (isset($_POST["mes"])) {
			$data = $_POST["mes"]."-".$_POST["ano"];
		}else{
			$_POST["mes"] = date("m");
			$_POST["ano"] = date("Y");
			$data = date("m")."-".date("Y");
		}

		if ($_POST["mes"]<10 && strlen($_POST["mes"])==1) {
			$_POST["mes"]= "0".$_POST["mes"];
		}

		$this->ListarEntradas($data);
		$this->ListarSaidas($data);
		$this->listarAvulsas($data);
		$this->listarReducoes($data);




		$this->view->Saldo = ($this->view->TotalEntrada+($this->view->TotalEntrada*0.3))-($this->view->TotalSaida + $this->view->TotalAvulsas+$this->view->TotalReducoes);

		$this->atualizaSaldo(number_format($this->view->Saldo,2,".",""),$data);

		$this->view->saldoAnterior = $this->saldoAnterior($data);

	}

	protected function atualizaSaldo($saldo,$data){

		$query = "SELECT * FROM saldos WHERE data='".$data."'";
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);
		if ($linha["data"]) {
			$query = "UPDATE saldos SET saldo='".$saldo."' WHERE data='".$data."'";
			$sql = $this->model->query($query);
		}else{
			$query = "INSERT INTO saldos (data,saldo) VALUES ('".$data."','".$saldo."')";
			$sql = $this->model->query($query);
		}
	}


	protected function saldoAnterior($data){

		$data = explode("-", $data);

		$query = "SELECT * FROM saldos";
		$sql = $this->model->query($query);
		while($linha = mysql_fetch_assoc($sql)){

			$date = explode("-", $linha["data"]);

				// date[0] e data[0] = mes
				// date[1] e data[1] = mes

			if ($date[0]<$data[0]&&$date[1]==$data[1]) {
				$saldo+=$linha["saldo"];
			}elseif ($date[1]<$data[1]) {
				$saldo+=$linha["saldo"];
			}
		}

		return $saldo;

	}



	protected function listarSaidas($data) {
		$lista="";

		$query = "SELECT * FROM nfe WHERE dEmi LIKE ('%".$data."')";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}
			
			$dadosCliente = $this->pegaDados("config_nfe", "1");

			$destinatario = $this->pegaDados("destinatarios", $linha["destinatario"]);
			$lista.= "
			<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".$linha["numero"]."</td>
				<td class='center'>".$linha["serie"]."</td>
				<td class='left'>".htmlspecialchars($destinatario["xNome"])."</td>
				<td class='center'>".$linha["dEmi"]."</td>
				<td class='center'>".$this->TpNfe[$linha["tpNF"]]."</td>";	

				$file="app/public/complementos/nfephp/nfe/".$this->pastaAmb[$linha["tpAmb"]]."/enviadas/aprovadas/".$linha["chave"]."-procNfe.xml";
				if (file_exists($file)) {

					$xml=file_get_contents($file);

					$xml=explode("<total>", $xml);
					$xml=explode("<vProd>", $xml[1]);
					$xml=explode("</vProd>", $xml[1]);

					if ($linha["natOp"]=="5104") {
						$this->view->TotalSaida+=$xml[0];
					}


					$lista.="<td class='center'>R$ ".number_format($xml[0],2,",",".")."</td>";
				}else{

					$lista.="<td class='center'>False</td>";
				}



				if (file_exists("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$linha["tpAmb"]]."/canceladas/".$linha["chave"]."-1-procCanc.xml") && $linha["cancelada"]!="1") {
					$query = "UPDATE nfe SET cancelada=1 WHERE chave='".$linha["chave"]."'";
					$this->model->query($query);
				}
				if ($linha["cancelada"]=="1") {
					$lista.= "
					<td class='center'>
						<a href='".URL."NFe/XML/".base64_encode("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$linha["tpAmb"]]."/canceladas/".$linha["chave"]."-1-procCanc.xml".$linha["chave"])."' title='XML' class='tipS'>
							<img src='". Folder."images/icons/control/32/xml.png' alt='' height='36' />
						</a>
					</td>
					<td class='center'>
						<a title='Cancelada' target='_blank' class='tipS'>
							<img src='". Folder."images/icons/control/new/block.png' width='24' alt='' />
						</a>
					</td>
					";
				}elseif (file_exists("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$linha["tpAmb"]]."/enviadas/aprovadas/".$linha["chave"]."-procNfe.xml")) {
					$lista.= "
					<td class='center'>
						<a href='".URL."NFe/XML/".base64_encode("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$linha["tpAmb"]]."/enviadas/aprovadas/".$linha["chave"]."-procNfe.xml".$linha["chave"])."' title='XML' class='tipS'>
							<img src='". Folder."images/icons/control/32/xml.png' alt='' height='36' />
						</a>
					</td>
					<td class='center'>
						<a href='".URL."NFe/GerarDanfe/".$linha["chave"]."' title='Pdf' target='_blank' class='tipS'>
							<img src='". Folder."images/icons/control/new/pdf.png' alt='' height='24' />
						</a>
					</td>";
				}else{
					$lista.= "
					<td class='center'></td>
					<td class='center'></td>";
				}



				$lista.= "
			</tr>";

		}

		$this->view->lista = $lista;

	}


	protected function listarAvulsas($data) {



		$lista="";

		$query = "SELECT * FROM nfavulsas WHERE data LIKE ('%".$data."')";

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
				<td class='center'>".$linha["data"]."</td>
				<td class='center'>R$ ".number_format($linha["valor"],2,",",".")."</td>
			</tr>";

			$this->view->TotalAvulsas+=$linha["valor"];

		}

		$this->view->listaAvulsas = $lista;

	}





	protected function listarReducoes($data) {



		$lista="";

		$query = "SELECT * FROM reducoes WHERE data LIKE ('%".$data."')";

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
				<td class='center'>".$linha["contador"]."</td>
				<td class='center'>".$linha["data"]."</td>
				<td class='center'>R$ ".number_format($linha["valor"],2,",",".")."</td>
			</tr>";

			$this->view->TotalReducoes+=$linha["valor"];

		}

		$this->view->listaReducoes = $lista;

	}







	protected function ListarEntradas($data) {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM nfeEntrada WHERE emissao LIKE ('%".$data."')";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}



			$destinatario = $this->pegaDados("fornecedores", $linha["remetente"]);
			$lista.= "

			<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".$linha["numero"]."</td>
				<td class='center'>".$linha["serie"]."</td>
				<td class='left'>".htmlspecialchars($destinatario["nome"])."</td>
				<td class='center'>".$linha["emissao"]."</td>";	


				$file="app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/recebidas/".substr($linha["emissao"], 3,10)."/".$linha["chave"]."-procNFe.xml";
				if (file_exists($file)) {

					$xml=file_get_contents($file);

					$xml=explode("<total>", $xml);
					$xml=explode("<vProd>", $xml[1]);
					$xml=explode("</vProd>", $xml[1]);


					$this->view->TotalEntrada+=$xml[0];

					$lista.="<td class='center'>R$ ".number_format($xml[0],2,",",".")."</td>";
				}else{

					$lista.="<td class='center'>False</td>";
				}


				if (file_exists("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/recebidas/".substr($linha["emissao"], 3,10)."/".$linha["chave"]."-procNFe.xml")) {
					$lista.= "
					<td class='center'>
						<a href='".URL."NFe/XML/".base64_encode("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/recebidas/".substr($linha["emissao"], 3,10)."/".$linha["chave"]."-procNFe.xml".$linha["chave"])."' title='XML' class='tipS'>
							<img src='". Folder."images/icons/control/32/xml.png' alt='' height='36' />
						</a>
					</td>
					<td class='center'>
						<a href='".URL."NFe/Pdf/".$linha["chave"]."' title='Pdf' target='_blank' class='tipS'>
							<img src='". Folder."images/icons/control/new/pdf.png' alt='' height='24' />
						</a>
					</td>";
				}else{
					$lista.= "<td class='center'></td>
					<td class='center'></td>";
				}

				$lista.= "
			</tr>";

		}

		$this->view->listaEntrada = $lista;

	}





	protected function ZipEntradas($data){
		$dir = "app/public/temp/";
		$nome = 'NFe_Entrada_'.$data.'.zip';
		$diretorio = "app/public/complementos/nfephp/nfe/producao/recebidas/".$data."/";

		$direct = dir($diretorio);


		$zip = new ZipArchive();

		if ($zip->open($dir.$nome, ZIPARCHIVE::CREATE) !== TRUE) {
			die ("Erro!");
		}

		while($arquivo = $direct->read()){
			if (is_file($diretorio.$arquivo)) {
				$zip->addFile($diretorio.$arquivo,$arquivo) or die ("ERRO: Não é possível adicionar o arquivo: $arquivo");
			}else{

			}

		}

		$zip->close();

		return $dir.$nome;

	}


	protected function ZipSaidas($data){
		$dir = "app/public/temp/";
		$nome = 'NFe_Saida_'.$data.'.zip';
		$diretorio = "app/public/complementos/nfephp/nfe/producao/enviadas/aprovadas/";

		$zip = new ZipArchive();

		if ($zip->open($dir.$nome, ZIPARCHIVE::CREATE) !== TRUE) {
			die ("Erro!");
		}

		$query = "SELECT * FROM nfe WHERE dEmi LIKE ('%".$data."')";

		$valores_db = $this->model->query($query);

		while ($linha = mysql_fetch_array($valores_db)) {
			if(is_file($diretorio.$linha["chave"]."-procNfe.xml")){
				$zip->addFile($diretorio.$linha["chave"]."-procNfe.xml",$linha["chave"]."-procNfe.xml") or die ("ERRO: Não é possível adicionar o arquivo: ".$linha["chave"]."-procNfe.xml");
			}else{
				die ("ERRO: Não é possível encontrar o arquivo: ".$diretorio.$linha["chave"]."-procNfe.xml");
			}
		}

		$zip->close();

		return $dir.$nome;

	}

}