<?php
class BlocosController extends Controller {
	function __construct() {
		parent::__construct ();

		$this->total="";


	}

	function index() {


		switch ($_GET["var2"]) {


			/// PESQUISA CLIENTE
			case "GetCliente":

			$this->GetCliente();

			break;


			/// CRIA OS BLOCOS DE PEDIDOS
			case "Adicionar":

			if (isset($_POST["numero"]) && isset($_POST["vendedor"])) {
				$this->cadastrar("blocos");
			}elseif (isset($_POST["numero"])) {
				$this->error("Selecione um Vendedor");
			}elseif (isset($_POST["vendedor"])) {
				$this->error("Selecione um Numero para o Bloco");
			}
			$this->vendedor();

			$this->view->render ( 'blocos/novo' );

			break;

			//// CRIA PEDIDOS NOS BLOCOS
			case "CriarPedido":
			$this->view->numero = $this->pegaProxPedido();

			if (isset($_POST["cliente"])) {
				unset($_POST["idCliente"]);
				$this->criarPedido();

			}
			$this->clientes();
			$this->view->render ( 'blocos/criarPedido' );

			break;


			/////// ESSE LISTA E ALTERA O PEDIDO

			case "Pedido":

			$this->error("A data &eacute; sempre a data da Venda!");

			$vars = explode("-", $_GET["var3"]);
			$this->view->bloco = $vars[0];
			$this->view->pedido = $vars[1];

			if (isset($_POST["pagamento"])) {
				if ($_POST["pagamento"]=="1") {
					$this->model->query("UPDATE pedidos SET pagamento=".$_POST["pagamento"].", vencimento='".$_POST["vencimento"]."' WHERE bloco=".$vars[0]." AND numero=".$vars[1]);
				}else{
					$this->model->query("UPDATE pedidos SET pagamento=".$_POST["pagamento"].", vencimento='' WHERE bloco=".$vars[0]." AND numero=".$vars[1]);	
				}
				
			}


			if (isset($_POST["produto"])) {
				$_POST["quantidade"] = str_replace(",", ".", $_POST["quantidade"]);
				$_POST["valor"] = str_replace(",", ".", $_POST["valor"]);
				
				$this->add();
			}
			
			$this->listar_pedido();


			if (isset($_POST["recebeu"]) || isset($_POST["pago"])) {
				$this->pagar($vars[0],$vars[1]);
			}

			
			$this->recebeu($vars[0],$vars[1]);
			
			
			$this->view->render ( 'blocos/pedido' );

			break;

			
			//// ESSE ALTERA O ITEM DO PEDIDO
			case "Item":
			$var = explode("-", $_GET["var3"]);
			$this->view->pedido = $var[0]."-".$var[1];

			if (isset($_POST["quantidade"])) {
				$this->atualizar();
			}

			$this->dados();

			$this->view->render ( 'blocos/item' );

			break;

			

			case "Pesquisar":



			$this->buscar();

			break;
			
			///// ESSE DELETA UM BLOCO INTEIRO E SEUS PEDIDOS
			case "Deletar":
			

			$this->deletarBloco();


			break;


			//// ESSE DELETA UM PEDIDO DE UM BLOCO
			case "Delete":
			$var = explode("-", $_GET["var3"]);

			if ($var[2]==true) {
				$query3 = "DELETE FROM produtosBlocos WHERE produto=".$var[2]." AND bloco=".$var[0]." AND pedido=".$var[1];
				$sql3 = $this->model->query($query3);



				header("Location: ".URL.$_GET["var1"]."/Pedido/".$var[0]."-".$var[1]);
			}else{
				$query = "DELETE FROM produtosBlocos WHERE bloco=".$var[0]." AND pedido=".$var[1];
				///echo ($query);

				if ($this->model->query ( $query )) {

					$query3 = "DELETE FROM pedidos WHERE numero=".$var[1]." AND bloco=".$var[0];
					$sql3 = $this->model->query($query3);

					$linha = mysql_fetch_assoc($sql3);



					header("Location: ".URL.$_GET["var1"]."/Pedidos/".$var[0]);

				}
			}


			break;


			case "Pedidos":


			$this->listar_bloco();


			$this->view->render ( 'blocos/pedidos' );

			break;

			default:


			$this->listar();


			$this->view->render ( 'blocos/index' );

			break;
		}
	}


