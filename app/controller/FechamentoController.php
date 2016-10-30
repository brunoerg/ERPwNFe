<?php
class FechamentoController extends Controller {
	function __construct() {
		parent::__construct ();
		$this->total=0;
	}

	function index() {

		$this->dados();
		$this->view->render ( 'fechamento/index' );
	}
	///bancos 
	protected function dados() {

		if (isset($_POST["mes"])) {
			$data = array($_POST["mes"],$_POST["ano"]);
			$mes = $_POST["mes"];
			$ano = $_POST["ano"];
		}else{
			$mes = date("m");
			$ano = date("Y");
			if (date("d")<10) {
				
				if ($mes=="01") {
					$ano--;
					$mes="12";
				}else{
					$mes--;

					$mes = "0".$mes;	

				}
				
			}

			$data = array($mes,$ano);
		}

		
		$this->view->mes = $mes;
		$this->view->ano = $ano;
		
		$this->RelatorioVendas($mes,$ano);
		$this->RelatorioDespesas($mes,$ano);
		$this->RelatorioCompras($mes,$ano);
		

		$this->gerarChart();
	}

















	protected function RelatorioVendas($mes,$ano){
		$query = "SELECT * FROM vendas ORDER BY id DESC";
		$sql = $this->model->query($query);
		while ($linha=mysql_fetch_assoc($sql)) {
			$data = explode("-", $linha["data"]);
			if ($mes==$data[1] && $ano==$data[2]) {
				$totalVenda = 0;
				foreach ($linha as $key => $value) {
					if ($key!="id"&&$key!="vendedor"&&$key!="total"&&$key!="data") {
						
						switch ($key) {
							case 'boleto':
							$this->Vendas["boleto"]+=$value;
							break;

							case 'cheque':
							$totalVenda+=$value;
							$this->Vendas["cheque"]+=$value;
							break;
							
							default:
							$totalVenda+=$value;
							$this->Vendas["dinheiro"]+=$value;
							break;
						}
						
					}
					
					
				}
				$this->Vendedor[$linha["vendedor"]]["total"]+=$totalVenda;
				$total+=$totalVenda;
				
			}
		}
		$total+=$this->BoletosPagos($mes,$ano);

		$this->view->TotalVendas=$total;
	}


	protected function BoletosPagos($mes,$ano){
		$query = "SELECT * FROM boletos WHERE pago=1 ORDER BY id DESC";
		$sql = $this->model->query($query);
		while ($linha=mysql_fetch_assoc($sql)) {
			$data = explode("-", $linha["vencimento"]);
			if ($mes==$data[1] && $ano==$data[2]) {
				$total+=$linha["valor"];
			}
		}
		return $total;
	}






















	protected function RelatorioDespesas($mes,$ano){


		$this->view->Administrativo["valor"] = 0;
		$this->view->Fixa["valor"] = 0;
		$this->view->Imposto["valor"] = 0;
		$this->view->Juros["valor"] = 0;
		$this->view->Combustivel["valor"] = 0;
		$this->view->Viagem["valor"] = 0;
		$this->view->Mecanico["valor"] = 0;
		$this->view->Folha["valor"] = 0;


		$this->Despesas($mes,$ano);
		$this->FolhaDePagamento($mes,$ano);

	}



