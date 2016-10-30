<?php
class WebServiceController extends Controller {
	function __construct() {
		parent::__construct ();

		$this->dir = "app/public/webservice/";
	}

	function index() {
		if($_GET["var2"]=="xml64") {
			$this->ArquivoXml(true);
		}elseif($_GET["var2"]=="XmlProds") {
			$this->XmlProds();
		}elseif($_GET["var2"]=="Transferir") {
			$this->Transferir();
		}else{

			if ($_GET["var2"]=="TransferAll") {
				$this->transferirTudo();
			}
			$this->lerXmls();
			$this->view->render ( 'webservice/index' );
		}
		
	}

	protected function ArquivoXml(){
		
		$xml = base64_decode($_POST["xml"]);
		
		$nome = $_POST["nome"];

		

		$file = $this->dir.$nome;

		if(file_put_contents($file, $xml)){
			echo "Arquivo Enviado com Sucesso!";
		}else{
			echo "Erro ao Enviar o Arquivo ao WebService. Tente novamente mais Tarde!";
		}
	}

	protected function transferirTudo(){
		$diretorio = dir($this->dir);


		while($arquivo = $diretorio -> read()){

			$file = $this->dir.$arquivo;

			if (is_file($file)) {

				$xml =  simplexml_load_file($file);

				$name = explode("_", $arquivo);

				$_POST["tipo"] = $name[0];
				$_POST["arquivo"] = $arquivo;

				$this->Transferir();
			}
		}
	}

	protected function lerXmls(){
		
		
		$html =""; 

		$diretorio = dir($this->dir);


		while($arquivo = $diretorio -> read()){

			$file = $this->dir.$arquivo;

			if (is_file($file)) {

				$xml =  simplexml_load_file($file);

				$name = explode("_", $arquivo);
				
				switch ($name[0]) {
					case 'Cliente':
					$html .= $this->Clientes($xml,$arquivo,$name);
					break;
					
					case 'Pedido':
					$html .= $this->Pedidos($xml,$arquivo,$name);
					break;
					
					case 'Recebeu':
					$html .= $this->Recebidos($xml,$arquivo,$name);
					break;
				}

				
			}
		}

		ksort($this->Vendedor);
		foreach ($this->Vendedor as $key => $values) {

			$vendedor = $this->pegaDados("funcionarios",$key);
			$html .= '
			<fieldset style="width: 30%; min-width: 200px; float: left; padding: 10px;">

			<div class="widget">
			<div class="title">
			<img src="'.Folder.'images/icons/dark/money2.png" alt="" class="titleIcon" />
			<h6>'.$vendedor["nome"].'</h6>
			</div>
			<div  style="padding: 10px;">
			';
			foreach ($values as $tipo => $value) {
				$html .= "
				<h6 style='font-size:18px; padding:20px;' class='exp'>".$tipo.":</h6>
				<div  style='padding-left: 20px;'>";
				foreach ($value as  $arqs) {

					$html .= $arqs;
				}
				$html.="
				</div>
				<hr>";
			}

			$html .= '

			</div>
			</div>

			</fieldset>';
		}

		$this->view->arquivos = $html;

	}

	protected function getObj($obj,$i=5){
		$x=$i+$i;
		for ($p=0; $p < $x; $p++) { 

			$space .= "&nbsp;";

		}
		foreach ($obj as $keys => $values) {        
			$html.= $space.$keys."=>".$values."<br>";
			if (get_object_vars($values)) {
				$html.= $this->getObj($values,$x);
			}
		}

		return $html;
	}

	protected function pegaCliente($values){
		$query = "SELECT id FROM clientes WHERE nome='".$values."'";
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);