	protected function criarPedido() {

		if ($this->checarPedido()) {

			
			$bloco = $this->pegaDados("blocos",$_GET["var3"]);
			$venda = $this->pegaDados("vendas",$bloco["venda"]);

			$_POST["bloco"] = $_GET["var3"];

			if ($_POST["pagamento"]!="1") {

				unset($_POST["vencimento"]);

			}

			$_POST["vendedor"] = $venda["vendedor"];
			$numero = $_POST["numero"];
			$this->cadastrar("pedidos");
			header("Location: ".URL.$_GET["var1"]."/Pedido/".$_GET["var3"]."-".$numero);
			
		}else{
			$this->error("O pedido de Numero ".$_POST["numero"]." j&aacute; existe!");
			return false;
		}
	}

	private function checarPedido(){

		$query = "SELECT numero FROM pedidos WHERE bloco=".$_GET["var3"]." AND numero=".$_POST["numero"];
		$linha = mysql_fetch_assoc($this->model->query($query));
		if(!$linha["numero"]){
			return true;
		}else{
			return false;
		}

	}


	private function pegaProxPedido(){
		$query3 = "SELECT numero FROM pedidos WHERE bloco=".$_GET["var3"]." ORDER BY id DESC LIMIT 1";
		$sql3 = $this->model->query($query3);

		$linha = mysql_fetch_assoc($sql3);
		
		return $linha["numero"]+1;
	}



