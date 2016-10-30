<?php
class PedidoController extends Controller {
	function __construct() {
		parent::__construct ();

		$this->total="";

	}

	function index() {


		switch ($_GET["var2"]) {


			/// PESQUISA CLIENTE
			case "GetFornecedor":

			$this->GetFornecedor();

			break;


			/// CRIA OS pedidos DE PEDIDOS
			case "Adicionar":

			if (isset($_POST["compra"])) {
				unset($_POST["idCompra"]);
				$this->cadastrar("pedidoCompra");
				header("Location: ".URL."Pedido/Relacao/".$this->pegaProxPedido());
			}

			$this->view->render ( 'pedidos/novo' );

			break;

			

			/////// ESSE LISTA E ALTERA O PEDIDO

			case "Relacao":

			
			if (isset($_POST["produto"])) {
				$_POST["quantidade"] = str_replace(",", ".", $_POST["quantidade"]);
				$_POST["valor"] = str_replace(",", ".", $_POST["valor"]);
				$_POST["venda"] = str_replace(",", ".", $_POST["venda"]);
				
				$this->add();
			}
			
			$this->listar_pedido();


			
			$this->view->render ( 'pedidos/pedido' );

			break;

			
			

			

			case "Pesquisar":



			$this->buscar();

			break;
			
			///// ESSE DELETA UM BLOCO INTEIRO E SEUS PEDIDOS
			case "Deletar":
			
			$this->deletarPedido();


			break;


			//// ESSE DELETA UM PEDIDO DE UM BLOCO
			case "Delete":
			$var = explode("-", $_GET["var3"]);

			if ($this->saida($var)) {
				$this->deletar($var[1],"produtospedidos",false);
			}



			header("Location: ".URL."Pedido/Relacao/".$var[0]);

			break;


			case "Pedidos":


			$this->listar_bloco();


			$this->view->render ( 'pedidos/pedidos' );

			break;

			default:


			$this->listar();


			$this->view->render ( 'pedidos/index' );

			break;
		}
	}



	private function pegaProxPedido(){
		$query3 = "SELECT id FROM pedidoCompra ORDER BY id DESC LIMIT 1";
		$sql3 = $this->model->query($query3);

		$linha = mysql_fetch_assoc($sql3);

		return $linha["id"];
	}




	protected function atualizar() {
		$var = explode("-", $_GET["var3"]);
		$produto = $this->pegaDados("produtos", $var[2]);

		if ($var[0]==false) {
			return false;
		}

		$valores_db = $this->model->query("UPDATE `pedido_".$var[0]."_".$var[1]."` SET quantidade=".$_POST["quantidade"].", valor=".$_POST["valor"]."  WHERE produto=".$var[2]);

	}





	protected function pega_produto($pedidos, $id) {
		if ($pedidos==false) {
			return false;
		}
		if ($id==false) {
			return false;
		}
		$valores_db = $this->model->query("SELECT * FROM `pedidos_".$pedidos."` WHERE produto=".$id);
		$linha = mysql_fetch_array($valores_db);

		return $linha;
	}




	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA vendas NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM pedidoCompra";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}
			