	protected function Despesas($mes,$ano){

		$query = "SELECT * FROM despesas ORDER BY valor DESC";
		$sql = $this->model->query($query);
		$xhtml = "";

		//// para cada bloco dessa venda
		while ($linha=mysql_fetch_assoc($sql)) {

			$tipos = array("Administrativo","Fixa","Imposto","Juros/Taxas","Combustivel","Viagem","Mec&acirc;nico");



			// $data[1] = mes
			// $data[2] = ano
			if ($linha["vencimento"]=="") {
				$data = explode("-", $linha["data"]);	
			}else{
				$data = explode("-", $linha["vencimento"]);	
			}

			switch ($linha["tipo"]) {
					case '0': // Administrativo

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Administrativas["html"] .= $html["html"];
						$this->view->Administrativas["valor"] += $html["valor"];

					}
					break;

					case '1': // FIXA
					if ($data[1]==$mes && $data[2]==$ano) {
						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Fixas["html"] .= $html["html"];
						$this->view->Fixas["valor"] += $html["valor"];
					}
					break;

					case '2': // IMPOSTO
					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Imposto["html"] .= $html["html"];
						$this->view->Imposto["valor"] += $html["valor"];

					}
					break;

					case '3': // JUROS
					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Juros["html"] .= $html["html"];
						$this->view->Juros["valor"] += $html["valor"];

					}
					break;
					case '4': // COMBUSTIVEL
					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Combustivel["html"] .= $html["html"];
						$this->view->Combustivel["valor"] += $html["valor"];

					}
					break;

					case '5': // Viagem					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Viagem["html"] .= $html["html"];
						$this->view->Viagem["valor"] += $html["valor"];

					}
					break;

					case '6': // Mecanico					
					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalDespesas+=$linha["valor"];
						$this->tipo[$linha["tipo"]]+=$linha["valor"];

						$html = $this->GetDados($linha);
						$this->view->Mecanico["html"] .= $html["html"];
						$this->view->Mecanico["valor"] += $html["valor"];

					}
					break;


				}
			}
		}


		protected function GetDados($dados){

			$pagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cart&atilde;o");

			switch ($dados["pagamento"]) {

					case '1': // BOLETO
					$detalhe = $this->getBoleto($dados);
					break;

					case '2': // CHEQUE DA EMPRESA
					$detalhe = $this->getCheque($dados);
					break;

					case '3': // CHEQUE DE CLIENTES
					$detalhe = $this->getChequeCliente($dados);
					break;

					case '4': // CARTAO
					$detalhe = $this->getCartao($dados);
					break;
				}

				$xhtml .= "<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
				<h6 style='font-size:14px;'>".substr($dados["titulo"], 0,30)." - R$ ".number_format($dados["valor"],2,",",".")."</h6>
			</li>
			<div style='padding-left:20px;'>
				<span>Titulo: ".$dados["titulo"]."</span><br>
				<span>Tipo de Pagamento: ".$pagamentos[$dados["pagamento"]]."</span><br>
				<span>Valor: R$ ".number_format($dados["valor"],2,",",".")."</span><br>
				<span>Data: ".$dados["data"]."</span><br>
				".$detalhe."
				<hr>
			</div>";


			$html["valor"] = $dados["valor"];
			$html["html"] = $xhtml;
			$this->TipoPagamento[$dados["pagamento"]] += $dados["valor"];
			return $html;
		}


		protected function getBoleto($dados){


			$boleto = $this->pegaDados("vencimentos",$dados["boleto"]);

			$detalhe .= "<li style='padding-left:10px;' class='exp' >
			<span>Vencimento do Boleto: ".$dados["vencimento"]."</span><br>
		</li>";


		return $detalhe;
	}

	protected function getCheque($dados){


		$cheque = $this->pegaCheque($dados["cheque"]);
		$banco = $this->pegaDados("bancos",$cheque["banco"]);

		$detalhe .= "<li style='padding-left:10px;' class='exp' >
		<span>Banco: ".$banco["nome"]."</span><br>
		<span>Numero: ".$cheque["numero"]."</span><br>
		<span>Compensa&ccedil;&atilde;o: ".$cheque["para"]."</span><br>
	</li>";


	return $detalhe;
}


