<?php
class NFeController extends Controller {

	public $ToolsNFe;
	public $NFeTXT;

	function __construct() {

		//error_reporting(0); FPDF


		$this->ambiente = array(1=>"Produ&ccedil;&atilde;o",2=>"Homologa&ccedil;&atilde;o");
		$this->TpNfe = array("Entrada","Saida");
		$this->pastaAmb = array(1=>"producao",2=>"homologacao");



		parent::__construct ();
		$this->ToolsNFe = new ToolsNFePHP();
		$this->NFeTXT = new NFeTXT();



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





	/*





	UPDATE produtosNFe 

	*/

	function index() {

		switch ($_GET["var2"]) {



			/*************************FUNCOES EXTRAS*************************/

			case "GetNumberNFe":

			$numero = $this->pegaNumNF($_POST["serie"]);
			echo $numero;
			break;

			case "Pesquisar":

			$this->Config();

			$this->buscar();

			break;

			case "GetDestinatario":

			$this->GetDestinatario();

			break;
			case "GetRemetente":

			$this->GetRemetente();

			break;



			case "Gerar":

			$this->Config();
			$NFeTxt = $this->geraTxt();
			$NFeXML = $this->geraXML($NFeTxt);
			$Assinar = $this->assinaNFe($NFeXML);

			break;
			case "GerarDanfe":	
			$this->GeraDanfe($_POST["file"]);
			break;


			case "Email":	

			$this->email();
			
			break;	

			case "Lote":
			$this->ConsultarRecibo();
			break;

			case "BuscarNFe":
			$this->BuscarNFe();
			break;

			case "RetornoCanc":
			$this->confirmCancel();
			break;

			case "CancelarNFe":

			if (isset($_POST["motivo"])) {
				if (strlen($_POST["motivo"]) < 15){
					echo "A justificativa deve ter pelo menos 15 digitos!!";
					
				}elseif (strlen($_POST["motivo"]) > 255){
					echo "A justificativa deve ter no m&aacute;ximo 255 digitos!!";
					
				}else{

					$this->cancelar();	
				}
			}

			break;

			case "ConfirmNFe":
			$this->ConfirmarNFe();
			break;

			case "GetNFe":

			$this->GetNFe();

			break;
			
			case 'Pdf':

			$this->Status();

			$this->Pdf();

			break;



			/*************************OUTRAS FUNCOES*************************/

			case 'XML':

			$var = base64_decode($_GET["var3"]);
			$vars = explode(".xml", $var);

			header('Content-disposition: attachment; filename="'.$vars[1].'.xml"');
			header('Content-type: "text/xml"; charset="utf8"');


			readfile($vars[0].".xml");
			
			break;

			case "Criar":
			$this->Config();
			
			$this->listas();
			if ($_POST["serie"]=="0") {
				$this->info("A serie da NFe não pode ser 0!");
			}elseif ( isset($_POST["natOp"]) && isset($_POST["indPag"]) && isset($_POST["tpNF"]) && isset($_POST["destinatario"])) {
				unset($_POST["idCliente"]);
				$this->prepararCadastro();
			}elseif ($_POST) {

				$array = array("natOp"=>$_POST["natOp"], "indPag"=>$_POST["indPag"], "tpNF"=>$_POST["tpNF"], "destinatario"=>$_POST["destinatario"]);
				foreach ($array as $key => $value) {
					if (!isset($value)) {
						foreach ($_POST as $key => $value) {
							$this->view->$key = $value;
						}
						$this->info("Ocorreu um erro no campo $key!");
					}
				}
				
			}


			$this->Status();

			$this->view->render ( 'nfe/novo' );
			break;
			case "Editar":
			
			if (isset($_POST["dEmi"])) {
				unset($_POST["idCliente"]);

				$this->editar($_GET["var3"],"nfe");
			}

			$this->Status();

			$this->pegaId("nfe",$_GET["var3"]);
			$this->listas();
			$this->view->render ( 'nfe/editar' );

			break;
			case "Item":
			
			$var = explode("-", $_GET["var3"]);

			if (isset($_POST["qCom"])) {
				$this->atualizar();
			}

			$this->dados();

			$this->Status();

			$this->view->render ( 'nfe/item' );

			break;

			case "Delete":
			$var = explode("-", $_GET["var3"]);

			$query = "DELETE FROM produtosNFe WHERE NFe=".$var[0]." AND produto=".$var[1];

			if ($this->model->query ( $query )) {

				header("Location: ".URL.$_GET["var1"]."/Produtos/".$var[0]);
			}else{
				die(mysql_error());
			}


			break;

			case "Deletar":

			$query = "DELETE FROM nfe WHERE id=".$_GET["var3"];
			
			if ($this->model->query ( $query )) {

				$query = "DELETE FROM produtosNFe WHERE NFe=".$_GET["var3"];
				if ($this->model->query ( $query )) {
					header("Location: ".URL.$_GET["var1"]."/Listar");
				}else{
					die(mysql_error());
				}
			}else{
				die(mysql_error());
			}

			break;

			case "Produtos":

			$this->Config();

			if (isset($_POST["qCom"])) {
				$_POST["NFe"] = $_GET["var3"];
				$_POST["qCom"] = str_replace(",", ".", $_POST["qCom"]);
				$_POST["vUnCom"] = str_replace(",", ".", $_POST["vUnCom"]);
				$_POST["vProd"] = $_POST["qCom"]*$_POST["vUnCom"];
				unset($_POST["busca"]);
				$this->cadastrar("produtosNFe");
			}

			$this->listarNFe();

			$this->Status();

			$this->pegaId("nfe",$_GET["var3"]);

			$dest = $this->pegaDados("destinatarios",$this->view->destinatario);

			$this->view->destinatario = htmlspecialchars($dest["xNome"]);

			$this->view->boletos = $this->pegaBoletos($_GET["var3"]);

			$this->view->render ( 'nfe/produtos' );
			break;
			case "Status":
			$this->view->render ( 'nfe/status' );
			break;
			case "Cancelar":

			$this->dadosCancelar();

			$this->status();
			
			$this->view->render ( 'nfe/cancelar' );

			break;

			case "Reproduzir":

			$this->listarReproduzir();

			if (isset($_POST["id"])) {

				$this->reproduzir();
			}
			$this->Status();
			$this->view->render ( 'nfe/reproduzir' );
			break;

			case "Install":
			$this->view->render ( 'nfe/install' );
			break;

			default:
			$this->Config();

			$this->Status();

			$this->listar();
			$this->view->render ( 'nfe/index' );
			break;
		}

	}


	protected function listas() {
		$this->cMun();

		$this->cPais();


		$this->cUF();

		$this->ufs();
		$this->destinatarios();
		$this->veiculos();

	}

	protected function destinatarios() {

		$query = "SELECT * FROM destinatarios ORDER BY xNome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){
			if (isset($this->view->destinatario) && $linha["id"]==$this->view->destinatario) {
				$lista .="<option value='".$linha["id"]."' selected>".html_entity_decode($linha["xNome"])."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".html_entity_decode($linha["xNome"])."</option>";
			}

		}


		$this->view->destinatarios = $lista;

	}

