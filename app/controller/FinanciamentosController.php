<?php
class FinanciamentosController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

			if (isset($_POST["titulo"])) {
				$_POST["juros"] = str_replace(",", ".", $_POST["juros"]);
				$_POST["nParcelas"] = $this->pegaNParcelas();
				$this->cadastrar("financiamentos");
			}

			$this->bancos();

			$this->view->render ( 'financiamentos/novo' );
			break;

			case "Editar":

			if (isset($_POST["titulo"])) {

				$_POST["juros"] = str_replace(",", ".", $_POST["juros"]);
				$_POST["nParcelas"] = $this->pegaNParcelas();

				$this->editar($_GET["var3"],"financiamentos");
			}

			$this->pegaId("financiamentos",$_GET["var3"]);
			
			$this->bancos();

			$this->view->render ( 'financiamentos/novo' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "financiamentos");

			$this->listar();

			$this->view->render ( 'financiamentos/index' );
			break;


			case "Detalhar":

			$this->pegaId("financiamentos",$_GET["var3"]);
			$banco = $this->pegaDados("bancos",$this->view->banco);
			$this->view->banco = $banco["nome"];

			$this->simulacao();

			$this->view->render ( 'financiamentos/detalhar' );
			break;


			case "Simular":


			$this->view->render ( 'financiamentos/simular' );
			break;


			case "Simulacao":

			$this->simulacaoFinanciamento();
			
			break;



			default:

			$this->listar();

			$this->view->render ( 'financiamentos/index');
			break;
		}
	}




	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM financiamentos";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$banco = $this->pegaDados("bancos", $linha["banco"]);

			$data = explode("-", $linha["dataInicial"]);

			$dataFinal = $this->pegaDataFinal($linha);

			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".html_entity_decode($linha["titulo"])."</td>
			<td class='center'>R$ ".number_format($linha["valor"],2,",",".")."</td>
			<td class='center'>R$ ".number_format($linha["parcela"],2,",",".")."</td>
			<td class='center'>".$data[2]."-".$data[1]."-".$data[0]."</td>
			<td class='center'>".$dataFinal."</td>
			<td class='center'>".html_entity_decode($banco["nome"])."</td>
			
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Detalhar/".$linha["id"]."' title='Detalhar' class='tipS'>
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


	protected function pegaDataFinal($dados){

		$data = explode("-", $dados["dataInicial"]);

		for ($i=0; $i < $dados["nParcelas"]; $i++) { 

			$data[1]++;

			if ($data[1]>12) {
				$data[1]-=12;
				$data[2]++;
			}
		}

		if ($data[1]<10) {
			$data[1]="0".$data[1];
		}

		return $data[2]."-".$data[1]."-".$data[0];
	}




	protected function simulacao(){
		$dados = $this->pegaDados("financiamentos",$_GET["var3"]);

		$html = "Total Financiado = R$ ".number_format($dados["valor"],2,",",".")."";
		$html .= "<br>";
		$html .= "Valor Parcela = R$ ".number_format($dados["parcela"],2,",",".")."";
		$html .= "<br>";
		$html .= "Valor Taxas = R$ ".number_format($dados["taxas"],2,",",".")."";
		$html .= "<br>";
		$html .= "Juros = ".$dados["juros"]."%";
		$html .= "<br>";
		$html .= "<br>";


		$total = $dados["valor"];
		$parcela = $dados["parcela"];
		$nParcelas = 0;
		$juros = $dados["juros"]/100;
		$taxas = $dados["taxas"];
		
		$totalFinal = $total;

		$date = explode("-", $dados["dataInicial"]);
		
		while ($totalFinal>0) {

			$totalFinal = ($totalFinal-$parcela)+$totalFinal*$juros;
			
			if ($totalFinal>=0) {



				$html .= "Parcela <b>".($nParcelas+1)."</b>: ( <b>".$date[1]." / ".$date[2]."</b> )  <b>R$ ".number_format($parcela,2,",",".")."</b>. Restante <b>R$ ".number_format(($totalFinal),2,",",".")."</b>";
				$html .= "<br>";

				$date[1]++;

				if ($date[1]>12) {
					$date[1]-=12;
					$date[2]++;
				}

				if ($date[1]<10) {
					$date[1]="0".$date[1];
				}


				$nParcelas++;
			}

			
		}

		$html .= "<br>";
		$html .= "Valor Final = Valor da Parcela ( <b>R$ ".number_format($parcela,2,",",".")."</b> ) * Numero de Parcelas ( <b> $nParcelas </b>) + Taxas ( <b>R$ ".number_format($taxas,2,",",".")."</b> ) = <b>R$ ".number_format((($parcela*$nParcelas)+$taxas),2,",",".")."</b>";
		$html .= "<br>";

		$jurosPagosR = ($parcela*$nParcelas)-$total;
		$jurosPagosP = ($jurosPagosR/$total)*100;

		$html .= "<br>";
		$html .= "Juros = <b>R$ ".number_format($jurosPagosR,2,",",".")."</b> ( <b>".$jurosPagosP."% </b>)";
		$html .= "<br>";
		$html .= "Juros<span style='vertical-align:sub;'><b><i>/ano</b></i></span> = <b>R$ ".number_format(($jurosPagosR/($nParcelas/12)),2,",",".")."</b> ( <b>".($jurosPagosP/($nParcelas/12))."% </b>)";
		$html .= "<br>";
		$html .= "Juros<span style='vertical-align:sub;'><b><i>/mes</b></i></span> = <b>R$ ".number_format(($jurosPagosR/($nParcelas)),2,",",".")."</b> ( <b>".($jurosPagosP/($nParcelas))."% </b>)";



		$this->view->simulacao = $html;
		
		
	}

	private function calculaRaiz($grauraiz,$numero){
		return pow($numero,(1/$grauraiz));
	}


	protected function pegaNParcelas(){
		$totalFinal = $_POST["valor"];

		$nParcelas = 0;
		
		while ($totalFinal>0) {

			$totalFinal = ($totalFinal-$_POST["parcela"])+$totalFinal*($_POST["juros"]/100);
			
			if ($totalFinal>=0) {
				$nParcelas++;
			}

			
		}

		return $nParcelas;
	}




	private function bancos(){

		$query = "SELECT * FROM bancos ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->banco) && $linha["id"]==$this->view->banco) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->bancos = $lista;
	}

	protected function simulacaoFinanciamento(){

		$total = $_POST["ValorFinanciado"];
		$parcela = $_POST["ValorParcela"];
		$nParcelas = 0;
		$juros = $_POST["Juros"];

		$mes = $_POST["mes"];
		$ano = $_POST["ano"];
		
		$totalFinal = $total;
		
		while ($totalFinal>0) {

			$totalFinal = ($totalFinal-$parcela)+$totalFinal*$juros;
			
			if ($totalFinal>=0) {

				if ($letra=="B") {
					$letra="A";
				}elseif ($letra=="A") {
					$letra = "B";
				}

				if ($mes<10) {
					$mes="0".$mes;
				}

				
				$lista.= "

				<tr class='grade".$letra."'>
				<td class='center'>".($nParcelas+1)."</td>
				<td class='center'>R$ ".number_format($parcela,2,",",".")."</td>
				<td class='center'>".$mes."/".$ano."</td>
				<td class='center'>R$ ".number_format($totalFinal,2,",",".")."</td>
				</tr>";


				$mes++;

				if ($mes>12) {
					$mes-=12;
					$ano++;
				}


				$nParcelas++;
			}

			
		}

		//print_r($_POST);

		echo $lista;
	}



}