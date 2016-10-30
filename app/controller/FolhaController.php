<?php
class FolhaController extends Controller {
	function __construct() {
		parent::__construct ();

	}

	function index() {

		$this->administrativo();
		$this->vendedores();
		$this->view->render ( 'folha/index' );

	}



	protected function vendedores() {

		if (isset($_POST["mes"])) {
			$data = array($_POST["mes"],$_POST["ano"]);
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

		$query = "SELECT * FROM funcionarios WHERE funcao=1";
		$sql = $this->model->query($query);

		while ($linha=mysql_fetch_array($sql)) {

			$vale = $this->vales($linha["id"],$data);
			$venda = $this->vendas($linha["id"],$data);
			$salario["fixo"] = $linha["fixo"];
			$salario["comissao"] = $linha["comissao"];

			$salario["bruto"] = ($venda["total"]*($salario["comissao"]/100))+$salario["fixo"];
			$salario["liquido"] = $salario["bruto"] - $vale["total"];

			$html.="
			<fieldset>
			<div class='widget'>
			<div class='title'>
			<h6>".$linha["nome"]." - R$ ".number_format($salario["liquido"],2)."</h6>
			</div>";

			$html.="
			<div class='formRow'>
			<ul>
			<li>S&aacute;lario Fixo: ".number_format($salario["fixo"],2)." </li>
			<li style='list-style: none;  padding:5px;' class='exp'>
			Total Venda =  R$ ".number_format($venda["total"],2)." 
			</li>
			<ul>".$venda["html"]."</ul>
			<li>S&aacute;lario Bruto: ".number_format($salario["bruto"],2)." </li>
			
			<li style='list-style: none;  padding:5px;' class='exp'>
			Total Vales =  R$ ".number_format($vale["total"],2)." 
			</li>
			<ul>".$vale["html"]."</ul>
			
			<li>S&aacute;lario Liquido: ".number_format($salario["liquido"],2)." </li>
			</ul>
			</div>
			</div>
			</fieldset>";


		}

		$this->view->vendedores = $html;


	}

	protected function administrativo() {

		if (isset($_POST["mes"])) {
			$data = array($_POST["mes"],$_POST["ano"]);
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

		$query = "SELECT * FROM funcionarios WHERE funcao>1";
		$sql = $this->model->query($query);
		while ($linha=mysql_fetch_array($sql)) {

			$vale = $this->vales($linha["id"],$data);
			$salario["bruto"] = $linha["fixo"];

			$salario["liquido"] = $salario["bruto"] - $vale["total"];

			$html.="
			<fieldset>
			<div class='widget'>
			<div class='title'>
			<h6>".$linha["nome"]." - R$ ".number_format($salario["liquido"],2)."</h6>
			</div>";

			$html.="
			<div class='formRow'>
			<ul>
			<li>S&aacute;lario Bruto: ".number_format($salario["bruto"],2)." </li>
			
			<li style='list-style: none;  padding:5px;' class='exp'>
			Total Vales =  R$ ".number_format($vale["total"],2)." 
			</li>
			<ul>".$vale["html"]."</ul>
			
			<li>S&aacute;lario Liquido: ".number_format($salario["liquido"],2)." </li>
			</ul>
			</div>
			</div>
			</fieldset>";


		}

		$this->view->folha = $html;


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
				<h6 style='font-size:12px;'>".substr($linha["descricao"], 0,10)." - R$ ".number_format($linha["valor"],2)." 
				
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


}