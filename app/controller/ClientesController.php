<?php
class ClientesController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

			if (isset($_POST["nome"])) {
				unset($_POST["tipo"]);
				unset($_POST["idCliente"]);
				$this->cadastrar("clientes");
			}
			$this->cidades();
			$this->pagamentos();
			$this->vendedor();
			$this->view->render ( 'clientes/novo' );
			break;

			case 'XML':
			$this->consultar();
			break;

			case 'BuscaCidade':
			$this->BuscaCidade();
			break;

			case "Editar":

			if (isset($_POST["nome"])) {
				unset($_POST["tipo"]);
				unset($_POST["idCliente"]);
				if ($_POST["pagamento"]=="0") {
					unset($_POST["pagamento"]);
				}

				$this->editar($_GET["var3"],"clientes");
			}
			
			$this->pegaId("clientes",$_GET["var3"]);
			$this->pagamentos();
			$this->cidades();
			$this->vendedor();
			$this->view->render ( 'clientes/novo' );
			break;
			case "Cpf":

			$this->verificar();

			break;

			case "Cliente":

			$this->verificarCliente();

			break;

			case "GetCliente":

			$this->GetCliente();

			break;

			case "Cliente":

			$this->buscar();

			break;

			case "Relatorio":
			$this->view->formas = array("Selecione uma forma de Pagamento","A Vista", "Boleto", "Cheque", "Fiado");

			
			$this->pegaId("clientes",$_GET["var3"]);
			$cidade = $this->pegaDadosCodigo("municipios",$this->view->cidade);
			$this->view->cidade = ucwords(strtolower($cidade["nome"]));

			$vendedor = $this->pegaDados("funcionarios",$this->view->vendedor);
			$this->view->vendedor = ucwords(strtolower($vendedor["nome"]));

			$this->pegaPedidos();
			$this->pegaCheques();
			$this->Localizacao();

			$this->gerarVendas();
			$this->gerarChart();

			$this->view->render ( 'clientes/relatorio' );
			break;


			case "Deletar":

			$this->deletar($_GET["var3"], "clientes");

			$this->listar();

			$this->view->render ( 'clientes/index' );
			break;

			default:
			$this->listar();
			$this->view->render ( 'clientes/index' );
			break;
		}
	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA Clientes NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM clientes";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$vendedor = $this->pegaDados("funcionarios", $linha["vendedor"]);

			$this->formatarCpf($linha);

			if ($linha["cidade"]!="") {
				$cidade = $this->pegaDadosCodigo("municipios",$linha["cidade"]);
			}else{
				$cidade["nome"] = "XXX";
			}
			$vendedor = explode(" ", $vendedor["nome"]);
			$lista.= "
			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".htmlentities($linha["nome"])."</td>
			<td class='center'>".$linha["cpf"]."</td>
			<td class='center'>".ucwords(strtolower($cidade["nome"]))."</td>
			<td class='center'>".$vendedor[0]." ".$vendedor[1]."</td>
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Relatorio/".$linha["id"]."' title='Ver o Relatório' class='tipS'>
			<img src='". Folder."images/icons/control/16/attibutes.png' alt='' /> 
			</a>
			<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
			<img src='". Folder."images/icons/control/16/pencil.png' alt='' /> 
			</a> 
			<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
			<img src='". Folder."images/icons/control/16/clear.png' alt='' />
			</a>
			</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}


	private function formatarCpf($dados){
		if ($dados["nome"]!==ucwords($dados["nome"]) OR !strstr($dados["cpf"], "-") OR !strstr($dados["cpf"], ".")) {
			$cpf = $this->formatarCpfCnpj(strval($dados["cpf"]));
			$query = "UPDATE clientes SET cpf='".$cpf."', nome='".ucwords($dados["nome"])."' WHERE id=".$dados["id"];
			$sql = $this->model->query($query);
		}
		
		
	}
	private function vendedor(){

		$query = "SELECT * FROM funcionarios WHERE funcao=1";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->vendedor) && $linha["id"]==$this->view->vendedor) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->vendedores = $lista;
	}

	protected function verificarCliente() {
		$query = "SELECT * FROM clientes WHERE nome LIKE ('%".$_POST["nome"]."%')";
		$sql = $this->model->query($query);
		$html = "";
		while($linha = mysql_fetch_array($sql)){
			$cidade = $this->pegaDadosCodigo("municipios",$linha["cidade"]);
			$html .= "
			<ol>Nome: 
			<b>
			<a href='".URL."Clientes/Relatorio/".$linha["id"]."' target='_blank'>".($linha["nome"])."</a>
			</b>
			<li style='margin-left:10px;'>CPF: ".$linha["cpf"]."</li>
			<li style='margin-left:10px;'>Cidade: ".$cidade["nome"]."</li>
			</ol>";
		}

		if ($html=="") {
			$html = "Nenhum resultado em Clientes";
		}

		echo $html;


	}

	protected function GetCliente() {
		$query = "SELECT * FROM clientes WHERE nome LIKE ('%".$_POST["nome"]."%') LIMIT 4";
		$sql = $this->model->query($query);
		$html = "";
		while($linha = mysql_fetch_array($sql)){
			$cidade = $this->pegaDadosCodigo("municipios",$linha["cidade"]);
			$html .= "
			<script>
			$(function(){ $('.idCliente').click( function() { id = $(this).val();	$('#idCliente').val(id); }); });
			</script>
			<ol style='float:left; border:1px #ccc dashed;padding:10px;'>
			<li>Nome: <b><a href='".URL."Clientes/Relatorio/".$linha["id"]."' target='_blank'>".($linha["nome"])."</a></b></li>
			<li style='margin-left:10px;'>CPF: ".$linha["cpf"]."</li>
			<li style='margin-left:10px;'>Cidade: ".$cidade["nome"]."</li>
			<li><label><input type='radio' name='idCliente' value='".$linha["id"]."' class='idCliente'> Pegar ID</label></li>
			</ol>";
		}

		if ($html=="") {
			$html = "Nenhum resultado em Clientes";
		}

		echo $html;


	}

	protected function BuscaCidade() {
		$query = "SELECT * FROM municipios WHERE nome = '".$_POST["cidade"]."' LIMIT 1";
		$sql = $this->model->query($query);
		$html = "";
		$linha = mysql_fetch_array($sql);
		if ($linha["codigo"]) {
			echo json_encode($linha);
		}else{
			$data["false"] = true;
			echo json_encode($data);
		}

	}


	protected function verificar() {
		$query = "SELECT * FROM clientes WHERE cpf='".$_POST["cpf"]."'";
		$sql = $this->model->query($query);
		while($linha = mysql_fetch_array($sql)){
			$i++;

		}

		if ($i>0) {
			$html = "<span style='color:green;'>Cliente J&aacute; Cadastrado!<span>";
		}else{
			$html = "<span style='color:red;'>Cliente n&atilde;o Cadastrado!<span>";
		}
		$number = str_replace(".", "", $_POST["cpf"]);
		$number = str_replace("/", "", $number);
		$number = str_replace("-", "", $number);
		$validate = new Validate;

		if (strlen($number)==14) {

			$retorno = $validate->cnpj($number);
			if (strstr($retorno, "Inv")) {
				$html .= "<br><span style='color:red;'>".$retorno."!<span>";
			}else{
				$html .= "<br><span style='color:green;'>".$retorno."!<span>
				<input type='button' value='Buscar Dados do CNPJ' class='consultarCNPJ' style='margin-left:20px;'>";
			}

		}elseif (strlen($number)==11) {
			$retorno = $validate->cpf($number);
			if (strstr($retorno, "Inv")) {
				$html .= "<br><span style='color:red;'>".$retorno."!<span>";
			}else{
				$html .= "<br><span style='color:green;'>".$retorno."!<span>";
			}
		}else{
			$html .="<br><span style='color:red;'>Numero Inv&aacute;lido!<span>";

		}


		echo $html;


	}

	private function pagamentos(){
		$pagamentos = array("Selecione uma forma de Pagamento","A Vista", "Boleto", "Cheque", "Fiado");

		foreach ($pagamentos as $key => $value) {


			if (isset($this->view->pagamento) && $key==$this->view->pagamento) {
				$lista .="<option value='".$key."' selected>".$value."</option>";
			}else{
				$lista .="<option value='".$key."'>".$value."</option>";
			}
		}


		$this->view->pagamentos = $lista;
	}




	private function cidades(){

		$query = "SELECT * FROM municipios WHERE codigo LIKE ('52%') ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){


			if (isset($this->view->cidade) && $linha["codigo"]==$this->view->cidade) {
				$lista .="<option value='".$linha["codigo"]."' selected>".(ucwords(strtolower(htmlentities($linha["nome"]))))."</option>";
			}else{
				$lista .="<option value='".$linha["codigo"]."'>".(ucwords(strtolower(htmlentities($linha["nome"]))))."</option>";
			}
		}


		$this->view->selectCidades = $lista;
	}


	protected function pegaCheques(){


		$query = "SELECT * FROM chqclientes WHERE cliente=".$_GET["var3"]." ORDER BY id DESC";
		$sql = $this->model->query($query);

		//// para cada bloco dessa venda
		while ($linha=mysql_fetch_assoc($sql)) {
			$valor+= $linha["valor"];

			if ($linha["voltou"]=="1") {
				$voltou="<img src='". Folder."images/icons/control/16/clear.png' alt=''/>";
			}else{
				$voltou="<img src='". Folder."images/icons/control/16/check.png' alt=''/>";
			}
			$html .= "
			<li style='list-style: none;  padding:5px;' class='exp'>
			<h6 style='font-size:14px;'>N&ordm;: ".$linha['numero']." - Valor: R$ ".number_format($linha["valor"],2,",",".")." ( ".$linha["data"]." / P/ ".$linha["para"]." ) $voltou</h6>
			</li>
			<div >
			<li style='list-style: none;  padding:5px;' >
			<span>Compensa&ccedil;&atilde;o: ".$linha["para"]."</span><br>
			<span>Dado a: ".$linha["quem"]."</span><br>
			</li>
			</div>";

		}

		if ($html==false) {
			$html = "<i>Nenhum Cheque desse Cliente</i>";
		}

		$this->view->chequesCliente["html"] .= $html;
		$this->view->chequesCliente["total"] = $valor;

	}


	protected function pegaPedidos(){
		$this->view->venda["avista"] = array();
		$this->view->venda["aprazo"] = array();
		$this->view->venda["cheque"] = array();
		$this->view->venda["boleto"] = array();


		$this->view->venda["avista"]["total"] = 0;
		$this->view->venda["aprazo"]["total"] = 0;
		$this->view->venda["cheque"]["total"] = 0;
		$this->view->venda["boleto"]["total"] = 0;

		$query = "SELECT * FROM pedidos WHERE cliente=".$_GET["var3"]." ORDER BY bloco ASC";
		$sql = $this->model->query($query);

		//// para cada bloco dessa venda
		while ($linha=mysql_fetch_assoc($sql)) {

			$this->detalhaPedido($linha);

		}

	}

	protected function detalhaPedido($dadosPedido){

		$query = "SELECT * FROM produtosBlocos WHERE bloco=".$dadosPedido["bloco"]." AND pedido=".$dadosPedido["numero"]." ORDER BY id";
		$sql = $this->model->query($query);

		$qntProdutos=0;
		$xhtml = "";

		//// para cada bloco dessa venda
		while ($linha=mysql_fetch_assoc($sql)) {

			$produto = $this->pegaDados("produtos",$linha["produto"]);


			$valor+=($linha["valor"]*$linha["quantidade"]);

			$qntProdutos+=$linha["quantidade"];

			$xhtml .= "<li style='padding-left:10px;' class='exp' >
			<span>".$produto["nome"]."</span>
			</li>
			<div style='padding-left:20px;'>
			<span>Valor: R$ ".number_format($linha["valor"],2,",",".")."</span><br>
			<span>Quantidade: ".$linha["quantidade"]."</span><br>";
			if ($linha["valor"]>$produto["venda"]) {
				$acima += ($linha["valor"] - $produto["venda"])*$linha["quantidade"];
				$this->view->venda["acima"]+= $acima;
				$xhtml .= "			<span>Acima: R$ ".number_format(($linha["valor"]-$produto["venda"]),2,",",".")." / Total: R$ ".number_format(($linha["valor"]-$produto["venda"])*$linha["quantidade"],2,",",".")."</span><br>";
			}elseif ($linha["valor"]<$produto["venda"]) {
				$desconto += ($produto["venda"]-$linha["valor"])*$linha["quantidade"];
				$this->view->venda["desconto"]+= $desconto;
				$xhtml .= "			<span>Desconto: R$ ".number_format(($produto["venda"]-$linha["valor"]),2,",",".")." / Total: R$ ".number_format(($produto["venda"]-$linha["valor"])*$linha["quantidade"],2,",",".")."</span><br>";	

			}else{

			}


			$xhtml .= "<hr></div>";

		}
		$recebidos = $this->pegaRecebeu($dadosPedido["bloco"], $dadosPedido["numero"]);

		$dadosBloco = $this->pegaDados("blocos",$dadosPedido["bloco"]);
		$dadosCliente = $this->pegaDados("clientes",$dadosPedido["cliente"]);
		$html = "
		<li style='list-style: none;  padding:5px;' class='exp'>
		<h6 style='font-size:14px;'>Bloco N&ordm;: ".$dadosPedido['bloco']." e Pedido N&ordm;: ".$dadosPedido['numero']." - Valor: R$ ".number_format($valor,2,",",".")." ( ".$dadosPedido["data"]." )</h6>
		</li>
		<div >
		<li style='list-style: none;  padding:5px;' >
		<span>Cliente: ".$dadosCliente["nome"]."</span><br>
		<span>Data: ".$dadosPedido["data"]."</span><br>

		<ul>
		<li style='list-style: none;  padding:5px;' class='exp'>
		<span>Produtos: ".$qntProdutos."</span><br>
		<span>Desconto: R$ ".number_format($desconto,2,",",".")."</span><br>
		<span>Acima: R$ ".number_format($acima,2,",",".")."</span><br>";
		if ($recebidos!=0) {
			$html .="<span>Recebeu: R$ ".number_format($recebidos,2,",",".")."</span><br>";
		}
		$html .="
		<span style='font-weight:bold;'> [ Detalhar ]</span>
		</li>
		<div >
		<ol style='list-style:decimal inside;'>
		".$xhtml."
		</ol>
		</div>
		</ul>
		</li>

		</div>";


		$this->pedido[$dadosPedido["data"]]=$valor;

		$this->view->pedidos["html"] .= $html;
		$this->view->pedidos["total"] += $valor;

		switch ($dadosPedido["pagamento"]) {

			case '0':
			$this->view->venda["avista"]["total"] += $valor;
			break;

			case '1':
			$this->view->venda["aprazo"]["total"] += $valor;
			break;

			case '2':
			$this->view->venda["cheque"]["total"] += $valor;
			break;

			case '3':
			$this->view->venda["boleto"]["total"] += $valor;
			break;

		}


	}

	private function pegaRecebeu($bloco,$pedido){

		$query = "SELECT valor,data FROM recebeuPedido WHERE bloco=".$bloco." AND pedido=".$pedido;

		$sql = $this->model->query($query);

		while ($linha=mysql_fetch_assoc($sql)) {
			$valor+= $linha["valor"];

		}
		return $valor;
	}




	/*






	*/
	protected function gerarVendas(){
		$vendas = $this->pedido;

		$url .= "function vendasChart() {\n";

		$url .= "var data = google.visualization.arrayToDataTable([\n";



			$url .= "['x', 'Compras'],\n";


			$count = count($vendas);

			foreach ($vendas as $key => $value) {
				$valores .= "['".$key."',  ".$value;	

				if ($vendas[$count-1]==$value) {
					$valores .= "]\n";
				}else{
					$valores .= "],\n";
				}
			}
			




			$url .= $valores;

			$url .= "]);\n ";
$url .= " var options = {\n
	title: 'Gráfico das Compras',\n
	curveType: 'none',\n
};\n";


