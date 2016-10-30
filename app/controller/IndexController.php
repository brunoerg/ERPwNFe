<?php

class IndexController extends Controller {
	function __construct() {
		parent::__construct ();
		$this->total = 0;
		$this->meses = array("Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
		$this->funcionarios = array();
	}

	function index() {
		
		switch ($_GET["var2"]) {

			case 'GetFile':
			$this->getFile();
			break;

			case 'Teste':
			$this->test();
			//$this->view->render ( 'index/teste' );
			break;

			case 'Gmail':
			$this->getGmail();
			break;
			
			default:
			$this->dados();
			$this->graficos();

			$this->view->render ( 'index/index' );
			break;
		}
	}

	protected function test($path=false,$margin = 10){

		$ignores = array("..",".",".DS_Store");

		if ($path==false) {
			$path = "app/";
		}
		
		if (is_dir($path)) {
			echo "<p style='margin-left:".$margin."px;'>Dir:".$path."</p>";
			$direct = dir($path);

			while($arquivo = $direct->read()){
				if (!in_array($arquivo, $ignores)) {
					//echo "=>".$path.$arquivo."<br>";
					if (is_dir($path.$arquivo)) {
						$this->test($path.$arquivo."/",($margin+10));
					}elseif (is_file($path.$arquivo)) {
						$this->files($path.$arquivo,$margin);
					}			
				}
			}
		}
	}

	protected function getFile(){
		ini_set("display_errors", "on");
		//$file = base64_decode($_GET["var3"]);
		//$dados = stat($file);
		//echo date("d-m-Y : H:i:s",$dados[10]);
		echo "<pre>";
		echo shell_exec("help ssh");
		echo "</pre>";
	}



	protected function files($path,$margin){
		$dados = stat($path);
		//$url = "https://waydistribuicao.com/Index/GetFile/".base64_encode($path);
		//$ch = curl_init($url);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//$resultado = curl_exec($ch);
		//curl_close($ch);

		echo "<p style='margin-left:".$margin."px;'>file:".$path." (".base64_encode($path).") > ".date("d-m-Y : H:i:s",$dados[9])." > $resultado </p>";
	}

	protected function getGmail(){

		
		$username ="waydist";
		$password ="32101588";
		$url = "https://".$username.":".$password."@mail.google.com/mail/feed/atom";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		/*curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_ENCODING, "");*/
		$resultado = curl_exec($curl);

		curl_close($ch);
		$xml = simplexml_load_string($resultado);
		
		ob_end_clean();
		
		if ($xml->entry) {
			$i=0;
			foreach ($xml->entry as $msg) {
				$txt = explode("T", $msg->issued);
				$data = explode("-", $txt[0]);
				$data = $data[2]."/".$data[1]."/".$data[0];
				$hora = str_replace("Z", "hs", $txt[1]);
				$title = strval($msg->title);
				$link = strval($msg->link["href"]);
				$autor= strval($msg->author->name);
				$msg = strval($msg->summary);

				$dados[$i]["title"] = $title;
				$dados[$i]["msg"] = $msg;
				$dados[$i]["link"] = $link;
				$dados[$i]["data"] = $data;
				$dados[$i]["hora"] = $hora;
				$dados[$i]["autor"] = $autor;
				$i++;
			}

			echo json_encode($dados);
		}else{
			echo $resultado;
			echo "<br>".$url;
			return false;
		}
		
	}

	


	protected function dados() {
		$data = date("d-m-Y");
		$this->chequesitau($data);
		$this->chequesbb($data);
		$this->boletos($data);
		$this->vencimentos($data);
		$this->debitos($data);
	}

	protected function chequesitau($data) {
		$html ="";

		$total = 0;


		$query = "SELECT * FROM cheques WHERE banco=2 AND pago=0";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["para"]);
			$para = explode("-", $data);
			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			if( $date[1]<$para[1] && $date[2]<=$para[2]){

				$banco = $this->pegaDados("bancos", $linha["banco"]);
				$html.="
				<ul>
				<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>N&ordm; ".$linha["numero"]." - R$ ".number_format($linha["valor"],2)." 

				</h6>
				</li>
				<div >
				<li style='list-style: none;  padding:5px;' >
				<span>Para: ".$linha["quem"]."</span><br>
				<span>Data: ".$linha["data"]."</span><br>
				<span>Compensa&ccedil;&atilde;o: ".$linha["para"]."</span><br>
				<a url='".URL."Cheques/Pago/".$linha["numero"]."' title='Pago' class='tipS'>
				<img src='". Folder."images/icons/control/16/busy.png' alt='' style='padding-top:10px;cursor:pointer;'/> 
				</a>
				</li>

				</div>
				</ul>
				";
				$total +=$linha["valor"];
			}elseif( $date[1]==$para[1] && $date[2]<=$para[2]){

				if ($date[0]<=$para[0]) {

					$banco = $this->pegaDados("bancos", $linha["banco"]);
					$html.="
					<ul>
					<li style='list-style: none;  padding:5px;' class='exp'>
					<h6 style='font-size:14px;'>N&ordm; ".$linha["numero"]." - R$ ".number_format($linha["valor"],2)." 

					</h6>
					</li>
					<div >
					<li style='list-style: none;  padding:5px;' >
					<span>Para: ".$linha["quem"]."</span><br>
					<span>Data: ".$linha["data"]."</span><br>
					<span>Compensa&ccedil;&atilde;o: ".$linha["para"]."</span><br>
					<a url='".URL."Cheques/Pago/".$linha["numero"]."' title='Pago' class='tipS'>
					<img src='". Folder."images/icons/control/16/busy.png' alt='' style='padding-top:10px;cursor:pointer;'/> 
					</a>
					</li>

					</div>
					</ul>
					";
					$total +=$linha["valor"];
				}
			}


		}