protected function getChequeCliente($dados){

	$cheques = explode(",", $dados["chqcliente"]);



	foreach ($cheques as $value) {
		if ($id!="") {

			$cheque = $this->pegaDados("chqclientes",$value);

			//echo "Numero: ".$cheque["banco"]."ID: ".$cheque["id"]."<br>";
			$banco = $this->pegaDados("bancos",$cheque["banco"]);
			$cliente = $this->pegaDados("clientes",$cheque["cliente"]);


			$detalheChqs .= "
			<span>Numero: ".$cheque["numero"]."</span><br>
			<span>Cliente: <b><a href='".URL."Clientes/Relatorio/".$cliente["id"]."' target='_blank'>".htmlspecialchars_decode($cliente["nome"])."</a></b></span><br>
			<span>Valor: R$ ".number_format($cheque["valor"],2,",",".")."</span><br>
			<span>Cheque para: ".$cheque["para"]."</span><br>
			<span>Banco: ".$banco["nome"]."</span><br>";

			$n++;
			$valorCheques +=$cheque["valor"];
		}
	}
	if ($valorCheques<$dados["valor"]) {

		$avista["valor"] = $dados["valor"]-$valorCheques;
		$this->TipoPagamento[0] += $avista["valor"];
		$this->TipoPagamento[$dados["pagamento"]] -= $avista["valor"];

	}else{
		$Credito["valor"] = $valorCheques-$dados["valor"];
	}

	$detalhe .= "<li style='padding-left:10px;'>
	<span>Numero de Cheques: ".$n."</span><br>
	<span>Pagou em Dinheiro: R$ ".number_format($avista["valor"],2,",",".")."</span><br>
	<span>Ficou de Credito: R$ ".number_format($Credito["valor"],2,",",".")."</span><br>
</li>
<b  class='exp' style='cursor:pointer;'>[ Detalhar ]</b>
<div>
	".$detalheChqs."</div>";



	return $detalhe;
}

protected function getCartao($dados){

	$cartao = $this->pegaDados("cartao",$dados["cartao"]);


	$bandeira = $this->pegaDados("bandeiras",$cartao["bandeira"]);

	$parcela = $this->pegaParcelaDespesas($dados);
	$detalhe .= "
	<b  class='exp' style='cursor:pointer;'>[ Detalhar ]</b>
	<div><li style='padding-left:10px;'>
		<span>Parcela: ".$parcela."/".$dados["parcelas"]."</span><br>
		<span>Vencimento: ".$dados["vencimento"]."</span><br>
		<span>Cart&atilde;o: ".$bandeira["nome"]."</span><br>
	</li>
</div>";


return $detalhe;
}
protected function pegaParcelaDespesas($dados){
	$query = "SELECT * FROM despesas WHERE pagamento=4 AND titulo='".$dados["titulo"]."' AND data='".$dados["data"]."' AND parcelas=".$dados["parcelas"];
	$sql = $this->model->query($query);
	while ($linha=mysql_fetch_assoc($sql)) {
		$vencimento = explode("-", $linha["vencimento"]);
		$vencimentoCartao = explode("-", $dados["vencimento"]);
		if ($vencimento[1]<=$vencimentoCartao[1]) {
			$parcela++;
		}
	}
	return $parcela;
}


















