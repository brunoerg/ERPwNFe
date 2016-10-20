<?php

/*
 *
 * CLASSE BALANCOCONTROLLER
 *
 * @author GestorLab Sistemas - Wender Teixeira ( weenphp@gmail.com )
 * @version 5 BETA
 * @access public
 * @class BalancoController -> Controle para pagina de Balancos
 *
 *
 *
 */ 


class BalancoController extends Controller {
	function __construct() {
		parent::__construct ();

		// LISTA DE ID DE ITENS A IGNORAR NA BUSCA -> ITENS ESPECIAIS - > inutilizado
		$this->itensIgnore = array(176,579,538,248);

	}
	/// FUNCAO INDEX CHAMA FUNCOES NECESSARIAS
	function index() {

		// DIRECIONA AS FUNCOES DEPENDEDNO DO VALOR DAS VARIAVEL GET var2
		switch ($_GET["var2"]) {

			// PAGINA PARA CRIAR BALANCO
			case "Criar":
			// SE SELECIONOU O VENDEDOR PARA O BALANCO
			if (isset($_POST["vendedor"])) {
				/// SE SELECIONOU UMA DATA
				if (isset($_POST["data"])) {
					// CHAMA FUNCAO PARA CRIAR BALANCO
					$this->criarBalanco();

				}else{
					// SE NAO MOSTRA PARA O USUARIO O AVISO DE SELECIONAR UMA DATA
					$this->error("Selecione uma Data");
				}

			}
			// LISTA VENDEDORES
			$this->vendedor();

			// Chama o view para renderizar a pagina app/view/balanco/novo.php
			$this->view->render ( 'balanco/novo' );

			break;

			// ADICIONAR CARGA A BALANCO JA CRIADO
			case "Carga":
			/// ZERA VARIAVEIS DE VALORES
			$this->lucro = 0;
			$this->view->levados = 0;
			$this->view->ida = 0;
			$this->view->volta = 0;
			$this->view->estimativa = 0;
			$this->view->diferenca = 0;

			// SE PUXAR RETORNO
			if (isset($_POST["puxar"])) {
				$this->puxar();
			}
			// SE DESPUXAR RETORNO
			if (isset($_POST["UnPuxar"])) {
				$this->UnPuxar();
			}


			if (isset($_POST["produto"]) && isset($_POST["acrescentar"])) {
				// SE TIVER O CAMPO acrescentar CHAMA FUNCAO update
				$this->update($_POST["produto"], $_POST["quantidade"]);
			}elseif (isset($_POST["produto"])) {
				// SE NAO TIVER O CAMPO acrescentar CHAMA FUNCAO add
				$this->add();
			}


			// FUNCAO QUE LISTA ITENS DO BALANCO
			$this->listarBalanco();

			// PEGA OS DADOS DO BALANCO COM A FUNCAO PEGA DADOS -> pegaDados(tabela,id)
			$dados = $this->pegaDados("balancos", $_GET["var3"]);

			$this->view->data = $dados["data"];
			// PEGA DADOS DO VENDEDOR RELACIONADO AO BALANCO
			$vendedor = $this->pegaDados("funcionarios", $dados["vendedor"]);
			$this->view->vendedor = $vendedor["nome"];


			// DETALHA BALANCO
			$this->detalhes();


			// SETA LUCRO DO BALANCO
			$this->view->lucro = $this->view->venda - $this->lucro;

			// Chama o view para renderizar a pagina app/view/balanco/balanco.php
			$this->view->render ( 'balanco/balanco' );

			break;

			case "Retorno":
			
			/// ZERA VARIAVEIS DE VALORES
			$this->lucro = 0;
			$this->view->levados = 0;
			$this->view->ida = 0;
			$this->view->volta = 0;
			$this->view->estimativa = 0;
			$this->view->diferenca = 0;


			// SE PUXAR RETORNO
			if (isset($_POST["puxar"])) {
				$this->puxar();
			}
			// SE DESPUXAR RETORNO
			if (isset($_POST["UnPuxar"])) {
				$this->UnPuxar();
			}

			// SE CAMPO PRODUTO ADICIONA RETORNO
			if (isset($_POST["produto"])) {
				$this->retorno();
			}

			// FUNCAO QUE LISTA ITENS DO BALANCO
			$this->listarBalanco();

			// PEGA OS DADOS DO BALANCO COM A FUNCAO PEGA DADOS -> pegaDados(tabela,id)
			$dados = $this->pegaDados("balancos", $_GET["var3"]);

			$this->view->data = $dados["data"];
			// PEGA DADOS DO VENDEDOR RELACIONADO AO BALANCO
			$vendedor = $this->pegaDados("funcionarios", $dados["vendedor"]);
			$this->view->vendedor = $vendedor["nome"];


			// DETALHA BALANCO
			$this->detalhes();


			// SETA LUCRO DO BALANCO
			$this->view->lucro = $this->view->venda - $this->lucro;

			// Chama o view para renderizar a pagina app/view/balanco/retorno.php
			$this->view->render ( 'balanco/retorno' );

			break;

			case "Item":
			// EDITAR ITEM DO BALANCO
			
			// EXPLODE var3 =>
			//var[0] = id do balanco
			//var[1] = id do item
			$var = explode("-", $_GET["var3"]);
			$this->view->balanco = $var[0];

			// se campo carga setado atualiza o item
			if (isset($_POST["carga"])) {
				$this->atualizar();
			}

			// lista dados
			$this->dados();

			// Chama o view para renderizar a pagina app/view/balanco/item.php
			$this->view->render ( 'balanco/item' );

			break;

			case "Puxar":
			// PUXAR RETORNO

			if (isset($_POST["retorno"])) {
				$this->addRetorno()	;
			}
			// Chama o view para renderizar a pagina app/view/balanco/puxar.php
			$this->view->render ( 'balanco/puxar' );
			break;

			case "Pesquisar":
			// PESQUISAR PRODUTO PARA ADICIONAR AO BALANCO

			$this->buscar();

			break;


			case "Pesquisar-Retorno":
			// PESQUISAR PRODUTO NA CARGA PARA ADICIONAR RETORNO DE CARGA
			$this->buscarRetorno();

			break;

			case "Delete":
			// DELETA UM PRODUTO DO BALANCO
			$var = explode("-", $_GET["var3"]);

			$query = "DELETE FROM produtosBalanco WHERE balanco=".$var[0]." AND produto=".$var[1];
				///echo ($query);
			// CHAMA FUNCAO this->abate(idBalanco,idProduto) que abate/devolve do estoque
			if ($this->abate($var[0],$var[1])) {
				if ($this->model->query ( $query )) {
					// redireciona para pagina de carga do balanco
					header("Location: ".URL.$_GET["var1"]."/Carga/".$var[0]);
				}else{
					die(mysql_error());
				}

			}


			break;

			default:

			// funcao listar balancos criados
			$this->listar();
			// Chama o view para renderizar a pagina app/view/balanco/index.php
			$this->view->render ( 'balanco/index' );

			break;
		}
	}