		$html.="
		<div class='title'>
		<h6>Total =  R$ ".number_format($total,2)."</h6>
		</div>";
		$this->view->chequesitau = $html;

	}
	protected function chequesbb($data) {
		$html ="";

		$total = 0;


		$query = "SELECT * FROM cheques WHERE banco=1 AND pago=0";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["para"]);
			$para = explode("-", $data);
			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			if( $date[1]<$para[1] && $date[2]<=$para[2]){

				$banco = $this->pegaDados("bancos", $linha["banco"]);
				$html.="
				<ul>
				<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>N&ordm; ".$linha["numero"]." - R$ ".number_format($linha["valor"],2)." 

				</h6>
				</li>
				<div >
				<li style='list-style: none;  padding:5px;' >
				<span>Para: ".$linha["quem"]."</span><br>
				<span>Data: ".$linha["data"]."</span><br>
				<span>Compensa&ccedil;&atilde;o: ".$linha["para"]."</span><br>
				<a url='".URL."Cheques/Pago/".$linha["numero"]."-Index' title='Pago' class='tipS'>
				<img src='". Folder."images/icons/control/16/busy.png' alt='' style='padding-top:10px;cursor:pointer;'/> 
				</a>
				</li>

				</div>
				</ul>
				";
				$total +=$linha["valor"];
			}elseif( $date[1]==$para[1] && $date[2]<=$para[2]){

				if ($date[0]<=$para[0]) {

					$banco = $this->pegaDados("bancos", $linha["banco"]);
					$html.="
					<ul>
					<li style='list-style: none;  padding:5px;' class='exp'>
					<h6 style='font-size:14px;'>N&ordm; ".$linha["numero"]." - R$ ".number_format($linha["valor"],2)." 

					</h6>
					</li>
					<div >
					<li style='list-style: none;  padding:5px;' >
					<span>Para: ".$linha["quem"]."</span><br>
					<span>Data: ".$linha["data"]."</span><br>
					<span>Compensa&ccedil;&atilde;o: ".$linha["para"]."</span><br>
					<a url='".URL."Cheques/Pago/".$linha["numero"]."-Index' title='Pago' class='tipS'>
					<img src='". Folder."images/icons/control/16/busy.png' alt='' style='padding-top:10px;cursor:pointer;'/> 
					</a>
					</li>

					</div>
					</ul>
					";
					$total +=$linha["valor"];
				}
			}
		}

		$html.="
		<div class='title'>

		<h6>Total =  R$ ".number_format($total,2)."</h6>
		</div>";

		$this->view->chequesbb = $html;

	}

	protected function boletos($data) {
		$html ="";

		$total = 0;

		$query = "SELECT * FROM boletos WHERE pago=0";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){

			$date = explode("-", $linha["vencimento"]);
			$para = explode("-", $data);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			if($date[1]<$para[1] && $date[2]<=$para[2]){

				$cliente = $this->pegaDados("clientes",$linha["cliente"]);

				$html.="
				<ul>
				<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>".$cliente["nome"]." - R$ ".number_format($linha["valor"],2)." 

				</h6>
				</li>
				<div >
				<li style='list-style: none;  padding:5px;' >
				<span>Vencimento: ".$linha["vencimento"]."</span><br>
				<span>ID: ".$linha["id"]."</span><br>
				<a url='".URL."Boletos/Pago/".$linha["id"]."' title='Pago' class='tipS'>
				<img src='". Folder."images/icons/control/16/busy.png' alt='' style='padding-top:10px;cursor:pointer;'/> 
				</a>
				</li>

				</div>
				</ul>";
				$total +=$linha["valor"];
			}elseif( $date[1]==$para[1] && $date[2]<=$para[2]){

				if ($date[0]<=$para[0]) {

					$cliente = $this->pegaDados("clientes",$linha["cliente"]);

					$html.="
					<ul>
					<li style='list-style: none;  padding:5px;' class='exp'>
					<h6 style='font-size:14px;'>".$cliente["nome"]." - R$ ".number_format($linha["valor"],2)." 

					</h6>
					</li>
					<div >
					<li style='list-style: none;  padding:5px;' >
					<span>Vencimento: ".$linha["vencimento"]." </span><br>
					<span>ID: ".$linha["id"]." </span><br>
					<a url='".URL."Boletos/Pago/".$linha["id"]."' title='Pago' class='tipS'>
					<img src='". Folder."images/icons/control/16/busy.png' alt='' style='padding-top:10px;cursor:pointer;'/> 
					</a>
					</li>

					</div>
					</ul>";
					$total +=$linha["valor"];
				}
			}
		}

		$html.="
		<div class='title'>
		<h6>Total =  R$ ".number_format($total,2)."</h6>
		</div>";

		$this->view->boletos = $html;

	}




	protected function vencimentos($data) {
		$html ="";

		$total = 0;

		$query = "SELECT * FROM vencimentos WHERE pago=0";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["vencimento"]);
			$para = explode("-", $data);
			//date[0] = dia
			//date[1] = mes
			//date[2] = ano


			if($date[1]<$para[1] && $date[2]<=$para[2]){

				$add = "";
				if ($this->verificaVencimento($date)) {
					$add = "vencido='1'";
					$link ="Juros";
					$url2 = "url2='".URL."Vencimentos/Pago/".$linha["id"]."'";
				}else{
					$link ="Pago";
				}

				$html.="
				<ul>
				<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>".substr($linha["cedente"], 0,15)." - R$ ".number_format($linha["valor"],2)." 

				</h6>
				</li>
				<div >
				<li style='list-style: none;  padding:5px;' >
				<span>Vencimento: ".$linha["vencimento"]."</span><br>
				<a url='".URL."Vencimentos/$link/".$linha["id"]."' $url2 title='Pago' $add class='tipS'>
				<img src='". Folder."images/icons/control/16/busy.png' alt='' style='padding-top:10px;'/> 
				</a>
				</li>

				</div>
				</ul>";



				$total +=$linha["valor"];
			}elseif( $date[1]==$para[1] && $date[2]<=$para[2]){



				if ($date[0]<=$para[0]) {

					$add = "";
					if ($this->verificaVencimento($date)) {
						$add = "vencido='1'";
						$link ="Juros";
						$url2 = "url2='".URL."Vencimentos/Pago/".$linha["id"]."'";
					}else{
						$link ="Pago";
					}
					$html.="
					<ul>
					<li style='list-style: none;  padding:5px;' class='exp'>
					<h6 style='font-size:14px;'>".substr($linha["cedente"], 0,15)." - R$ ".number_format($linha["valor"],2)." </h6>
					</li>
					<div >
					<li style='list-style: none;  padding:5px;' >
					<span>Vencimento: ".$linha["vencimento"]."</span><br>
					<a url='".URL."Vencimentos/$link/".$linha["id"]."' $url2 title='Pago' $add class='tipS'>
					<img src='". Folder."images/icons/control/16/busy.png' alt='' style='padding-top:10px;'/> 
					</a>
					</li>

					</div>
					</ul>";

					$total +=$linha["valor"];
				}
			}
		}

		$html.="
		<div class='title'>

		<h6>Total =  R$ ".number_format($total,2)."</h6>
		</div>";

		$this->view->vencimentos = $html;

	}


	protected function debitos($data) {
		$html ="";

		$total = 0;

		$query = "SELECT * FROM despesas WHERE data='".$data."' AND pagamento=5";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			
			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			$html.="
			<ul>
			<li style='list-style: none;  padding:5px;' class='exp'>
			<h6 style='font-size:14px;'>".substr($linha["titulo"], 0,15)." - R$ ".number_format($linha["valor"],2)." 

			</h6>
			</li>
			<div>
			<li style='list-style: none;  padding:5px;'>
			<span>Titulo: ".$linha["titulo"]."</span><br>
			</li>

			</div>
			</ul>";



			$total +=$linha["valor"];
			

		}

		$html.="
		<div class='title'>
		<h6>Total =  R$ ".number_format($total,2)."</h6>
		</div>";

		$this->view->debitos = $html;

	}


	protected function verificaVencimento($data) {
		if (date("d-m-Y",mktime(0, 0, 0, $data[1], $data[0], $data[2]))!=date("d-m-Y")) {
			$dataPagamento = array(date("d"),date("m"),date("Y"));
			$dataTeste = implode("-", $dataPagamento);
			if (date("w",mktime(0, 0, 0, $data[1], $data[0], $data[2]))==6) {
				if (date("d-m-Y",mktime(0, 0, 0, $data[1], $data[0]+2, $data[2]))==$dataTeste) {
					return false;
				}elseif (date("d-m-Y",mktime(0, 0, 0, $data[1], $data[0]+1, $data[2]))==$dataTeste) {
					return false;
				}else{
					return true;
				}
			}elseif (date("w",mktime(0, 0, 0, $data[1], $data[0], $data[2]))==0) {

				if (date("d-m-Y",mktime(0, 0, 0, $data[1], $data[0]+1, $data[2]))==$dataTeste) {
					return false;
				}else{
					return true;
				}
			}else{
				return true;
			}
		}else{
			return false;
		}
	}








	/*
	 *
	 *
	 *
	 *
	 *
	 *
	 *GERAR GRAFICOS ABAIXO
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 */

	protected function graficos(){

		$this->gerarDespesas();
		$this->gerarFornecedores();
		$this->gerarVendas();
		//$this->gerarVendaDetalhada();

	}


			/*






	*/

			/*






	*/
			protected function gerarDespesas(){
				$despesas = $this->despesas();


				$url .= "function despesasChart() {\n";
		//// DEFINE ARRAY COM OS DADOS
				$url .= "var data = google.visualization.arrayToDataTable([\n";

					$tipos = array("Administrativo","Fixa","Imposto","Juros/Taxas","Combustivel","Viagem","Mecânico");

		//// VARIAVEIS
					$url .= "['x'";
					foreach ($tipos as $value) {
						$url.=",'".$value."'";
					}
					$url.= "],\n";

				/*

		/////////// DEFINE VALORES DE COMBUSTIVEL//////////////////////

		*/

				$count = count($despesas);

				foreach ($this->meses as $value) {
					$valores .= "['".$value."'";
					for ($i=0; $i < $count; $i++) { 

						if ($despesas[$i][$value]==0) {
							$valores .= ",  0";
						}else{
							$valores .= ",  ".$despesas[$i][$value];
						}
					}

					if ($value=="Dez") {
						$valores .= "]\n";
					}else{
						$valores .= "],\n";	
					}


				}





				$url .= $valores;

				$url .= "
				]);\n 