protected function RelatorioCompras($mes,$ano){


	$this->view->avista["valor"] = 0;
	$this->view->cheque["valor"] = 0;
	$this->view->chequeCliente["valor"] = 0;
	$this->view->boleto["valor"] = 0;
	$this->view->cartao["valor"] = 0;
	$this->Compras($mes,$ano);

}
protected function compras($mes,$ano){

	$query = "SELECT * FROM compras ORDER BY fornecedor";
	$sql = $this->model->query($query);
	$xhtml = "";

		//// para cada bloco dessa venda
	while ($linha=mysql_fetch_assoc($sql)) {

		$pagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cart&atilde;o");




		switch ($linha["pagamento"]) {
					case '0': // AVISTA
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["data"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoAvista($linha);
						$this->view->avista["html"] .= $html["html"];
						$this->view->avista["valor"] += $html["valor"];

					}
					break;

					case '1': // BOLETO
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["vencimento"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoBoleto($linha);
						$this->view->boleto["html"] .= $html["html"];
						$this->view->boleto["valor"] += $html["valor"];
					}
					break;

					case '2': // CHEQUE DA EMPRESA
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["vencimento"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoCheque($linha);
						$this->view->cheque["html"] .= $html["html"];
						$this->view->cheque["valor"] += $html["valor"];
					}

					break;

					case '3': // CHEQUE DE CLIENTES
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["data"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoChqClientes($linha);
						$this->view->chequeCliente["html"] .= $html["htmlChq"];
						$this->view->avista["html"] .= $html["html"];
						$this->view->chequeCliente["valor"] += $html["valor"];
					}
					break;

					case '4': // CARTAO
					// $data[1] = mes
					// $data[2] = ano
					$data = explode("-", $linha["vencimento"]);

					if ($data[1]==$mes && $data[2]==$ano) {

						$this->view->TotalCompras+=$linha["valor"];
						$this->Fornecedor[$linha["fornecedor"]]+=$linha["valor"];

						$html = $this->PagamentoCartao($linha);
						$this->view->cartao["html"] .= $html["html"];
						$this->view->cartao["valor"] += $html["valor"];
					}

					break;
				}
			}
		}


		protected function PagamentoAvista($dadosCompra){

			$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

			$xhtml .= "<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($dadosCompra["valor"],2,",",".")."</h6>
		</li>
		<div style='padding-left:20px;'>
			<span>Valor: R$ ".number_format($dadosCompra["valor"],2,",",".")."</span><br>
			<span>Data: ".$dadosCompra["data"]."</span><br>
			<hr></div>";


			$html["valor"] = $dadosCompra["valor"];
			$html["html"] = $xhtml;
			return $html;
		}

		protected function PagamentoBoleto($dadosCompra){

			$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

			$boleto = $this->pegaDados("vencimentos",$dadosCompra["boleto"]);

			$detalhe .= "<li style='padding-left:10px;' class='exp' >
			<span>Vencimento: ".$dadosCompra["vencimento"]."</span><br>
			<span>Data: ".$dadosCompra["data"]."</span><br>
			<hr>
		</li>";

		$xhtml = "
		<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($dadosCompra["valor"],2,",",".")."</h6>
		</li>
		<div >
			".$detalhe."

		</div>";

		$html["valor"] = $dadosCompra["valor"];
		$html["html"] = $xhtml;
		return $html;
	}


	protected function PagamentoCheque($dadosCompra){

		$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

		$cheque = $this->pegaCheque($dadosCompra["cheque"]);
		$banco = $this->pegaDados("bancos",$cheque["banco"]);

		$detalhe .= "
		<li style='padding-left:10px;' class='exp' >
			<span>Numero: ".$cheque["numero"]."</span><br>
			<span>Vencimento: ".$cheque["para"]."</span><br>
			<span>Data: ".$dadosCompra["data"]."</span><br>
			<span>Banco: ".$banco["nome"]."</span><br>
			<hr>
		</li>";

		$xhtml = "
		<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($dadosCompra["valor"],2,",",".")."</h6>
		</li>
		<div >
			".$detalhe."

		</div>";

		$html["valor"] = $dadosCompra["valor"];
		$html["html"] = $xhtml;
		return $html;
	}

	protected function pegaCheque($numero) {

		$valores_db = $this->model->query("SELECT * FROM `cheques` WHERE numero=".$numero);
		$linha = mysql_fetch_array($valores_db);

		return $linha;

	}

	protected function PagamentoChqClientes($dadosCompra){

		$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

		$chequesCliente = explode(",", $dadosCompra["chqcliente"]);
		foreach ($chequesCliente as $id) {
			$cheque = $this->pegaChequeCliente($id);

			$banco = $this->pegaDados("bancos",$cheque["banco"]);
			$cliente = $this->pegaDados("clientes",$cheque["cliente"]);
			$detalhe .= "
			<li style='padding-left:10px;' >
				<span>Numero: ".$cheque["numero"]."</span><br>
				<span>Cliente: <b><a href='".URL."Clientes/Relatorio/".$cliente["id"]."' target='_blank'>".htmlspecialchars_decode($cliente["nome"])."</a></b></span><br>
				<span>Valor: R$ ".number_format($cheque["valor"],2,",",".")."</span><br>
				<span>Cheque para: ".$cheque["para"]."</span><br>
				<span>Banco: ".$banco["nome"]."</span><br>
				<hr>
			</li>";
			$n++;
			$valorCheques +=$cheque["valor"];
		}

		if ($valorCheques<$dadosCompra["valor"]) {

			$avista["valor"] = $dadosCompra["valor"]-$valorCheques;

		}else{
			$Credito["valor"] = $valorCheques-$dadosCompra["valor"];
		}


		$xhtml = "
		<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
			<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($valorCheques,2,",",".")."</h6>
		</li>
		<div >
			<li style='list-style: none;  padding:5px;' >
				<span>ID da Compra: ".$dadosCompra["id"]."</span><br>
				<span>Numero de Cheques: ".$n."</span><br>
				<span>Pagou em Dinheiro: R$ ".number_format($avista["valor"],2,",",".")."</span><br>
				<span>Ficou de Credito: R$ ".number_format($Credito["valor"],2,",",".")."</span><br>
				<span>Data: ".$dadosCompra["data"]."</span><br>
				<ul>
					<li style='list-style: none;  padding:5px;' class='exp'>
						<span style='font-weight:bold; cursor:pointer;'> [ Cheques ]</span>
					</li>
					<div >
						<ol style='list-style:decimal inside;'>
							".$detalhe."
						</ol>
					</div>

				</div>";

				if ($avista>0) {
					$html["html"] = "<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
					<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($avista["valor"],2,",",".")."</h6>
				</li>
				<div style='padding-left:20px;'>
					<span>Valor: R$ ".number_format($avista["valor"],2,",",".")."</span><br>
					<span>Data: ".$dadosCompra["data"]."</span><br>
					<span>Referente a Compra de ID : ".$dadosCompra["id"]."</span><br>
					<hr></div>"; 
					$this->view->avista["valor"] += $avista["valor"];
				}


				$html["valor"] = $valorCheques;
				$html["htmlChq"] = $xhtml;
				return $html;
			}

			protected function pegaChequeCliente($id) {

				$valores_db = $this->model->query("SELECT * FROM `chqclientes` WHERE id=".$id);
				$linha = mysql_fetch_array($valores_db);

				return $linha;

			}

			protected function PagamentoCartao($dadosCompra){

				$fornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

				$cartao = $this->pegaDados("cartao",$dadosCompra["cartao"]);

				$parcela = $this->pegaParcelaCompra($dadosCompra);
				$detalhe .= "<li style='padding-left:10px;' class='exp' >
				<span>Parcela: ".$parcela."/".$dadosCompra["parcelas"]."</span><br>
				<span>Vencimento: ".$dadosCompra["vencimento"]."</span><br>
				<span>Data: ".$dadosCompra["data"]."</span><br>
				<hr>
			</li>";

			$xhtml = "
			<li style='padding:10px; font-size:15px;cursor:pointer;' class='exp' >
				<h6 style='font-size:14px;'>".$fornecedor["nome"]." - R$ ".number_format($dadosCompra["valor"],2,",",".")."</h6>
			</li>
			<div >
				".$detalhe."

			</div>";

			$html["valor"] = $dadosCompra["valor"];
			$html["html"] = $xhtml;
			return $html;
		}
		

		protected function pegaParcelaCompra($dadosCompra){
			$query = "SELECT * FROM compras WHERE pagamento=4 AND fornecedor=".$dadosCompra["fornecedor"]." AND data='".$dadosCompra["data"]."' AND parcelas=".$dadosCompra["parcelas"];
			$sql = $this->model->query($query);
			while ($linha=mysql_fetch_assoc($sql)) {
				$vencimento = explode("-", $linha["vencimento"]);
				$vencimentoCartao = explode("-", $dadosCompra["vencimento"]);
				if ($vencimento[1]<=$vencimentoCartao[1]) {
					$parcela++;
				}
			}
			return $parcela;
		}














		protected function FolhaDePagamento($mes,$ano){
			$data = array($mes,$ano);
			$folha .= $this->vendedores($data);
			$folha .= $this->administrativo($data);

			$this->view->folha=$folha;
		}










		protected function vendedores($data) {

			

			$query = "SELECT * FROM funcionarios WHERE funcao=1";
			$sql = $this->model->query($query);

			while ($linha=mysql_fetch_array($sql)) {

				$vale = $this->vales($linha["id"],$data);
				$venda = $this->vendas($linha["id"],$data);
				$salario["fixo"] = $linha["fixo"];
				$salario["comissao"] = $linha["comissao"];

				$salario["bruto"] = ($venda["total"]*($salario["comissao"]/100))+$salario["fixo"];
				$salario["liquido"] = $salario["bruto"] - $vale["total"];

				$this->view->TotalDespesas+=$salario["bruto"];
				$html.="

				<fieldset style='width: 40%; min-width: 250px; float: left; padding: 10px;'>

					<div class='widget'>
						<div class='title exp'>
							<img src='".Folder."images/icons/dark/money2.png' alt='' class='titleIcon' />
							<h6 style='cursor:pointer;'>".$linha["nome"]." - R$ ".number_format($salario["bruto"],2,',','.')."</h6>
						</div>
						<ul>
							<li>S&aacute;lario Fixo: ".number_format($salario["fixo"],2,',','.')." </li>
							<li style='list-style: none;  padding:5px;' class='exp'>
								Total Venda =  R$ ".number_format($venda["total"],2,',','.')." 
							</li>
							<ul>".$venda["html"]."</ul>
							<li>S&aacute;lario Bruto: ".number_format($salario["bruto"],2,',','.')." </li>

							<li style='list-style: none;  padding:5px;' class='exp'>
								Total Vales =  R$ ".number_format($vale["total"],2,',','.')." 
							</li>
							<ul>".$vale["html"]."</ul>

							<li>S&aacute;lario Liquido: ".number_format($salario["liquido"],2,',','.')." </li>
						</ul>
						<div class='title'>
							<img src='".Folder."images/icons/dark/money2.png' alt='' class='titleIcon' />
							<h6 style='cursor:pointer;'>Sal&aacute;rio Liquido: R$ ".number_format($salario["liquido"],2,',','.')."</h6>
						</div>
					</div>

				</fieldset>";


			}

			return $html;


		}

		protected function administrativo($data) {


			$query = "SELECT * FROM funcionarios WHERE funcao>1";
			$sql = $this->model->query($query);
			while ($linha=mysql_fetch_array($sql)) {

				$vale = $this->vales($linha["id"],$data);
				$salario["bruto"] = $linha["fixo"];

				$this->view->TotalDespesas+=$salario["bruto"];

				$salario["liquido"] = $salario["bruto"] - $vale["total"];

				$html.="
				<fieldset style='width: 40%; min-width: 250px; float: left; padding: 10px;'>

					<div class='widget'>
						<div class='title exp'>
							<img src='".Folder."images/icons/dark/money2.png' alt='' class='titleIcon' />
							<h6 style='cursor:pointer;'>".$linha["nome"]." - R$ ".number_format($salario["bruto"],2,',','.')."</h6>
						</div>";

						$html.="
						<div class='formRow'>
							<ul>
								<li>S&aacute;lario Bruto: ".number_format($salario["bruto"],2,',','.')." </li>

								<li style='list-style: none;  padding:5px;' class='exp'>
									Total Vales =  R$ ".number_format($vale["total"],2,',','.')." 
								</li>
								<ul>".$vale["html"]."</ul>

								<li>S&aacute;lario Liquido: ".number_format($salario["liquido"],2,',','.')." </li>
							</ul>
						</div>
						<div class='title'>
							<img src='".Folder."images/icons/dark/money2.png' alt='' class='titleIcon' />
							<h6 style='cursor:pointer;'>Sal&aacute;rio Liquido: R$ ".number_format($salario["liquido"],2,',','.')."</h6>
						</div>
					</div>
				</fieldset>";


			}


			return $html;


		}

	/*
	 *
	 *
	 *
	 *
	 * FUNCOES FOLHA GERAL
	 *
	 *
	 *
	 *
	 */

	protected function vales($funcionario,$data) {

		$total = 0;

		$query = "SELECT * FROM vales WHERE funcionario=".$funcionario;

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["data"]);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			if($date[1]==$data[0] && $date[2]==$data[1]){

				$html.="
				
				<li style='list-style: none;  padding:5px;' class='exp'>
					<h6 style='font-size:12px;'>".substr($linha["descricao"], 0,10)." - R$ ".number_format($linha["valor"],2,',','.')." 

					</h6>
				</li>
				<div >
					<li style='list-style: none;  padding:5px;' >
						<span>".$linha["descricao"]."</span><br>
						<span>Valor: ".$linha["valor"]."</span><br>
						<span>Data: ".$linha["data"]."</span><br>
					</li>

				</div>
				
				";
				$total +=$linha["valor"];
			}
		}
		if ($total==0) {
			$html.="
			<ul>
				<li style='list-style: none;  padding:5px;' class='exp'>
					<h6 style='font-size:12px;'>Nenhum Vale</h6>
				</li>
			</ul>
			";
		}
		$vales["total"]= $total;
		$vales["html"] = $html;

		return $vales;
	}



	/*
	 *
	 *
	 *
	 * FUNCOES FOLHA DE VENDEDORES
	 *
	 *
	 *
	 */


	protected function vendas($vendedor,$data) {

		$total = 0;

		$query = "SELECT * FROM vendas WHERE vendedor=".$vendedor;

		$result = $this->model->query($query);

		while($linha = mysql_fetch_array($result)){
			$date = explode("-", $linha["data"]);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			if($date[1]==$data[0] && $date[2]==$data[1]){
				$html.="
				
				<li style='list-style: none;  padding:5px;' >
					<h6 style='font-size:12px;'>".$linha["data"]." - R$ ".number_format($linha["total"],2,',','.')." 

					</h6>
				</li>
				";
				$total += $linha["total"];
			}
		}
		if ($total==0) {
			$html.="
			
			<li style='list-style: none;  padding:5px;' >
				<h6 style='font-size:12px;'>Nenhuma Venda</h6>
			</li>

			";
		}


		$vendas["total"] = $total;
		$vendas["html"] = $html;
		return $vendas;
	}




































	protected function gerarChart(){

		$Tipspagamentos = array("A Vista", "Boleto", "Cheque", "Cheque de Cliente","Cartão");

		$url .= "function Graficos() {\n";
			//// REPARTICAO DAS COMPRAS POR MEIO DE PAGAMENTO
		$url .= "
		var dataDespesasTipo = google.visualization.arrayToDataTable([\n
			['Labels','Values'],\n
			['Administrativo', ".$this->view->Administrativas["valor"]."],\n
			['Fixo',".$this->view->Fixas["valor"]."],\n
			['Imposto',".$this->view->Imposto["valor"]."],\n
			['Juros/Taxas',".$this->view->Juros["valor"]."],\n
			['Combustível',".$this->view->Combustivel["valor"]."],\n
			['Viagem',".$this->view->Viagem["valor"]."],\n
			['Mecânico',".$this->view->Mecanico["valor"]."]\n
			]);\n
var optionsDespesasTipo = {\n
	title: 'Despesas por Tipo',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chartDespesasTipo = new google.visualization.PieChart(document.getElementById('despesasTipo'));
chartDespesasTipo.draw(dataDespesasTipo, optionsDespesasTipo);\n";

$url .= "
var dataDespesasPagamento = google.visualization.arrayToDataTable([\n
	['Labels','Values'],\n";

	$i=0;
	

	foreach ($this->TipoPagamento as $key=>$value) {
		$pagamentos[$key] .= "['".$Tipspagamentos[$key]."', ".$value."]";
		$i++;
	}

	if ($i==0) {
		$html = "['Nenhuma Despesa', 1]";
	}else{
		$html = implode(",\n", $pagamentos);	
	}

			//print_r($this->TipoPagamento);
	

	$url .= $html."
	]);\n
var optionsDespesasPagamento = {\n
	title: 'Despesas por Forma de Pagamento',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chartDespesasPagamento = new google.visualization.PieChart(document.getElementById('despesasPagamento'));
chartDespesasPagamento.draw(dataDespesasPagamento, optionsDespesasPagamento);\n";


$this->Fornecedor[$linha["fornecedor"]];


			//// REPARTICAO DAS COMPRAS POR MEIO DE PAGAMENTO
$url .= "
var dataComprasPagamento = google.visualization.arrayToDataTable([\n
	['Labels','Values'],\n
	['A Vista', ".$this->view->avista["valor"]."],\n
	['Cheque',".$this->view->cheque["valor"]."],\n
	['Cheque de Cliente',".$this->view->chequeCliente["valor"]."],\n
	['Boleto',".$this->view->boleto["valor"]."],\n
	['Cartão',".$this->view->cartao["valor"]."]\n
	]);\n
var optionsComprasPagamento = {\n
	title: 'Compras por Forma de Pagamento',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chartComprasPagamento = new google.visualization.PieChart(document.getElementById('comprasPagamento'));
chartComprasPagamento.draw(dataComprasPagamento, optionsComprasPagamento);";

$url .= "
var dataComprasFornecedores = google.visualization.arrayToDataTable([\n
	['Labels','Values'],\n";
	$i=0;
	foreach ($this->Fornecedor as $key => $value) {
		$fornecedor = $this->pegaDados("fornecedores",$key);
		$fornecedores[$key] = "['".htmlspecialchars_decode($fornecedor["nome"])."', ".$value."]";
		$i++;
	}
	if ($i==0) {
		$html = "['Nenhuma compra', 1]";
	}else{
		$html = implode(",\n", $fornecedores);	
	}


	$url .= $html."
	]);\n
var optionsComprasFornecedores = {\n
	title: 'Compras por Fornecedor',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chartComprasFornecedores = new google.visualization.PieChart(document.getElementById('comprasFornecedores'));
chartComprasFornecedores.draw(dataComprasFornecedores, optionsComprasFornecedores);\n
";

$url .= "
var dataVendas = google.visualization.arrayToDataTable([\n
	['Labels','Values'],\n
	['Dinheiro', ".$this->Vendas["dinheiro"]."],\n
	['Cheque',".$this->Vendas["cheque"]."],\n
	['Boleto',".$this->Vendas["boleto"]."]\n
	]);\n
var optionsVendas = {\n
	title: 'Vendas',\n
	is3D:true,\n
	titleTextStyle:{color: '#000000', fontSize: 22,fontName:'Helvetica'}\n
};\n
var chartVendas = new google.visualization.PieChart(document.getElementById('Vendas'));
chartVendas.draw(dataVendas, optionsVendas);\n

}";




$this->view->graficos = $url;

}	


}