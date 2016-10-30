<?php
class VendasController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		//balanco_

		switch ($_GET["var2"]) {
			case "Adicionar":

			if ($_POST["vendedor"]!=0 && isset($_POST["data"])) {

				$total = $_POST["dinheiro"] + $_POST["deposito"] + $_POST["boleto"] + $_POST["cheque"] + $_POST["combustivel"] + $_POST["hotel"] + $_POST["mecanico"] + $_POST["outros"];

				$_POST["total"] = $total;
				$this->cadastrar("vendas");
			}else{

				if (isset($_POST["data"]) && isset($_POST["balanco"])) {
					$this->error("Selecione um Vendedor");
				}elseif(isset($_POST["total"]) && isset($_POST["balanco"])){
					$this->error("Selecione uma Data");
				}elseif(!isset($_POST["balanco"])){
					$this->error("Selecione a ID de um Balanco");
				}
			}

			$this->vendedor();

			$this->view->render ( 'vendas/novo' );
			break;

			case "Editar":

			if ($_POST["vendedor"]!=0 && isset($_POST["data"])) {
				$total = $_POST["dinheiro"] + $_POST["deposito"] + $_POST["boleto"] + $_POST["cheque"] + $_POST["combustivel"] + $_POST["hotel"] + $_POST["mecanico"] + $_POST["outros"];

				$_POST["total"] = $total;
				$this->editar($_GET["var3"],"vendas");
			}else{
				if (isset($_POST["data"]) && isset($_POST["balanco"])) {
					$this->error("Selecione um Vendedor");
				}elseif(isset($_POST["total"]) && isset($_POST["balanco"])){
					$this->error("Selecione uma Data");
				}elseif(!isset($_POST["balanco"])){
					$this->error("Selecione a ID de um Balanco");
				}
			}

			$this->pegaId("vendas",$_GET["var3"]);
			$this->vendedor();
			$this->view->render ( 'vendas/novo' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "vendas");

			$this->listar();

			$this->view->render ( 'vendas/index' );
			break;


			case "Relatorio":

			$this->relatorio();

			$this->view->render ( 'vendas/relatorio' );
			break;

			case "Pesquisar":



			$this->buscar();

			break;

			default:
			if (isset($_POST["mes"])&& isset($_POST["ano"])) {
				header("Location: ".URL."Pdf/Vendas/".$_POST["mes"]."-".$_POST["ano"]);
			}

			$this->listar();
			$this->view->render ( 'vendas/index' );
			break;
		}
	}


	protected function relatorio(){
		$this->pegaDadosVenda();
		$this->pegaBlocos();
		$this->pegaRecebidos();

		$this->view->venda["total"] = $this->view->venda["recebeu"]["total"] + $this->view->venda["avista"]["total"] + $this->view->venda["cheque"]["total"] + $this->view->venda["boleto"]["total"];
		$this->view->venda["totalGeral"] = $this->view->venda["aprazo"]["total"] + $this->view->venda["avista"]["total"] + $this->view->venda["cheque"]["total"] + $this->view->venda["boleto"]["total"];
		$this->gerarChart();
	}

	protected function pegaDadosVenda(){
		$venda = $this->pegaDados("vendas",$_GET["var3"]);

		$this->view->VendaDinheiro = $venda["dinheiro"] + $venda["deposito"] + $venda["combustivel"] + $venda["hotel"] + $venda["mecanico"] + $venda["outros"];
		$this->view->VendaBoleto = $venda["boleto"];
		$this->view->VendaCheque = $venda["cheque"];
	}

	protected function pegaBlocos(){


		$this->view->venda["acima"] = 0;
		$this->view->venda["desconto"] = 0;
		$this->view->venda["avista"] = array();
		$this->view->venda["aprazo"] = array();
		$this->view->venda["cheque"] = array();
		$this->view->venda["boleto"] = array();
		$this->view->venda["recebeu"] = array();


		$this->view->venda["avista"]["total"] = 0;
		$this->view->venda["aprazo"]["total"] = 0;
		$this->view->venda["cheque"]["total"] = 0;
		$this->view->venda["boleto"]["total"] = 0;
		$this->view->venda["recebeu"]["total"] = 0;

		$query = "SELECT * FROM blocos WHERE venda=".$_GET["var3"];
		$sql = $this->model->query($query);

		//// para cada bloco dessa venda
		while ($linha=mysql_fetch_assoc($sql)) {
			$this->pegaPedidos($linha["id"]);
		}

		$this->produtosVendidos();

	}

	protected function pegaPedidos($bloco){

		$query = "SELECT * FROM pedidos WHERE bloco=".$bloco;
		$sql = $this->model->query($query);
		
		//// para cada bloco dessa venda
		while ($linha=mysql_fetch_assoc($sql)) {

			$this->detalhaPedido($bloco,$linha);

		}

	}

	protected function detalhaPedido($bloco,$dadosPedido){

		$query = "SELECT * FROM produtosBlocos WHERE bloco=".$bloco." AND pedido=".$dadosPedido["numero"]." ORDER BY id ASC";

		$sql = $this->model->query($query);

		$qntProdutos=0;
		$lucroPedido = 0;
		$xhtml = "";

		//// para cada bloco dessa venda
		while ($linha=mysql_fetch_assoc($sql)) {

			$produto = $this->pegaDados("produtos",$linha["produto"]);

			
			$valor+=($linha["valor"]*$linha["quantidade"]);

			$qntProdutos+=$linha["quantidade"];

			$xhtml .= "
			<li style='padding-left:10px;' class='exp' >
				<span>".$produto["nome"]."</span>
			</li>
			<div style='padding-left:20px;'>
				<span>Valor: R$ ".number_format($linha["valor"],2,",",".")."</span><br>
				<span>Quantidade: ".$linha["quantidade"]."</span><br>";
				if ($linha["produto"]==578 || $linha["produto"]==581 || $linha["produto"]==582) {
					if ($linha["produto"]==578 || $linha["produto"]==582) {
						$desconto += ($linha["valor"])*-1;
					}


				}elseif($dadosPedido["pagamento"]!=1){
					$this->produtosVendidos[$linha["produto"]] += $linha["quantidade"]; 

					$ThisLucro = ($linha["valor"]-$produto["compra"])*$linha["quantidade"];
					$lucroPedido+=$ThisLucro;
					$this->view->lucro += $ThisLucro;
					$xhtml .= "<span>Lucro: R$ ".number_format(($ThisLucro),2,",",".")." </span><br>";		


					if ($linha["valor"]>$produto["venda"]) {
						$acima += ($linha["valor"] - $produto["venda"])*$linha["quantidade"];
						$this->view->venda["acima"]+= $acima;
						$xhtml .= "			<span>Acima: R$ ".number_format(($linha["valor"]-$produto["venda"]),2,",",".")." / Total: R$ ".number_format(($linha["valor"]-$produto["venda"])*$linha["quantidade"],2,",",".")."</span><br>";
					}elseif ($linha["valor"]<$produto["venda"]) {
						$desconto += ($produto["venda"]-$linha["valor"])*$linha["quantidade"];
						$this->view->venda["desconto"]+= $desconto;
						$xhtml .= "			<span>Desconto: R$ ".number_format(($produto["venda"]-$linha["valor"]),2,",",".")." / Total: R$ ".number_format(($produto["venda"]-$linha["valor"])*$linha["quantidade"],2,",",".")."</span><br>";	

					}
				}else{

					$this->produtosVendidos[$linha["produto"]] += $linha["quantidade"]; 

					$ThisLucro = ($linha["valor"]-$produto["compra"])*$linha["quantidade"];
					$lucroPedido+=$ThisLucro;

					$xhtml .= "<span>Lucro: R$ ".number_format(($ThisLucro),2,",",".")." </span><br>";		


					if ($linha["valor"]>$produto["venda"]) {
						$acima += ($linha["valor"] - $produto["venda"])*$linha["quantidade"];

						$xhtml .= "			<span>Acima: R$ ".number_format(($linha["valor"]-$produto["venda"]),2,",",".")." / Total: R$ ".number_format(($linha["valor"]-$produto["venda"])*$linha["quantidade"],2,",",".")."</span><br>";
					}elseif ($linha["valor"]<$produto["venda"]) {
						$desconto += ($produto["venda"]-$linha["valor"])*$linha["quantidade"];

						$xhtml .= "			<span>Desconto: R$ ".number_format(($produto["venda"]-$linha["valor"]),2,",",".")." / Total: R$ ".number_format(($produto["venda"]-$linha["valor"])*$linha["quantidade"],2,",",".")."</span><br>";	

					}

				}


				$xhtml .= "<hr></div>";

			}
			$recebidos = $this->pegaRecebeu($dadosPedido["bloco"], $dadosPedido["numero"]);
			$valor-=$recebidos;
			$dadosBloco = $this->pegaDados("blocos",$bloco);
			$dadosCliente = $this->pegaDados("clientes",$dadosPedido["cliente"]);
			$html = "
			<li style='list-style: none;  padding:5px;' class='exp'>
				<h6 style='font-size:14px;'>N&ordm; do Pedido: ".$dadosPedido['numero']."  Valor: R$ ".number_format($valor,2,",",".")." </h6>
			</li>
			<div >
				<li style='list-style: none;  padding:5px;' >
					<span>Cliente: ".$dadosCliente["nome"]."</span><br>
					<span>Data: ".$dadosPedido["data"]."</span><br>

					<ul>
						<li style='list-style: none;  padding:5px;' class='exp'>
							<span>Produtos: ".$qntProdutos."</span><br>
							<span>Lucro: R$ ".number_format($lucroPedido,2,",",".")." </span><br>	
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



			switch ($dadosPedido["pagamento"]) {

				case '0':
				$this->view->venda["avista"]["html"] .= $html;
				$this->view->venda["avista"]["total"] += $valor;
				break;

				case '1':
				if ($dadosPedido["pago"]!=1) {

					$this->view->venda["aprazo"]["html"] .= $html;
					$this->view->venda["aprazo"]["total"] += $valor;
				}
				break;

				case '2':
				$this->view->venda["cheque"]["html"] .= $html;
				$this->view->venda["cheque"]["total"] += $valor;
				break;

				case '3':
				$this->view->venda["boleto"]["html"] .= $html;
				$this->view->venda["boleto"]["total"] += $valor;
				break;

			}



		}

		protected function pegaVendaBlocos(){

			$querys = "SELECT * FROM blocos WHERE venda='".$_GET["var3"]."'";
			$sqls = $this->model->query($querys);
			while ($linha=mysql_fetch_assoc($sqls)) {
				$blocos[]=$linha["id"];
			}

			return $blocos;
		}

		private function pegaRecebidos(){
			$dadosVenda = $this->pegaDados("vendas",$_GET["var3"]);

			$blocos = $this->pegaVendaBlocos();


			$querys = "SELECT * FROM recebeuPedido WHERE data='".$dadosVenda["data"]."'";
			$sqls = $this->model->query($querys);

		//// para cada bloco dessa venda

			while ($linhas=mysql_fetch_assoc($sqls)) {




				$valor=0;
				$lucroPedido=0;
				$acima=0;
				$linhas["valor"] = str_replace(",", ".", $linhas["valor"]);
				$dadosPedidoAtual = $this->pegaDadosPedido($linhas["bloco"],$linhas["pedido"]);
				$dadosBlocoAtual = $this->pegaDados("blocos", $linhas["bloco"]);
				$dadosVendaPedido = $this->pegaDados("vendas",$dadosBlocoAtual["venda"]);



				if ($dadosVenda["vendedor"]==$dadosVendaPedido["vendedor"] ) {

					$recebeu += $linhas["valor"];

					$valorRecebido = $linhas["valor"];



					$recebido = $this->pegaRecebeu($linhas["bloco"],$linhas["pedido"]);

					$query = "SELECT * FROM produtosBlocos WHERE bloco=".$linhas["bloco"]." AND pedido=".$linhas["pedido"]." ORDER BY produto";


					$sql = $this->model->query($query);

					$qntProdutos=0;
					$xhtml = "";

		//// para cada bloco dessa venda
					while ($linha=mysql_fetch_assoc($sql)) {


						$produto = $this->pegaDados("produtos",$linha["produto"]);
						$linha["valor"] = str_replace(",", ".", $linha["valor"]);

						$valor+=($linha["valor"]*$linha["quantidade"]);

						$qntProdutos+=$linha["quantidade"];

						$xhtml .= "
						<li style='padding-left:10px;' class='exp' >
							<span>".$produto["nome"]."</span>
						</li>
						<div style='padding-left:20px;'>
							<span>Valor: R$ ".number_format($linha["valor"],2,",",".")."</span><br>
							<span>Quantidade: ".$linha["quantidade"]."</span><br>";

							$ThisLucro = ($linha["valor"]-$produto["compra"])*$linha["quantidade"];
							$lucroPedido+=$ThisLucro;

							$xhtml .= "	<span>Lucro: R$ ".number_format(($ThisLucro),2,",",".")." </span><br>";	
							if ($linha["valor"]>$produto["venda"]) {
								$acima += ($linha["valor"] - $produto["venda"])*$linha["quantidade"];

								$xhtml .= "			<span>Acima: R$ ".number_format(($linha["valor"]-$produto["venda"]),2,",",".")." / Total: R$ ".number_format(($linha["valor"]-$produto["venda"])*$linha["quantidade"],2,",",".")."</span><br>";
							}elseif ($linha["valor"]<$produto["venda"]) {
								$desconto += ($produto["venda"]-$linha["valor"])*$linha["quantidade"];

								$xhtml .= "			<span>Desconto: R$ ".number_format(($produto["venda"]-$linha["valor"]),2,",",".")." / Total: R$ ".number_format(($produto["venda"]-$linha["valor"])*$linha["quantidade"],2,",",".")."</span><br>";	

							}else{

							}


							$xhtml .= "<hr></div>";

						}

						$porcentagemRecebida = $valorRecebido/$valor;

						$porcentagemLucro = $lucroPedido * $porcentagemRecebida;

						$this->view->lucro += $porcentagemLucro;

						$dadosCliente = $this->pegaDados("clientes",$dadosPedidoAtual["cliente"]);
						$i++;
						$html .= "
						<li style='list-style: none;  padding:5px;' class='exp'>
							<h6 style='font-size:14px;'>N&ordm; do Pedido $i: ".$linhas['bloco']." - ".$linhas['pedido']."  Recebeu: R$ ".number_format($linhas["valor"],2,",",".")." </h6>
						</li>
						<div >
							<li style='list-style: none;  padding:5px;' >
								<span>Cliente: ".$dadosCliente["nome"]."</span><br>
								<span>Data: ".$dadosPedidoAtual["data"]."</span><br>
								<span>Lucro Total: R$ ".number_format($lucroPedido,2,",",".")." </span><br>	
								<span>Valor Total: ".number_format($valor,2,",",".")."</span><br>
								<span>Valor J&aacute; Recebido: ".number_format($recebido,2,",",".")."</span><br>
								<span>Valor Restante: ".number_format(($valor-$recebido),2,",",".")."</span><br>

								<ul>";

									$html .= "<li style='list-style: none;  padding:5px;' class='exp'>
									<span>Produtos: ".$qntProdutos."</span><br>
									<span>Lucro: R$ ".number_format($porcentagemLucro,2,",",".")." </span><br>	
									<span>Desconto: R$ ".number_format($desconto,2,",",".")."</span><br>
									<span>Acima: R$ ".number_format($acima,2,",",".")."</span><br>
									<span style='font-weight:bold;'> [ Detalhar ]</span>
								</li>
								<div >
									<ol style='list-style:decimal inside;'>
										".$xhtml."
									</ol>
								</div>
							</ul>
						</li>";

						$html .= "</div>";
					}


				}
				$this->view->venda["recebeu"]["html"] .= $html;
				$this->view->venda["recebeu"]["total"] += $recebeu;

			}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA vendas NA PAGINA PRINCIPAL pedidos_
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM vendas";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$vendedor = $this->pegaDados("funcionarios", $linha["vendedor"]);

			$lista.= "
			<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".htmlspecialchars($vendedor["nome"])."</td>
				<td class='center'>R$ ".number_format($linha["total"],2)."</td>
				<td class='center'>".$linha["data"]."</td>
				<td class='center'>".$linha["balanco"]."</td>
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

	

	private function produtosVendidos(){
		$dadosVenda = $this->pegaDados("vendas",$_GET["var3"]);

		$sqlQuery = "SELECT id FROM balancos WHERE data='".$dadosVenda["data"]."' AND vendedor=".$dadosVenda["vendedor"];
		$result = $this->model->query($sqlQuery);
		$idBalanco = mysql_fetch_assoc($result); 

		$diferencaUp = 0;
		$diferencaDw = 0;

		foreach ($this->produtosVendidos as $key => $value) {

			$produtoBalanco = $this->pegaProdutoBalanco($key,$idBalanco["id"]);
			$vendido = $produtoBalanco["carga"]-$produtoBalanco['retorno'];
			$produto = $this->pegaDados("produtos", $key);

			$lista.= "
			<tr class='grade".$letra."'>
				<td class='center'>".$key."</td>
				<td class='left'>".htmlspecialchars($produto["nome"])."</td>
				<td class='center'>".$value."</td>
				<td class='center'>".$vendido."</td>
				<td class='center'>".($value-$vendido)."</td>
				<td class='center'>R$ ".number_format(($value-$vendido)*$produto["venda"],2,",",".")."</td>
			</tr>";
			if (($value-$vendido)>0) {
				$diferencaUp +=  ($value-$vendido)*$produto["venda"];
			}elseif (($value-$vendido)<0) {
				$diferencaDw +=  ($value-$vendido)*$produto["venda"];
			}
		}
		if ($idBalanco["id"]!=0) {

			$query = "SELECT * FROM produtosBalanco WHERE balanco=".$idBalanco["id"];
			$sql = $this->model->query($query);
			while($linha = mysql_fetch_assoc($sql)){
				if ($linha["carga"]>$linha["retorno"]) {

					if (!array_key_exists($linha["produto"], $this->produtosVendidos)) {
						$produto = $this->pegaDados("produtos", $linha["produto"]);
						$vendido = $linha["carga"]-$linha['retorno'];
						$value = 0;
						$lista.= "
						<tr class='grade".$letra."'>
							<td class='center'>".$linha["produto"]."</td>
							<td class='left'>".htmlspecialchars($produto["nome"])."</td>
							<td class='center'>".$value."</td>
							<td class='center'>".$vendido."</td>
							<td class='center'>".($value-$vendido)."</td>
							<td class='center'>R$ ".number_format(($value-$vendido)*$produto["venda"],2,",",".")."</td>
						</tr>";	
						if (($value-$vendido)>0) {
							$diferencaUp +=  ($value-$vendido)*$produto["venda"];
						}elseif (($value-$vendido)<0) {
							$diferencaDw +=  ($value-$vendido)*$produto["venda"];
						}
						
						
					}
				}
			}
		}
		
		$this->view->diferencaDw = $diferencaDw;
		$this->view->diferencaUp = $diferencaUp;

		$this->view->produtosVendidos = $lista;
	}



	/*






	*/
	protected function gerarChart(){
		

		$url .= "function vendaChart() {\n";
			//// DEFINE ARRAY COM OS DADOS
		$url .= "
		var data = google.visualization.arrayToDataTable([\n
			['Labels','Values'],\n
			['A Vista', ".$this->view->venda["avista"]["total"]."],\n
			['Cheque',".$this->view->venda["cheque"]["total"]."],\n
			['Boleto',".$this->view->venda["boleto"]["total"]."],\n
			['Recebeu Fiado',".$this->view->venda["recebeu"]["total"]."]\n
			]);\n
var options = {\n
	title: 'Repartição do Dinheiro',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data, options);";
				/// TITULO DO GRAFICO
$url .= "
var data2 = google.visualization.arrayToDataTable([\n
	['Labels','Values'],\n
	['A Vista', ".$this->view->venda["avista"]["total"]."],\n
	['Cheque',".$this->view->venda["cheque"]["total"]."],\n
	['Boleto',".$this->view->venda["boleto"]["total"]."],\n
	['Fiado',".$this->view->venda["aprazo"]["total"]."]\n
	]);\n
var options2 = {\n
	title: 'Repartição da Venda',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
chart2.draw(data2, options2);

}";



$this->view->graficosVenda = $url;

}	