	/// FUNCAO ADICIONA RETORNO
	protected function addRetorno() {
		$query = "UPDATE balancos SET retorno='".$_POST["retorno"]."' WHERE id=".$_GET["var3"];
		if ($this->model->query ( $query )) {

			header("Location: ".URL.$_GET["var1"]."/Carga/".$_GET["var3"]);
		}else{
			die(mysql_error());
		}
	}


	/// FUNCAO PARA ABATER/DEVOLVER PRODUTOS DO ESTOQUE
	protected function abate($balanco,$produto) {
		// pega dados do produto no balanco
		$produto = $this->pegaProduto($balanco,$produto);

		// SE O RETORNO=0 ele da entrada no estoque de toda a quantidade de carga do produto
		if ($linha["retorno"]==0) {
			if ($this->entrada($produto,$linha["carga"])) {
				return true;
			}else{
				return false;
			}
		}else{
			// SE O RETORNO != 0 ele da entrada no estoque da quantidade de carga do produto menos o retorno
			$quantidade = $linha["carga"] - $linha["retorno"];

			if ($this->entrada($produto,$quantidade)) {
				return true;
			}else{
				return false;
			}
		}

	}

	// DETALHA O BALANCO
	protected function detalhes() {
		// PEGA DADOS DO BALANCO
		$balanco = $this->pegaDados("balancos", $_GET["var3"]);
		// PEGA DADOS DA VENDA
		$venda = $this->pegaVenda($_GET["var3"], $balanco["vendedor"]);
		$fiado = $this->pegaFiado($_GET["var3"], $balanco["vendedor"]);

		// VALOR TOTAL EM PRODUTOS DE IDA
		$ida = $this->view->ida;
		// VALOR TOTAL EM PRODUTOS DE VOLTA
		$volta = $this->view->volta;

		/// VALOR GERAL DA IDA COM FIADO
		$valorIda = $ida + $fiado["ida"];
		/// VALOR GERAL DA VOLTA COM FIADO E VALOR DA VENDA
		$valorVolta = $volta + $fiado["volta"] + $venda;

		//DIFERENCA É O VALOR DA VOLTA MENOS O VALOR DA IDA.
		// O NORMAL É A DIFERENCA >= 0
		$this->view->diferenca = $valorVolta - $valorIda;

		return $valorVolta - $valorIda;
	}