		return $linha["id"];
	}

	protected function makePost($tipo,$obj){

		//print_r($tipo);


		switch ($tipo) {

			case 'Pedido':
			foreach($obj as $key=>$value){
				switch ($key) {

					case 'info':

					foreach ($value as $keys => $values) { 
						if ($keys=="cliente") {
							$_POST[$keys] = $this->pegaCliente(strval($values));
							$this->cliente = $_POST[$keys];
						}else{
							$_POST[$keys] = strval($values);
							if ($keys=="data") {
								$this->dataPedido =strval($values);
							}	
						}	
					}
					$this->cadastrar("pedidos");
					break;
					case 'produtos':

					foreach ($value as $keys => $values) { 
						$this->makePost("prod",$values);
					}
					break;


					case 'cheques':
					foreach ($value as $keys => $values) { 
						$this->makePost("cheque",$values);
					}
					break;

					case 'recebeu':
					
					foreach ($value as $keys => $values) { 
						$this->makePost("Recebeu2",$values);
					}
					break;

					case 'total':

					break;

				}
			}


			break;

			case 'cheque':
			$_POST["cliente"] = $this->cliente;
			$_POST["pedido"] = $this->pegaId($this->name);
			$_POST["data"] = $this->dataPedido;
			foreach ($obj as $keys => $values) { 
				$_POST[$keys] = strval($values);
				
				
			}
			$this->cadastrar("chqclientes");

			break;

			case 'Recebeu2':
			
			foreach ($obj as $keys => $values) { 
				$_POST[$keys] = strval($values);
			}
			$_POST["pedido"] = $this->pegaId($this->name);
			$this->cadastrar("recebeuPedido");

			break;
			case 'prod':

			$_POST["pedido"] = $this->pegaId($this->name);
			foreach ($obj as $keys => $values) { 
				$_POST[$keys] = strval($values);
				
				
			}
			$this->cadastrar("produtosBlocos");

			break;

			case 'Cliente':

			foreach ($obj as $keys => $values) { 
				if ($keys=="nome") {
					$_POST[$keys] = ucwords(strval($values));
				}elseif ($keys=="cpf") {
					$_POST[$keys] = $this->formatarCpfCnpj(strval($values));
				}else{
					$_POST[$keys] = strval($values);
				}
				
			}

			break;

			case 'Recebeu':

			foreach ($obj as $keys => $values) { 
				$_POST[$keys] = strval($values);
			}

			break;

		}


		return true;
	}

	protected function pegaId($dadosPedido){
		$query = "SELECT id FROM pedidos WHERE numero=".$dadosPedido[3]." AND bloco=".$dadosPedido[2]." AND vendedor=".$dadosPedido[1]." ORDER BY id DESC";
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);

		return $linha["id"];
	}
	protected function Clientes($xml,$arquivo,$name){

		$html = "
		<div>
		<ul>
		<li style='list-style: none;  padding:5px;' class='exp'>
		<h6 style='font-size:14px;'>Nome: ".$xml->nome." 
		<span tipo='".$name[0]."' arquivo='".$arquivo."' title='Transferir' class='tipS Transferir'>
		<img src='". Folder."images/icons/control/32/communication.png' alt='' style='vertical-align: 0px;margin-top:-10px;margin-left:-20px;padding-right:10px;float:left;'/> 
		</span></h6>
		</li>
		<div>";

		foreach($xml as $key=>$value){
			switch ($key) {

				case "nome":break;
				case "vendedor":break;
				case 'cidade':

				$cidade = $this->pegaDadosCodigo("municipios",$value);
				$value = $cidade["nome"];

				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($value)."</span><br>
				</li>
				";
				break;
				case 'pagamento':
				$pagamento = array("Selecione uma forma de Pagamento","A Vista", "Boleto", "Cheque", "Fiado");

				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($pagamento[(int) $value])."</span><br>
				</li>
				";
				break;
				case 'cidade':

				$cidade = $this->pegaDadosCodigo("municipios",$value);
				$value = $cidade["nome"];

				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($value)."</span><br>
				</li>
				";
				break;

				default:
				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($value)."</span><br>
				</li>
				";
				break;
			}

		}

		$html .="
		</div>
		</ul>
		</div>";
		$this->Vendedor[$name[1]]["Clientes Novos"][$arquivo]= $html;
	}
	protected function Pedidos($xml,$arquivo,$name){


		$html = "
		<div>
		<ul>
		<li style='list-style: none;  padding:5px;' class='exp'>
		<h6 style='font-size:14px;'>Bloco: ".$xml->info->bloco." Numero: ".$xml->info->numero." 
		<span tipo='".$name[0]."' arquivo='".$arquivo."' title='Transferir' class='tipS Transferir'>
		<img src='". Folder."images/icons/control/32/communication.png' alt='' style='vertical-align: 0px;margin-top:-10px;margin-left:-20px;padding-right:10px;float:left;'/> 
		</span></h6>
		</li>
		<div>";

		foreach($xml as $key=>$value){
			switch ($key) {

				case 'info':
				$html.="
				<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>Informa&ccedil;&otilde;es:</h6>
				</li>
				<div>";
				$html .= $this->Infos($value);
				$html .="
				</div>";
				break;
				case 'produtos':
				$html.="
				<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>Produtos:</h6>
				</li>
				<div>";
				$html .= $this->Produtos($value);
				$html .="
				</div>";
				break;

				case 'cheques':
				$html.="
				<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>Cheques Recebidos:</h6>
				</li>
				<div>";
				$html .= $this->Cheques($value);
				$html .="
				</div>";
				break;

				case 'recebeu':
				$html.="
				<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>Recebeu:</h6>
				</li>
				<div>";
				$html .= $this->RecebeuFiado($value);
				$html .="
				</div>";
				break;

				case 'total':
				$html .="
				<li style='list-style: none;  padding-left:15px;font-size:14px;'>
				<span>".ucwords($key).": R$ ".number_format(((int)$value),2,",",".")."</span><br>
				</li>
				";
				if ($this->RecebeuFiadoAbater) {
					$html .="
					<li style='list-style: none;  padding-left:15px;font-size:14px;'>
					<span>Falta Receber: R$ ".number_format(((int)$value-$this->RecebeuFiadoAbater),2,",",".")."</span><br>
					</li>
					";
				}
				break;

			}

		}

		$html .="
		</div>
		</ul>
		</div>";



		$this->Vendedor[$name[1]]["Pedidos Novos"][$arquivo]= $html;
	}



	protected function Infos($obj){
		foreach($obj as $key=>$value){
			switch ($key) {

				case "pago":break;
				case "chqs":break;
				case "vendedor":break;

				case "location":

				$loca = explode(",", strval($value));
				$url = "https://maps.google.com.br/maps?q=".$loca[0]."+".$loca[1]."&hl=pt-BR&ll=".strval($value)."&spn=0.002606,0.004812&sll=".strval($value)."&sspn=0.010423,0.019248&t=h&z=20";	
				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": <a href='".$url."' target='_blank'>( Lat: ".number_format($loca[0],9)." / Lon: ".number_format($loca[1],9).") </a></span><br>
				</li>
				";
				break;

				case 'cidade':

				$cidade = $this->pegaDadosCodigo("municipios",$value);
				$value = $cidade["nome"];

				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($value)."</span><br>
				</li>
				";
				break;
				case 'pagamento':
				$pagamento = array("A Vista", "A Prazo", "Boleto", "Cheque");

				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($pagamento[(int) $value])."</span><br>
				</li>
				";
				break;
				case 'cidade':

				$cidade = $this->pegaDadosCodigo("municipios",$value);
				$value = $cidade["nome"];

				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($value)."</span><br>
				</li>
				";
				break;

				case 'vencimento':
				if ($value!="0") {

					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": ".ucwords($value)."</span><br>
					</li>
					";
				}
				break;

				default:
				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($value)."</span><br>
				</li>
				";
				break;
			}

		}

		return $html;
	}

	protected function Cheques($obj){
		foreach($obj as $keys=>$values){
			foreach ($values as $key => $value) {

				switch ($key) {
					case 'banco':
					$dadosProd = $this->pegaDados("bancos",$value);
					$value = $dadosProd["nome"];

					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": ".ucwords($value)."</span><br>
					</li>
					";
					break;

					case 'cliente':

					break;

					case 'valor':

					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": R$ ".number_format(((int)$value),2,",",".")."</span><br>
					</li>
					";
					break;

					default:
					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": ".ucwords($value)."</span><br>
					</li>
					";
					break;
				}	
			}
			$html .="<hr>";
		}
		return $html;
	}





	protected function Produtos($obj){
		foreach($obj as $keys=>$values){

			foreach ($values as $key => $value) {

				switch ($key) {
					case 'produto':
					$dadosProd = $this->pegaDados("produtos",$value);
					$value = $dadosProd["nome"];

					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": ".ucwords($value)."</span><br>
					</li>
					";
					break;

					case 'valor':

					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": R$ ".number_format(((int)$value),2,",",".")."</span><br>
					</li>
					";
					break;

					default:
					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": ".ucwords($value)."</span><br>
					</li>
					";
					break;
				}
			}
			$html .="<hr>";
		}

		return $html;
	}

	protected function RecebeuFiado($obj){

		foreach($obj as $keys=>$values){
			foreach($values as $key=>$value){
				switch ($key) {

					case "pedido":break;
					case 'valor':

					$this->RecebeuFiadoAbater+=(int) $value;
					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": R$ ".number_format(((int)$value),2,",",".")."</span><br>
					</li>
					";
					break;

					default:
					$html .="
					<li style='list-style: none;  padding-left:15px;'>
					<span>".ucwords($key).": ".ucwords($value)."</span><br>
					</li>
					";
					break;
				}
			}
			$html .="<hr>";

		}

		return $html;
	}






	protected function Recebidos($xml,$arquivo,$name){
		$html = "
		<div>
		<ul>
		<li style='list-style: none;  padding:5px;' class='exp'>
		<h6 style='font-size:14px;'>ID Pedido: ".$xml->pedido." 
		<span tipo='".$name[0]."' arquivo='".$arquivo."' title='Transferir' class='tipS Transferir'>
		<img src='". Folder."images/icons/control/32/communication.png' alt='' style='vertical-align: 0px;margin-top:-10px;margin-left:-20px;padding-right:10px;float:left;'/> 
		</span></h6>
		</li>
		<div>";

		foreach($xml as $key=>$value){
			switch ($key) {

				case "pedido":break;
				case 'valor':

				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": R$ ".number_format(((int)$value),2,",",".")."</span><br>
				</li>
				";
				break;

				default:
				$html .="
				<li style='list-style: none;  padding-left:15px;'>
				<span>".ucwords($key).": ".ucwords($value)."</span><br>
				</li>
				";
				break;
			}

		}

		$html .="
		</div>
		</ul>
		</div>";
		$this->Vendedor[$name[1]]["Fiados Recebidos"][$arquivo]= $html;
	}




	protected function Transferir(){
		switch ($_POST["tipo"]) {
			case 'Cliente':
			$this->transferirCliente();
			break;
			case 'Pedido':
			$this->transferirPedido();
			break;
			case 'Recebeu':
			$this->transferirRecebeu();
			break;	
		}
	}

	protected function transferirCliente(){
		$file = $this->dir.$_POST["arquivo"];
		$file2 = $this->dir."updated/".$_POST["arquivo"];

		if (is_file($file)) {

			$xml =  simplexml_load_file($file);
			$this->makePost($_POST["tipo"],$xml);
			unset($_POST["arquivo"]);
			unset($_POST["tipo"]);
			//print_r($_POST);
			if ($this->cadastrar("clientes")) {
				if($this->mover($file,$file2)){
					echo "ok";
				}

			}else{
				print_r($_POST);
			}
		}
	}


	protected function transferirRecebeu(){
		$file = $this->dir.$_POST["arquivo"];
		$file2 = $this->dir."updated/".$_POST["arquivo"];

		if (is_file($file)) {

			$xml =  simplexml_load_file($file);
			$this->makePost($_POST["tipo"],$xml);
			unset($_POST["arquivo"]);
			unset($_POST["tipo"]);
			//print_r($_POST);
			if ($this->cadastrar("recebeuPedido")) {
				if($this->mover($file,$file2)){
					echo "ok";
				}

			}else{
				print_r($_POST);
			}
		}
	}


	protected function transferirPedido(){
		$file = $this->dir.$_POST["arquivo"];
		$file2 = $this->dir."updated/".$_POST["arquivo"];

		if (is_file($file)) {
			$arquivo = str_replace(".xml", "", $_POST["arquivo"]);

			$this->name = explode("_", $arquivo);

			//print_r($this->name);
			//print_r($_POST);
			$tipo = $_POST["tipo"];

			unset($_POST["arquivo"]);
			unset($_POST["tipo"]);


			$xml =  simplexml_load_file($file);
			$this->makePost($tipo,$xml);


			if($this->mover($file,$file2)){
				echo "ok";
			}else{
				print_r($_POST);
			}
		}

	}




	private function mover($arquivo,$arquivo2){

		if (is_file($arquivo )) {
			if(!rename($arquivo, $arquivo2)){
				echo "Erro ao mover o Arquivo: $arquivo para: $arquivo2 !";
				return false;
			}
			return true;
		}else{
			echo "Arquivo $arquivo inexistente";
			return false;
		}

	}


	protected function XmlProds() {
		
		$query = "SELECT * FROM produtos ORDER BY nome ASC";

		$valores_db = $this->model->query($query);

		$xml = new DOMDocument("1.0", "ISO-8859-1");
		$xml->preserveWhiteSpace = false;
		$xml->formatOutput = false;

		$produtos = $xml->createElement("produtos");
		while ($linha = mysql_fetch_assoc($valores_db)) {


			$prod = $xml->createElement("prod");

			$id = $xml->createAttribute('id');

			$id->value = $linha["id"];
			$prod->appendChild($id);
			
			foreach ($linha as $key => $value) {

				if ($key!="estoque" && $key!="distribuidor" && $key!="lucro" && $key!="peso") {

					try{
						switch ($key) {
							case 'compra':
							$$key = $xml->createElement($key,number_format($value,2,",","."));
							break;
							case 'venda':
							$$key = $xml->createElement($key,number_format($value,2,",","."));
							break;
							
							default:
							$$key = $xml->createElement($key,utf8_encode($value));
							break;
						}
						
						$prod->appendChild($$key);
					}catch(DOMException $e){
						echo $e;
					}
				}
			}
			$produtos->appendChild($prod);
		}

		$xml->appendChild($produtos);

		header("Content-Type: text/xml");

		print $xml->saveXML();

	}



}