protected function pegaDadosPedido($bloco, $numero) {
	$query = "SELECT * FROM pedidos WHERE numero=" . $numero." AND bloco=".$bloco;

	$result = $this -> model -> query($query);

	$linha = mysql_fetch_array($result);

	return $linha;
}

private function pegaRecebeu($bloco,$pedido){

	$query = "SELECT valor,data FROM recebeuPedido WHERE bloco=".$bloco." AND pedido=".$pedido;

	$sql = $this->model->query($query);

	while ($linha=mysql_fetch_assoc($sql)) {
		$linha["valor"] = str_replace(",", ".", $linha["valor"]);
		$valor+= $linha["valor"];

	}
	return $valor;
}


protected function pegaProdutoBalanco($id,$balanco) {
	if ($id!=true) {
		return false;
	}
	if ($balanco!=true) {
		return false;
	}
	$query = "SELECT * FROM produtosBalanco WHERE balanco=".$balanco." AND produto=".$id;

	$result = $this->model->query($query);

	$linha = mysql_fetch_array($result);

	return $linha;
}


protected function buscar() {

	$query = "SELECT * FROM blocos WHERE venda=".$_GET["var3"];
	$sql = $this->model->query($query);
	$this->buscados=0;
	echo "<script>
	$(function(){
		$('#nomeBuscado').html('".htmlspecialchars($produto["nome"])."');
		$('table').tablesorter();
		oTable = $('.dTableRel').dataTable({
			\"bJQueryUI\" : true,
			\"sPaginationType\" : \"full_numbers\",
			\"sDom\" : '<\"\"l>t<\"F\"fp>'
		});
});
</script>";

echo "<table cellpadding='0' cellspacing='0' border='0' class='display dTableRel'>
<thead>
	<tr>
		<th>Cliente</th>
		<th>Bloco</th>
		<th>Pedido</th>
		<th>Quantidade</th>
		<th>Valor</th>
		<th>Total</th>
	</tr>

</thead>
<tbody>";
		//// para cada bloco dessa venda
	while ($linha=mysql_fetch_assoc($sql)) {
		$this->buscarPedidos($linha["id"]);
	}
	$produto = $this->pegaDados("produtos",$_POST["produto"]);



	$this->view->BuscaNome = htmlspecialchars($produto["nome"]);

	if ($this->buscados==0) {
		echo "<tr class='grade".$letra."'>
		<td class='center'></td>
		<td class='center'></td>
		<td class='center'>Nenhum Produto Encontrado!</td>
		<td class='center'></td>
		<td class='center'></td>
		<td class='center'></td>
	</tr>";
}
echo "</tbody>
</table>
<div class='clear'></div>";

}