	protected function pegaVenda($idBalanco,$vendedor) {
		//Pega dados da venda

		// se nao tiver id ou vendedor retorna false
		if ($idBalanco!=true) {
			return false;
		}
		if ($vendedor!=true) {
			return false;
		}
		// Seleciona venda onde balanco e vendendor foram passados
		$query = "SELECT * FROM vendas WHERE balanco='".$idBalanco."' AND vendedor=".$vendedor."";
		$sql = $this->model->query($query);

		while ($linha = mysql_fetch_assoc($sql)) {
			// soma totais das vendas
			$total += $linha["total"];
		}

		$this->view->venda += $total;
		return $total;
	}

	
	protected function pegaFiado($idBalanco,$vendedor) {

		if ($idBalanco!=true) {
			return false;
		}
		if ($vendedor!=true) {
			return false;
		}

		$query = "SELECT * FROM fiados WHERE balanco='".$idBalanco."' AND vendedor=".$vendedor."";
		$sql = $this->model->query($query);



		while($linha = mysql_fetch_assoc($sql)){
			$ida +=$linha["ida"];
			$volta +=$linha["volta"];
		}

		$this->view->fiadoi = $ida;
		$this->view->fiadov = $volta;
		$fiado["ida"] = $ida;
		$fiado["volta"] = $volta;

		return $fiado;
	}