			$compra = $this->pegaDados("compras",$linha["compra"]);
			$fornecedor = $this->pegaDados("fornecedores",$compra["fornecedor"]);


			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".htmlspecialchars($fornecedor["nome"])."</td>
			<td class='center'>".($compra["data"])."</td>
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Relacao/".$linha["id"]."' title='Ver Pedidos' class='tipS'>
			<img src='". Folder."images/icons/control/16/attibutes.png' alt='' height='16' /> 
			</a> 
			<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
			<img src='". Folder."images/icons/control/16/clear.png' alt='' height='16' />
			</a>
			</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}


	


	private function listar_pedido(){

		$lista="";
		//$valores_db = mysql_query();

		$dadosPedido = $this->pegaDados("pedidoCompra",$_GET["var3"]);
		$dadosCompra = $this->pegaDados("compras",$dadosPedido["compra"]);
		$dadosFornecedor = $this->pegaDados("fornecedores",$dadosCompra["fornecedor"]);

		$this->view->fornecedor = $dadosFornecedor["nome"] . " - Valor da Pago: R$ ".$dadosCompra["valor"];

		$query = "SELECT * FROM produtospedidos WHERE pedido=".$_GET["var3"];

		$valores_db = $this->model->query($query);

		$qnt = 0;
		$total = 0;
		while($linha = mysql_fetch_assoc($valores_db)){

			
			$produto = $this->pegaDados("produtos",$linha["produto"]);
			$total = $linha["quantidade"]*$linha["valor"];
			$this->total += $total;
			$lista .= "
			<tr class='gradeA'>
			<td class='center'>".$linha["quantidade"]."</td>
			<td class='center'>".html_entity_decode($produto["nome"])."</td>
			<td class='center'>R$ ".number_format($linha["valor"], 2)."</td>
			<td class='center'>R$ ".number_format($total, 2)."</td>
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Delete/".$_GET["var3"]."-".$linha["id"]."' title='Deletar' class='tipS'>
			<img src='". Folder."images/icons/control/16/clear.png' alt=''  />
			</a>
			</td>
			</tr>";



		}



		$this->view->total = $this->total;

		$this->view->lista =  $lista;
	}



	private function vendedor(){

		$query = "SELECT * FROM funcionarios WHERE funcao=1";

		$sql = $this->model->query($query);
		$lista = "";
		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->vendedor) && $linha["id"]==$this->view->vendedor) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->vendedores = $lista;
	}



	

	protected function cadastrar_pedidos() {
		$query = "INSERT INTO pedidoss (vendedor,data,retorno)
		VALUES('".$_POST["vendedor"]."','".$_POST["data"]."','".$_POST["retorno"]."');";

		if ($this->model->query ( $query )) {
			$this->Log("Cadastrou o pedidos para ".$_POST["data"]." do vendedor de id ".$_POST["vendedor"]."");
			unset($_POST);

			return true;
		}else{
			die(mysql_error());
		}
	}

	protected function buscar() {

		$dadosPedido = $this->pegaDados("pedidoCompra",$_GET["var3"]);
		$dadosCompra = $this->pegaDados("compras",$dadosPedido["compra"]);
		

		$html = '<script type="text/javascript">


		//desenvolve o sistema de lucro
		$(function(){
			



			$(".venda").keyup(function(){

				id=$(this).attr("var");
				
				 venda = $(".venda").attr("value");
				 compra = $(".compra").attr("value");

				 lucro = (venda - compra)/venda;
				valor = (venda-compra);

				lucro = lucro*100;
				
				lucro = lucro.toFixed(2);
				valor = valor.toFixed(2);
				 
				$(".lucrop"+id).html((lucro));
				$(".lucror"+id).html(valor);
				
			});

			$(".compra").keyup(function(){
				
				id=$(this).attr("var");

				 venda = $(".venda").attr("value");
				 compra = $(".compra").attr("value");

				lucro = (venda - compra)/venda;
				valor = (venda-compra);
				 

				lucro = lucro*100;
				
				lucro = lucro.toFixed(2);
				valor = valor.toFixed(2);


				$(".lucrop"+id).html((lucro));
				$(".lucror"+id).html(valor);
				
			});
	
		});
		</script>';

		$query = "SELECT * FROM produtos WHERE nome LIKE ('%".$_POST["produto"]."%') LIMIT 4";
		$sql = $this->model->query($query);
		while($linha = mysql_fetch_array($sql)){
			
			if ($this->verifica($linha["id"])) {


				$html .= "

				<div style='padding:5px; border:3px #ccc double; width:50%;float:left;'>
				<form method='post' action=''>
				<span style='font-size:14px;'>".$linha["nome"]." - ".$linha["quantidade"]."x1</span> (Lucro: R$  <span class='lucror".$linha["id"]."'> </span> / <span class='lucrop".$linha["id"]."'> </span>%)<br>
				<br>
				Quantidade: <input type='number' name='quantidade'  style='width: 100px'/> <br>
				Valor Compra : R$ <input type='number' name='valor' class='compra' var='".$linha["id"]."' step='0.01' style='width: 100px' value='".$linha["compra"]."'/><br>
				Valor Venda : R$ <input type='number' name='venda' class='venda' var='".$linha["id"]."' step='0.01' style='width: 100px' value='".$linha["venda"]."'/>
				<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
				<input type='hidden' name='distribuidor' value='".$dadosCompra["fornecedor"]."'  style='width: 100px'/>
				<input type='submit' id='submit' value='' style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' />
				</form>
				</div>";


			}else{
				$html .= "Produto ".$linha['nome']." J&aacute; adicionado!<br>";
			}

		}

		if ($html==false) {
			$html = "Nenhum produto encontrado!";
		}

		echo $html;


	}



	protected function verifica($id) {
		$id_bloco = str_replace("-", "_", $_GET["var3"]);


		$query = "SELECT * FROM produtospedidos WHERE pedido=".$_GET["var3"]." AND produto=".$id;

		$sql = $this->model->query($query);

		$linha = mysql_fetch_array($sql);
		if ($linha==true) {
			return false;
		}else{
			return true;
		}
	}


	protected function add() {

		unset($_POST["busca"]);

		$dadosProduto = $this->pegaDados("produtos",$_POST["produto"]);
		if ($dadosProduto["compra"]!=$_POST["valor"] || $dadosProduto["venda"]!=$_POST["venda"] || $dadosProduto["distribuidor"]!=$_POST["distribuidor"]) {
			$this->atualizarProduto();
		}else{
			unset($_POST["venda"]);
		}

		$query = "INSERT INTO produtospedidos (pedido,produto,quantidade,valor,data)VALUES(".$_GET["var3"].",".$_POST["produto"].",'".$_POST["quantidade"]."','".$_POST["valor"]."','".date("d-m-Y")."')";



		if ($this->model->query ( $query )) {

			$this->entrada();

			unset($_POST);

			return true;
		}else{
			die(mysql_error());
		}

	}

	protected function entrada() {
		$query = "SELECT * FROM estoque WHERE produto=".$_POST["produto"];

		$valores_db = $this->model->query($query);


		$linha = mysql_fetch_array($valores_db);

		$quantidade = $linha["quantidade"] + $_POST["quantidade"];

		$query = "UPDATE estoque SET quantidade=".$quantidade." WHERE produto=".$_POST["produto"];

		if ($this->model->query ( $query )) {

			$produto = $this->pegaDados("produtos",$_POST["produto"]);


			$this->Log("Deu Entrada de ".$_POST["quantidade"]." do produto ".$_POST["produto"]." ('".htmlentities($produto["nome"])."') no estoque.");


		}else{

			die(mysql_error());

		}

	}

	protected function saida($dados) {
		$dadosProduto = $this->pegaDados("produtospedidos",$dados[1]);
		$query = "SELECT * FROM estoque WHERE produto=".$dadosProduto["produto"];

		$valores_db = $this->model->query($query);


		$linha = mysql_fetch_array($valores_db);

		$quantidade = $linha["quantidade"] - $dadosProduto["quantidade"];

		$query = "UPDATE estoque SET quantidade=".$quantidade." WHERE produto=".$dadosProduto["produto"];

		if ($this->model->query ( $query )) {

			$produto = $this->pegaDados("produtos",$dadosProduto["produto"]);


			$this->Log("Deu saida de ".$dadosProduto["quantidade"]." do produto ".$dadosProduto["produto"]." ('".htmlentities($produto["nome"])."') no estoque.");

			return true;
		}else{

			die(mysql_error());

		}

	}

	protected function atualizarProduto(){
		$_POST["compra"] = $_POST["valor"];

		$valor = $_POST["valor"];

		$produto = $_POST["produto"];

		$quantidade = $_POST["quantidade"];

		unset($_POST["valor"]);

		unset($_POST["produto"]);

		unset($_POST["quantidade"]);
		
		$_POST["lucro"] = ($_POST["venda"]-$_POST["compra"])/$_POST["venda"];

		$_POST["lucro"] = $_POST["lucro"] * 100;

		if ($this->editar($produto,"produtos",false)) {
			
			unset($_POST["lucro"]);
			unset($_POST["distribuidor"]);

		}


		$_POST["valor"] = $valor;
		$_POST["produto"] = $produto;
		$_POST["quantidade"] = $quantidade;

		return true;

	}



	protected function GetFornecedor() {

		$query = "SELECT * FROM fornecedores WHERE nome LIKE ('%".$_POST["nome"]."%') LIMIT 6";
		$sql = $this->model->query($query);
		$html = "";
		while($linha = mysql_fetch_array($sql)){
			$html .= $this->compras($linha["id"]);
		}



		echo $html;


	}



	protected function deletarPedido(){
		$query = "DELETE FROM produtospedidos WHERE pedido=".$_GET["var3"];
		if ($this->model->query($query)) {
			$query = "DELETE FROM pedidoCompra WHERE id=".$_GET["var3"];	
			if ($this->model->query($query)) {
				header("Location: ".URL."Pedido");
				return true;
			}else{
				return false;
			}	
		}

	}



	protected function compras($fornecedor){
		$dados = $this->pegaDados("fornecedores",$fornecedor);
		$query = "SELECT * FROM compras WHERE fornecedor=".$fornecedor." ORDER BY id DESC LIMIT 6";
		$sql = $this->model->query($query);
		$html = "";
		while($linha = mysql_fetch_array($sql)){

			$html .= "
			<script>
			$(function(){

				$('.idCompra').click(function() {
					id = $(this).val();

					$('#idCompra').val(id);
				});});
</script>
<ol style='float:left; border:1px #ccc dashed;padding:10px;'>
<li>Fornecedor: <b>".htmlentities($dados["nome"])."</a></b></li>
<li style='margin-left:10px;'>Data: ".$linha["data"]."</li>
<li style='margin-left:10px;'>Valor: R$ ".number_format($linha["valor"],2,",",".")."</li>
<li><label><input type='radio' name='idCompra' value='".$linha["id"]."' class='idCompra'> Pegar ID</label></li>
</ol>";
}

if ($html=="") {
	
	$html = "Nenhuma Compra de ".$dados["nome"]." Cadastrada<br>";
}

return $html;
}



}