protected function buscarPedidos($bloco){


	$query = "SELECT * FROM pedidos WHERE bloco=".$bloco;
	$sql = $this->model->query($query);

		//// para cada pedido
	while ($linha=mysql_fetch_assoc($sql)) {

		$this->buscaProduto($linha);

	}

}

protected function buscaProduto($dadosPedido){

	$query = "SELECT * FROM produtosBlocos WHERE bloco=".$dadosPedido["bloco"]." AND pedido=".$dadosPedido["numero"]." AND produto=".$_POST["produto"];

	
	$sql = $this->model->query($query);

	$linha = mysql_fetch_assoc($sql);

	if ($linha["produto"]!=false) {
		$cliente = $this->pegaDados("clientes",$dadosPedido["cliente"]);
		$produto = $this->pegaDados("produtos",$linha["produto"]);
		echo "<tr class='grade".$letra."'>
		<td class='left'><a href='".URL."Clientes/Relatorio/".$cliente["id"]."' target='_blank'>".htmlspecialchars($cliente["nome"])."</a></td>
		<td class='center'><a href='".URL."Blocos/Pedidos/".$dadosPedido["bloco"]."' target='_blank'>".$dadosPedido["bloco"]."</a></td>
		<td class='center'><a href='".URL."Blocos/Pedido/".$dadosPedido["bloco"]."-".$dadosPedido["numero"]."' target='_blank'>".$dadosPedido["numero"]."</a></td>
		<td class='center'>".$linha["quantidade"]."</td>
		<td class='center'>R$ ".number_format($linha["valor"],2,",",".")."</td>
		<td class='center'>R$ ".number_format(($linha["quantidade"]*$linha["valor"]),2,",",".")."</td>
	</tr>";
	$this->buscados++;
}

}
}