var options = {\n
	title: 'Gráfico de Despesas',\n
	vAxis: {minValue: 0}\n
};\n";

								/// TITULO DO GRAFICO
$url .= "var chart = new google.visualization.LineChart(document.getElementById('despesasChart'));\n
chart.draw(data, options);

}";



$this->view->graficosDespesas = $url;

}





/*






	*/
protected function gerarFornecedores(){
	$fornecedores = $this->fornecedores();

	$url .= "function fornecedoresChart() {\n";
		//// DEFINE ARRAY COM OS DADOS
	$url .= "var data = google.visualization.arrayToDataTable([\n";

		//// VARIAVEIS
		$pagamentos = array("A Vista", "Boleto", "Cheques", "Cheques de Cliente","Cartão");

		//// VARIAVEIS
		$url .= "['x'";
		foreach ($pagamentos as $value) {
			$url.=",'".$value."'";
		}
		$url.= "],\n";



	/*

		/////////// DEFINE VALORES DE COMBUSTIVEL//////////////////////

		*/

	$count = count($fornecedores);

	foreach ($this->meses as $value) {
		$valores .= "['".$value."'";
		for ($i=0; $i < $count; $i++) { 

			if ($fornecedores[$i][$value]==0) {
				$valores .= ",  0";
			}else{
				$valores .= ",  ".$fornecedores[$i][$value];
			}
		}

		if ($value=="Dez") {
			$valores .= "]\n";
		}else{
			$valores .= "],\n";	
		}


	}





	$url .= $valores;

	$url .= "]);\n";
		/// OPCOES
$url .= " var options = {\n
	title: 'Gráfico de Gastos com Fornecedores',\n
	vAxis: {minValue: 0}\n
};\n";

						/// TITULO DO GRAFICO
