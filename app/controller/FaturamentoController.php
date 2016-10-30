<?php
class FaturamentoController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		
		if (!isset($_POST["meses"]) || $_POST["meses"]=="") {
			$_POST["meses"] = 6;
		}
		$this->faturamento();
		
		$this->view->render ( 'faturamento/index' );
		
	}

	/*
	 *
	 *
	 *
	 * // FUNCAO faturamento - LISTA bancos NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function faturamento() {
		$lista="";
		$letra = "B";

		$mesAtual = date("m");
		$anoAtual = date("Y");
		$meses = $_POST["meses"];

		while ($meses != 0) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$vendas = $this->RelatorioVendas($mesAtual,$anoAtual);

			$lista.= "
			<tr class='grade".$letra."'>
			<td class='center'>".$anoAtual."</td>
			<td class='center'>".$mesAtual."</td>
			<td class='center'>R$ ". (($vendas["avista"]!=0) ? number_format($vendas["avista"],2,",",".") : "") ."</td>
			<td class='center'>R$ ".(($vendas["prazo"]!=0) ? number_format($vendas["prazo"],2,",",".") : "")."</td>
			<td class='center'>R$ ".((($vendas["prazo"]+$vendas["avista"])!=0) ? number_format(($vendas["prazo"]+$vendas["avista"]),2,",",".") : "")."</td>
			</tr>";
			$mesAtual--;
			$meses--;
			if ($mesAtual==0) {
				$mesAtual=12;
				$anoAtual--;
			}
			
		}

		$this->view->lista = $lista;

	}

	protected function RelatorioVendas($mes,$ano){
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

}