	protected function veiculos() {

		$query = "SELECT * FROM veiculos";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->veiculo) && $linha["id"]==$this->view->veiculo) {
				$lista .="<option value='".$linha["id"]."' selected>".html_entity_decode($linha["descricao"])."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".html_entity_decode($linha["descricao"])."</option>";
			}

		}


		$this->view->veiculos = $lista;

	}

	private function ufs(){
			
			$query = "SELECT * FROM estados ORDER BY sigla";

			$sql = $this->model->query($query);

			while($linha = mysql_fetch_array($sql)){

				if (isset($this->view->transPlacaUf) && $linha["sigla"]==$this->view->transPlacaUf) {
					$lista .="<option value='".$linha["sigla"]."' selected>".$linha["sigla"]."</option>";
				}else{
					$lista .="<option value='".$linha["sigla"]."'>".$linha["sigla"]."</option>";
				}
			}
			
			//$lista .="<option value='GO' selected>GO</option>";


			$this->view->ufs = $lista;
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

			
			$lista .="<option value='1058' selected>1058</option>";
			$listax .="<option value='Brasil' selected>Brasil</option>";


			$this->view->cPais = $lista;
			$this->view->xPais = $listax;
		}

		protected function prepararCadastro() {
			$dadosCliente = $this->pegaDados("config_nfe", "1");
			$_POST["cMunFG"] = $dadosCliente["cMun"];
			
			$_POST["numero"] = $this->pegaNumNF($_POST["serie"]);

			$_POST["modelo"] = 55;
			$_POST["cUf"] = 17;

			$chave = $this->completaQnt($_POST["cUf"], 2, 0).$this->formataData($_POST["dEmi"],"AAMM").$this->completaQnt($dadosCliente["CNPJ"], 14, 0).$this->completaQnt($_POST["modelo"], 2, 0).$this->completaQnt($_POST["serie"], 3, 0).$this->completaQnt($_POST["numero"], 9, 0).$_POST["tpEmis"].$this->geraCNf($dadosCliente["CNPJ"]);
			
			$_POST["cDV"] = $this->geraDV($chave);
			$_POST["chave"] = $chave.$_POST["cDV"];

			if ($_POST["opTransportador"]=="0") {
				unset($_POST["transxNome"]);
				unset($_POST["transAntt"]);
				unset($_POST["transPlaca"]);
				unset($_POST["transPlacaUf"]);
				unset($_POST["transUf"]);
				unset($_POST["transCnpj"]);
				unset($_POST["transIE"]);
				unset($_POST["transEndereco"]);
				unset($_POST["transMun"]);
			}else{
				$_POST["transPlaca"] = strtoupper($_POST["transPlaca"]);
				$_POST["transPlacaUf"] = strtoupper($_POST["transPlacaUf"]);
				$_POST["transUf"] = strtoupper($_POST["transUf"]);
				$_POST["transMun"] = strtoupper($_POST["transMun"]);

			}


			if($this->cadastrar("nfe")){
				header("Location: ".URL.$_GET["var1"]."/Produtos/".$this->pegaIdNfe());
			}


		}


		protected function pegaNumNF($serie) {
			
			$query = "SELECT * FROM nfe WHERE serie=".$serie." ORDER BY numero DESC";
			$sql = $this->model->query($query);
			$linha = mysql_fetch_array($sql);

			
			

			return ++$linha["numero"];
		}

		protected function pegaIdNfe() {
			
			$query = "SELECT * FROM nfe  ORDER BY id DESC";
			$sql = $this->model->query($query);
			$linha = mysql_fetch_array($sql);
			return $linha["id"];

		}


		protected function Config() {









		//////////////       PEGA DADOS DO EMITENTE   //////////////////////
			$dadosEmpresa = $this->pegaDados("config_nfe", "1");

			$xPais = $this->pegaDadosCodigo("paises", $dadosEmpresa["cPais"] );

			$xMun = $this->pegaDadosCodigo("municipios", $dadosEmpresa["cMun"] );

			$dadosEmpresa["xPais"] = htmlspecialchars($xPais["nome"]);
			$dadosEmpresa["xMun"] =  $xMun["nome"];

			$dadosEmpresa["IEST"] =  "0";
			$dadosEmpresa["IM"] =  "0";

			$this->NFeTXT->dadosEmitente = $dadosEmpresa;
		/////////////////////////////////////////////////////




		/////////			PEGA AS PROPRIEDADES DA NOTA   ////////////////
			if (isset($_GET["var3"])) {

				


				/////////////////////// PEGA DADOS DA COBRANCA /////////////////////

				$cobranca = $this->pegaCobranca($_GET["var3"]);

				if ($cobranca==true) {
					$this->NFeTXT->dadosCobranca = $cobranca;
				}

				

				//////////////////////////////////
				
				$dadosNota = $this->pegaDados("nfe", $_GET["var3"]);

				$dadosNota["cNF"] = $this->geraCNf($dadosEmpresa["CNPJ"]);
				$dadosNota["dEmi"] = $this->formataData($dadosNota["dEmi"],"AAAA-MM-DD");
				$dadosNota["dSaiEnt"] = $this->formataData($dadosNota["dSaiEnt"],"AAAA-MM-DD");
				$dadosNota["hSaiEnt"] = "00:00:00";
				$dadosNota["nNF"] = $dadosNota["numero"];

				$this->CFOP = $dadosNota["natOp"];
				

				//// IGUALA TODOS OS CFOP IGUAIS AOS DA NFe
				$this->atualizaCFOP($dadosNota["natOp"]);

				$dadosNota["natOp"] = $this->pegaNatOp($dadosNota["natOp"]);
				

				$this->NFeTXT->dadosNFe = $dadosNota;
				$this->view->FormFile ="app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/validadas/".$dadosNota["chave"]."-nfe.xml";

				$this->NFeTXT->dadosA["versao"] = "2\.00";
				$this->NFeTXT->dadosA["quantidade"] = "1";
				$this->NFeTXT->dadosA["Id"] = $this->NFeTXT->dadosNFe["chave"];





			/////////////////////////////////////////////////////
			/////////			PEGA DADOS DO DESTINO   //////////////////////
				$dadosDestino = $this->pegaDados("destinatarios", $dadosNota["destinatario"]);


				$xMun = $this->pegaDadosCodigo("municipios", $dadosDestino["cMun"]);
				$dadosDestino["xMun"] = $xMun["nome"];

				$xPais = $this->pegaDadosCodigo("paises", $dadosDestino["cPais"]);
				$dadosDestino["xPais"] = $xPais["nome"];

				$this->NFeTXT->dadosDestino = $dadosDestino;
			}



		}


		protected function pegaNatOp($natOp){
			$query = "SELECT * FROM cfop WHERE codigo=".$natOp;
			$sql = $this->model->query($query);
			$linha = mysql_fetch_assoc($sql);
			return substr($linha["descricao"], 0,60);
		}



		protected function pegaCobranca($nfe){

			$query = "SELECT * FROM boletos WHERE NFe=".$nfe;
			$sql = $this->model->query($query);

			$i=1;
			
			while($linha = mysql_fetch_assoc($sql)){
				$dadosCobranca["Duplicata"][$i]["nDup"] = $linha["id"];

				$vencimento = explode("-", $linha["vencimento"]);
				$dadosCobranca["Duplicata"][$i]["dVenc"] = $vencimento[2]."-".$vencimento[1]."-".$vencimento[0];
				$dadosCobranca["Duplicata"][$i]["vDup"] = number_format($linha["valor"],2,".","");

				$i++;	
			}

			if ($i!=1) {
				return $dadosCobranca;
			}else{
				return false;
			}

			
		}



		protected function formataData($data,$tipo="AAAA-MM-DD") {
			switch ($tipo) {
				case "DDMMAAAA":
				if (stripos($data,"/")) {
					$data = str_replace("/","", $data);
				}
				if (stripos($data,"-")) {
					$data = str_replace("-","", $data);
				}
				$dataFormated = $data;
				break;

				case "AAAA-MM-DD":
				if (stripos($data,"/")) {
					$data = explode("/", $data);
				}
				if (stripos($data,"-")) {
					$data = explode("-", $data);
				}
				$dataFormated = $data[2]."-".$data[1]."-".$data[0];
				break;

				case "MMAAAA":
				if (stripos($data,"/")) {
					$data = str_replace("/","", $data);
				}
				if (stripos($data,"-")) {
					$data = str_replace("-","", $data);
				}
				$dataFormated = $data[1].$data[0];
				break;

				case "MMAA":
				if (stripos($data,"/")) {
					$data = explode("/",$data);
				}
				if (stripos($data,"-")) {
					$data = explode("-", $data);
				}

				$ano = substr($data[2], 2);
				$dataFormated = $data[1].$ano;
				break;

				case "AAMM":
				if (stripos($data,"/")) {
					$data = explode("/",$data);
				}
				if (stripos($data,"-")) {
					$data = explode("-", $data);
				}

				$ano = substr($data[2], 2);
				$dataFormated = $ano.$this->completaQnt($data[1], 2, 0);
				break;

				default:
				if (stripos($data,"/")) {
					$data = explode("-", $data);
				}
				if (stripos($data,"-")) {
					$data = explode("-", $data);
				}
				$dataFormated = $data[2].$data[1].$data[0];


				break;
			}

			return $dataFormated;
		}

		protected function geraCNf($cnpj) {
			$cNF = substr($cnpj,0, 8);
			return $cNF;
		}

		protected function atualizaCFOP($cfop) {

			$query = "UPDATE produtosNFe SET CFOP=".$cfop." WHERE  NFe=".$_GET["var3"]."";
			$this->model->query($query);

		}

		protected function geraDV($key_nfe) {

			$base = 9;
			$result = 0;
			$sum = 0;
			$factor = 2;

			for ($i = strlen($key_nfe); $i > 0; $i--) {
				$numbers[$i] = substr($key_nfe,$i-1,1);
				$partial[$i] = $numbers[$i] * $factor;
				$sum += $partial[$i];
				if ($factor == $base) {
					$factor = 1;
				}
				$factor++;
			}

			if ($result == 0) {
				$sum *= 10;
				$digit = $sum % 11;
				if ($digit == 10) {
					$digit = 0;
				}
				return $digit;
			} elseif ($result == 1){
				$rest = $sum % 11;
				return $rest;
			}
		}


		function completaQnt($numero,$qnt,$insert) {


			while(strlen($numero)<$qnt){
				$numero = $insert ."". $numero;
			}


			return $numero;
		}

		protected function cUF() {
			
			$query = "SELECT * FROM estados ORDER BY nome";

			$sql = $this->model->query($query);

			while($linha = mysql_fetch_array($sql)){

				if (isset($this->view->cUf) && $linha["id"]==$this->view->cUf) {
					$lista .="<option value='".$linha["id"]."' selected>".utf8_decode($linha["nome"])."</option>";
				}else{
					$lista .="<option value='".$linha["id"]."'>".utf8_decode($linha["nome"])."</option>";

				}
			}
			//$lista .="<option value='17' selected>Goi&aacute;s</option>";


			$this->view->cUf = $lista;
		}




		


		protected function listar() {



			$lista="";

			$query = "SELECT * FROM nfe";

			$valores_db = $this->model->query($query);
			$letra = "B";


			while ($linha = mysql_fetch_array($valores_db)) {

				if ($letra=="B") {
					$letra="A";
				}elseif ($letra=="A") {
					$letra = "B";
				}

				$destinatario = $this->pegaDados("destinatarios", $linha["destinatario"]);
				$lista.= "

				<tr class='grade".$letra."'>
					<td class='center'>".$linha["id"]."</td>
					<td class='center'>".$linha["numero"]."</td>
					<td class='center'>".$linha["serie"]."</td>
					<td class='left'>".htmlspecialchars($destinatario["xNome"])."</td>
					<td class='center'>".$linha["dEmi"]."</td>
					<td class='center'>".$this->TpNfe[$linha["tpNF"]]."</td>";	

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
					<td class='center'>
						<a href='".URL.$_GET["var1"]."/Produtos/".$linha["id"]."' title='Produtos' class='tipS'>
							<img src='". Folder."images/icons/control/new/clipboard.png' width='32' alt='' />
						</a>
					</td>

					<td class='actBtns'>
						<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
							<img src='". Folder."images/icons/control/new/pencil-2.png' width='24' alt='' />
						</a>
					</td>
					<td class='actBtns'>
						<a href='".URL.$_GET["var1"]."/Cancelar/".$linha["id"]."' title='Cancelar' class='tipS'>
							<img src='". Folder."images/icons/control/new/block.png' width='24' alt='' />
						</a>
					</td>
					<td class='actBtns'>
						<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
							<img src='". Folder."images/icons/control/16/clear.png' alt='' width='24'/>
						</a>
					</td>

				</tr>";

			}

			$this->view->lista = $lista;

		}


		protected function listarReproduzir() {



			$lista="";

			$query = "SELECT * FROM nfe WHERE id!=".$_GET["var3"];

			$valores_db = $this->model->query($query);
			$letra = "B";


			while ($linha = mysql_fetch_array($valores_db)) {





				if ($letra=="B") {
					$letra="A";
				}elseif ($letra=="A") {
					$letra = "B";
				}

				$destinatario = $this->pegaDados("destinatarios", $linha["destinatario"]);
				$lista.= "

				<tr class='grade".$letra."'>

					<td class='center'><input type='radio' name='id' value='".$linha["id"]."'></td>
					<td class='center'>".$linha["id"]."</td>
					<td class='left'>".$destinatario["xNome"]."</td>
					<td class='center'>".$linha["dEmi"]."</td>
					<td class='center'>".$linha["chave"]."</td>
				</tr>";

			}

			$this->view->lista = $lista;

		}


		protected function listarNFe() {



			$lista="";

			$NFe = $this->pegaDados("nfe", $_GET["var3"]);




			$xml = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$NFe["tpAmb"]]."/enviadas/aprovadas/".$NFe["chave"]."-procNfe.xml";
			if (file_exists($xml)) {
				$pdf = "NFe/Pdf/".$NFe["chave"]."";

				$this->view->pdf = $pdf;

				$this->view->xml = $xml;
			}else{
				$this->view->xml = false;
			}


			$this->view->chave = $NFe["chave"];


			$query = "SELECT * FROM produtosNFe WHERE  NFe=".$_GET["var3"]." ORDER BY id";

			$valores_db = $this->model->query($query);
			$letra = "B";

			$i=1;
			while ($linha = mysql_fetch_array($valores_db)) {

				if ($letra=="B") {
					$letra="A";
				}elseif ($letra=="A") {
					$letra = "B";
				}



				$produto = $this->pegaDados("produtos", $linha["produto"]);
				$lista.= "

				<tr class='grade".$letra."'>
					<td class='center'>".$i."</td>
					<td class='left'>  ".htmlspecialchars($produto["nome"])." - ".$produto["quantidade"]."x1</td>
					<td class='center'>".$linha["CFOP"]."</th>
						<td class='center'>".$linha["qCom"]."</td>
						<td class='center'> R$ ".number_format($linha["vUnCom"],2)."</td>
						<td class='center'> R$ ".number_format($linha["vProd"],2)."</td>
						<td class='center'>".$linha["CST"]."</td>
						<td class='actBtns'>
							<a href='".URL.$_GET["var1"]."/Item/".$_GET["var3"]."-".$linha["produto"]."' title='Editar' class='tipS'>
								<img src='". Folder."images/icons/control/16/pencil.png' alt=''  /> 
							</a> 
							<a href='".URL.$_GET["var1"]."/Delete/".$_GET["var3"]."-".$linha["produto"]."' title='Deletar' class='tipS'>
								<img src='". Folder."images/icons/control/16/clear.png' alt=''  />
							</a>
						</td>
					</tr>";
					$vTotal += $linha["vProd"];
					$i++;
				}

				$this->view->vTotal = $vTotal;
				$this->view->lista = $lista;

			}




			protected function buscar() {
				$query = "SELECT * FROM produtos WHERE nome LIKE ('%".$_POST["produto"]."%') LIMIT 4";
				$sql = $this->model->query($query);
				while($linha = mysql_fetch_array($sql)){
					if ($this->verifica($linha["id"])) {
						$html .= "
						<fieldset>
							<form id='validate' method='post' action=''>

								<div class='widget'>
									<div class='title'>
										<img src='".Folder."images/icons/dark/user.png' alt=''
										class='titleIcon' />
										<h6>".htmlspecialchars($linha["nome"])." - ".$linha["quantidade"]."x1</h6>
									</div>

									<div class='formRow'>
										<label>
											<input type='hidden' name='produto' value='".$linha["id"]."' class='' />

											Codigo/ID:".$linha["id"]."<br>
											Unidade de Medida:".$linha["unidade"]."<br>
											Valor Unit&aacute;rio: R$ ".$linha["venda"]."
										</label>

										<div class='clear'></div>
									</div>
									<div class='formRow'>
										<label>CFOP:</label>
										<div class='formRight'>
											<input type='text' name='CFOP' class='' value='".$this->CFOP."' /><br>
										</div>
										<div class='clear'></div>
									</div>
									<div class='formRow'>
										<label>Valor Unit&aacute;rio:</label>
										<div class='formRight'>
											<input type='text' name='vUnCom' value='".$linha["venda"]."' class='' /><br>
										</div>
										<div class='clear'></div>
									</div>
									<div class='formRow'>
										<label>Quantidade:</label>
										<div class='formRight'>
											<input type='text' name='qCom' class='' />
										</div>
										<div class='clear'></div>
									</div>

									<div class='formRow'>
										<label>Origem:</label>
										<div class='formRight'>
											<select name='orig'>
												<option value='0'>Nacional</option>
											</select>
										</div>
										<div class='clear'></div>
									</div>

									<div class='formRow'>
										<label></label>
										<div class='formRight'>
											<br>
											<input type='submit' class=' rednwB ml15 m10' value='Adicionar' style='margin: 18px 0 0 0; float: right;'/>
										</div>
										<div class='clear'></div>
									</div>
									<a href='javascript:document.produto_".$linha["id"].".submit()' title=''
									class=''
									> <span></span> </a>



								</div>
							</form>

						</fieldset>";
					}else{
						$html = "Produto ".$linha['nome']." J&aacute; adicionado!";
					}

				}

				if ($html==false) {
					$html = "Nenhum produto encontrado!";
				}

				echo $html;


			}
			protected function verifica($id) {
				$query = "SELECT * FROM  produtosNFe WHERE NFe=".$_GET["var3"]." AND produto=".$id;

				$sql = $this->model->query($query);

				$linha = mysql_fetch_array($sql);
				if ($linha==true) {
					return false;
				}else{
					return true;
				}
			}


			protected function atualizar() {
		//var[0] = id da NFe
		//var[1] = id do produto
				$var = explode("-", $_GET["var3"]);

				$produto = $this->pega_produto($var[0], $var[1]);

				$_POST["qCom"] = str_replace(",", ".", $_POST["qCom"]);
				$_POST["vUnCom"] = str_replace(",", ".", $_POST["vUnCom"]);


				$_POST["vProd"] = $_POST["qCom"] * $_POST["vUnCom"];

				if ($this->editarNFe($var[1],$var[0] )) {

					$this->Log("Atualizacao no Balanco de id $var[0]; query($query)");

					header("Location: ".URL.$_GET["var1"]."/Produtos/".$var[0]);
				}else{
					die(mysql_error());
				}


			}


		/*
	 *
	 *
	 * FUNCAO EDITAR - EDITA NOTICIAS CADASTRADAS NO BANCO BANCO
	 *
	 *
	 *
	 */
		protected function editarNFe($id, $nfe) {



			$campos = array_keys($_POST);
			$quant = count($campos);
			$quant = ($quant - 1);
			$query = "UPDATE ";
			$query .= "`produtosNFe` ";
			$query .= "SET ";
			for ($i = 0; $i < $quant; $i++) {
				$camp = $campos[$i];
				$query .= "`$campos[$i]`= '" . $this -> string -> preparar($_POST[$camp]) . "',";
			}
			$camp = $campos[$quant];
			$query .= "`$campos[$quant]`= '" . $this -> string -> preparar($_POST[$camp]) . "' ";
			$query .= "WHERE NFe=".$nfe." AND produto=" . $id . "";


			if ($this -> model -> query($query)) {

				$this -> Log("Alteracao na tabela produtosNFe da NFe ".$nfe." no produto=$id; query($query)");

				unset($_POST);
				return true;
			} else {
				die(mysql_error());
			}

		}



		protected function pega_produto($nfe, $id) {
			$valores_db = $this->model->query("SELECT * FROM `produtosNFe` WHERE  NFe=".$nfe." AND produto=".$id);
			$linha = mysql_fetch_array($valores_db);

			return $linha;
		}

		protected function dados() {
			$var = explode("-", $_GET["var3"]);
			$produto = $this->pegaDados("produtos", $var[1]);



			$valores_db = $this->model->query("SELECT * FROM `produtosNFe` WHERE NFe=".$var[0]." AND produto=".$var[1]);
			$linha = mysql_fetch_array($valores_db);


		//VARIAVEIS DO BANCO
			$variaveis = array_keys($linha);
			$count = count($variaveis);

			for ($i = 0; $i < $count; $i++) {
				$this->view->$variaveis[$i]	= $linha[$variaveis[$i]];
			}
			$this->view->NFe = $var[0];
			$this->view->produto = $produto["nome"];
		}

		//NFe_
		protected function geraTxt() {
			$query = "SELECT * FROM produtosNFe WHERE NFe=".$_GET["var3"]." ORDER BY Produto";
			$result = $this->model->query($query);
			$i =1;
			while ($linha=mysql_fetch_array($result)) {
				$produto = $this->pegaDados("produtos", $linha["produto"]);

				$this->NFeTXT->NFeProdutos[$i]["produto"]["cProd"] = $this->completaQnt($linha["produto"], 8, 0);
				$this->NFeTXT->NFeProdutos[$i]["produto"]["xProd"] = trim(htmlspecialchars($produto["nome"])." - ".$produto["quantidade"]."x1.");
				$this->NFeTXT->NFeProdutos[$i]["produto"]["CFOP"] = $linha["CFOP"];
				if ($produto["unidade"]=="") {
					$produto["unidade"]="1";
				}
				$this->NFeTXT->NFeProdutos[$i]["produto"]["uCom"] = number_format($produto["unidade"],2,".","");

				$this->NFeTXT->NFeProdutos[$i]["produto"]["qCom"] = number_format($linha["qCom"],3,".","");

				$this->NFeTXT->NFeProdutos[$i]["produto"]["vUnCom"] = number_format($linha["vUnCom"],2,".","");

				$this->NFeTXT->NFeProdutos[$i]["produto"]["vProd"] = number_format($linha["vProd"],2,".","");

				$this->NFeTXT->NFeProdutos[$i]["CST"]["CST"] = 90;
				$this->NFeTXT->NFeProdutos[$i]["CST"]["orig"] = $linha["orig"];

				$this->NFeTXT->NFeProdutos[$i]["vTotTrib"] = number_format($linha["vProd"] * ($this->NFeTXT->dadosEmitente["alicota"]/100),2,".","");

				$this->NFeTXT->NFeProdutos[$i]["CST"]["pCredSN"] = $this->NFeTXT->dadosEmitente["credito"];
				$this->NFeTXT->NFeProdutos[$i]["CST"]["vCredICMSSN"] = number_format($linha["vProd"] * ($this->NFeTXT->dadosEmitente["credito"]/100),2,".","");

				$this->NFeTXT->NFeProdutos[$i]["PIS"]["CST"] = 99;
				$this->NFeTXT->NFeProdutos[$i]["PIS"]["vPIS"] = 0.00;
				$this->NFeTXT->NFeProdutos[$i]["PIS"]["pPIS"] = 0.0000;
				$this->NFeTXT->NFeProdutos[$i]["PIS"]["qBCProd"] = 0.0000;
				$this->NFeTXT->NFeProdutos[$i]["PIS"]["vAliqProd"] = 0.0000;
				$this->NFeTXT->NFeProdutos[$i]["PIS"]["vBC"] = 0.0000;

				$this->NFeTXT->NFeProdutos[$i]["COFINS"]["CST"] = 99;
				$this->NFeTXT->NFeProdutos[$i]["COFINS"]["vCOFINS"] = 0.00;
				$this->NFeTXT->NFeProdutos[$i]["COFINS"]["pCOFINS"] = 0.0000;
				$this->NFeTXT->NFeProdutos[$i]["COFINS"]["qBCProd"] = 0.0000;
				$this->NFeTXT->NFeProdutos[$i]["COFINS"]["vAliqProd"] = 0.0000;
				$this->NFeTXT->NFeProdutos[$i]["COFINS"]["vBC"] = 0.0000;

				$vTotCred += number_format($this->NFeTXT->NFeProdutos[$i]["CST"]["vCredICMSSN"],2,".","");
				$vTotTrib += number_format($this->NFeTXT->NFeProdutos[$i]["vTotTrib"],2,".","");
				$vTotal += number_format($linha["vProd"],2,".","");

				$i++;
			}

			$this->NFeTXT->dadosTotais["vProd"]= number_format($vTotal,2,".","");
			$this->NFeTXT->dadosTotais["vTotTrib"]= number_format($vTotTrib,2,".","");

			$this->NFeTXT->dadosTotais["indTot"]=0;


		/*
		 *
		 *
		 *
		 *  DADOS DO TRANSPORTADOR
		 *
		 *
		 * */
		$this->NFeTXT->NFeFrete = $this->NFeTXT->dadosNFe["frete"];
		if ($this->NFeTXT->dadosNFe["opTransportador"]=="0") {
			$this->NFeTXT->dadosTransportador["transportador"]["xNome"] = $this->NFeTXT->dadosEmitente["xNome"];
			$this->NFeTXT->dadosTransportador["transportador"]["IE"] = $this->NFeTXT->dadosEmitente["IE"];
			$this->NFeTXT->dadosTransportador["transportador"]["xEnder"] = $this->NFeTXT->dadosEmitente["xLgr"].", ".$this->NFeTXT->dadosEmitente["nro"].", ".$this->NFeTXT->dadosEmitente["xCpl"].", ".$this->NFeTXT->dadosEmitente["xBairro"];
			$this->NFeTXT->dadosTransportador["transportador"]["UF"] = $this->NFeTXT->dadosEmitente["UF"];
			$this->NFeTXT->dadosTransportador["transportador"]["xMun"] = $this->NFeTXT->dadosEmitente["xMun"];
			if ($this->NFeTXT->dadosEmitente["CNPJ"]) {
				$this->NFeTXT->dadosTransportador["transportador"]["CNPJ"] = $this->NFeTXT->dadosEmitente["CNPJ"];
			}else{
				$this->NFeTXT->dadosTransportador["transportador"]["CPF"] = $this->NFeTXT->dadosEmitente["CPF"];
			}

			/////// PEGA DADOS DO VEICULO

			$veiculo = $this->pegaDados("veiculos", $this->NFeTXT->dadosNFe["veiculo"]);
			$this->NFeTXT->dadosTransportador["transportador"]["veiculos"]["placa"] = str_replace("-", "", $veiculo["placa"]);
			$this->NFeTXT->dadosTransportador["transportador"]["veiculos"]["UF"] = $veiculo["uf"];
			$this->NFeTXT->dadosTransportador["transportador"]["veiculos"]["ANTT"] = "";



		}else{


			$this->NFeTXT->dadosTransportador["transportador"]["xNome"] = $this->NFeTXT->dadosNFe["transxNome"];
			$this->NFeTXT->dadosTransportador["transportador"]["IE"] = $this->NFeTXT->dadosNFe["transIE"];
			$this->NFeTXT->dadosTransportador["transportador"]["xEnder"] = $this->NFeTXT->dadosNFe["transEndereco"];
			$this->NFeTXT->dadosTransportador["transportador"]["UF"] = $this->NFeTXT->dadosNFe["transUf"];
			$this->NFeTXT->dadosTransportador["transportador"]["xMun"] = $this->NFeTXT->dadosNFe["transMun"];
			if (strlen($this->NFeTXT->dadosNFe["transCnpj"])>12) {
				$this->NFeTXT->dadosTransportador["transportador"]["CNPJ"] = $this->NFeTXT->dadosNFe["transCnpj"];
			}else{
				$this->NFeTXT->dadosTransportador["transportador"]["CPF"] = $this->NFeTXT->dadosNFe["transCnpj"];
			}


			///////PEGA DADOS DO VEICULO
			$this->NFeTXT->dadosTransportador["transportador"]["veiculos"]["placa"] = str_replace("-", "", $this->NFeTXT->dadosNFe["transPlaca"]);
			$this->NFeTXT->dadosTransportador["transportador"]["veiculos"]["UF"] = $this->NFeTXT->dadosNFe["transPlacaUf"];
			$this->NFeTXT->dadosTransportador["transportador"]["veiculos"]["ANTT"] = $this->NFeTXT->dadosNFe["transAntt"];

		}

		//$this->NFeTXT->dadosNFe["fiscoComplementares"] = wordwrap($this->NFeTXT->dadosNFe["fiscoComplementares"], 50, "\n");
		//$this->NFeTXT->dadosNFe["contribuinteComplementares"] = wordwrap($this->NFeTXT->dadosNFe["contribuinteComplementares"], 50, "\n");

		
		
		$this->NFeTXT->setInfAdic($this->NFeTXT->dadosNFe["fiscoComplementares"],$this->NFeTXT->dadosNFe["contribuinteComplementares"]);


		$NFeTxt = $this->NFeTXT->getTxt();
		// Abre o arquivo para leitura e escrita

		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/txt/".$this->NFeTXT->dadosNFe["chave"]."-nfe.txt";
		$f = fopen($file, "w+");

		// Escreve no arquivo
		fwrite($f, $NFeTxt);

		// Libera o arquivo
		fclose($f);

		return $file;
	}


	protected function geraXML($NFeTxt) {
		$NFe = $this->pegaDados("nfe", $_GET["var3"]);

		$convertNFe = new ConvertNFePHP();




		$xml = $convertNFe->nfetxt2xml($NFeTxt);

		// Abre o arquivo para leitura e escrita
		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/xml/".$this->NFeTXT->dadosNFe["chave"]."-nfe.xml";
		if ( !file_put_contents($file, $xml) ) {
			echo "Erro na gravação da NFe em xml";
		}else{
			//unlink($NFeTxt);
		}

		return $file;

	}


	protected function assinaNFe($NFeXML) {
		$contents = file_get_contents($NFeXML);
		//echo $contents;
		$assinando = $this->ToolsNFe->signXML($contents);
		//echo $assinando;

		if ($assinando === FALSE) {
			die("Erro na assinatura do XML de NF-e");
		}
		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/assinadas/".$this->NFeTXT->dadosNFe["chave"]."-nfe.xml";
		if ( !file_put_contents($file, $assinando) ) {
			echo "Erro na gravação da NFe em xml";
			return false;
		}else{

			$this->validaXML($file);
			unlink($NFeXML);
		}
		//echo 2; "ID"


	}

	protected function validaXML($NFeXML) {

		$contents = file_get_contents($NFeXML);
		$pathXSD = 'app/public/complementos/nfephp/schemes/PL_006r/nfe_v2.00.xsd';
		$validado = $this->ToolsNFe->validXML($contents,$pathXSD);

		if ($validado === FALSE) {
			echo str_replace(".", ".<br>", $this->ToolsNFe->errMsg);
			echo "<br>";
			die("Erro na validacao do XML de NF-e");
			return false;
		}else{





			$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/validadas/".$this->NFeTXT->dadosNFe["chave"]."-nfe.xml";
			if ( !file_put_contents($file, $contents) ) {
				echo "Erro na gravação da NFe em xml";
				return false;
			}else{
				$this->EnviaXml($contents,$file);

				unlink($NFeXML);
			}
		}



	}

	protected function EnviaXml($NFeXML,$file) {

		if (!$this->Status==false) {
			echo "<span style='color:red;font-weight:bold;'>
			Servi&ccedil;o de NFe est&aacute; Off Line!!! Servidor do SEFAZ Fora do Ar!!
		</span>";

		return false;
	}

		$modSOAP = '2'; //usando  1 - SOAP 2 - cURL

		//obter um numero de lote
		$lote = substr(str_replace(',','',number_format(microtime(true)*1000000,0)),0,15);
		// montar o array com a NFe
		$aNFe = array(0=>$NFeXML);

		//$this->ToolsNFe->tpAmb="2";// Tipo de ambiente 1-produção 2-homologação

		//enviar o lote
		$aResp = $this->ToolsNFe->sendLot($aNFe, $lote, $modSOAP);
		if ($aResp["Fail"]==false){
			if ($aResp['bStat']){
				echo "Numero do Recibo : " . $aResp['nRec']."<br>" ;
				//print_r($this->NFeTXT->dadosNFe);

				echo "
				<script>

					$(function(){

						$('#FormRec').val('".$aResp["nRec"]."');
						$('#FormChave').val('".$this->NFeTXT->dadosNFe["chave"]."');

					});

</script>";

				//$this->ConsultarRecibo($aResp['nRec']);
} else {
	echo "houve erro 1 !!  <br>".$this->ToolsNFe->errMsg;
	echo "<br>";

	foreach ($aResp as $k=>$v) {
		echo $k."=> ".$v."<br>";
	}
}
} else {
	echo "houve erro 2 !!  <br>".$this->ToolsNFe->errMsg;
	echo "<br>";


	foreach ($aResp as $k=>$v) {
		echo $k."=> ".$v."<br>";
	}

}



		/*echo '<BR><BR><h1>DEBUG DA COMUNICAÇÃO SOAP</h1><BR><BR>';
		 echo '<PRE>';
		 $msg = str_replace(">", ">\n", $this->ToolsNFe->soapDebug);
		 $msg = htmlspecialchars($msg);
		 echo str_replace("\n", "<br>", $msg);

		 echo '</PRE><BR>';
		 // */

		}


		/*
	//////// BUSCA POR RECIBO
	*/

		protected function ConsultarRecibo() {

		/*
		 * Exemplo de solicitação da situação da NFe atraves do numero do
		 * recibo de uma nota enviada e recebida com sucesso pelo SEFAZ
		 */

		//echo "<br>".$nRec."<br>";
		$nRec = $_POST["nRec"];

		$modSOAP = '2'; //usando cURL

		$this->ToolsNFe->temDir = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/temporarias/";
		$tpAmb = $this->ToolsNFe->tpAmb; // 1 - Produção / 2 - Homologação
		//$recibo = ltrim($_GET["var3"]);
		//$recibo = rtrim($recibo);
		//$recibox = $this->completaQnt($recibo, 15, 0);

		header('Content-type: text/html; charset=UTF-8');

		if ($aResp = $this->ToolsNFe->getProtocol($nRec, "", $tpAmb, $modSOAP)){
			//houve retorno mostrar dados

			//print_r($aResp);
			/*
			foreach ($aResp as $k=>$v) {
			if ($v==array()) {
			echo $k.": <br>----";
			foreach ($v as $x=>$y) {
			echo $x.": ".$y."<br>";
			}
			}else{
			echo $k.": ".$v."<br>";
			}
			}
			//*/



			$this->addProtocolo($_POST["file"],$nRec);



		} else {

			//não houve retorno mostrar erro de comunicação
			echo "Houve erro no recibo ".$nRec." !! ".$this->ToolsNFe->errMsg;
		}



	}

	protected function addProtocolo($NFe,$nRec) {

		$ProtFile = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/temporarias/".$nRec."-recprot.xml";


		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/enviadas/aprovadas/".$_POST["Chave"]."-procNfe.xml";

		if ($xml = $this->ToolsNFe->addProt($NFe, $ProtFile)){
			
			file_put_contents($file, $xml);
			unlink($NFe);
			unlink($ProtFile);
			//echo "Protocolo Adicionado"; FormFile

			echo "
			<a title='PDF' target='_blank' class='wButton redwB ml15 m10' id='PDF' href='".URL."NFe/GerarDanfe/".$_POST["Chave"]."'>
				<span>Abrir PDF</span> 
			</a>
			<br>";
		}else{
			$errorFile = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/temporarias/".$nRec."-recprot.xml";
			echo "Protocolo nao foi Adicionado<br>";
			echo $this->ToolsNFe->errMsg;
			
			echo "<br>Erro: <br>";
			$xml = str_replace(">", ">\n", $errorFile);
			$chNFe = explode("chNFe>", file_get_contents($errorFile));
			$xMotivo = explode("<xMotivo>", $chNFe[2]);

			print_r("Chave: ".$chNFe[1]);
			print_r("<br>");
			print_r("<br>Motivo: ".$xMotivo[1]);


			unset($_SESSION["nRec"]);
		}

	}
	/*
	//////// 
	*/



	/*
	//////// BUSCA POR CHAVE
	*/
	protected function BuscarNFe() {

		/*
		 * Exemplo de solicitação da situação da NFe atraves do numero do
		 * recibo de uma nota enviada e recebida com sucesso pelo SEFAZ
		 */

		//echo "<br>".$nRec."<br>";
		$chave = $_POST["chave"];

		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/enviadas/aprovadas/";

		if ($this->ToolsNFe->getNFe($chave,$file,false)) {

			echo " 
			<a title='PDF' target='_blank' class='wButton redwB ml15 m10' id='PDF' href='".URL."NFe/Pdf/".$chave."'>
				<span>Gerar PDF</span> 
			</a>
			<br>";
			
		}elseif ($this->ToolsNFe->getNFe($chave,$file)) {

			echo " 
			<a title='PDF' target='_blank' class='wButton redwB ml15 m10' id='PDF' href='".URL."NFe/Pdf/".$chave."'>
				<span>Gerar PDF</span> 
			</a>
			<br>";
			
		}else{

			echo "Dados:".$file." - ".$chave;
			echo '<br><br><PRE>';
			echo "Houve erro !! ".$this->ToolsNFe->errMsg;
			echo '<br><br><PRE>';
			$html = htmlspecialchars($this->ToolsNFe->soapDebug);
			print_r($html);
			echo '</PRE><BR>';
		}





	}

	protected function addProtocoloNFe($NFe,$chave) {

		$ProtFile = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/temporarias/".$chave."-prot.xml";


		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/enviadas/aprovadas/".$chave."-procNfe.xml";

		if ($xml = $this->ToolsNFe->addProt($NFe, $ProtFile)){
			
			file_put_contents($file, $xml);
			unlink($NFe);
			unlink($ProtFile);
			//echo "Protocolo Adicionado";

			echo "
			<a title='PDF' target='_blank' class='wButton redwB ml15 m10' id='PDF' href='".URL."NFe/GerarDanfe/".$chave."'>
				<span>Abrir PDF</span> 
			</a>
			<br>";
		}else{
			$errorFile = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/temporarias/".$chave."-prot.xml";
			echo "Protocolo nao foi Adicionado 2<br>";
			echo $this->ToolsNFe->errMsg;
			
			echo "<br>Erro: <br>";
			$xml = str_replace(">", ">\n", $errorFile);
			$chNFe = explode("chNFe>", file_get_contents($errorFile));
			$xMotivo = explode("<xMotivo>", $chNFe[2]);

			print_r("Chave: ".$chNFe[1]);
			print_r("<br>");
			print_r("<br>Motivo: ".$xMotivo[1]);



		}

	}

	/*
	/////////
	*/
	protected function GeraDanfe() {

		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/enviadas/aprovadas/".$_GET["var3"]."-procNfe.xml";
		if ( is_file($file) ){
			$docxml = file_get_contents($file);

			$danfe = new DanfeNFePHP($docxml, 'P', 'A4','app/public/complementos/nfephp/images/logo.jpg');

			$danfe->SystemVersion = VERSAO.UPGRADE.ERROS.BETA.ALFA;
			$id = $danfe->montaDANFE();

			ob_end_clean();
			$teste = $danfe->printDANFE("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/pdf/".$id.'.pdf','I');
			
		}
	}


	protected function reproduzir(){

		$id_nfe = $_POST["id"];

		
		$query = "SELECT * FROM produtosNFe WHERE NFe=".$id_nfe;
		$sql = $this->model->query($query);

		while ($linha=mysql_fetch_assoc($sql)) {
			foreach ($linha as $key => $value) {
				$_POST[$key] = $value;
			}
			unset($_POST["id"]);
			unset($_POST["tableFilter"]);
			$_POST["NFe"] = $_GET["var3"];

			if($this->cadastrar("produtosNFe")){
				$true=true;
			}else{
				$true=false;
			}
		}


		if ($true) {
			$this->Log("Reproduziu a NFe de ID ".$id_nfe." na NFe de ID ".$_GET["var3"]);

			header("Location: ".URL.$_GET["var1"]."/Produtos/".$_GET["var3"]);

		}else{

			$this->Log("Error ao Reproduzir a NFe de ID ".$id_nfe." na NFe de ID ".$_GET["var3"]);
		}

		


	}




	protected function GetNFe(){

		$chave = $_POST["chave"];

		$query = "SELECT emissao FROM nfeEntrada WHERE chave='".$chave."'";
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);

		$folder = substr($linha["emissao"], 3,10);

		if (!is_dir("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/recebidas/".$folder."/")) {
			mkdir("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/recebidas/".$folder."/");
		}

		if ($xml = $this->ToolsNFe->getNFe($chave,$folder)) {

			echo " 
			<a title='PDF' target='_blank' class='wButton redwB ml15 m10' id='PDF' href='".URL."NFe/Pdf/".$chave."'>
				<span>Gerar PDF</span> 
			</a>
			<br>";
			
		}else{
			echo "xml = !".$xml."
			";
			echo "Houve erro !! ".$this->ToolsNFe->errMsg;
			echo '<br><br><PRE>';
			$html = htmlspecialchars($this->ToolsNFe->soapDebug);
			print_r($html);
			echo '</PRE><BR>';
		}

	}

	protected function ConfirmarNFe(){


		

		$chave = $_POST["chave"];
		
		///echo $chave." - ".$modSOAP." - ".$tpAmb." - ".$tpEvento;

		//*
		if (!$xml = $this->ToolsNFe->manifDest($chave)){

			if (strstr($this->ToolsNFe->errMsg,"573")) {
				echo "NFe numero ".$_POST["numero"]." j&aacute; confirmada!";
				echo '<br>';
			}else{

				echo "Houve erro !! ".$this->ToolsNFe->errMsg;
				echo '<br><br><PRE>';
				echo htmlspecialchars($this->ToolsNFe->soapDebug);
				echo '</PRE><BR>';
			}

		} else {

			echo "Confirmado o Recebimento da NFe numero ".$_POST["numero"]."";
			echo '<br>';
		}
		//*/

	}





	protected function dadosCancelar(){

		$NFe = $this->pegaDados("nfe", $_GET["var3"]);

		$ProtFile = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$NFe["tpAmb"]]."/enviadas/aprovadas/".$NFe["chave"]."-procNfe.xml";
		if (file_exists($ProtFile)) {
			$xml = simplexml_load_file($ProtFile);
			$this->view->nProt = strval($xml->protNFe->infProt->nProt);
			$this->view->chNFe = strval($xml->protNFe->infProt->chNFe);
			$this->view->tpAmb = strval($xml->protNFe->infProt->tpAmb);
		} else {
			$this->info('Arquivo XML da NFe n&atilde;o existe!');
		}

	}


	protected function cancelar(){

		$resp = $this->ToolsNFe->cancelEvent(trim($_POST["chNFe"]), trim($_POST["nProt"]), trim($_POST["motivo"]), trim($_POST["tpAmb"]));
		$html = "";
		foreach ($resp as $key => $value) {
			$html.= $key." => ".$value.'<BR>';
		}

		if ($this->ToolsNFe->errMsg) {
			$html.= $this->ToolsNFe->errMsg.'<BR>';
			echo $html;
		}else{
			echo false;
		}

		

		
	}

	protected function confirmCancel(){

		if (file_exists("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$_POST["tpAmb"]]."/canceladas/".trim($_POST["chNFe"])."-1-procCanc.xml")) {
			$query = "UPDATE nfe SET cancelada=1 WHERE chave='".trim($_POST["chNFe"])."'";
			if($this->model->query($query)){

				$html = "NFe de chave  = ( ".trim($_POST["chNFe"])." ) foi cancelada!";
				$this->log("NFe de chave  = ( ".trim($_POST["chNFe"])." ) foi cancelada!");

			}


		}else{

			$this->log("Erro ao cancelar a NFe de chave  = ( ".trim($_POST["chNFe"])." )!!");
			$html ="Erro ao cancelar a NFe de chave  = ( ".trim($_POST["chNFe"])." )!!";
		}

		echo $html;
	}

	protected function GetDestinatario() {
		$query = "SELECT * FROM destinatarios WHERE xNome LIKE ('%".$_POST["nome"]."%') LIMIT 4";
		$sql = $this->model->query($query);
		$html = "";
		while($linha = mysql_fetch_array($sql)){
			$cidade = $this->pegaDadosCodigo("municipios",$linha["cMun"]);
			$html .= "
			<script>
				$(function(){

					$('.idCliente').click(function() {
						id = $(this).val();

						$('#idDestinatario').val(id);
					});
});
</script>
<ol style='float:left; border:1px #ccc dashed;padding:10px;'>
	<li>Nome: <b>".htmlspecialchars($linha["xNome"])."</b></li>
	<li style='margin-left:10px;'>CNPJ: ".($linha["CNPJ"] !=""  ? $this->formatarCpfCnpj($linha["CNPJ"]) : $this->formatarCpfCnpj($linha["CPF"]))."</li>
	<li style='margin-left:10px;'>Cidade: ".$cidade["nome"]."</li>
	<li><label><input type='radio' name='idCliente' value='".$linha["id"]."' class='idCliente'> Pegar ID</label></li>
</ol>";
}

if ($html=="") {
	$html = "Nenhum resultado em Clientes";
}

echo $html;


}
protected function GetRemetente() {
	$query = "SELECT * FROM fornecedores WHERE nome LIKE ('%".$_POST["nome"]."%') LIMIT 4";
	$sql = $this->model->query($query);
	$html = "";
	while($linha = mysql_fetch_array($sql)){

		$html .= "
		<script>
			$(function(){

				$('.idCliente').click(function() {
					id = $(this).val();

					$('#idRemetente').val(id);
				});
});
</script>
<ol style='float:left; border:1px #ccc dashed;padding:10px;'>
	<li>Nome: <b>".wordwrap(htmlspecialchars($linha["nome"]))."</b></li>
	<li style='margin-left:10px;'>CNPJ: ".$linha["cnpj"]."</li>
	<li style='margin-left:10px;'>Email: ".$linha["email"]."</li>
	<li><label><input type='radio' value='".$linha["id"]."' class='idCliente'> Pegar ID</label></li>
</ol>";
}

if ($html=="") {
	$html = "Nenhum Fornecedor Encontrado!";
}

echo $html;


}

protected function Pdf($save=false,$chave=""){



	if ($save==false) {
		$query = "SELECT emissao FROM nfeEntrada WHERE chave='".$_GET["var3"]."'";
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);

		$folder = substr($linha["emissao"], 3,10);


		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/recebidas/".$folder."/".$_GET["var3"].'-procNFe.xml';
	}else{
		$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/enviadas/aprovadas/".$chave.'-procNfe.xml';
	}
	

	if ( is_file($file) ){
		$docxml = file_get_contents($file);


		

		if ($save) {
			$danfe = new DanfeNFePHP($docxml, 'P', 'A4','app/public/complementos/nfephp/images/logo.jpg',"F");
		}else{
			$danfe = new DanfeNFePHP($docxml, 'P', 'A4');	
		}
		

		$danfe->SystemVersion = VERSAO.UPGRADE.ERROS.BETA.ALFA;
		$id = $danfe->montaDANFE();


		if ($save==false) {
			ob_end_clean();

			$teste = $danfe->printDANFE("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/pdf/".$_GET["var3"].'.pdf','I');
			
		}else{
			ob_end_clean();
			$file = "app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/pdf/".$chave.'.pdf';
			$teste = $danfe->printDANFE($file,'F');

			return $file;
		}
		
	}else{
		echo "Erro ao ler o arquivo!";
	}

}