	protected function dados() {
		$var = explode("-", $_GET["var3"]);
		$produto = $this->pegaDados("produtos", $var[2]);

		if ($var[0]==false) {
			return false;
		}

		$valores_db = $this->model->query("SELECT * FROM `produtosBlocos`  WHERE produto=".$var[2]." AND bloco=".$var[0]." AND pedido=".$var[1]);
		$linha = mysql_fetch_array($valores_db);


		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);

		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i]	= $linha[$variaveis[$i]];
		}
		$this->view->produto = $produto["nome"];
	}

	protected function atualizar() {
		$var = explode("-", $_GET["var3"]);
		$produto = $this->pegaDados("produtos", $var[2]);

		if ($var[0]==false) {
			return false;
		}
		$query = "UPDATE `produtosBlocos` SET quantidade=".$_POST["quantidade"].", valor=".$_POST["valor"]."  WHERE produto=".$var[2]." AND bloco=".$var[0]." AND pedido=".$var[1]."";

		if($this->model->query($query)){
			header("Location: ".URL."Blocos/Pedido/".$var[0]."-".$var[1]);
		}


	}





	protected function pega_produto($blocos, $id) {
		if ($blocos==false) {
			return false;
		}
		if ($id==false) {
			return false;
		}
		$valores_db = $this->model->query("SELECT * FROM `blocos_".$blocos."` WHERE produto=".$id);
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

		$query = "SELECT * FROM blocos";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}
			

			$venda = $this->pegaDados("vendas",$linha["venda"]);

			$pedidos = $this->countPedidos($linha["id"]);
			

			$vendedor = $this->pegaDados("funcionarios",$venda["vendedor"]);





			$lista.= "

			<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".htmlspecialchars($vendedor["nome"])."</td>
				<td class='center'>".($venda["data"])."</td>
				<td class='center'>".($pedidos)."</td>
				<td class='actBtns'>
					<a href='".URL.$_GET["var1"]."/Pedidos/".$linha["id"]."' title='Ver Pedidos' class='tipS'>
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


	protected function countPedidos($id){

		$query = "SELECT id FROM pedidos WHERE bloco=".$id;

		$sql = $this->model->query($query);
		$qnt=0;
		while ($linha=mysql_fetch_assoc($sql)) {
			$qnt++;
		}

		return $qnt;
	}

	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR -
	 *
	 *
	 *
	 *
	 * */
	protected function listar_bloco() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT numero FROM pedidos WHERE bloco=".$_GET["var3"];

		$valores_db = $this->model->query($query);
		$letra = "B";


		while($linha = mysql_fetch_assoc($valores_db)){

			$lista.= $this->pegaPedidoLista($linha["numero"]);

		} 


		
		
		$this->view->lista = $lista;

	}

	private function pegaPedidoLista($id){

		$lista="";
		

		$dadosPedido = $this->pegaDadosPedido($_GET["var3"],$id);
		$dadosCliente = $this->pegaDados("clientes",$dadosPedido["cliente"]);
		$query = "SELECT * FROM produtosBlocos WHERE bloco=".$_GET["var3"]." AND pedido=".$id;

		$valores_db = $this->model->query($query);
		$letra = "B";

		$qnt = 0;
		$valor = 0;
		while($linha = mysql_fetch_assoc($valores_db)){

			$qnt += $linha["quantidade"];
			$valor += $linha["quantidade"]*$linha["valor"];

		}

		if ($valor==0) {
			$this->view->total=0;
		}else{

			$this->view->total += $valor;	
		}
		if ($dadosPedido["pagamento"]=="1") {

			if ($dadosPedido["pago"]==1) {
				$pago = "Pago <img src='". Folder."images/icons/control/16/check.png' alt=''/> ";
				$this->view->pagos++;
			}else{

				$valorPago = $this->pegaRecebeu($dadosPedido["bloco"],$dadosPedido["numero"]);
				if ($valorPago["total"]==false) {
					$valorPago=0;
					$pago = "Em Aberto <img src='". Folder."images/icons/control/16/busy.png' alt=''/>";
					$this->view->abertos++;
				}else{
					$this->view->parciais++;
					$pago = "R$ ".number_format($valorPago["total"],2,",",".")."<img src='". Folder."images/icons/control/16/clear.png' alt=''/>";
				}

			}
		}else{
			$pago = "Pago <img src='". Folder."images/icons/control/16/check.png' alt=''  /> ";
		}
		
		$pagamento = array("A Vista","A Prazo","Cheque","Boleto");


		$lista = "
		<tr class='gradeA'>
			<td class='center'>".$id."</td>
			<td class='left'><a href='".URL."Clientes/Relatorio/".$dadosCliente["id"]."' target='_blank'>".($dadosCliente["nome"])."</a></td>
			<td class='center'>".($qnt)."</td>
			<td class='center'>R$ ".number_format($valor, 2)."</td>
			<td class='center'>".($pagamento[$dadosPedido["pagamento"]])."</td>
			<td class='center'>".($pago)."</td>
			<td class='actBtns'>
				<a href='".URL.$_GET["var1"]."/Pedido/".$_GET["var3"]."-".$id."' title='Editar' class='tipS'>
					<img src='". Folder."images/icons/control/16/pencil.png' alt=''  /> 
				</a> 
				<a href='".URL.$_GET["var1"]."/Delete/".$_GET["var3"]."-".$id."' title='Deletar' class='tipS'>
					<img src='". Folder."images/icons/control/16/clear.png' alt=''  />
				</a>
			</td>
		</tr>";

		

		return $lista;
	}



	private function listar_pedido(){

		$lista="";
		//$valores_db = mysql_query();

		$id = str_replace("-", "_", $_GET["var3"]);
		$numb = explode("_", $id);
		$dadosPedido = $this->pegaDadosPedido($numb[0],$numb[1]);
		$dadosCliente = $this->pegaDados("clientes",$dadosPedido["cliente"]);
		$this->view->cliente = $dadosCliente["nome"];

		$this->view->pagamento = $dadosPedido["pagamento"];
		$this->view->vencimento = $dadosPedido["vencimento"];

		$query = "SELECT * FROM produtosBlocos WHERE bloco=".$numb[0]." AND pedido=".$numb[1]." ORDER BY id ASC";

		$valores_db = $this->model->query($query);

		$i=1;

		$qnt = 0;
		$total = 0;
		while($linha = mysql_fetch_assoc($valores_db)){

			
			$produto = $this->pegaDados("produtos",$linha["produto"]);
			$total = $linha["quantidade"]*$linha["valor"];
			$this->total += $total;
			$lista .= "
			<tr class='gradeA'>
				<td class='center'>".$i."</td>
				<td class='center'>".$linha["quantidade"]."</td>
				<td class='center'>".html_entity_decode($produto["nome"])."</td>
				<td class='center'>R$ ".number_format($linha["valor"], 2)."</td>
				<td class='center'>R$ ".number_format($total, 2)."</td>
				<td class='actBtns'>
					<a href='".URL.$_GET["var1"]."/Item/".$_GET["var3"]."-".$linha["produto"]."' title='Editar' class='tipS'>
						<img src='". Folder."images/icons/control/16/pencil.png' alt=''  /> 
					</a> 
					<a href='".URL.$_GET["var1"]."/Delete/".$_GET["var3"]."-".$linha["produto"]."' title='Deletar' class='tipS'>
						<img src='". Folder."images/icons/control/16/clear.png' alt=''  />
					</a>
				</td>
			</tr>";

			$i++;

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



	

	protected function cadastrar_blocos() {
		$query = "INSERT INTO blocos (vendedor,data,retorno)
		VALUES('".$_POST["vendedor"]."','".$_POST["data"]."','".$_POST["retorno"]."');";

		if ($this->model->query ( $query )) {
			$this->Log("Cadastrou o blocos para ".$_POST["data"]." do vendedor de id ".$_POST["vendedor"]."");
			unset($_POST);

			return true;
		}else{
			die(mysql_error());
		}
	}

	protected function buscar() {
		$bloco = explode("-", $_GET["var3"]);
		$dadosBloco = $this->pegaDados("blocos",$bloco[0]);
		$dadosVenda = $this->pegaDados("vendas",$dadosBloco["venda"]);
		$querys = "SELECT id FROM balancos WHERE data='".$dadosVenda["data"]."' AND vendedor='".$dadosVenda["vendedor"]."'";
		$sqls = $this->model->query($querys);
		$balanco = mysql_fetch_assoc($sqls);
		

		$html = "";
		$query = "SELECT * FROM produtos WHERE nome LIKE ('%".$_POST["produto"]."%') LIMIT 4";
		$sql = $this->model->query($query);
		while($linha = mysql_fetch_array($sql)){
			if ($linha["id"]==578 || $linha["id"]==581 || $linha["id"]==582) {
				$html .= "
				<div style='padding:5px; border:3px #ccc double; width:50%;float:left;'>
					<form method='post' action=''>
						<span style='font-size:14px;'>".$linha["nome"]." - ".$linha["quantidade"]."x1</span><br>
						<br>
						Quantidade: <input type='text' name='quantidade'  style='width: 100px'/> 
						Valor: <input type='text' name='valor' value='".$linha["venda"]."'  style='width: 100px'/>
						<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
						<input type='submit' id='submit' value=''
						style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' 
						/>
					</form>
				</div>";
			}else{
				if ($balanco["id"]) {
					if ($this->analizarBalanco($balanco["id"],$linha["id"])) {
						if ($this->verifica($linha["id"])) {


							$html .= "
							<div style='padding:5px; border:3px #ccc double; width:50%;float:left;'>
								<form method='post' action=''>
									<span style='font-size:14px;'>".$linha["nome"]." - ".$linha["quantidade"]."x1</span><br>
									<br>
									Quantidade: <input type='text' name='quantidade'  style='width: 100px'/> 
									Valor: <input type='text' name='valor'  style='width: 100px'/>
									<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
									<input type='submit' id='submit' value=''
									style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' 
									/>
								</form>
							</div>";


						}else{
							$html .= "Produto ".$linha['nome']." J&aacute; adicionado!<br>";
						}
					}else{
						$html .= "Produto ".$linha['nome']." n&atilde;o adicionado ao Balan&ccedil;o!<br>";
					}
				}else{
					if ($this->verifica($linha["id"])) {


						$html .= "
						<div style='padding:5px; border:3px #ccc double; width:50%;float:left;'>
							<form method='post' action=''>
								<span style='font-size:14px;'>".$linha["nome"]." - ".$linha["quantidade"]."x1</span><br>
								<br>
								Quantidade: <input type='text' name='quantidade'  style='width: 100px'/> 
								Valor: <input type='text' name='valor'  style='width: 100px'/>
								<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
								<input type='submit' id='submit' value=''
								style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' 
								/>
							</form>
						</div>";


					}else{
						$html .= "Produto ".$linha['nome']." J&aacute; adicionado!<br>";
					}
				}
			}
		}

		if ($html==false) {
			$html = "Nenhum produto encontrado!";
		}

		echo $html;


	}

	

	protected function verifica($id) {
		$id_bloco = explode("-", $_GET["var3"]);


		$query = "SELECT id FROM produtosBlocos WHERE bloco=".$id_bloco[0]." AND pedido=".$id_bloco[1]." AND produto=".$id;

		$sql = $this->model->query($query);

		$linha = mysql_fetch_assoc($sql);
		if ($linha["id"]==true) {
			return false;
		}else{
			return true;
		}
	}

	protected function analizarBalanco($id,$produto) {



		$query = "SELECT * FROM produtosBalanco WHERE balanco=".$id." AND produto=".$produto;

		$sql = $this->model->query($query);

		$linha = mysql_fetch_array($sql);
		if ($linha==false) {
			return false;
		}else{
			return true;
		}
	}

	protected function add() {
		$id_bloco = explode("-", $_GET["var3"]);


		
		$query = "INSERT INTO produtosBlocos (bloco,pedido,produto,quantidade,valor) VALUES(".$id_bloco[0].",".$id_bloco[1].",".$_POST["produto"].",".$_POST["quantidade"].",".$_POST["valor"].")";
		

		if ($this->model->query ( $query )) {

			unset($_POST);

			return true;
		}else{
			die(mysql_error());
		}
		
	}


	
	





	private function deletarBloco(){



		$query = "SELECT id FROM pedidos WHERE bloco=".$_GET["var3"];
				///echo ($query); pedido_

		$sql = $this->model->query ( $query );
		while ($linha=mysql_fetch_assoc($sql)) {



			$query3 = "DELETE FROM produtosBlocos WHERE bloco=".$_GET["var3"]." AND pedido=".$linha["id"];
			$sql3 = $this->model->query($query3);


			$qquery2 = "DELETE FROM pedidos WHERE id=".$linha["id"];
			$this->model->query ( $qquery2 );
			

		}

		$queri = "DELETE FROM blocos WHERE id=".$_GET["var3"];
		if($this->model->query ( $queri )){
			header("Location: ".URL.$_GET["var1"]."/Lista");
		}

	}


	private function clientes(){
		$venda = $this->pegaDados("blocos",$_GET["var3"]);
		$vendedor = $this->pegaDados("vendas",$venda["venda"]);
		$query = "SELECT * FROM clientes WHERE vendedor=".$vendedor["vendedor"]." ORDER BY nome";

		$sql = $this->model->query($query);
		$lista = "";
		while($linha = mysql_fetch_array($sql)){
			if ($this->verificaCliente($linha["id"])) {
				$cidade = $this->pegaDadosCodigo("municipios",$linha["cidade"]);
				if (isset($this->view->cliente) && $linha["id"]==$this->view->cliente) {

					$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]." - ".$cidade["nome"]."</option>";
				}else{
					$lista .="<option value='".$linha["id"]."'>".$linha["nome"]." - ".$cidade["nome"]."</option>";
				}
			}
			
		}


		$this->view->clientes = $lista;
	}

	private function verificaCliente($cliente,$bloco=false){
		if ($bloco==false) {
			$query = "SELECT id FROM pedidos WHERE bloco=".$_GET["var3"]." AND cliente=".$cliente;
		}else{
			$query = "SELECT id FROM pedidos WHERE bloco=".$bloco." AND cliente=".$cliente;
		}
		$sql = $this->model->query($query);
		$linha = mysql_fetch_assoc($sql);
		if ($linha["id"]==true) {
			return false;
		}else{
			return true;
		}
	}


	private function recebeu($bloco,$pedido){

		$query = "SELECT pago FROM pedidos WHERE bloco=".$bloco." AND numero=".$pedido;

		$sql = $this->model->query($query);

		$linha = mysql_fetch_array($sql);

		if ($linha["pago"]=="1") {

			$this->view->pagamentos = "Pagamento total foi efetuado!<br>";
			$this->view->pago=true;
		}

		$pagamentos = $this->pegaRecebeu($bloco,$pedido);
		$html = "";
		$total = 0;
		if (count($pagamentos)==0) {
			$html .= "Nenhum pagamento efetuado!<br>";

		}else{

			foreach (	$pagamentos as $value) {
				$value["valor"] = str_replace(",", ".", $value["valor"]);
				$html .= "Recebeu: R$ ".number_format($value["valor"],2,",",".")." / Data: ".$value["data"]."<br>";
				$total += $value["valor"];
			}
			$html.="Total: R$ ".number_format($total,2,",",".")."<br> Falta: R$ ".number_format(($this->total - $total),2,",",".");
		}

		$this->view->pagamentos .= $html;

		$this->view->recebeu=$total;

		if (!$this->view->recebeu) {
			$linha["recebeu"]=0;
		}



	}

	private function pegaRecebeu($bloco,$pedido){

		$query = "SELECT valor,data FROM recebeuPedido WHERE bloco=".$bloco." AND pedido=".$pedido;
		$pagamentos = array();
		$sql = $this->model->query($query);
		$i=0;
		while ($linha=mysql_fetch_assoc($sql)) {
			$pagamentos[$i]["valor"]= $linha["valor"];
			$pagamentos[$i]["data"]= $linha["data"];
			$total += $linha["valor"];
			$i++;	
		}
		$pagamentos["total"] = $total;
		return $pagamentos;
	}

	private function pagar($bloco, $numero){

		$dadosBloco = $this->pegaDados("blocos",$bloco);
		$dadosVenda = $this->pegaDados("vendas",$dadosBloco["venda"]);
		if ($this->verificaVenda($_POST["data"], $dadosVenda["vendedor"])) {


			if ($_POST["recebeu"]==$this->total) {
				$_POST["pago"]=true;
			}


			if ($_POST["recebeu"]>$this->total) {
				$this->error("<span class='red'>O valor que recebeu foi maior do que o valor do pedido!</span>");
				return false;
			}

			if ($_POST["recebeu"]==false) {
				$_POST["recebeu"] = $this->total;
			}




			if (isset($_POST['pago']) && $_POST["pago"]==true) {

				$query = "UPDATE pedidos SET pago=1 WHERE bloco=".$bloco." AND numero=".$numero;

			}else{

				$query = "UPDATE pedidos SET pago=0 WHERE bloco=".$bloco." AND numero=".$numero;
			}

			if ($this->model->query ( $query )) {
				$query = "INSERT INTO recebeuPedido (bloco,pedido,data,valor) VALUES(".$bloco.",".$numero.",'".$_POST["data"]."','".$_POST["recebeu"]."')";
				$this->model->query ( $query );

				return true;

			}


		}else{
			$this->error("<br><span class='red'>N&atilde;o existe venda para esta data!</span>");
		}

	}

	protected function verificaVenda($venda,$vendedor){

		$query = "SELECT id FROM vendas WHERE data='".$venda."' AND vendedor=".$vendedor;

		$sql = $this->model->query ( $query );

		$linha = mysql_fetch_assoc($sql);
		if ($linha["id"]==true) {
			return true;
		}else{
			return false;
		}

	}
	protected function deletarPagamentos($bloco,$numero){

		$query = "DELETE FROM recebeuPedido WHERE bloco=".$bloco." AND pedido=".$numero;


		if ($this->model->query ( $query )) {
			return true;
		}else{
			return false;
		}

	}

	protected function pegaDadosPedido($bloco, $numero) {
		$query = "SELECT * FROM pedidos WHERE numero=" . $numero." AND bloco=".$bloco;

		$result = $this -> model -> query($query);

		$linha = mysql_fetch_array($result);

		return $linha;
	}

	protected function GetCliente() {
		$venda = $this->pegaDados("blocos",$_POST["bloco"]);
		$vendedor = $this->pegaDados("vendas",$venda["venda"]);
		$query = "SELECT * FROM clientes WHERE vendedor=".$vendedor["vendedor"]." AND nome LIKE ('%".$_POST["nome"]."%') LIMIT 6";
		$sql = $this->model->query($query);
		$html = "";
		while($linha = mysql_fetch_array($sql)){
			if ($this->verificaCliente($linha["id"],$_POST["bloco"])) {
				$cidade = $this->pegaDadosCodigo("municipios",$linha["cidade"]);
				$html .= "
				<script>
					$(function(){

						$('.idCliente').click(function() {
							id = $(this).val();

							$('#idCliente').val(id);
						});});
</script>
<ol style='float:left; border:1px #ccc dashed;padding:10px;'>
	<li>Nome: <b><a href='".URL."Clientes/Relatorio/".$linha["id"]."' target='_blank'>".($linha["nome"])."</a></b></li>
	<li style='margin-left:10px;'>CPF: ".$linha["cpf"]."</li>
	<li style='margin-left:10px;'>Cidade: ".$cidade["nome"]."</li>
	<li><label><input type='radio' name='idCliente' value='".$linha["id"]."' class='idCliente'> Pegar ID</label></li>
</ol>";
}

}

if ($html=="") {
	$html = "Nenhum resultado em Clientes";
}

echo $html;


}


/*
protected function transferir(){
	$query = "SELECT * FROM blocos ORDER BY id ASC";

	$sql = $this->model->query($query);

	while ($linha=mysql_fetch_assoc($sql)) {
		$query1 = "SELECT * FROM pedidos WHERE bloco=".$linha["id"]."";

		$sql1 = $this->model->query($query1);


		while ($linha1=mysql_fetch_assoc($sql1)) {




			$query2 = "SELECT * FROM pedido_".$linha1["bloco"]."_".$linha1["numero"]."";

			$sql2 = $this->model->query($query2);

			while ($linha2=mysql_fetch_assoc($sql2)) {
				$query3 = "INSERT INTO produtosBlocos (bloco,pedido,produto,quantidade,valor) VALUES(".$linha1["bloco"].",".$linha1["numero"].",".$linha2["produto"].",".$linha2["quantidade"].",".$linha2["valor"].")";

				if($this->model->query($query3)){

					$i++;

					$true = true;
				}else{
					$true = false;
				}

			}

			if ($true==true) {
				
				//*
				$query3 = "DROP TABLE IF EXISTS pedido_".$linha1["bloco"]."_".$linha1["numero"];

				$this->model->query($query3);
				//* /
			}

		}	
	}
}

*/

}