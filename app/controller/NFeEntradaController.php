<?php
class NFeEntradaController extends Controller {

	
	function __construct() {

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




	function index() {

		switch ($_GET["var2"]) {


			case "Cadastrar":


			if ($_POST["remetente"]) {


				$_POST["chave"] = str_replace(".", "", $_POST["chave"]);
				$_POST["chave"] = str_replace("/", "", $_POST["chave"]);
				$_POST["chave"] = str_replace("-", "", $_POST["chave"]);
				$_POST["chave"] = str_replace(" ", "", $_POST["chave"]);


				if($this->cadastrar("nfeEntrada")){

					$query = "SELECT * FROM nfeEntrada ORDER BY id DESC";
					$sql = $this->model->query($query);
					$linha = mysql_fetch_array($sql);

					header("Location:".URL."NFeEntrada/Buscar/".$linha["id"]);
				}

			}
			$this->view->render ( 'nfeentrada/entrada' );

			break;


			case "Editar":


			if ($_POST["remetente"]) {


				$_POST["chave"] = str_replace(".", "", $_POST["chave"]);
				$_POST["chave"] = str_replace("/", "", $_POST["chave"]);
				$_POST["chave"] = str_replace("-", "", $_POST["chave"]);
				$_POST["chave"] = str_replace(" ", "", $_POST["chave"]);


				$this->editar($_GET["var3"],"nfeEntrada",false);

				header("Location:".URL."NFeEntrada/Buscar/".$_GET["var3"]);
			}

			$this->pegaId("nfeEntrada",$_GET["var3"]);
			$this->view->render ( 'nfeentrada/entrada' );
			break;


			case "Buscar":

			$this->pegaId("nfeEntrada",$_GET["var3"]);


			$this->view->render ( 'nfeentrada/buscar' );
			break;
			
			case "GetRemetenteCNPJ":

			$this->pegaCnpj();

			break;


			case "Deletar":

			$query = "DELETE FROM nfeEntrada WHERE id=".$_GET["var3"];
				///echo ($query);


			if ($this->model->query ( $query )) {
				header("Location: ".URL."NFeEntrada");
			}

			break;



			
			default:
			
			$this->listar();
			
			$this->view->render ( 'nfeentrada/index' );
			break;
		}

	}



	protected function listar() {

		$lista="";


		$query = "SELECT * FROM nfeEntrada";

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

			<td class='center'>
			<a href='".URL.$_GET["var1"]."/Buscar/".$linha["id"]."' title='Buscar' class='tipS'>
			<img src='". Folder."images/icons/control/32/publish.png' width='24' alt='' />
			</a>
			</td>
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
			<img src='". Folder."images/icons/control/new/pencil-2.png' width='24' alt='' />
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




	protected function pegaCnpj(){
		$cnpj = $this->formatarCpfCnpj(strval($_POST["cnpj"]));
		$query = "SELECT id FROM fornecedores WHERE cnpj='".$cnpj."'";
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);

		ob_end_clean();
		echo $linha["id"];
	}
}