	protected function dados() {
		$var = explode("-", $_GET["var3"]);
		$produto = $this->pegaDados("produtos", $var[1]);

		if ($var[0]==false) {
			return false;
		}

		$valores_db = $this->model->query("SELECT * FROM produtosBalanco WHERE balanco=".$var[0]." AND produto=".$var[1]);
		$linha = mysql_fetch_assoc($valores_db);


		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);

		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i]	= $linha[$variaveis[$i]];
		}
		$this->view->produto = $produto["nome"];
	}


	protected function pega_estoque($id) {
		$query = "SELECT * FROM estoque WHERE produto=".$id;

		$result = $this->model->query($query);

		$linha = mysql_fetch_assoc($result);

		return $linha;
	}


	protected function pegaProduto($balanco, $id) {
		if ($balanco==false) {
			return false;
		}
		if ($id==false) {
			return false;
		}
		$query= "SELECT * FROM produtosBalanco WHERE balanco=".$balanco." AND produto=".$id;

		$sql = $this->model->query($query);

		$linha = mysql_fetch_assoc($sql);

		return $linha;
	}



	protected function atualizar() {
		// EXPLODE var3 =>
		//var[0] = id do balanco
		//var[1] = id do item
		$var = explode("-", $_GET["var3"]);

		$produto = $this->pegaProduto($var[0], $var[1]);



		if ($_POST["carga"]>$produto["carga"]) {

			$quantidade = $_POST["carga"] - $produto["carga"];

			$confirma = $this->pega_estoque($var[1]);

			if (($confirma["quantidade"]-$quantidade)>=0) {
				$this->saida($var[1],$quantidade)	;
			}else{
				$this->error("Quantidade insuficiente em Estoque");
				return false;
			}


		}else if ($_POST["carga"]<$produto["carga"]) {

			$quantidade =  $produto["carga"] - $_POST["carga"];
			$this->entrada($var[1],$quantidade);
		}

		$query = "UPDATE produtosBalanco SET carga=".$_POST["carga"]." WHERE balanco=".$var[0]." AND produto=".$var[1];

		if ($this->model->query ( $query )) {

			$this->Log("Atualiza��o no Balanco de id $var[0]; query($query)");

			header("Location: ".URL.$_GET["var1"]."/Carga/".$var[0]);
		}else{
			die(mysql_error());
		}


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

		$query = "SELECT * FROM balancos";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_assoc($valores_db)) {

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
			<td class='center'>".$linha["data"]."</td>
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Carga/".$linha["id"]."' title='Carga' class='tipS'>
			<img src='". Folder."images/icons/control/32/shipping.png' alt='' height='24' /> 
			</a> 
			<a href='".URL.$_GET["var1"]."/Retorno/".$linha["id"]."' title='Retorno' class='tipS'>
			<img src='". Folder."images/icons/control/32/refresh.png' alt='' height='24' />
			</a>
			<a href='".URL."Pdf/Balanco/".$linha["id"]."' title='Pdf' target='_blank' class='tipS'>
			<img src='". Folder."images/icons/control/new/pdf.png' alt='' height='24' />
			</a>
			</td>
			</tr>";

		}

		$this->view->lista = $lista;

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
	protected function listarBalanco() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM produtosBalanco WHERE balanco=".$_GET["var3"]." ORDER BY id ASC";

		$valores_db = $this->model->query($query);
		$letra = "B";

		$i=1;
		while ($linha = mysql_fetch_assoc($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$produto = $this->pegaDados("produtos", $linha["produto"]);

			$vendido = $linha["carga"] - $linha["retorno"];

			$custo += $produto["compra"] * $vendido;

			$lucro = ($produto["venda"]-$produto["compra"])*$vendido;

			$this->view->ida += $produto["venda"] * $linha["carga"];
			$this->view->volta += $produto["venda"] * $linha["retorno"];

			$this->view->estimativa = $this->view->ida - $this->view->volta;



			/*
			 pega e soma o peso das mercadorias
			 */

			 $this->view->pesoi += $produto["peso"]*$linha["carga"];
			 $this->view->pesov += $produto["peso"]*$linha["retorno"];

			/*
			 *
			 * */
			

			

			$this->view->levados += $linha["carga"];


			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".$i."</td>
			<td class='center'>".$linha["produto"]."</td>
			<td class='left'>".html_entity_decode($produto["nome"])." - ".$produto["quantidade"]."x1</td>
			<td class='center'>".number_format($produto["peso"], 2)." Kg</td>
			<td class='center'>R$ ".number_format($produto["venda"], 2,",",".")."</td>
			<td class='center'>".$linha["carga"]."</td>
			<td class='center'>".$linha["retorno"]."</td>
			<td class='center'>".$vendido."</td>
			<td class='center'>R$ ".number_format($lucro, 2)."</td>
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

		$this->lucro = $custo ;

		$this->view->lista = $lista;

	}



	private function vendedor(){

		$query = "SELECT * FROM funcionarios WHERE funcao=1";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_assoc($sql)){

			if (isset($this->view->vendedor) && $linha["id"]==$this->view->vendedor) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->vendedores = $lista;
	}



	protected function criarBalanco() {


		$cadastrar = $this->cadastrar_balanco();

		if ($cadastrar==true) {
			$query="SELECT * FROM balancos ORDER BY id DESC";
			$sql = $this->model->query($query);

			$linha = mysql_fetch_assoc($sql);

			$this->Log("Criou o Balanco de id ".$linha["id"]."");

			header("Location: ".URL.$_GET["var1"]."/Carga/".$linha["id"]);
		}
	}

	protected function cadastrar_balanco() {
		$query = "INSERT INTO balancos (vendedor,data,retorno) VALUES('".$_POST["vendedor"]."','".$_POST["data"]."','".$_POST["retorno"]."');";

		if ($this->model->query ( $query )) {
			$this->Log("Cadastrou o Balanco para ".$_POST["data"]." do vendedor de id ".$_POST["vendedor"]."");
			unset($_POST);

			return true;
		}else{
			die(mysql_error());
		}
	}

	protected function buscar() {

		$achados = array();


		$query = "SELECT * FROM produtos WHERE nome LIKE ('%".$_POST["produto"]."%') LIMIT 8";
		$sql = $this->model->query($query);
		while($linha = mysql_fetch_assoc($sql)){
			if ($this->verifica($linha["id"])) {

				array_push($achados, $linha["id"]);


				$html .= "
				<div style='padding:5px; border:3px #ccc double; width:25%;float:left;'>
				<form method='post' action=''>
				<span style='font-size:14px;'>".$linha["nome"]." - ".$linha["quantidade"]."x1</span><br>
				<span style='font-size:14px;'>R$ ".number_format($linha["venda"],2)."</span>
				<br>
				Quantidade: <input type='number' name='quantidade' step='0.1'  style='width: 100px'/>
				<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
				<input type='submit' id='submit' value=''
				style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' 
				/>
				</form>
				</div>";
			}else{

				$produto = $this->pegaProduto($_GET["var3"], $linha["id"]);

				array_push($achados, $linha["id"]);

				$html .= "
				<div style='padding:5px; border:3px #ccc double; width:25%;float:left;'>
				<form method='post' action=''>
				<span style='font-size:14px; color:red;'>Produto ".$linha['nome']." <br>".$produto["carga"]." J&aacute; adicionado! </span><br>

				<br>
				Acrescentar: <input type='number' name='quantidade'  style='width: 100px'/>
				<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
				<input type='hidden' name='acrescentar' value='1'  style='width: 100px'/>
				<input type='submit' id='submit' value=''
				style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' 
				/>
				</form>
				</div>";

			}

		}


		$nomeProd = explode(" ", $_POST["produto"]);

		foreach ($nomeProd as $value) {

			$query = "SELECT * FROM produtos WHERE nome LIKE ('%".$value."%') LIMIT 8";
			$sql = $this->model->query($query);
			while($linha = mysql_fetch_assoc($sql)){
				if (!$this->verifica($linha["id"]) && !in_array($linha["id"], $achados)) {

					array_push($achados, $linha["id"]);


					$dados = $this->pegaProduto($_GET["var3"], $linha["id"]);
					$html .= "
					<form method='post' action=''>
					<div style='padding:5px; border:3px #ccc double; width:25%;float:left;'><form method='post' action=''>
					<span style='font-size:14px;'>".$linha["nome"]." - ".$linha["quantidade"]."</span>
					<br>
					Carga : [ ".$dados["carga"]." ]
					<br>
					Quantidade: <input type='number' name='quantidade' step='0.1'  style='width: 100px'/>
					<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
					<input type='submit' id='submit' value=''
					style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' 
					/>
					</div>
					</form>";

				}

			}
		}
		if ($html==false) {
			$html = "Nenhum produto encontrado!";
		}

		echo $html;
	}

	protected function buscarRetorno() {

		$achados = array();

		$query = "SELECT * FROM produtos WHERE nome LIKE ('%".$_POST["produto"]."%') LIMIT 8";
		$sql = $this->model->query($query);
		while($linha = mysql_fetch_assoc($sql)){
			if (!$this->verifica($linha["id"])) {

				array_push($achados, $linha["id"]);
				$dados = $this->pegaProduto($_GET["var3"], $linha["id"]);
				$html .= "
				<form method='post' action=''>
				<div style='padding:5px; border:3px #ccc double; width:25%;float:left;'><form method='post' action=''>
				<span style='font-size:14px;'>".$linha["nome"]." - ".$linha["quantidade"]."</span>
				<br>
				Carga : [ ".$dados["carga"]." ]
				<br>
				Quantidade: <input type='number' name='quantidade' step='0.1'  style='width: 100px'/>
				<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
				<input type='submit' id='submit' value=''
				style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' 
				/>
				</div>
				</form>";

			}

		}


		$nomeProd = explode(" ", $_POST["produto"]);

		foreach ($nomeProd as $value) {

			$query = "SELECT * FROM produtos WHERE nome LIKE ('%".$value."%') LIMIT 8";
			$sql = $this->model->query($query);
			while($linha = mysql_fetch_assoc($sql)){
				if (!$this->verifica($linha["id"]) && !in_array($linha["id"], $achados)) {

					array_push($achados, $linha["id"]);


					$dados = $this->pegaProduto($_GET["var3"], $linha["id"]);
					$html .= "
					<form method='post' action=''>
					<div style='padding:5px; border:3px #ccc double; width:25%;float:left;'><form method='post' action=''>
					<span style='font-size:14px;'>".$linha["nome"]." - ".$linha["quantidade"]."</span>
					<br>
					Carga : [ ".$dados["carga"]." ]
					<br>
					Quantidade: <input type='number' name='quantidade' step='0.1'  style='width: 100px'/>
					<input type='hidden' name='produto' value='".$linha["id"]."'  style='width: 100px'/>
					<input type='submit' id='submit' value=''
					style='background:url(\"". Folder."images/icons/control/32/plus.png\") no-repeat; height:100px; border:none;' 
					/>
					</div>
					</form>";

				}

			}
		}

		if ($html==false) {
			$html = "Nenhum produto encontrado na carga!";
		}

		echo $html;


	}

	protected function verifica($id) {
		$query = "SELECT * FROM produtosBalanco WHERE balanco=".$_GET["var3"]." AND produto=".$id;

		$sql = $this->model->query($query);

		$linha = mysql_fetch_assoc($sql);
		if ($linha==true) {
			return false;
		}else{
			return true;
		}
	}

	protected function add() {


		$query = "INSERT INTO produtosBalanco (balanco,produto,carga)VALUES(".$_GET["var3"].",".$_POST["produto"].",".$_POST["quantidade"].")";

		if ($this->saida($_POST["produto"],$_POST["quantidade"])) {

			if ($this->model->query ( $query )) {

				$produto = $this->pegaDados("produtos",$_POST["produto"]);
				$this->error("Adicionou ".$_POST["quantidade"]." do produto ".html_entity_decode($produto["nome"])." no Balanco ".$_GET["var3"]);
				unset($_POST);

				return true;
			}else{
				die(mysql_error());
			}
		}
	}


	protected function retorno() {


		$query = "UPDATE produtosBalanco  SET retorno=".$_POST["quantidade"]." WHERE balanco=".$_GET["var3"]." AND produto=".$_POST["produto"];

		if($this->validar()){


			if ($this->model->query ( $query )) {

				$produto = $this->pegaDados("produtos",$_POST["produto"]);
				$this->error("Adicionou ".$_POST["quantidade"]." do produto ".html_entity_decode($produto["nome"])." de Retorno no Balanco ".$_GET["var3"]);

				header("Location: ".URL.$_GET["var1"]."/Retorno/".$_GET["var3"]);
			}else{
				die(mysql_error());
			}

		}
	}

	protected function validar() {
		$produto = $this->pegaProduto($_GET["var3"], $_POST["produto"]);

		$nome = $this->pegaDados("produtos", $_POST["produto"]);

		if ($produto["carga"]<$_POST["quantidade"]) {
			$this->error($nome["nome"]." teve ".$produto["carga"]." de carga. N&atilde;o pode retornar mais do que foi!");
			return false;
		}else{
			//$this->entrada($_POST["produto"],$_POST["quantidade"]);
			return true;
		}

		/*

			elseif ($produto["retorno"]!=0){

			$quantidade = ($_POST["quantidade"]) - ($produto["retorno"]);

			if ($_POST["quantidade"]<$produto["retorno"]) {
				$quantidade = -($quantidade);
				//$this->saida($_POST["produto"],$quantidade);
			}else{
				//$this->entrada($_POST["produto"],$quantidade);
			}

			return true;

		}
		*/
	}

	protected function entrada($item=false,$quantidade=false) {


		$produto = $this->pega_estoque($item);
		$final = $produto["quantidade"] + $quantidade;

		$query = "UPDATE estoque SET quantidade=".$final." WHERE produto=".$item;
		$sql = $this->model->query($query);

		$dados = $this->pegaDados("produtos",$item);

		$this->Log("Deu entrada de ".$quantidade." do produto ".$item." ('".htmlentities($dados["nome"])."') no estoque.");

		return true;
		
	}

	protected function saida($item=false,$quantidade=false) {




		$produto = $this->pega_estoque($item);
		$final = $produto["quantidade"] - $quantidade;


		$confirma = $this->pega_estoque($item);

		if (($confirma["quantidade"]-$final)>=0) {
			$query = "UPDATE estoque SET quantidade=".$final." WHERE produto=".$item;
			$sql = $this->model->query($query);

			$dados = $this->pegaDados("produtos",$item);

			$this->Log("Deu saida de ".$quantidade." do produto ".$item." ('".htmlentities($dados["nome"])."') no estoque.");


			return true;
		}else{
			$this->error("Quantidade insuficiente em Estoque");
			return false;
		}

	}




	protected function dados_balanco($balanco,$vendedor,$detalhes) {
		$data = $this->pegaDados("balancos", $balanco);

		$venda = $this->pegaVenda($balanco, $vendedor["id"]);
		$fiado = $this->pegaFiado($balanco, $vendedor["id"]);

		$valorIda = $detalhes["ida"]+$fiado["ida"];
		$valorVolta = $detalhes["volta"] + $fiado["volta"] + $venda;

		$diferenca = $valorVolta - $valorIda;

		if ($diferenca<0) {
			return $diferenca;
		}else{
			return 0;
		}



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




	protected function puxar() {

		$id_balanco = $this->pega_detalhes_puxar();

		$query = "SELECT * FROM produtosBalanco WHERE  balanco=".$id_balanco." AND retorno>0";
		$sql = $this->model->query($query);

		while($linha=mysql_fetch_assoc($sql)){

			if (!$this->verifica($linha["produto"])) {

				$this->update($linha["produto"], $linha["retorno"]);

				$atualizado++;
			}else{

				$this->adiciona($linha["produto"], $linha["retorno"]);
				$adicionados++;
			}

		}

		$this->error ("$atualizado produtos foram atualizados e $adicionados foram adicionados ao balan&ccedil;o");



	}

	protected function UnPuxar() {

		$id_balanco = $this->pega_detalhes_puxar();

		$query = "SELECT * FROM  produtosBalanco WHERE  balanco=".$id_balanco." AND retorno>0s";
		$sql = $this->model->query($query);

		while($linha=mysql_fetch_assoc($sql)){
			
			$this->update($linha["produto"], $linha["retorno"],true);

			$atualizado++;
			

		}

		$this->error ("$atualizado produtos foram atualizados e $adicionados foram adicionados ao balan&ccedil;o");



	}




	protected function adiciona($produto,$quantidade) {

		$query = "INSERT INTO produtosBalanco (balanco,produto,carga)VALUES(".$_GET["var3"].",".$produto.",".$quantidade.")";

		if ($this->model->query ($query)) {

			$produtos = $this->pegaDados("produtos",$produto);
			$this->error("Adicionou ".$quantidade." do produto ".html_entity_decode($produtos["nome"])." no Balanco ".$_GET["var3"]);
			

			return true;
		}else{
			die(mysql_error());
		}

	}




	protected function pega_detalhes_puxar($id=false) {
		if ($id==false) {
			$id = $_GET["var3"];
		}

		$balanco = $this->pegaDados("balancos", $id);


		if ($balanco["retorno"]==0) {
			header("Location: ".URL.$_GET["var1"]."/Puxar/".$id);
		}else{

			$query = "SELECT * FROM balancos WHERE data='".$balanco["retorno"]."' AND vendedor=".$balanco["vendedor"];

			$result = $this->model->query($query);

			$query = mysql_fetch_assoc($result);


			return $query["id"];

		}
	}

	protected function pega_detalhes_data($data,$vendedor) {

		$query = "SELECT * FROM balancos WHERE data='".$data."' AND vendedor=".$vendedor;

		$result = $this->model->query($query);

		$linha = mysql_fetch_assoc($result);


		return $linha["id"];


	}



	protected function update($produto,$quantidade,$desfazer=false) {

		if ($desfazer==false) {


			$anterior = $this->pegaProduto($_GET["var3"], $produto);


			$quantidades = $quantidade + $anterior["carga"];

			$query = "UPDATE produtosBalanco  SET carga=".$quantidades." WHERE balanco=".$_GET["var3"]." AND produto=".$produto;

			if ($this->model->query ( $query )) {

				$produtos = $this->pegaDados("produtos",$produto);
				$this->error("Adicionou $quantidade no produto ".html_entity_decode($produtos["nome"])." no Balanco ".$_GET["var3"].". Total de $quantidades ");

				return true;

			}else{

				die(mysql_error());

			}


		}else{



			$anterior = $this->pegaProduto($_GET["var3"], $produto);

			$quantidades = $anterior["carga"] - $quantidade;

			$query = "UPDATE produtosBalanco SET carga=".$quantidades." WHERE balanco=".$_GET["var3"]." AND produto=".$produto;

			if ($this->model->query ( $query )) {

				$produtos = $this->pegaDados("produtos",$produto);
				$this->error("Retirou $quantidade no produto ".html_entity_decode($produtos["nome"])." no Balanco ".$_GET["var3"].". Total de $quantidades ");

				return true;

			}else{

				die(mysql_error());

			}

		}

		

	}


}