<?php
class PdfController extends Controller {
	function __construct() {
		parent::__construct ();


		$this->pdf = new FPDF();
		$this->pdf->Open();
		$this->pdf->AddPage();
		$this->pdf->SetXY(10,10);
		$this->pdf->SetMargins(10,5,0);
		$this->pdf->SetAutoPageBreak(true,10);
	}


	function index() {
		switch ($_GET["var2"]) {
			

			case 'Faturamento':

			if (!isset($_GET["var3"]) || $_GET["var3"]=="") {
				$_GET["var3"] = 6;
			}
			$this->setTitulo("Relação de Faturamento");
			$this->header(20,"C",false);
			$this->Faturamento();
			$this->fecharPdf();
			


			break;


			case 'Boleto':

			$this->Boleto();


			break;


			case 'Fechamento':
			if ($_GET["var3"]=="" || !isset($_GET["var3"])) {
				$mes = date("m");
				$ano = date("Y");
				if (date("d")<10) {

					if ($mes=="01") {
						$ano--;
						$mes="12";
					}else{
						$mes--;
						if ($mes<10) {
							$mes = "0".$mes;
						}
					}

				}
				$_GET["var3"] = $mes."-".$ano;
			}

			$this->Fechamento();

			break;

			case 'Compras':

			$date = explode("-", $_GET["var3"]);
			
			$this->setTitulo("Relatório de Compras    ".$date[0]." / ".$date[1]);
			$this->header();
			$this->RelatorioCompras($date);
			$this->fecharPdf();

			break;

			case 'Despesas':

			$date = explode("-", $_GET["var3"]);
			
			$this->setTitulo("Relatório de Despesas    ".$date[0]." / ".$date[1]);
			$this->header();
			$this->RelatorioDespesas($date);
			$this->fecharPdf();

			break;

			case 'Vendas':
			if ($_GET["var3"]=="" || !isset($_GET["var3"])) {
				$mes = date("m");
				$ano = date("Y");
				if (date("d")<27) {

					if ($mes=="01") {
						$ano--;
						$mes="12";
					}else{
						$mes--;
						if ($mes<10) {
							$mes = "0".$mes;
						}	
						
					}

				}
				$_GET["var3"] = $mes."-".$ano;
			}
			$date = explode("-", $_GET["var3"]);
			$this->setTitulo("Relatório de Vendas ".$date[0]." / ".$date[1]);
			$this->header();
			$this->RelatorioVendas($date);
			$this->fecharPdf();

			break;

			case 'Folha':
			$this->setTitulo("Folha de Pagamento");
			$this->Folha();
			$this->fecharPdf();

			break;

			case 'Estoque':
			$this->setTitulo("Controle de Estoque ".$data);
			$this->header();
			$this->Estoque();
			$this->fecharPdf();

			break;

			case 'Geral':
			
			$this->setTitulo("Relatório de Contas a Pagar");
			$this->header();
			$this->geral();
			$this->fecharPdf();

			break;

			case 'ContasAPagar':
			$this->setTitulo("Relatório de Vencimentos");
			$this->header();
			$this->vencimentos();
			$this->fecharPdf();
			break;

			case 'Cheques':
			$this->setTitulo("Relatório de Cheques");
			$this->header();
			$this->cheques();
			$this->fecharPdf();
			break;


			case 'Clientes':
			$this->setTitulo("Relatório de Clientes");
			
			$this->header(22,"C");
			$this->Clientes();
			$this->fecharPdf();
			break;


			case 'CatalogoSimples':
			$this->setTitulo("Catálogo de Produtos");
			$this->header();
			$this->CatalogoSimples();
			$this->fecharPdf();
			break;

			case 'CatalogoCompleto':
			$this->setTitulo("Catálogo de Produtos Completo");
			$this->header();
			$this->CatalogoCompleto();
			$this->fecharPdf();
			break;

			case 'Pedido':
			$dados = explode("-", $_GET["var3"]);

			$this->setTitulo("Bloco ".$dados[0]." - Pedido ".$dados[1]);
			$this->header(14,"C",false);
			$this->Pedido($dados);
			$this->fecharPdf();
			break;

			case 'Balanco':
			if (isset($_GET["var3"])) {

				$data = $this->pegaDados("balancos", $_GET["var3"]);
				$vendedor = $this->pegaDados("funcionarios", $data["vendedor"]);

				if ($data["retorno"]!="") {
					$balanco_retorno = $this->pega_detalhes_data($data["retorno"], $data["vendedor"]);
					$puxar=true;
				}else{
					$balanco_retorno=false;
					$puxar=false;
				}


				$this->setTitulo("Balanco ".$vendedor["nome"]." - ".$data["data"]);
				$this->header();
				$this->Balanco($puxar,$balanco_retorno);
				$this->fecharPdf();
			}else{


				$this->setTitulo("Lista de Balanco - Vendedor:                                       
					Data:      /      /");
				$this->header(14);
				$this->BalancoLista();
				$this->fecharPdf();
			}
			
			break;
		}
	}

	protected function setTitulo($titulo){
		$this->titulo = utf8_decode($titulo);
	}

	protected function header($font=22,$align="L",$line=true,$pos=17,$w=200,$lineW=0.5){

		$end = 210-$w;

		$left = $end;

		$right = 210-$end;

		
		$this->pdf->SetFont('Arial',null,$font);
		$this->pdf->Cell(190,5,$this->titulo,0,0,$align);
		$this->pdf->Ln();
		if ($line==true) {
			$this->pdf->SetLineWidth($lineW);
			$this->pdf->Line($left,$pos,$right,$pos);
			$this->pdf->Ln(2);			
		}
		
	}


	

	protected function fecharPdf($name=false,$arquivo=""){

		if ($name==true) {
			if ($arquivo=="") {
				$arquivo = "app/public/pdf/".$name.".pdf";
			}
			
			$this->pdf->Output($arquivo, "F");

		}else{
			ob_end_clean();
			$this->pdf->Output($this->titulo.".pdf", "I");	
		}
		

	}


	


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO FOLHA////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function Folha() {

		if (isset($_GET["var3"])) {
			$date = explode("-", $_GET["var3"]);
			$data = array($date[0],$date[1]);
		}else{
			$mes = date("m");
			$ano = date("Y");
			if (date("d")<10) {
				
				if ($mes=="01") {
					$ano--;
					$mes="12";
				}else{
					$mes--;
				}
				
			}
			$data = array($mes,$ano);
		}



		$funcao = array("","Vendedor","Administrativo","Financeiro","Estoque");


		$this->pdf = new FPDF();
		$this->pdf->Open();
		$this->pdf->SetXY(10,10);
		$this->pdf->SetMargins(10,5,0);
		$this->pdf->SetAutoPageBreak(true,10);


		

		//////////PEGA DADOS NO BANCO
		$query = "SELECT * FROM funcionarios";
		$sql = $this->model->query($query);
		while ($linha=mysql_fetch_assoc($sql)) {
			
			$this->pdf->AddPage();

			$this->pdf->SetXY(5,5);
			$this->pdf->SetFont('Arial',null,22);
			$this->pdf->Cell(200,5,"Recibo de Pagamento de Salario",0,0,'C');
			$this->pdf->Ln(5);
			$this->pdf->SetFont('Courier',null,14);
			//////////////LINHA ACIMA DO TITULO
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,15,202,15);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(5);
			/////////////HEADER
			$this->pdf->Cell(190,6,"Funcionario: ".$linha["id"]." - ".html_entity_decode($linha["nome"]), 0,1,'L',0);
			$this->pdf->Cell(190,6,"Funcao: ".$linha["funcao"]." - ".$funcao[$linha["funcao"]], 0,1,'L',0);
			$this->pdf->Cell(190,6,"Ref. a ".$data[0]."/".$data[1], 0,1,'R',0);
			//////////////////////LINHA ABAIXO REFERENCIA MES
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,35,202,35);
			$this->pdf->SetLineWidth(0.4);
			//////////COLUNAS
			$this->pdf->Ln(5);
			$this->pdf->Cell(75,6,"Descricao", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"Data", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"Vencimentos", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"Descontos", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			//////////////////////LINHA ABAIXO TITULOS COLUNAS
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,45,202,45);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(10);


			//////// LISTA SALARIO FIXO