protected function email(){

	$NFe = $this->pegaDados("nfe",$_POST["id"]);

	$destinatario = $this->pegaDados("destinatarios",$NFe["destinatario"]);

	$Duplicatas = $this->pegaBoletos($_POST["id"]);

	

	foreach ($Duplicatas as $value) {

		$pdf = new PdfController;
		
		$pdf->Boleto($value);
		
		unset($pdf);
	}
	


	$aMail['para'] = $destinatario["email"];
	$aMail['contato'] = $destinatario["xNome"];


	$aMail['numero'] = $NFe["numero"];
	
	

	$pdf = file_get_contents($this->Pdf(true,$NFe["chave"]));
	$xml = file_get_contents("app/public/complementos/nfephp/nfe/".$this->pastaAmb[$this->ToolsNFe->tpAmb]."/enviadas/aprovadas/".$NFe["chave"].'-procNfe.xml');

	$Mail = new MailNFePHP();


	if($Mail->sendNFe($xml,$pdf,$NFe["chave"].".xml",$NFe["chave"].".pdf",$Duplicatas,$aMail)){
		echo "Email Enviado para <br>".$aMail["contato"]." (".$aMail["para"].")<br> com Sucesso!<br> 
		<a title='' class='wButton redwB ml15 m10' class='OKK' style='cursor:pointer;'> 
			<span>Ok</span> 
		</a>";
	}else{
		echo "Ocorreu um erro ao enviar o email! Tente novamente...<br>Erro: ".$Mail->mailERROR;
	}


	
}


protected function pegaBoletos($nfe){
	$query = "SELECT * FROM boletos WHERE NFe=".$nfe;
	$sql = $this->model->query($query);
	while ($linha = mysql_fetch_assoc($sql)) {
		$boletos[]=$linha["id"];
	}
	return $boletos;
}



}