$url .= "var chart = new google.visualization.LineChart(document.getElementById('fornecedoresChart'));\n
chart.draw(data, options);

}";



$this->view->graficosFornecedores = $url;

}


/*






	*/
protected function gerarVendas(){
	$vendas = $this->vendas();

	$url .= "function vendasChart() {\n";
		//// DEFINE ARRAY COM OS DADOS
	$url .= "var data = google.visualization.arrayToDataTable([\n";

		//// VARIAVEIS

		$url .= "['x', 'Geral'";
		foreach ($this->funcionarios as $value) {
			$url .= ",'".$value."'";
		}
		$url .= "],\n";

	/*

		/////////// DEFINE VALORES DE COMBUSTIVEL//////////////////////

		*/

	$count = count($vendas);

	foreach ($this->meses as $value) {
		$valores .= "['".$value."'";
		for ($i=0; $i < $count; $i++) { 

			if ($vendas[$i][$value]==0) {
				$valores .= ",  0";
			}else{
				$valores .= ",  ".$vendas[$i][$value];
			}
		}

		if ($value=="Dez") {
			$valores .= "]\n";
		}else{
			$valores .= "],\n";	
		}


	}





	$url .= $valores;

	$url .= "]);\n";
		/// OPCOES
$url .= " var options = {\n
	title: 'Gráfico de Vendas',\n
};\n";

						/// TITULO DO GRAFICO