$url .= "var chart = new google.visualization.LineChart(document.getElementById('vendasChart'));\n
chart.draw(data, options);

}";

$this->view->graficosVendas = $url;

}


/*






	*/
protected function gerarChart(){


	$url .= "function comprasChart() {\n";
			//// DEFINE ARRAY COM OS DADOS
	$url .= "
	var data = google.visualization.arrayToDataTable([\n
		['Labels','Values'],\n
		['A Vista', ".$this->view->venda["avista"]["total"]."],\n
		['Cheque',".$this->view->venda["cheque"]["total"]."],\n
		['Boleto',".$this->view->venda["boleto"]["total"]."],\n
		['Fiado',".$this->view->venda["aprazo"]["total"]."]\n
		]);\n
var options = {\n
	title: 'Divisão das Compras',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data, options);
}";
				/// TITULO DO GRAFICO




$this->view->graficosCompras = $url;

}	

protected function Localizacao(){
	$query = "SELECT * FROM localizacao WHERE cliente=".$_GET["var3"];
	$sql = $this->model->query($query);
	while ($linha=mysql_fetch_assoc($sql)) {
		$loca = explode(",", $linha["location"]);

		


		if (!in_array($linha["location"], $locations)) {
			$locations[] = $linha["location"];

			$url = "https://maps.google.com.br/maps?q=".$loca[0]."+".$loca[1]."&hl=pt-BR&ll=".$linha["location"]."&spn=0.002606,0.004812&sll=".$linha["location"]."&sspn=0.010423,0.019248&t=h&z=20";

			$html .= "
			<li style='list-style: none;  padding:5px;'>
			<h6 style='font-size:14px;'>Data: ".$linha['data']." - Hora: ".$linha["horario"]." ( Lat: ".number_format($loca[0],9)." / Lon: ".number_format($loca[1],9).") 
			<a href='".$url."' title='' target='_blank' class='wButton greenwB ml15 m10' style='margin: 18px 18px 0 0px;'> 
			<span>Ver no Mapa</span> 
			</a> 
			</h6>
			</li>";
		}
	}

	$this->view->localizacao = $html;

}