			$this->pdf->Cell(75,6,"Salario Fixo", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($linha["fixo"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"", 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);

			//DEFINE O TAMANHA DE ESPACAMENTO DA LINHA FOOTER



			//
			if($linha["funcao"]==1){
				$venda = $this->vendas($linha["id"], $data);
				$comissao = ($venda["total"]*($linha["comissao"]/100));

			}else{
				$venda["total"]=0;
				$comissao=0;
				
			}

			$salario["bruto"] = $comissao+$linha["fixo"];


			$this->pdf->Ln(6);
			$this->pdf->Cell(75,6,"Vendas", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($venda["total"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"", 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);

			$this->pdf->Ln(6);
			$this->pdf->Cell(75,6,"Comissao", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($comissao,2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"", 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);


			$this->pdf->Ln(6);
			$this->pdf->Cell(75,6,"Salario Bruto", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($salario["bruto"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"", 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);

			//////////SE FOR VENDEDOR LISTA AS VENDAS E COMISSAO E SOMA




			/// LISTA VALES

			$this->pdf->SetFont('Courier',null,12);

			$queri = "SELECT * FROM vales WHERE funcionario=".$linha["id"];

			$result = $this->model->query($queri);
			$v=0;
			$i=1;
			while($linhax = mysql_fetch_assoc($result)){
				$date = explode("-", $linhax["data"]);

				//date[0] = dia
				//date[1] = mes
				//date[2] = ano

				if($date[1]==$data[0] && $date[2]==$data[1]){

					$v+=$linhax["valor"];

					$valesV[$i]["descricao"]=$linhax["descricao"];
					$valesV[$i]["valor"]=$linhax["valor"];
					$valesV[$i]["data"]=$linhax["data"];

					$i++;

					/// ACRESCENTA A VARIAVEL $H

				}
				
			}
			if ($v==0) {
				$this->pdf->Ln(6);
				$this->pdf->Cell(75,6,"Nenhum Vale", 0,0,'L',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				//$this->pdf->SetFont('Courier',null,11);
				$this->pdf->Cell(35,6,"", 0,0,'C',0);
				//$this->pdf->SetFont('Courier',null,14);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				$this->pdf->Cell(45,6,"", 0,0,'R',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				$this->pdf->Cell(30,6,"R$ 0,00", 0,0,'R',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			}else{
				$this->pdf->Ln(6);
				$this->pdf->Cell(75,6,"Vales", 0,0,'L',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				//$this->pdf->SetFont('Courier',null,11);
				$this->pdf->Cell(35,6,"", 0,0,'C',0);
				//$this->pdf->SetFont('Courier',null,14);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				$this->pdf->Cell(45,6,"", 0,0,'R',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				$this->pdf->Cell(30,6,"R$ ".number_format($v,2,",","."), 0,0,'R',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			}

			////

			//////////////////////LINHA ACIMA SALARIO LIQUIDO
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,80,202,80);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(10);

			$this->pdf->SetFont('Courier',null,12);
			//////// LISTA SALARIO FIXO

			$this->pdf->Cell(75,6,"", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($salario["bruto"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"R$ ".number_format($v,2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);

			////// LINHA ABAIXO SALARIO LIQUIDO
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,90,202,90);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(10);


			$this->pdf->SetFont('Courier',null,14);
			//////// LISTA SALARIO LIQUIDO
			$salario["liquido"] = $salario["bruto"] - $v;

			$this->pdf->Cell(75,6,"", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(25,6,"", 0,0,'C',0);
			$this->pdf->Cell(50,6,"Salario Liquido:", 0,0,'R',0);
			$this->pdf->Cell(39,6,"R$ ".number_format($salario["liquido"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);

			/////LINHA FINALIZANDO TABELA
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,100,202,100);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(10);



			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Line(40,112,175,112);
			$this->pdf->Ln(10);
			$this->pdf->Cell(200,6,"Assinatura: ".$linha["nome"], 0,0,'C',0);


			///// DUAS LINHAS DE DIVISA
			$this->pdf->SetLineWidth(0.2);
			$ss = 2;
			for ($i = 2; $i < 43; $i++) {
				$this->pdf->Line((2+$ss),120,(5+$ss),120);
				$ss+=5;
			}
			$this->pdf->Ln(8);
			$this->pdf->SetFont('Arial',null,7);
			$this->pdf->Cell(198,5,utf8_decode("2ª Via"),0,0,'R');
			
			//$this->pdf->Line(2,135,208,135);
			//$this->pdf->Line(2,137,208,137);
			$this->pdf->Ln(2);








			/*
			 *
			 *
			 * **************************************
			 *
			 * AGORA REPETE PARA SEGUNDA VIA
			 *
			 * ******************************************
			 *
			 *
			 *
			 *
			 * */






			$this->pdf->Ln(5);
			$this->pdf->SetFont('Arial',null,22);
			$this->pdf->Cell(200,5,"Recibo de Pagamento de Salario",0,0,'C');
			$this->pdf->Ln(5);
			$this->pdf->SetFont('Courier',null,14);
			//////////////LINHA ACIMA DO NOME DO FUNCIONARIO
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,135,202,135);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(5);
			/////////////HEADER
			$this->pdf->Cell(190,6,"Funcionario: ".$linha["id"]." - ".utf8_encode(htmlspecialchars($linha["nome"])), 0,1,'L',0);
			$this->pdf->Cell(190,6,"Funcao: ".$linha["funcao"]." - ".$funcao[$linha["funcao"]], 0,1,'L',0);
			$this->pdf->Cell(190,6,"Ref. a ".$data[0]."/".$data[1], 0,1,'R',0);
			//////////////////////LINHA ABAIXO DA REFERENCIA DO MES
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,155,202,155);
			$this->pdf->SetLineWidth(0.4);
			//////////COLUNAS
			$this->pdf->Ln(5);
			$this->pdf->Cell(75,6,"Descricao", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"Data", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"Vencimentos", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"Descontos", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			//////////////////////LINHA ABAIXO DOS TITULOS DAS COLUNAS
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,165,202,165);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(10);


			//////// LISTA SALARIO FIXO

			$this->pdf->Cell(75,6,"Salario Fixo", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($linha["fixo"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"", 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);


			//
			//////////SE FOR VENDEDOR LISTA AS VENDAS E COMISSAO E SOMA



			$this->pdf->Ln(6);
			$this->pdf->Cell(75,6,"Vendas", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($venda["total"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"", 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);

			$this->pdf->Ln(6);
			$this->pdf->Cell(75,6,"Comissao", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($comissao,2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"", 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);



			$this->pdf->Ln(6);
			$this->pdf->Cell(75,6,"Salario Bruto", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($salario["bruto"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"", 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);



			/// LISTA VALES


			$this->pdf->SetFont('Courier',null,12);
			if ($v==0) {
				$this->pdf->Ln(6);
				$this->pdf->Cell(75,6,"Nenhum Vale", 0,0,'L',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				//$this->pdf->SetFont('Courier',null,11);
				$this->pdf->Cell(35,6,"", 0,0,'C',0);
				//$this->pdf->SetFont('Courier',null,14);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				$this->pdf->Cell(45,6,"", 0,0,'R',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				$this->pdf->Cell(30,6,"R$ 0,00", 0,0,'R',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			}else{
				$this->pdf->Ln(6);
				$this->pdf->Cell(75,6,"Vales", 0,0,'L',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				//$this->pdf->SetFont('Courier',null,11);
				$this->pdf->Cell(35,6,"", 0,0,'C',0);
				//$this->pdf->SetFont('Courier',null,14);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				$this->pdf->Cell(45,6,"", 0,0,'R',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
				$this->pdf->Cell(30,6,"R$ ".number_format($v,2,",","."), 0,0,'R',0);
				$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			}

			////

			//////////////////////LINHA ACIMA DO SALARIO LIQUIDO
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,200,202,200);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(10);

			$this->pdf->SetFont('Courier',null,12);
			//////// LISTA SALARIO FIXO

			$this->pdf->Cell(75,6,"", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(35,6,"", 0,0,'C',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($salario["bruto"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(30,6,"R$ ".number_format($v,2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);

			/// LINHA ABAIXO DO SALARIO LIQUIDO
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,210,202,210);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(10);


			$this->pdf->SetFont('Courier',null,14);
			//////// LISTA SALARIO LIQUIDO
			$salario["liquido"] = $salario["bruto"] - $v;

			$this->pdf->Cell(75,6,"", 0,0,'L',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);
			$this->pdf->Cell(25,6,"", 0,0,'C',0);
			$this->pdf->Cell(50,6,"Salario Liquido:", 0,0,'R',0);
			$this->pdf->Cell(39,6,"R$ ".number_format($salario["liquido"],2,",","."), 0,0,'R',0);
			$this->pdf->Cell(2,6,"|", 0,0,'C',0);


			//// LINHA FECHANDO A TABELA
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(10,220,202,220);
			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Ln(10);


			$this->pdf->SetLineWidth(0.4);
			$this->pdf->Line(40,233,175,233);
			$this->pdf->Ln(10);
			$this->pdf->Cell(200,6,"Assinatura: ".$linha["nome"], 0,0,'C',0);


			$this->pdf->Ln(8);


			if ($valesV) {
				
				ksort($valesV);

			//// DESCRICAO DOS VALES
				if (count($valesV)>6) {
					$this->pdf->AddPage();
				}
				$this->pdf->Cell(10,6,utf8_decode("Relação de Vales:"), 0,1,'L',0);
				$this->pdf->SetFont('Courier',null,10);
				foreach ($valesV as $key => $value) {
					$this->pdf->Cell(10,6,($key).".:", 0,0,'L',0);
					$this->pdf->Cell(25,6,"R$ ".$value["valor"], 0,0,'L',0);
					$this->pdf->Cell(45,	6,"| Data: ".str_replace("-", "/", $value["data"]), 0,0,'L',0);
					$this->pdf->Cell(150,6,utf8_decode("| Descrição: ".$value["descricao"]), 0,1,'L',0);
				}


				unset($valesV);
			}

			


		}





	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM FOLHA///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////




	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO ESTOQUE////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function Estoque() {
		$data = date("d-m-Y");



		$this->pdf->SetFont('Arial',null,12);
		$this->pdf->SetLineWidth(0.6);
		$this->pdf->Ln(5);
		$this->pdf->Cell(12,5,'id', 1,0,'C',0);
		$this->pdf->Cell(80,5,'Nome', 1,0,'C',0);
		$this->pdf->Cell(50,5,'Quantidade', 1,0,'C',0);
		$this->pdf->Cell(50,5,'Valor', 1,0,'C',0);
		$this->pdf->Ln(2);
		$this->pdf->SetLineWidth(0.4);


		$query = "SELECT * FROM produtos WHERE id>0 ORDER BY nome ASC";

		$valores_db = $this->model->query($query);


		while ($produto = mysql_fetch_assoc($valores_db)) {

			$linha = $this->pega_estoque($produto["id"]);

			if ($linha==true && $linha["quantidade"]>0) {

				$quant++;
				$itens += $linha["quantidade"];
				$valor = $linha["quantidade"] * $produto["compra"];
				$total += $valor;

				$this->pdf->Ln();
				$this->pdf->Cell(12,5,$produto["id"], 1,0,'C',0);
				$this->pdf->Cell(80,5,html_entity_decode(utf8_decode($produto["nome"])), 1,0,'L',0);
				$this->pdf->Cell(50,5,$linha["quantidade"], 1,0,'C',0);
				$this->pdf->Cell(50,5,"R$ ".number_format($valor,2), 1,0,'L',0);
			}

		}
		$this->pdf->Ln(10);
		$this->pdf->Cell(70,5,"Total de Produtos: ".number_format($quant), 1,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->Cell(70,5,"Total de Itens: ".number_format($itens), 1,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->Cell(70,5,"Valor Total: R$ ".number_format($total,2), 1,0,'L',0);

		
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM ESTOQUE///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////






////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO CLIENTES/////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function Clientes() {

		$this->pdf->SetFont('Arial',null,8);
		$this->pdf->SetLineWidth(0.6);
		$this->pdf->Ln(5);

		$querys = "SELECT id FROM funcionarios WHERE funcao=1 ORDER BY Nome";

		$sql = $this->model->query($querys);

		while ($linha = mysql_fetch_assoc($sql)) {
			if (isset($addPage) && $addPage!=$linha["id"]) {
				$this->pdf->AddPage();
				$this->pdf->SetXY(10,10);
			}
			$addPage = $linha["id"];

			
			$vendedor = $this->pegaDados("funcionarios",$linha["id"]);
			$this->pdf->Ln(0);
			$this->pdf->SetFont('Arial',null,15);
			$this->pdf->Cell(75,8,utf8_decode($vendedor['nome']), 0,1,'L',0);
			$this->pdf->SetFont('Arial',null,10);


			$this->pdf->Cell(80,5,'Nome', 1,0,'C',0);
			$this->pdf->Cell(40,5,'Cidade', 1,0,'C',0);
			$this->pdf->Cell(30,5,'Fone', 1,0,'C',0);
			$this->pdf->Cell(40,5,'CPF', 1,0,'C',0);

			$this->pdf->Ln(0);
			$this->pdf->SetLineWidth(0.4);



			$query = "SELECT * FROM clientes WHERE vendedor=".$linha["id"]." ORDER BY cidade ASC, nome ASC";

			$valores_db = $this->model->query($query);

			while ($cliente = mysql_fetch_assoc($valores_db)) {

				$this->pdf->Ln(5);
				$cidade = $this->pegaDadosCodigo("municipios",$cliente["cidade"]);

				$this->pdf->Cell(80,5,substr(utf8_decode($cliente['nome']), 0,42), 1,0,'L',0);
				$this->pdf->Cell(40,5,ucwords(strtolower(substr(utf8_decode($cidade['nome']), 0,21))), 1,0,'C',0);
				$this->pdf->Cell(30,5,$cliente['fone'], 1,0,'C',0);
				$this->pdf->Cell(40,5,$cliente['cpf'], 1,0,'C',0);
				$this->pdf->Ln(0);

			}

			$this->pdf->Ln(5);
		}

		$this->pdf->Ln();
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM CLIENTES////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////




	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO GERAL////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function geral() {

		$query = "SELECT * FROM cheques WHERE pago=0 ORDER BY para ASC";

		$valores_db = $this->model->query($query);

		$i=0;
		while ($cheques = mysql_fetch_assoc($valores_db)) {

			$compensacao = explode("-", $cheques["para"]);
			if (date("w", mktime(0, 0, 0, $compensacao[1], $compensacao[0], $compensacao[2]))==0) {
				$compensacao[0]++;
			}
			if (date("w", mktime(0, 0, 0, $compensacao[1], $compensacao[0], $compensacao[2]))==6) {
				$compensacao[0]+=2;
			}
			$semana = date("W", mktime(0, 0, 0, $compensacao[1], $compensacao[0], $compensacao[2]));
			$limitesSemana = $this->verificaLimitesSemana($compensacao);
			$aPagarSemana[$semana]["max"] = $limitesSemana["max"];
			$aPagarSemana[$semana]["min"] = $limitesSemana["min"];
			$aPagarSemana[$semana][1][$i] = $cheques;

			$i++;
		}

		$query = "SELECT * FROM vencimentos WHERE pago=0 ORDER BY vencimento ASC";

		$valores_db = $this->model->query($query);

		$i=0;
		while ($boletos = mysql_fetch_assoc($valores_db)) {

			$vencimento = explode("-", $boletos["vencimento"]);
			if (date("w", mktime(0, 0, 0, $vencimento[1], $vencimento[0], $vencimento[2]))==0) {
				$vencimento[0]++;
			}
			if (date("w", mktime(0, 0, 0, $vencimento[1], $vencimento[0], $vencimento[2]))==6) {
				$vencimento[0]+=2;
			}
			$semana = date("W", mktime(0, 0, 0, $vencimento[1], $vencimento[0], $vencimento[2]));
			$limitesSemana = $this->verificaLimitesSemana($vencimento);
			$aPagarSemana[$semana]["max"] = $limitesSemana["max"];
			$aPagarSemana[$semana]["min"] = $limitesSemana["min"];
			$aPagarSemana[$semana][2][$i] = $boletos;

			$i++;
		}
		ksort($aPagarSemana);
		foreach ($aPagarSemana as $key => $value) {

			$this->pdf->SetFont('Arial',null,15);
			$this->pdf->SetLineWidth(0.6);
			$this->pdf->Ln(5);
			
			$this->pdf->Cell(190,6,"A Pagar de ".$value["min"]." a ".$value["max"], 1,0,'C',0);
			$this->pdf->Ln(1);

			$this->pdf->SetFont('Arial',null,10);
			$this->pdf->SetLineWidth(0.6);
			$this->pdf->Ln(5);
			
			


			unset($value["min"]);
			unset($value["max"]);
			
			$total=0;
			print_r($value);
			ksort($value);
			foreach ($value as $tipo=>$i) {
				if ($tipo==1) {
					$this->pdf->Cell(190,5,"Cheques", 1,1,'C',0);

					$this->pdf->Cell(20,5,'Numero', 1,0,'C',0);
					$this->pdf->Cell(55,5,'Pago a', 1,0,'C',0);
					$this->pdf->Cell(25,5,'Valor', 1,0,'C',0);
					$this->pdf->Cell(25,5,'Data', 1,0,'C',0);
					$this->pdf->Cell(25,5,'Para', 1,0,'C',0);
					$this->pdf->Cell(40,5,'Banco', 1,1,'C',0);
					$this->pdf->SetLineWidth(0.4);
					foreach ($i as $valor) {
						
						$banco = $this->pegaDados("bancos",$valor["banco"]);
						$this->pdf->Cell(20,5,$valor['numero'], 1,0,'C',0);
						$this->pdf->Cell(55,5,substr(utf8_decode($valor['quem']), 0,33) , 1,0,'C',0);
						$this->pdf->Cell(25,5,"R$ ".number_format($valor['valor'],2,",","."), 1,0,'C',0);
						$this->pdf->Cell(25,5,$valor["data"], 1,0,'C',0);
						$this->pdf->Cell(25,5,$valor['para'], 1,0,'C',0);
						$this->pdf->Cell(40,5,utf8_decode(html_entity_decode($banco['nome'])), 1,1,'C',0);
						$total+=$valor["valor"];
					}
				}else{
					$this->pdf->Cell(190,5,"Boletos", 1,1,'C',0);
					$this->pdf->Cell(100,5,'Cedente', 1,0,'C',0);
					$this->pdf->Cell(45,5,'Valor', 1,0,'C',0);
					$this->pdf->Cell(45,5,'Vencimento', 1,1,'C',0);

					$this->pdf->SetLineWidth(0.4);
					foreach ($i as $valor) {
						$this->pdf->Cell(100,5,substr(utf8_decode($valor['cedente']), 0,50), 1,0,'C',0);
						$this->pdf->Cell(45,5,"R$ ".number_format($valor['valor'],2,",","."), 1,0,'C',0);
						$this->pdf->Cell(45,5,$valor['vencimento'], 1,1,'C',0);
						$total+=$valor["valor"];
					}
				}
			}
			$this->pdf->Cell(145,6,"Total:", 1,0,'R',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($total,2,",","."), 1,0,'C',0);
			$this->pdf->Ln(6);
		}

		
		$this->pdf->Ln();
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM GERAL///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////







	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO VENCIMENTOS//////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function vencimentos() {

		$query = "SELECT * FROM vencimentos WHERE pago=0 ORDER BY id ASC";

		$valores_db = $this->model->query($query);

		$i=0;
		while ($boletos = mysql_fetch_assoc($valores_db)) {

			$vencimento = explode("-", $boletos["vencimento"]);
			if (date("w", mktime(0, 0, 0, $vencimento[1], $vencimento[0], $vencimento[2]))==0) {
				$vencimento[0]++;
			}
			if (date("w", mktime(0, 0, 0, $vencimento[1], $vencimento[0], $vencimento[2]))==6) {
				$vencimento[0]+=2;
			}
			$semana = date("W", mktime(0, 0, 0, $vencimento[1], $vencimento[0], $vencimento[2]));
			$limitesSemana = $this->verificaLimitesSemana($vencimento);
			$boletoSemana[$semana]["max"] = $limitesSemana["max"];
			$boletoSemana[$semana]["min"] = $limitesSemana["min"];
			$boletoSemana[$semana][$i] = $boletos;

			$i++;
		}
		ksort($boletoSemana);
		foreach ($boletoSemana as $key => $value) {

			$this->pdf->SetFont('Arial',null,15);
			$this->pdf->SetLineWidth(0.6);
			$this->pdf->Ln(5);
			
			$this->pdf->Cell(190,6,"Boletos de ".$value["min"]." a ".$value["max"], 1,0,'C',0);
			$this->pdf->Ln(1);

			$this->pdf->SetFont('Arial',null,10);
			$this->pdf->SetLineWidth(0.6);
			$this->pdf->Ln(5);
			
			$this->pdf->Cell(100,5,'Cedente', 1,0,'C',0);
			$this->pdf->Cell(45,5,'Valor', 1,0,'C',0);
			$this->pdf->Cell(45,5,'Vencimento', 1,1,'C',0);
			$this->pdf->SetLineWidth(0.4);


			unset($value["min"]);
			unset($value["max"]);
			
			$total=0;
			//print_r($value);
			foreach ($value as $valor) {
				$this->pdf->Cell(100,5,substr(utf8_decode($valor['cedente']), 0,50), 1,0,'C',0);
				$this->pdf->Cell(45,5,"R$ ".number_format($valor['valor'],2,",","."), 1,0,'C',0);
				$this->pdf->Cell(45,5,$valor['vencimento'], 1,1,'C',0);
				$total+=$valor["valor"];
			}
			$this->pdf->Cell(145,6,"Total:", 1,0,'R',0);
			$this->pdf->Cell(45,6,"R$ ".number_format($total,2,",","."), 1,0,'C',0);
			$this->pdf->Ln(6);
		}

		
		$this->pdf->Ln();
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM VENCIMENTOS/////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO CHEQUES//////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function cheques() {

		$query = "SELECT * FROM cheques WHERE pago=0 ORDER BY para ASC";

		$valores_db = $this->model->query($query);

		$i=0;
		while ($cheques = mysql_fetch_assoc($valores_db)) {

			$compensacao = explode("-", $cheques["para"]);
			if (date("w", mktime(0, 0, 0, $compensacao[1], $compensacao[0], $compensacao[2]))==0) {
				$compensacao[0]++;
			}
			if (date("w", mktime(0, 0, 0, $compensacao[1], $compensacao[0], $compensacao[2]))==6) {
				$compensacao[0]+=2;
			}
			$semana = date("W", mktime(0, 0, 0, $compensacao[1], $compensacao[0], $compensacao[2]));
			$limitesSemana = $this->verificaLimitesSemana($compensacao);
			$chequeSemana[$semana]["max"] = $limitesSemana["max"];
			$chequeSemana[$semana]["min"] = $limitesSemana["min"];
			$chequeSemana[$semana][$i] = $cheques;

			$i++;
		}
		ksort($chequeSemana);
		foreach ($chequeSemana as $key => $value) {

			$this->pdf->SetFont('Arial',null,15);
			$this->pdf->SetLineWidth(0.6);
			$this->pdf->Ln(5);
			
			$this->pdf->Cell(190,6,"Cheques de ".$value["min"]." a ".$value["max"], 1,0,'C',0);
			$this->pdf->Ln(1);

			$this->pdf->SetFont('Arial',null,10);
			$this->pdf->SetLineWidth(0.6);
			$this->pdf->Ln(5);
			
			$this->pdf->Cell(20,5,'Numero', 1,0,'C',0);
			$this->pdf->Cell(55,5,'Pago a', 1,0,'C',0);
			$this->pdf->Cell(25,5,'Valor', 1,0,'C',0);
			$this->pdf->Cell(25,5,'Data', 1,0,'C',0);
			$this->pdf->Cell(25,5,'Para', 1,0,'C',0);
			$this->pdf->Cell(40,5,'Banco', 1,1,'C',0);
			$this->pdf->SetLineWidth(0.4);


			unset($value["min"]);
			unset($value["max"]);
			
			$total=0;
			foreach ($value as $valor) {
				$banco = $this->pegaDados("bancos",$valor["banco"]);
				$this->pdf->Cell(20,5,$valor['numero'], 1,0,'C',0);
				$this->pdf->Cell(55,5,substr(utf8_decode($valor['quem']), 0,33), 1,0,'C',0);
				$this->pdf->Cell(25,5,"R$ ".number_format($valor['valor'],2,",","."), 1,0,'C',0);
				$this->pdf->Cell(25,5,$valor["data"], 1,0,'C',0);
				$this->pdf->Cell(25,5,$valor['para'], 1,0,'C',0);
				$this->pdf->Cell(40,5,utf8_decode(html_entity_decode($banco['nome'])), 1,1,'C',0);
				$total+=$valor["valor"];
			}
			$this->pdf->Cell(150,6,"Total:", 1,0,'R',0);
			$this->pdf->Cell(40,6,"R$ ".number_format($total,2,",","."), 1,0,'C',0);
			$this->pdf->Ln(6);
		}
		///*
		
		$this->pdf->Ln();
	}


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM CHEQUES/////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO CATALOGO/////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function CatalogoSimples() {

		
		$this->pdf->SetFont('Arial',null,12);
		$this->pdf->SetLineWidth(0.6);
		$this->pdf->Ln(5);
		$this->pdf->Cell(12,5,'id', 1,0,'C',0);
		$this->pdf->Cell(100,5,'Nome', 1,0,'C',0);
		$this->pdf->Cell(25,5,'Venda', 1,0,'C',0);
		$this->pdf->Cell(55,5,'', 1,1,'C',0);
		$this->pdf->SetLineWidth(0.4);



		$query = "SELECT * FROM produtos ORDER BY nome ASC";

		$valores_db = $this->model->query($query);

		while ($linha = mysql_fetch_assoc($valores_db)) {


			$this->pdf->Cell(12,5,$linha["id"], 1,0,'C',0);
			$this->pdf->Cell(100,5,utf8_decode("   ".$linha["nome"])." - ".$linha["quantidade"]."x1", 1,0,'L',0);
			$this->pdf->Cell(25,5,"R$".number_format($linha["venda"],2), 1,0,'C',0);
			$this->pdf->Cell(55,5,'', 1,1,'C',0);

		}

	}

	protected function CatalogoCompleto() {

		
		$this->pdf->SetFont('Arial',null,12);
		$this->pdf->SetLineWidth(0.6);
		$this->pdf->Ln(5);
		$this->pdf->Cell(10,5,'id', 1,0,'C',0);
		$this->pdf->Cell(95,5,'Nome', 1,0,'C',0);
		$this->pdf->Cell(22,5,'Compra', 1,0,'C',0);
		$this->pdf->Cell(22,5,'Venda', 1,0,'C',0);
		$this->pdf->Cell(22,5,'Lucro R$', 1,0,'C',0);
		$this->pdf->Cell(22,5,'Lucro %', 1,1,'C',0);

		$this->pdf->SetLineWidth(0.4);



		$query = "SELECT * FROM produtos ORDER BY nome ASC";

		$valores_db = $this->model->query($query);

		while ($linha = mysql_fetch_assoc($valores_db)) {

			$lucro = ($linha["venda"]-$linha["compra"])/$linha["venda"];

			$lucro = $lucro * 100;

			$ganho = $linha["venda"]-$linha["compra"];

			if ($lucro<25) {
				$this->pdf->SetTextColor(255,0,0);
			}else{
				$this->pdf->SetTextColor(0,0,0);
			}

			$this->pdf->Cell(10,5,$linha["id"], 1,0,'C',0);
			$this->pdf->Cell(95,5,utf8_decode("  ".$linha["nome"])." - ".$linha["quantidade"]."x1", 1,0,'L',0);
			$this->pdf->Cell(22,5,"R$ ".number_format($linha["compra"],2), 1,0,'C',0);
			$this->pdf->Cell(22,5,"R$ ".number_format($linha["venda"],2), 1,0,'C',0);
			$this->pdf->Cell(22,5,"R$ ".number_format($ganho,2), 1,0,'C',0);
			$this->pdf->Cell(22,5,number_format($lucro,2)."%", 1,1,'C',0);

		}

	}


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM CATALOGO////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////




	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO PEDIDO //////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function Pedido($dados) {
		$dadosPedido = $this->pegaDadosPedido($dados[0],$dados[1]);

		$vendedor = $this->pegaDados("funcionarios",$dadosPedido["vendedor"]);
		$cliente = $this->pegaDados("clientes",$dadosPedido["cliente"]);


		$pagamento = array("A Vista","A Prazo","Cheque","Boleto");


		$this->pdf->Cell(90,5,utf8_decode('Vendedor: '.$vendedor["nome"]), 0,0,'L',0);
		if ($dadosPedido["pagamento"]=="1") {
			$this->pdf->Cell(40,5,utf8_decode('Data: '.$dadosPedido["data"]), 0,0,'R',0);
			$this->pdf->Cell(60,5,utf8_decode('Vencimento: '.$dadosPedido["vencimento"]), 0,0,'R',0);
		}else{
			$this->pdf->Cell(90,5,utf8_decode('Data: '.$dadosPedido["data"]), 0,0,'R',0);	
		}
		
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->Cell(190,5,utf8_decode('Cliente: '.$cliente["nome"]), 0,0,'L',0);
		$this->pdf->Ln();	
		$this->pdf->Ln();
		$this->pdf->Cell(190,5,utf8_decode('Forma de Pagamento: '.$pagamento[$dadosPedido["pagamento"]]), 0,0,'L',0);
		$this->pdf->Ln();
		


		$this->pdf->SetFont('Arial',null,12);
		$this->pdf->SetLineWidth(0.6);
		$this->pdf->Ln(5);
		$this->pdf->Cell(12,5,'id', 1,0,'C',0);
		$this->pdf->Cell(12,5,'Qnt', 1,0,'C',0);
		$this->pdf->Cell(100,5,'Produto', 1,0,'C',0);
		$this->pdf->Cell(30,5,'Valor', 1,0,'C',0);
		$this->pdf->Cell(30,5,'Total', 1,1,'C',0);
		$this->pdf->SetLineWidth(0.4);



		$query = "SELECT * FROM produtosBlocos WHERE bloco=".$dados[0]." AND pedido=".$dados[1]." ORDER BY id ASC";

		$valores_db = $this->model->query($query);

		$i=1;

		while ($linha = mysql_fetch_assoc($valores_db)) {

			$produto = $this->pegaDados("produtos",$linha["produto"]);

			$this->pdf->Cell(12,5,$i, 1,0,'C',0);
			$this->pdf->Cell(12,5,$linha["quantidade"], 1,0,'C',0);
			$this->pdf->Cell(100,5,utf8_decode("   ".$produto["nome"])." - ".$produto["quantidade"]."x1", 1,0,'L',0);
			$this->pdf->Cell(30,5,"   R$".number_format($linha["valor"],2), 1,0,'L',0);
			$this->pdf->Cell(30,5,"   R$".number_format($linha["valor"]*$linha["quantidade"],2), 1,1,'L',0);

			$total += $linha["valor"]*$linha["quantidade"];

			$i++;

		}
		$this->pdf->Cell(154,5,'Total do Pedido', 1,0,'R',0);
		$this->pdf->Cell(30,5,"   R$".number_format($total,2), 1,0,'L',0);

	}



	

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM PEDIDO /////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO FATURAMENTO//////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function Faturamento() {
		$this->pdf->SetLineWidth(0.2);


		$mesAtual = date("m")-1;
		$anoAtual = date("Y");
		$meses = $_GET["var3"];


		$this->pdf->Ln(0);

		$dadosEmpresa = $this->pegaDados("config_empresa",1);

		$this->pdf->Ln(10);
		$this->pdf->SetFont('Arial',null,16);
		$this->pdf->Cell(210,8,'Dados da empresa', 0,1,'L',0);

		$this->pdf->Ln(2);		

		$this->pdf->SetFont('Arial',null,14);
		$this->pdf->Cell(35,8,utf8_decode('Razão social:'), 0,0,'L',0);
		$this->pdf->Cell(30,8,utf8_decode($dadosEmpresa["razao"]), 0,1,'L',0);
		$this->pdf->Cell(18,8,utf8_decode('CNPJ:'), 0,0,'L',0);
		$this->pdf->Cell(30,8,utf8_decode($dadosEmpresa["cnpj"]), 0,1,'L',0);
		$this->pdf->Cell(60,8,utf8_decode('Mês/Ano de referência:'), 0,0,'L',0);
		$this->pdf->Cell(30,8,utf8_decode(date("m")."/".date("Y")), 0,1,'L',0);
		$this->pdf->Cell(110,8,utf8_decode('Faturamento bruto total - Últimos '.$_GET['var3'].' meses:'), 0,0,'L',0);
		$this->pdf->Cell(30,8,"R$ ".$this->faturamentoBruto(), 0,1,'L',0);



		$this->pdf->Ln(5);
		$this->pdf->SetFont('Arial',null,14);

		$this->pdf->Cell(25,8,'Ano', 1,0,'C',0);
		$this->pdf->Cell(25,8,utf8_decode('Mês'), 1,0,'C',0);
		$this->pdf->Cell(45,8,'Vendas Avista', 1,0,'C',0);
		$this->pdf->Cell(45,8,'Vendas A Prazo', 1,0,'C',0);
		$this->pdf->Cell(50,8,'Total Vendas', 1,1,'C',0);

		while ($meses != 0) {


			$vendas = $this->RelatorioFaturamento($mesAtual,$anoAtual);

			$v["avista"]+=$vendas["avista"];
			$v["prazo"]+=$vendas["prazo"];


			$this->pdf->Cell(25,8,$anoAtual, 1,0,'C',0);
			$this->pdf->Cell(25,8,(($mesAtual<10) ? "0".$mesAtual : $mesAtual), 1,0,'C',0);
			$this->pdf->Cell(45,8,"     R$ ".(($vendas["avista"]!=0) ? number_format($vendas["avista"],2,",",".") : ""), 1,0,'L',0);
			$this->pdf->Cell(45,8,"     R$ ".(($vendas["prazo"]!=0) ? number_format($vendas["prazo"],2,",",".") : ""), 1,0,'L',0);
			$this->pdf->Cell(50,8,"     R$ ".((($vendas["prazo"]+$vendas["avista"])!=0) ? number_format(($vendas["prazo"]+$vendas["avista"]),2,",",".") : ""), 1,1,'L',0);

			$mesAtual--;
			$meses--;
			if ($mesAtual==0) {
				$mesAtual=12;
				$anoAtual--;
			}


		}
		$this->pdf->Cell(50,8,utf8_decode("Total ".$_GET["var3"]." meses"), 1,0,'C',0);
		$this->pdf->Cell(45,8,"     R$ ".(($v["avista"]!=0) ? number_format($v["avista"],2,",",".") : ""), 1,0,'L',0);
		$this->pdf->Cell(45,8,"     R$ ".(($v["prazo"]!=0) ? number_format($v["prazo"],2,",",".") : ""), 1,0,'L',0);
		$this->pdf->Cell(50,8,"     R$ ".((($v["prazo"]+$v["avista"])!=0) ? number_format(($v["prazo"]+$v["avista"]),2,",",".") : ""), 1,1,'L',0);

		$this->pdf->Ln(10);


		$this->pdf->Cell(35,8,utf8_decode('Local/Data:'), 0,1,'L',0);
		$this->pdf->Cell(30,8,utf8_decode($dadosEmpresa["cidade"]." - ".$dadosEmpresa["estado"].", ".date("d")." de ".$this->mes(date("m"))." de ".date("Y")."."), 0,1,'L',0);
		
		$this->pdf->Ln(20);

		$this->pdf->SetLineWidth(0.4);

		$this->pdf->Line(10,$this->pdf->GetY(),90,$this->pdf->GetY());

		$this->pdf->Line(110,$this->pdf->GetY(),200,$this->pdf->GetY());

		$this->pdf->Ln(1);
		$this->pdf->Cell(80,6,utf8_decode($dadosEmpresa["razao"]), 0,0,'C',0);
		$this->pdf->Cell(130,6,utf8_decode("Assinatura do Contador"), 0,1,'C',0);
		$this->pdf->Cell(80,6,utf8_decode("Assinatura e Carimbo"), 0,0,'C',0);
		$this->pdf->Cell(130,6,utf8_decode("(com registro no CRC)"), 0,1,'C',0);
		

	}



	protected function faturamentoBruto(){

		$mes = date("m")-1;
		$ano = date("Y");
		$meses = $_GET["var3"];
		while ($meses != 0) {

			$query = "SELECT * FROM vendas WHERE data LIKE ('%".$mes."-".$ano."')  ORDER BY id DESC";
			$sql = $this->model->query($query);
			while ($linha=mysql_fetch_assoc($sql)) {
				$data = explode("-", $linha["data"]);
				if ($mes==$data[1] && $ano==$data[2]) {
					foreach ($linha as $key => $value) {
						if ($key!="id"&&$key!="vendedor"&&$key!="total"&&$key!="data") {

							$vendas+=$value;

						}	
					}	
				}
			}


			$mes--;
			$meses--;
			if ($mes==0) {
				$mes=12;
				$ano--;
			}
		}
		return number_format($vendas,2,",",".");
	}

	protected function RelatorioFaturamento($mes,$ano){
		$query = "SELECT * FROM vendas WHERE data LIKE ('%".$mes."-".$ano."')  ORDER BY id DESC";
		$sql = $this->model->query($query);
		while ($linha=mysql_fetch_assoc($sql)) {
			$data = explode("-", $linha["data"]);
			if ($mes==$data[1] && $ano==$data[2]) {
				foreach ($linha as $key => $value) {
					if ($key!="id"&&$key!="vendedor"&&$key!="total"&&$key!="data") {
						switch ($key) {
							case 'boleto':
							$vendas["prazo"]+=$value;
							break;

							case 'cheque':
							$vendas["prazo"]+=$value;
							break;

							default:
							$vendas["avista"]+=$value;
							break;
						}	
					}	
				}
			}
		}
		return $vendas;
	}





	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM FATURAMENTO/////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////






	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO VENDAS/////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function RelatorioVendas($date) {


		$querys = "SELECT id FROM funcionarios WHERE funcao=1";

		$sql = $this->model->query($querys);


		while ($linha = mysql_fetch_assoc($sql)) {
			$query = "SELECT * FROM vendas WHERE vendedor=".$linha["id"];

			$valores_db = $this->model->query($query);


			$vendedor = $this->pegaDados("funcionarios",$linha["id"]);


			$this->pdf->Ln(0);
			$this->pdf->SetFont('Arial',null,15);
			$this->pdf->Cell(75,8,$vendedor['nome'], 0,0,'L',0);
			$this->pdf->Ln(8);
			$this->pdf->SetFont('Arial',null,8);


			$this->pdf->Cell(18,5,'Data', 1,0,'C',0);
			$this->pdf->Cell(18,5,'Dinheiro', 1,0,'C',0);
			$this->pdf->Cell(18,5,'Deposito', 1,0,'C',0);
			$this->pdf->Cell(18,5,'Boleto', 1,0,'C',0);
			$this->pdf->Cell(18,5,'Cheque', 1,0,'C',0);
			$this->pdf->Cell(18,5,'Combustivel', 1,0,'C',0);
			$this->pdf->Cell(15,5,'Hotel', 1,0,'C',0);
			$this->pdf->Cell(15,5,'Mecanico', 1,0,'C',0);
			$this->pdf->Cell(15,5,'Outros', 1,0,'C',0);
			$this->pdf->Cell(25,5,'Total', 1,0,'C',0);
			$this->pdf->Ln(0);
			$this->pdf->SetLineWidth(0.4);

			while ($venda = mysql_fetch_assoc($valores_db)) {
				$data = explode("-", $venda["data"]);

				if ($data[1]==$date[0] && $data[2]==$date[1]) {

					$this->pdf->Ln(5);

					$this->pdf->Cell(18,5,$venda['data'], 1,0,'C',0);
					$this->pdf->Cell(18,5,'R$ '.number_format($venda["dinheiro"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(18,5,'R$ '.number_format($venda["deposito"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(18,5,'R$ '.number_format($venda["boleto"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(18,5,'R$ '.number_format($venda["cheque"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(18,5,'R$ '.number_format($venda["combustivel"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(15,5,'R$ '.number_format($venda["hotel"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(15,5,'R$ '.number_format($venda["mecanico"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(15,5,'R$ '.number_format($venda["outros"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(25,5,'R$ '.number_format($venda["total"],2,",","."), 1,0,'L',0);
					$this->pdf->Ln(0);
					$total+=$venda["total"];

					$geral["dinheiro"]+=$venda["dinheiro"];
					$geral["deposito"]+=$venda["deposito"];
					$geral["boleto"]+=$venda["boleto"];
					$geral["cheque"]+=$venda["cheque"];
					$geral["combustivel"]+=$venda["combustivel"];
					$geral["hotel"]+=$venda["hotel"];
					$geral["mecanico"]+=$venda["mecanico"];
					$geral["outros"]+=$venda["outros"];
					$geral["total"]+=$venda["total"];
				}
			}
			$this->pdf->Ln(5);
			$this->pdf->Cell(153,5,'Total:', 1,0,'R',0);
			$this->pdf->Cell(25,5,'R$ '.number_format($total,2,",","."), 1,0,'L',0);
			unset($total);
			$this->pdf->Ln(5);
		}

		$this->pdf->SetFont('Arial',"B",7);
		$this->pdf->Ln(5);
		$this->pdf->Cell(18,5,"Totais Gerais", 1,0,'C',0);
		$this->pdf->Cell(18,5,'R$ '.number_format($geral["dinheiro"],2,",","."), 1,0,'L',0);
		$this->pdf->Cell(18,5,'R$ '.number_format($geral["deposito"],2,",","."), 1,0,'L',0);
		$this->pdf->Cell(18,5,'R$ '.number_format($geral["boleto"],2,",","."), 1,0,'L',0);
		$this->pdf->Cell(18,5,'R$ '.number_format($geral["cheque"],2,",","."), 1,0,'L',0);
		$this->pdf->Cell(18,5,'R$ '.number_format($geral["combustivel"],2,",","."), 1,0,'L',0);
		$this->pdf->Cell(15,5,'R$ '.number_format($geral["hotel"],2,",","."), 1,0,'L',0);
		$this->pdf->Cell(15,5,'R$ '.number_format($geral["mecanico"],2,",","."), 1,0,'L',0);
		$this->pdf->Cell(15,5,'R$ '.number_format($geral["outros"],2,",","."), 1,0,'L',0);
		$this->pdf->Cell(25,5,'R$ '.number_format($geral["total"],2,",","."), 1,0,'L',0);
		$this->pdf->Ln(0);


	}





	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM VENDAS /////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////






	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO BALANCO//////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	protected function Balanco($puxar,$balanco_retorno) {
		$this->pdf->Ln(5);
		$this->pdf->SetFont('Arial',null,12);
		$this->pdf->SetLineWidth(0.6);

		$this->pdf->Cell(100,5,'Produto', 1,0,'C',0);
		$this->pdf->Cell(20,5,'Valor', 1,0,'C',0);
		if ($puxar==true) {
			$this->pdf->Cell(20,5,'Retorno', 1,0,'C',0);
		}

		$this->pdf->Cell(20,5,'Carga', 1,0,'C',0);
		$this->pdf->Cell(20,5,'Retorno', 1,1,'C',0);
		$this->pdf->SetLineWidth(0.4);



		$query = "SELECT * FROM produtos WHERE id>0 ORDER BY nome ASC";

		$valores_db = $this->model->query($query);


		while ($produto = mysql_fetch_assoc($valores_db)) {

			$linha = $this->pega_balanco($produto["id"],$_GET["var3"]);

			if ($linha["carga"]) {

				$detalhes["ida"] += $linha["carga"]*$produto["venda"];
				$detalhes["volta"] += $linha["retorno"]*$produto["venda"];



				$this->pdf->Cell(100,5,html_entity_decode(utf8_decode("  ".$produto["nome"]))." - ".$produto["quantidade"]."x1", 1,0,'L',0);
				$this->pdf->Cell(20,5," R$".number_format($produto["venda"],2), 1,0,'L',0);
				if ($puxar==true) {
					$retorno = $this->pega_balanco($produto["id"], $balanco_retorno);
					$this->pdf->Cell(20,5,$retorno["retorno"], 1,0,'C',0);
					$this->pdf->Cell(20,5,($linha["carga"]-$retorno["retorno"]), 1,0,'C',0);
				}else{
					$this->pdf->Cell(20,5,$linha["carga"], 1,0,'C',0);
				}
				$this->pdf->Cell(20,5,$linha["retorno"], 1,1,'C',0);

			}



		}
		$Dados = $this->pegaDados("balancos",$_GET["var3"]);
		$diferenca = $this->dados_balanco($_GET["var3"], $Dados["vendedor"],$detalhes);
		$this->pdf->Ln(5);
		if ($diferenca<0) {
			$this->pdf->SetTextColor(255,0,0);
		}else{
			$this->pdf->SetTextColor(0,0,0);
		}

		$this->pdf->Cell(100,5,html_entity_decode(utf8_decode("Diferenca")), 1,0,'R',0);
		$this->pdf->Cell(80,5,"   R$".number_format($diferenca,2), 1,0,'L',0);

	}


	protected function BalancoLista(){
		$this->pdf->Cell(12,5,'id', 1,0,'C',0);
		$this->pdf->Cell(100,5,'Nome', 1,0,'C',0);
		$this->pdf->Cell(30,5,'Venda', 1,0,'C',0);
		$this->pdf->Cell(25,5,'Carga', 1,0,'C',0);
		$this->pdf->Cell(25,5,'Retorno', 1,1,'C',0);
		$this->pdf->SetLineWidth(0.4);



		$query = "SELECT * FROM produtos WHERE id>0 ORDER BY nome ASC";

		$valores_db = $this->model->query($query);

		while ($linha = mysql_fetch_assoc($valores_db)) {
			$distribuidor = $this->pegaDados("fornecedores",$linha["distribuidor"]);

			$this->pdf->Cell(12,5,$linha["id"], 1,0,'C',0);
			$this->pdf->Cell(100,5,utf8_decode("  ".$linha["nome"])." - ".$linha["quantidade"]."x1", 1,0,'L',0);
			$this->pdf->Cell(30,5,"   R$".number_format($linha["venda"],2), 1,0,'L',0);
			$this->pdf->Cell(25,5,"", 1,0,'C',0);
			$this->pdf->Cell(25,5,"", 1,1,'C',0);

		}

	}


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM BALANCO/////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO COMPRAS//////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function RelatorioCompras($date,$graf=true){		

		$pagamentos = array(
			0 => "Compras A Vista",
			1 => "Compras no Boleto",
			2 => "Compras no Cheque",
			3 => "Compras com Cheques de Cliente",
			4 => "Compras no Cartão"
			);

		$this->pdf->Ln(5);
		$this->pdf->SetFont('Arial',null,12);


		$query = "SELECT * FROM compras WHERE data LIKE ('%-".$date[0]."-".$date[1]."') OR vencimento LIKE ('%-".$date[0]."-".$date[1]."')  ORDER BY id DESC";
		$sql = $this->model->query($query);
		$xhtml = "";

		//// para cada bloco dessa venda

		while ($linha=mysql_fetch_assoc($sql)) {
			if ($linha["vencimento"]!="") {
				$data = explode("-", $linha["vencimento"]);
			}else{
				$data = explode("-", $linha["data"]);	
			}

			if ($data[1]==$date[0] && $data[2]==$date[1]) {

				$compras[$linha["pagamento"]][] = $linha;

			}


		}




		foreach ($pagamentos as $key => $value) {
			$this->pdf->SetLineWidth(0.5);
			$this->pdf->ln();
			$this->pdf->Cell(190,5,utf8_decode($value), 1,1,'C',0);
			$this->pdf->ln(2);

			$this->pdf->Cell(15,5,"ID", 1,0,'C',0);
			$this->pdf->Cell(85,5,"Fornecedor", 1,0,'C',0);

			switch ($key) {
				case 0:

				$this->pdf->Cell(30,5,"Data", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Valor", 1,0,'C',0);
				$this->pdf->Cell(30,5,"", 1,1,'C',0);

				break;

				case 1:

				$this->pdf->Cell(30,5,"Data", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Valor", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Vencimento", 1,1,'C',0);

				break;

				case 2:

				$this->pdf->Cell(30,5,"Numero", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Valor", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Vencimento", 1,1,'C',0);

				break;

				case 3:

				$this->pdf->Cell(30,5,"Data", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Valor", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Qnt. Cheques", 1,1,'C',0);

				break;

				case 4:

				$this->pdf->Cell(30,5,"Data", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Valor", 1,0,'C',0);
				$this->pdf->Cell(30,5,"Vencimento", 1,1,'C',0);

				break;

			}


			$this->pdf->SetLineWidth(0.3);
			$total = 0;
			foreach ($compras[$key] as $chv => $valor) {

				$total+=$valor["valor"];

				$fornecedor = $this->pegaDados("fornecedores",$valor["fornecedor"]);
				$this->pdf->Cell(15,5,$valor["id"], 1,0,'C',0);
				$this->pdf->Cell(85,5,"  ".utf8_decode($fornecedor["nome"]), 1,0,'L',0);


				switch ($valor["pagamento"]) {
					case 0:

					$this->pdf->Cell(30,5,$valor["data"], 1,0,'C',0);
					$this->pdf->Cell(30,5,"  R$ ".number_format($valor["valor"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(30,5,"", 1,1,'C',0);

					break;

					case 1:

					$this->pdf->Cell(30,5,$valor["data"], 1,0,'C',0);
					$this->pdf->Cell(30,5,"  R$ ".number_format($valor["valor"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(30,5,$valor["vencimento"], 1,1,'C',0);

					break;

					case 2:


					$this->pdf->Cell(30,5,$valor["cheque"], 1,0,'C',0);
					$this->pdf->Cell(30,5,"  R$ ".number_format($valor["valor"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(30,5,$valor["vencimento"], 1,1,'C',0);

					break;

					case 3:

					$this->pdf->Cell(30,5,$valor["data"], 1,0,'C',0);
					$this->pdf->Cell(30,5,"  R$ ".number_format($valor["valor"],2,",","."), 1,0,'L',0);
					$chqs = explode(",", $valor["chqcliente"]);
					$this->pdf->Cell(30,5,count($chqs), 1,1,'C',0);

					break;

					case 4:

					$this->pdf->Cell(30,5,$valor["data"], 1,0,'C',0);
					$this->pdf->Cell(30,5,"  R$ ".number_format($valor["valor"],2,",","."), 1,0,'L',0);
					$this->pdf->Cell(30,5,$valor["vencimento"], 1,1,'C',0);

					break;

				}



			}

			$this->pdf->ln(1);
			$this->pdf->Cell(160,5,"Total: ", 1,0,'R',0);
			$this->pdf->Cell(30,5,"R$ ".number_format($total,2,",","."), 1,1,'C',0);

			$this->totalCompras["Geral"] += $total;
			$this->totalCompras["totais"][$key] = number_format($total,0,"","");
		}

		$this->pdf->ln();
		$this->pdf->Cell(190,5,utf8_decode("Total de Compras do Mês: R$ ").number_format($this->totalCompras["Geral"],2,",","."), 1,1,'C',0);

		$this->pdf->ln();



		ksort($this->totalCompras["totais"]);

		$TiposPagamentos = array(
			0 => "A Vista",
			1 => "Boleto",
			2 => "Cheque",
			3 => "Cheques de Cliente",
			4 => "Cartão"
			);


		foreach ($TiposPagamentos as $key => $value) {
			$titles[$key] = $value." (R$ ".number_format($this->totalCompras["totais"][$key],2,",",".").")";
		}
		$this->pdf->ln();

		$graficoPagamento = $this->grafs($TiposPagamentos,$this->totalCompras["totais"],$titles,"Gáfico de Compras por Forma de Pagamento",array(730,350),"888888",false);
		if ($graf==true) {

			$this->pdf->Cell(190,5,utf8_decode("Gráficos"), 1,1,'C',0);


			$this->pdf->Image($graficoPagamento,null,null,null,null,"PNG");

		}else{
			return $graficoPagamento;
		}



	}



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM COMPRAS/////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////




	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO DESPESAS/////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function RelatorioDespesas($date,$graf=true){		

		$tipos = array(
			"Administrativo",
			"Fixa",
			"Imposto",
			"Juros/Taxas",
			"Combustivel",
			"Viagem",
			"Mecânico"
			);


		$TiposPagamentos = array("A Vista","Boleto","Cheque","Cheques de Cliente","Cartão");

		$this->pdf->Ln(5);
		$this->pdf->SetFont('Arial',null,12);


		$query = "SELECT * FROM despesas WHERE data LIKE ('%-".$date[0]."-".$date[1]."') OR vencimento LIKE ('%-".$date[0]."-".$date[1]."')  ORDER BY id DESC";
		$sql = $this->model->query($query);
		$xhtml = "";

		//// para cada bloco dessa venda

		while ($linha=mysql_fetch_assoc($sql)) {
			if ($linha["vencimento"]!="") {
				$data = explode("-", $linha["vencimento"]);
			}else{
				$data = explode("-", $linha["data"]);	
			}

			if ($data[1]==$date[0] && $data[2]==$date[1]) {

				$despesas[$linha["tipo"]][] = $linha;

			}


		}




		foreach ($tipos as $key => $value) {
			$this->pdf->SetLineWidth(0.5);
			$this->pdf->ln();
			$this->pdf->Cell(190,5,utf8_decode($value), 1,1,'C',0);
			$this->pdf->ln(2);

			$this->pdf->Cell(10,5,"ID", 1,0,'C',0);
			$this->pdf->Cell(85,5,"Titulo", 1,0,'C',0);
			$this->pdf->Cell(25,5,"Pago Dia", 1,0,'C',0);
			$this->pdf->Cell(30,5,"Valor", 1,0,'C',0);
			$this->pdf->Cell(40,5,"Pagamento", 1,1,'C',0);



			$this->pdf->SetLineWidth(0.3);
			$total = 0;
			foreach ($despesas[$key] as $chv => $valor) {

				$this->totalDespesas["totais"]["pagamentos"][$valor["pagamento"]] += number_format($valor["valor"],0,"","");

				$total+=$valor["valor"];


				$this->pdf->Cell(10,5,$valor["id"], 1,0,'C',0);
				$this->pdf->Cell(85,5,"  ".substr(utf8_decode($valor["titulo"]), 0,40) , 1,0,'L',0);

				if ($valor["vencimento"]!="") {
					$this->pdf->Cell(25,5,$valor["vencimento"], 1,0,'C',0);
				}else{
					$this->pdf->Cell(25,5,$valor["data"], 1,0,'C',0);
				}


				$this->pdf->Cell(30,5,"  R$ ".number_format($valor["valor"],2,",","."), 1,0,'L',0);
				$this->pdf->Cell(40,5,utf8_decode($TiposPagamentos[$valor["pagamento"]]), 1,1,'C',0);



			}

			$this->pdf->ln(1);
			$this->pdf->Cell(160,5,"Total: ", 1,0,'R',0);
			$this->pdf->Cell(30,5,"R$ ".number_format($total,2,",","."), 1,1,'C',0);

			$this->totalDespesas["Geral"] += $total;
			$this->totalDespesas["totais"]["tipos"][$key] = number_format($total,0,"","");

		}

		$this->pdf->ln();
		$this->pdf->Cell(190,5,utf8_decode("Total de Despesas do Mês: R$ ").number_format($this->totalDespesas["Geral"],2,",","."), 1,1,'C',0);






		foreach ($tipos as $key => $value) {
			$titles[0][$key] = $value." (R$ ".number_format($this->totalDespesas["totais"]["tipos"][$key],2,",",".").")";
		}

		foreach ($TiposPagamentos as $pg => $valor) {
			$titles[1][$pg] = $valor." (R$ ".number_format($this->totalDespesas["totais"]["pagamentos"][$pg],2,",",".").")";
		}

		ksort($this->totalDespesas["totais"]["tipos"]);
		ksort($this->totalDespesas["totais"]["pagamentos"]);


		//// PARA DEBUG ////
		//print_r($titles[1]);
		//print_r($this->totalDespesas["totais"]);

		/////////


		$graficoTipo = $this->grafs($tipos,$this->totalDespesas["totais"]["tipos"],$titles[0],"Gáfico de Despesas por Tipo",array(730,350),"888888",false);


		$graficoPagamento = $this->grafs($TiposPagamentos,$this->totalDespesas["totais"]["pagamentos"],$titles[1],"Gáfico de Despesas por Forma de Pagamento",array(730,350),"888888",false);




		if ($graf==true) {
			$this->pdf->AddPage();


			$this->pdf->Cell(190,5,utf8_decode("Gráficos"), 1,1,'C',0);


			$this->pdf->Image($graficoTipo,null,null,null,null,"PNG");

			$this->pdf->ln();

			$this->pdf->Image($graficoPagamento,null,null,null,null,"PNG");

		}else{

			return array($graficoTipo,$graficoPagamento);

		}


	}



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM DESPESAS////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////










	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO FECHAMENTO///////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	protected function Fechamento(){
		$date = explode("-", $_GET["var3"]);

		$this->setTitulo("Fechamento do Mês de     ".$date[0]." / ".$date[1]);
		$this->header();

		$this->pdf->ln();

		$this->setTitulo("Relatório de Compras");
		$this->header(18,"C",true,28,150,0.3);
		$graficos[0]=$this->RelatorioCompras($date,false);

		$this->pdf->ln();
		$x=$this->pdf->GetY();

		$this->linhaPontilhada($x);

		$this->pdf->ln();

		$this->setTitulo("Relatório de Despesas");
		$this->header(18,"C",true,$x+10,150,0.3);
		$grf = $this->RelatorioDespesas($date,false);

		$graficos[1] = $grf[0];
		$graficos[2] = $grf[1];



		$this->pdf->Cell(160,5,"Total: ", 1,0,'R',0);
		$this->pdf->Cell(30,5,"R$ ".number_format($total,2,",","."), 1,1,'C',0);

		$this->pdf->ln();

		//print_r($graficos);
		$x=$this->pdf->GetY();



		$this->linhaPontilhada($x);


		$this->FechamentoGraficos($graficos);

		$this->fecharPdf();
	}

	protected function FechamentoGraficos($graficos){

		$this->pdf->AddPage();


		$this->pdf->Cell(190,5,utf8_decode("Gráficos"), 1,1,'C',0);
		$this->pdf->ln(1);

		foreach ($graficos as $value) {
			$this->pdf->Image($value,null,null,180,90,"PNG");
			$this->pdf->ln(1);
		}


	}





	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM FECHAMENTO//////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////





	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO BOLETOS//////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function Boleto($NFe=""){
		if ($NFe!="") {
			$_GET["var3"] = $NFe;
		}

		$this->pdf->HidePgNo = true;

		$banco = "app/public/images/boletos/logobb.jpg";

		$dados = $this->pegaDados("config_boletos_bb", 1);
		$dados_empresa = $this->pegaDados("config_empresa", 1);

		$agencia = explode("-", $dados["agencia"]);
		$conta = explode("-", $dados["conta"]);


		// DADOS DA SUA CONTA - BANCO DO BRASIL
		$dadosboleto["agencia"] = $agencia[0];// Num da agencia, sem digito
		$dadosboleto["conta"] = $conta[0]; // Num da conta, sem digito

		// DADOS PERSONALIZADOS - BANCO DO BRASIL
		$dadosboleto["convenio"] = $dados["convenio"];// Num do conv�nio - REGRA: 6 ou 7 ou 8 d�gitos
		$dadosboleto["contrato"] = $dados["contrato"]; // Num do seu contrato
		$dadosboleto["carteira"] = $dados["carteira"];

		$dadosboleto["variacao_carteira"] = "-0".$dados["variacao"]; // Varia��o da Carteira, com tra�o (opcional)

		// TIPO DO BOLETO
		$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Conv�nio c/ 8 d�gitos, 7 p/ Conv�nio c/ 7 d�gitos, ou 6 se Conv�nio c/ 6 d�gitos
		
		$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Conv�nio c/ 6 d�gitos: informe 1 se for NossoN�mero de at� 5 d�gitos ou 2 para op��o de at� 17 d�gitos


		// SEUS DADOS
		$dadosboleto["identificacao"] = "WWdotK - Online System Ver. ".VERSAO.UPGRADE.ERROS.BETA.ALFA." . Powered by BoletosPHP (GNU/GPLv3 GNU/LGPLv3) © www.wwdotk.com";
		

		$dadosboleto["cedente"] = $dados_empresa["razao"];
		$dadosboleto["cnpj"] = $dados_empresa["cnpj"];
		$dadosboleto["email"] = $dados_empresa["email"];





		$boleto = $this->pegaDados("boletos",$_GET["var3"]);


		$data_venc = str_replace("-", "/",$boleto["vencimento"]);
		
		$valor_cobrado = $boleto["valor"]; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal helvetica
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado, 2, ',', '');


		//// BUSCA A NFe Referente a esse boleto
		if ($boleto["NFe"]!="0") {
			$nfe = $this->pegaDados("nfe",$boleto["NFe"]);

			$dadosboleto["NFe"] = $nfe["numero"]." e Serie ".$nfe["serie"];

		}else{
			$dadosboleto["NFe"] = "";
		}
		



		// Num do pedido ou do documento
		$dadosboleto["data_vencimento"] = $data_venc;
		// Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data"] = str_replace("-", "/",$boleto["emissao"]);
		// Data de emiss�o do Boleto
		$dadosboleto["dataProc"] = date("d/m/Y");
		// Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = $valor_boleto;
		// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

		$cliente = $this->pegaDados("clientes", $boleto["cliente"]);

		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = htmlspecialchars_decode($cliente["nome"]);
		$dadosboleto["sacadoCNPJ"] = ($cliente["cpf"]);


		

		// INSTRU��ES PARA O CAIXA
		

		$juros = $dados["juros"] / 100;
		$juros = $dadosboleto["valor_boleto"] * $juros;
		$juros = $juros/26;

		$dadosboleto["multa"] = $dados["multa"];
		$dadosboleto["pJuros"] = $dados["juros"];
		$dadosboleto["vJuros"] = number_format($juros,2);


		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$dadosboleto["quantidade"] = "";
		$dadosboleto["valor_unitario"] = "";
		$dadosboleto["aceite"] = "N";
		$dadosboleto["especie"] = "R$";
		$dadosboleto["especie_doc"] = "DM";

		$GeraBoleto = new Boleto_BB($dadosboleto);

		$dadosboleto = array_merge($GeraBoleto->return_var(), $dadosboleto);

		$dadosboleto["barcode"] = $GeraBoleto->fbarcode($dadosboleto["codigo_barras"]);

		
		if ($NFe=="") {
			$this->cadastraNumero($dadosboleto);
		}
		
		


		$this->topoLinha($banco,$dadosboleto);	

		$this->topoDados($dadosboleto);

		$this->topoLinha($banco,$dadosboleto,85);

		$this->corpoDados($dadosboleto);

		if ($NFe!="") {

			$this->fecharPdf("Boleto".$NFe,"app/public/temp/Boleto".$NFe.".pdf");

			unset($dadosboleto);
			unset($NFe);

		}else{
			$this->fecharPdf();

			unset($dadosboleto);
		}

	}

	public function topoLinha($logo,$dados,$y=10){

		/////// MONTANTO TOPO

		$this->pdf->SetFont('Arial',"B",8);

		$this->pdf->SetTextColor(100);

		$this->pdf->Cell(180,0,"Recibo do Sacado", 0,1,'R');

		$this->pdf->SetTextColor(0);

		/// LOGO DO BANCO

		$this->pdf->Image($logo,9,($y-1),37.5,12,"JPG");

		/// CODIGO DO BANCO
		$this->pdf->SetFont('Arial',"B",16);

		$this->pdf->Text(50,($y+9),$dados["codigo_banco_com_dv"]);


		///// LINHA DIGITAVEL

		$this->pdf->SetFont('Arial',"B",13);
		$this->pdf->Text(70,($y+9),$dados["linha_digitavel"]);



		//// LINHAS

		$this->pdf->SetLineWidth(0.7);

		$this->pdf->SetLineWidth(1);
		$this->pdf->Line(47,$y,47,($y+10));

		$this->pdf->Line(67,$y,67,($y+10));
		
		$this->pdf->Line(10,($y+11),200,($y+11)); //// LINHA DA BASE DO TOPO COM LOGO E LINHA DIGITAVEL


		
		$this->pdf->SetLineWidth(0.2); //// PADRAO LINEWIDTH
	}


	public function topoDados($dados){


		///////////////////////////////////////// PRIMEIRA LINHA /////////////////////////////////////////

		//// COLUNA DO CEDENTE

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10.5,25,10.5,33);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(13,26,"Cedente");
		$this->pdf->SetFont('Arial',"",12);
		$this->pdf->Text(13,32,utf8_decode($dados["cedente"]));


		//// COLUNA DA AGENCIA E CONTA

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(80,25,80,33);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(82,26,utf8_decode("Agência/Cód. Cedente"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(82,32,utf8_decode($dados["agencia_codigo"]));



		//// COLUNA ESPECIEs

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(120,25,120,33);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(122,26,utf8_decode("Espécie"));
		$this->pdf->SetFont('Arial',"B",12);
		$this->pdf->Text(124,32,utf8_decode($dados["especie"]));

		//// COLUNA DA QUANTIDADE

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(135,25,135,33);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(137,26,utf8_decode("Quantidade"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(137,32,utf8_decode($dados["quantidade"]));

		//// COLUNA NOSSO NUMERO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(155,25,155,33);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(157,26,utf8_decode("Nosso Número"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(157,32,utf8_decode($dados["nosso_numero"]));


		//// LINHA DA BASE 
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,33.8,200,33.8); 


		///////////////////////////////////////// SEGUNDA LINHA /////////////////////////////////////////


		//// COLUNA NUMERO DO DOCUMENTO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10.5,35,10.5,43);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(13,37,utf8_decode("Número do Documento"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(13,42,utf8_decode($dados["numero_documento"]));

		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(50,35,50,43);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(52,37,utf8_decode("Contrato"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(52,42,utf8_decode($dados["contrato"]));

		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(75,35,75,43);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(77,37,utf8_decode("CPF/CEI/CNPJ"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(77,42,utf8_decode($dados["cnpj"]));

		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(115,35,115,43);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(117,37,utf8_decode("Vencimento"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(124,42,utf8_decode($dados["data_vencimento"]));

		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,35,150,43);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,37,utf8_decode("Valor"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,42,utf8_decode("R$ ".$dados["valor_boleto"]));


		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,43.8,200,43.8);


		///////////////////////////////////////// TERCEIRA LINHA /////////////////////////////////////////

		//// COLUNA DESCONTO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10.5,45,10.5,53);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(13,47,utf8_decode("(-) Desconto/Abatimento"));
		

		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(50,45,50,53);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(52,47,utf8_decode("(-) Outras Deduções"));
		

		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(85,45,85,53);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(87,47,utf8_decode("(+) Mora/Multa"));


		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(115,45,115,53);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(117,47,utf8_decode("(+) Outros Acréscimos"));


		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,45,150,53);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,47,utf8_decode("(=) Valor Cobrado"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,52,utf8_decode("R$"));	

		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,53.8,200,53.8);


		///////////////////////////////////////// ULTIMA LINHA /////////////////////////////////////////

		//// COLUNA SACADO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10.5,55,10.5,63);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(13,57,utf8_decode("Sacado"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(13,62,utf8_decode($dados["sacado"]));

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(120,57,utf8_decode("CPF/CEI/CNPJ do Sacado:"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(120,62,utf8_decode($dados["sacadoCNPJ"]));


		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,63.8,200,63.8);



		///////////////////////////////////////// FIM TOPO /////////////////////////////////////////

		/////// MONTANTO TOPO

		$this->pdf->SetFont('Arial',"B",6);

		$this->pdf->SetTextColor(100);

		$this->pdf->Text(160,66,utf8_decode("Autenticação mecânica"));

		$this->pdf->Text(10,79,utf8_decode("Corte na linha pontilhada"));

		$this->pdf->SetTextColor(0);

		$this->linhaPontilhada(80);


	}



	public function corpoDados($dados){


		///////////////////////////////////////// PRIMEIRA LINHA /////////////////////////////////////////

		//// COLUNA Local

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10.5,100,10.5,108);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(13,101,"Local de Pagamento");
		$this->pdf->SetFont('Arial',"",12);
		$this->pdf->Text(13,107,utf8_decode("QUALQUER BANCO ATÉ O VENCIMENTO"));


		//// COLUNA CONTRATO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,100,150,108);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,101,utf8_decode("Vencimento"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(180,107,utf8_decode($dados["data_vencimento"]));


		//// LINHA DA BASE 
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,108.5,200,108.5); 


		///////////////////////////////////////// SEGUNDA LINHA /////////////////////////////////////////


		//// COLUNA CEDENTE

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10.5,110,10.5,118);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(13,112,utf8_decode("Cedente"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(13,117,utf8_decode($dados["cedente"]));

		//// COLUNA AGENCIA E CONTA

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,110,150,118);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,112,utf8_decode("Agência/Cód. Cedente"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(165,117,utf8_decode($dados["agencia_codigo"]));


		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,118.8,200,118.8);


		///////////////////////////////////////// TERCEIRA LINHA /////////////////////////////////////////

		//// COLUNA DATA DOCUMENTO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10.5,120,10.5,128);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(13,122,utf8_decode("Data do Documento"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(13,127,utf8_decode($dados["data"]));


		//// COLUNA NUMERO DOCUMENTO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(50,120,50,128);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(52,122,utf8_decode("N.o Documento"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(52,127,utf8_decode($dados["numero_documento"]));


		//// COLUNA ESPECIE

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(85,120,85,128);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(87,122,utf8_decode("Espécie Doc."));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(87,127,utf8_decode("DM"));


		//// COLUNA ACEITE

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(107,120,107,128);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(109,122,utf8_decode("Aceite"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(109,127,utf8_decode("N"));


		//// COLUNA ACEITE

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(120,120,120,128);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(122,122,utf8_decode("Data Process."));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(126,127,utf8_decode($dados["dataProc"]));

		//// COLUNA NOSSO NUMERO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,120,150,128);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,122,utf8_decode("Nosso Número"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,127,utf8_decode($dados["nosso_numero"]));

		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,128.8,200,128.8);


		///////////////////////////////////////// QUARTA LINHA /////////////////////////////////////////

		//// COLUNA USO BANCO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10.5,130,10.5,138);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(13,132,utf8_decode("Uso do Banco"));


		//// COLUNA NUMERO DOCUMENTO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(60,130,60,138);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(62,132,utf8_decode("Carteira"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(62,137,utf8_decode($dados["carteira"].$dados["variacao_carteira"]));


		//// COLUNA ESPECIE

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(85,130,85,138);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(87,132,utf8_decode("Espécie"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(87,137,utf8_decode($dados["especie"]));


		//// COLUNA ACEITE

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(107,130,107,138);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(109,132,utf8_decode("Quantidade"));


		//// COLUNA VALOR

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,130,150,138);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,132,utf8_decode("Valor"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,137,utf8_decode("R$ ".$dados["valor_boleto"]));

		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,138.8,200,138.8);



		////////////////////////////////////////////////////////////////////////////////////////////////////

		//// INSTRUCOES

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(10,142,utf8_decode("Instruções ( Texto de Responsabilidade do Cedente )"));
		$this->pdf->SetFont('Arial',"",10);


		///// TEXTO MULTA
		$this->pdf->Text(10,150,utf8_decode("Multa.........: ".$dados["multa"]." % após 1 dia corrido do vencimento."));

		///// TEXTO JUROS
		$this->pdf->Text(10,155,utf8_decode("Juros.........: ".$dados["pJuros"]." % ao mês - ( R$ ".$dados["vJuros"]." ao dia )."));


		//// TEXTO DIVERSOS
		$this->pdf->Text(10,160,utf8_decode("Em caso de dúvidas entre em contato conosco: ".$dados["email"]."."));

		if ($dados["NFe"]!="") {
			//// TEXTO REF. NFe
			$this->pdf->Text(10,165,utf8_decode("Duplicata Referente a NFe de Numero ".$dados["NFe"]."."));

		}

		
		



		//// COLUNA DESCONTOS

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,140,150,148);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,142,utf8_decode("(-) Desconto/Abatimento"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,147,utf8_decode("R$ "));
		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(150,148.5,200,148.5);



		//// COLUNA OUTRAS DEDUCOES

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,150,150,158);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,152,utf8_decode("(-) Outras Deduções"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,157,utf8_decode("R$ "));
		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(150,158.5,200,158.5);


		//// COLUNA DESCONTOS

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,160,150,168);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,162,utf8_decode("(+) Mora/Multa"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,167,utf8_decode("R$ "));
		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(150,168.5,200,168.5);


		//// COLUNA DESCONTOS

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,170,150,178);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,172,utf8_decode("(+) Outros Acréscimos"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,177,utf8_decode("R$ "));
		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(150,178.5,200,178.5);

		//// COLUNA DESCONTOS

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(150,180,150,188);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(152,182,utf8_decode("(=) Valor Cobrado"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(152,187,utf8_decode("R$ "));
		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(150,188.5,200,188.5);



		///////////////////////////////////////// ULTIMA LINHA /////////////////////////////////////////

		//// COLUNA SACADO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10,190,10,198);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(12,192,utf8_decode("Sacado"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(12,197,utf8_decode($dados["sacado"]));


		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(110,192,utf8_decode("CPF/CEI/CNPJ do Sacado:"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->Text(110,197,utf8_decode($dados["sacadoCNPJ"]));

		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,198.8,200,198.8);

		//// COLUNA SACADO

		$this->pdf->SetLineWidth(1.5);
		$this->pdf->Line(10,200,10,208);

		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(12,202,utf8_decode("Sacador/Avalista"));


		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(110,202,utf8_decode("CPF/CEI/CNPJ do Sacador/Avalista:"));

		//// LINHA DA BASE
		$this->pdf->SetLineWidth(0.4);
		$this->pdf->Line(10,208.8,200,208.8);

		

		//// AUTENTICACAO FINAL
		$this->pdf->SetTextColor(100);
		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(135,212,utf8_decode("Autenticação Mecânica - Ficha de Compensação"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->SetTextColor(0);


		//// CODIGO DE BARRAS
		$this->pdf->SetTextColor(100);
		$this->pdf->SetFont('Arial',"B",8);
		$this->pdf->Text(10,233,utf8_decode("Código de Barras"));
		$this->pdf->SetFont('Arial',"",10);
		$this->pdf->SetTextColor(0);

		$this->Codebar(10,235,$dados["codigo_barras"]);



		//// FECHAMENTO BOLETO

		$this->pdf->SetFont('Arial',"I",6);
		$this->pdf->Text(90,290,utf8_decode($dados["identificacao"]));
		

	}




	public function cadastraNumero($dadosboleto) {

		$_POST['nossoNumero'] = $dadosboleto["nosso_numero"];
		$_POST['numeroTitulo'] = $dadosboleto["numero_documento"];
		$campos = array_keys($_POST);
		$quant = count($campos);
		$quant = ($quant - 1);
		$query = "UPDATE ";
		$query .= "`boletos` ";
		$query .= "SET ";
		for ($i = 0; $i < $quant; $i++) {
			$camp = $campos[$i];
			$query .= "`$campos[$i]`= '" . $this->string->preparar($_POST[$camp]) . "',";
		}
		$camp = $campos[$quant];
		$query .= "`$campos[$quant]`= '" . $this->string->preparar($_POST[$camp]) . "' ";
		$query .= "WHERE id=" . $_GET["var3"] . "";
		//$query .= ";";
		//$query = "UPDATE `Noticias` SET `titulo_br`='Wilker' Where id = 1"; //  LINHA DE TESTE

		//$this->error($query);

		if ($this->model->query($query)) {


			unset($_POST);
		} else {
			die(mysql_error());
		}

	}



	public function Codebar($xpos, $ypos, $code,$showCode=false, $basewidth=0.3, $height=20) {
		$barChar = array (
			'0' => array (6.5, 10.4, 6.5, 10.4, 6.5, 24.3, 17.9),
			'1' => array (6.5, 10.4, 6.5, 10.4, 17.9, 24.3, 6.5),
			'2' => array (6.5, 10.0, 6.5, 24.4, 6.5, 10.0, 18.6),
			'3' => array (17.9, 24.3, 6.5, 10.4, 6.5, 10.4, 6.5),
			'4' => array (6.5, 10.4, 17.9, 10.4, 6.5, 24.3, 6.5),
			'5' => array (17.9, 10.4, 6.5, 10.4, 6.5, 24.3, 6.5),
			'6' => array (6.5, 24.3, 6.5, 10.4, 6.5, 10.4, 17.9),
			'7' => array (6.5, 24.3, 6.5, 10.4, 17.9, 10.4, 6.5),
			'8' => array (6.5, 24.3, 17.9, 10.4, 6.5, 10.4, 6.5),
			'9' => array (18.6, 10.0, 6.5, 24.4, 6.5, 10.0, 6.5)
			);
		$this->pdf->SetFont('Arial','',13);
		
		if ($showCode) {
			$this->pdf->Text($xpos, $ypos + $height + 4, $code);
		}
		
		$this->pdf->SetFillColor(0);
		$code = strtoupper($code);
		for($i=0; $i<strlen($code); $i++){
			$char = $code[$i];
			if(!isset($barChar[$char])){
				$this->pdf->Error('Invalid character in barcode: '.$char);
			}
			$seq = $barChar[$char];
			for($bar=0; $bar<7; $bar++){
				$lineWidth = $basewidth*$seq[$bar]/6.5;
				if($bar % 2 == 0){
					$this->pdf->Rect($xpos, $ypos, $lineWidth, $height, 'F');
				}
				$xpos += $lineWidth;
			}
			$xpos += $basewidth*10.4/6.5;
		}
	}



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM BOLETOS/////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////





	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////INICIO FUNCOES//////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////




	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function grafs($titles,$vars,$legend=false,$title,$size=array(600,300),$color="000000",$bg="EEEEEE",$legendaPos="b") {

		$title = str_replace(" ", "+", $title);// trata espacos

		$titles = implode("|", $titles);
		$titles = str_replace(" ", "+", $titles); // trata os espacos

		$vars = implode("|", $vars);
		$vars = str_replace(" ", "+", $vars);// trata espacos
		$vars = str_replace(",", ".", $vars);// trata os numeros decimais
		$vars = str_replace("|", ",", $vars);// troca o separador de valores

		$url = "http://chart.apis.google.com/chart?cht=p3&chds=a";/// inicia url
		
		////// DADOS
		$url .= "&chl=".$titles; // titulos
		$url .= "&chd=t:".$vars; // variaveis	
		if ($legend!=false) {

			$legend = implode("|", $legend);
			$legend = str_replace(" ", "+", $legend); // trata os espacos

			$url .= "&chdl=".$legend; // Legenda
		}


		//// CONFIGURACOES DO GRAFICO
		
		$url .= "&chtt=".$title; //// TITULO
		$url .= "&chs=".$size[0]."x".$size[1]; // Tamanho
		$url .= "&chdlp=".$legendaPos; // Posicao da Legenda
		$url .= "&chf=bg,s,".$bg; // BACKGROUND
		$url .= "&chco=".$color; // COR 

		return $url;
	}





	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function verificaLimitesSemana($compensacao){
		$semana = date("W", mktime(0, 0, 0, $compensacao[1], $compensacao[0], $compensacao[2]));
		$diasMin = $compensacao;
		while ($semana == date("W", mktime(0, 0, 0, $diasMin[1], $diasMin[0], $diasMin[2]))) {
			
			if ($diasMin[0]<date("t", mktime(0, 0, 0, $diasMin[1], $diasMin[0], $diasMin[2]))) {
				$diasMin[0]-= date("t", mktime(0, 0, 0, $diasMin[1], $diasMin[0], $diasMin[2]));
				$diasMin[1]++;
			}
			$Min = $diasMin;
			$diasMin[0]--;
		}
		$return["min"] = date("d-m-Y", mktime(0, 0, 0, $Min[1], $Min[0]-2, $Min[2]));

		$diasMax = $compensacao;
		while ($semana == date("W", mktime(0, 0, 0, $diasMax[1], $diasMax[0], $diasMax[2]))) {

			if ($diasMax[0]>date("t", mktime(0, 0, 0, $diasMax[1], $diasMax[0], $diasMax[2]))) {
				$diasMax[0]-= date("t", mktime(0, 0, 0, $diasMax[1], $diasMax[0], $diasMax[2]));
				$diasMax[1]++;
			}
			$Max = $diasMax;
			$diasMax[0]++;
		}
		$return["max"] = date("d-m-Y", mktime(0, 0, 0, $Max[1], $Max[0]-2, $Max[2]));

		return $return;
	}





	protected function pega_detalhes_data($data,$vendedor) {

		$query = "SELECT * FROM balancos WHERE data='".$data."' AND vendedor=".$vendedor;

		$result = $this->model->query($query);

		$linha = mysql_fetch_assoc($result);


		return $linha["id"];


	}



	protected function pega_balanco($id,$balanco) {
		if ($id!=true) {
			return false;
		}
		if ($balanco!=true) {
			return false;
		}
		$query = "SELECT * FROM produtosBalanco WHERE balanco=".$balanco." AND produto=".$id;

		$result = $this->model->query($query);

		$linha = mysql_fetch_assoc($result);

		return $linha;
	}
	
	
	protected function dados_balanco($balanco,$vendedor,$detalhes) {
		$data = $this->pegaDados("balancos", $balanco);

		$venda = $this->pega_venda($data["data"], $vendedor["id"]);
		$fiado = $this->pega_fiado($data["data"], $vendedor["id"]);

		$valorIda = $detalhes["ida"]+$fiado["ida"];
		$valorVolta = $detalhes["volta"] + $fiado["volta"] + $venda;

		$diferenca = $valorVolta - $valorIda;

		if ($diferenca<0) {
			return $diferenca;
		}else{
			return 0;
		}



	}
	protected function pega_venda($data,$vendedor) {
		if ($data!=true) {
			return false;
		}
		if ($vendedor!=true) {
			return false;
		}
		$query = "SELECT * FROM vendas WHERE data='".$data."' AND vendedor=".$vendedor."";
		$sql = $this->model->query($query);



		$linha = mysql_fetch_assoc($sql);

		$this->view->venda = $linha["total"];
		return $linha["total"];
	}


	protected function pega_fiado($data,$vendedor) {

		if ($data!=true) {
			return false;
		}
		if ($vendedor!=true) {
			return false;
		}

		$query = "SELECT * FROM fiados WHERE data='".$data."' AND vendedor=".$vendedor."";
		$sql = $this->model->query($query);



		$linha = mysql_fetch_assoc($sql);

		$this->view->fiadoi = $linha["ida"];
		$this->view->fiadov = $linha["volta"];

		return $linha;
	}



	protected function vendas($vendedor,$data) {

		$total = 0;

		$query = "SELECT * FROM vendas WHERE vendedor=".$vendedor;

		$result = $this->model->query($query);

		while($linha = mysql_fetch_assoc($result)){
			$date = explode("-", $linha["data"]);

			//date[0] = dia
			//date[1] = mes
			//date[2] = ano

			if($date[1]==$data[0] && $date[2]==$data[1]){
				$html.="
				
				<li style='list-style: none;  padding:5px;' >
				<h6 style='font-size:12px;'>".$linha["data"]." - R$ ".number_format($linha["total"],2)." 

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



	/////*******/********************/////*******/********************/////*******/********************//

	


	protected function pegaDadosPedido($bloco, $pedido) {
		$query = "SELECT * FROM pedidos WHERE bloco=".$bloco." AND numero=".$pedido;

		$result = $this -> model -> query($query);

		$linha = mysql_fetch_assoc($result);

		return $linha;
	}






	//////////****////////////*********************///*****************************


	/////*******/********************/////*******/********************/////*******/********************//

	


	protected function linhaPontilhada($x) {
			///// DUAS LINHAS DE DIVISA
		$this->pdf->SetLineWidth(0.2);
		$ss = 2;
		for ($i = 2; $i < 43; $i++) {
			$this->pdf->Line((2+$ss),$x,(5+$ss),$x);
			$ss+=5;
		}
	}




	protected function margens(){

		$this->pdf->Line(2,2,208,2); /// LINHA DE MARGEM NO TOPO

		$this->pdf->Line(2,2,2,295); /// LINHA DE MARGEM ESQUERDA

		$this->pdf->Line(2,295,208,295); /// LINHA DE MARGEM BASE

		$this->pdf->Line(208,2,208,295); /// LINHA DE MARGEM DIREITA


	}







	//////////****////////////*********************///*****************************


	protected function pega_estoque($id) {
		$query = "SELECT * FROM estoque WHERE produto=".$id;

		$result = $this->model->query($query);

		$linha = mysql_fetch_assoc($result);

		return $linha;
	}


	protected function mes($mes) {
		$meses = $this->pegaDados("meses",$mes);

		return $meses["mes"];
	}

	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////FIM FUNCOES/////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////


}