$url .= "var chart = new google.visualization.LineChart(document.getElementById('vendasChart'));\n
chart.draw(data, options);

}";

$this->view->graficosVendas = $url;

}




protected function vendas() {

	$vendas = array();
	array_push($vendas, $this->dadosVendas("total"));

	$query = "SELECT * FROM funcionarios WHERE funcao=1";
	$result = $this->model->query($query);
	while ($linha=mysql_fetch_array($result)) {
		array_push($this->funcionarios, $linha["nome"]);
		array_push($vendas, $this->dadosVendas("total",$linha["id"]));
	}




	return $vendas;
}

protected function fornecedores() {

	$pagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cartão");

	foreach ($pagamentos as $key => $value) {
		$gastos[] = $this->dadosCompra($key);
	}

	return $gastos;
}


protected function despesas() {

	$tipos = array("Administrativo","Fixa","Imposto","Juros/Taxas","Combustivel","Viagem","Mecânico");

	foreach ($tipos as $key => $value) {
		$despesas[] = $this->dadosDespesas($key);
	}

	return $despesas;
}

	/*
	 *
	 *
	 *
	 *
	 *
	 *
	 *DADOS PARA GRAFICOS
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 */


	protected function dadosDespesas($dado) {


		$total = array();

		$query = "SELECT * FROM despesas WHERE tipo=".$dado;



		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			if ($linha["pagamento"]=="0" || $linha["pagamento"]=="3") {
				$date = explode("-", $linha["data"]);
			}else{
				$date = explode("-", $linha["vencimento"]);	
			}


			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			$total[$this->meses[(int)$date[1]-1]] += $linha["valor"];


		}





		return $total;

	}

	protected function dadosCompra($dado) {


		$total = array();

		$query = "SELECT * FROM compras WHERE pagamento=".$dado;



		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			if ($dado=="0" || $dado=="3") {
				$date = explode("-", $linha["data"]);
			}else{
				$date = explode("-", $linha["vencimento"]);	
			}


			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			$total[$this->meses[(int)$date[1]-1]] += $linha["valor"];


		}





		return $total;

	}



	protected function dadosVendas($dado, $vendedor=false) {


		$total = array();
		if ($vendedor==false) {
			$query = "SELECT * FROM vendas";
		}else{
			$query = "SELECT * FROM vendas WHERE vendedor=".$vendedor;
		}


		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["data"]);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			$total[$this->meses[(int)$date[1]-1]] += $linha[$dado];


		}





		return $total;

	}






	protected function Ggeral() {


		$total = array();


		$query = "SELECT * FROM despesas";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["data"]);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			$total[$this->meses[(int)$date[1]-1]] += $linha["valor"];




		}

		return $total;

	}

	/*
	 *
	 *
	 *
	 *
	 *despesas COM FORNECEDORES ABAIXO
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 */

	protected function chequesCLientes() {


		$total = array();


		$query = "SELECT * FROM chqclientes WHERE quem!=''";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["para"]);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano
			for ($i=1; $i <= date("n"); $i++) {
				if($date[1]==$i && $date[2]==date("Y")){

					$total[$this->meses[$i-1]] += $linha["valor"];

				}
			}





		}


		return $total;

	}



	protected function Gchequesitau() {


		$total = array();


		$query = "SELECT * FROM cheques WHERE banco=2";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["para"]);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano
			for ($i=1; $i <= date("n"); $i++) {
				if($date[1]==$i && $date[2]==date("Y")){

					$total[$this->meses[$i-1]] += $linha["valor"];

				}
			}





		}


		return $total;

	}



	protected function Gchequesbb() {


		$total = array();


		$query = "SELECT * FROM cheques WHERE banco=1";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["para"]);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			for ($i=1; $i <= date("n"); $i++) {
				if($date[1]==$i && $date[2]==date("Y")){

					$total[$this->meses[$i-1]] += $linha["valor"];

				}
			}

		}


		return $total;

	}



	protected function Gvencimentos() {


		$total = array();

		$query = "SELECT * FROM vencimentos WHERE fornecedor=1";

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["vencimento"]);


			for ($i=1; $i <= date("n"); $i++) {
				if($date[1]==$i && $date[2]==date("Y")){

					$total[$this->meses[$i-1]] += $linha["valor"];

				}
			}

		}

		return $total;

	}



}