protected function consultar(){
	$login = "waydist";
	//$login = "wwdotk";
	$senha = "bb7oexty";

	if ($_POST["cpf"]) {
		$vars = array(
			'login' => $login,
			'senha' => $senha,
			"cpf" => $_POST["cpf"]
			);

		$url = "http://ws.fontededados.com.br/consulta.asmx/SituacaoCadastralPFCompleta";

	}elseif ($_POST["cnpj"]) {
		$vars = array(
			'login' => $login,
			'senha' => $senha,
			"cnpj" => $_POST["cnpj"]
			);
		$url = "http://ws.fontededados.com.br/consulta.asmx/SituacaoCadastralPJ";	
	}

	foreach($vars as $keys=>$values) { $fields_string .= $keys.'='.$values.'&'; }
	rtrim($fields_string, '&');
	  ////EXECUTA A URL
	$ch = curl_init($url);
	curl_setopt($ch,CURLOPT_POST, count($vars));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


	  /// $resultado  PEGA O XML COM OS RESULTADOS DA BUSCA
	$resultado = curl_exec($ch);
	curl_close($ch);
	

	$xml =  simplexml_load_string($resultado);
	foreach ($xml as $key => $value) {
		$xml->$key = ucwords(strtolower($value));
	}

	if ($xml->CodErro>0) {
		$data["false"] = "false";
		foreach ($xml as $key => $value) {
			$data[$key]  = ucwords(strtolower($value));
		}
		echo json_encode($data);
	}else{
		echo json_encode($xml);
	}
	
	

}




}