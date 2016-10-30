<?php
class EstoqueController extends Controller {
	function __construct() {
		parent::__construct ();

		$this->total = 0;
	}

	function index() {
		switch ($_GET["var2"]) {
			case "Entrada":

			if (isset($_POST["quantidade"])) {
				$this->entrada();
			}

			$this->dados();
			$this->view->render ( 'estoque/entrada' );
			break;

			case "Saida":

			if (isset($_POST["quantidade"])) {
				$this->saida();
			}

			$this->dados();
			$this->view->render ( 'estoque/saida' );
			break;


			default:
			$this->atualizar();
			$this->listar();
			$this->view->total = $this->total;
			$this->view->render ( 'estoque/index' );
			break;

		}

	}

	protected function atualizar() {
		$query = "SELECT * FROM produtos";
		$sql = $this->model->query($query);

		while($linha=mysql_fetch_array($sql)){

			$qery = "SELECT * FROM estoque WHERE produto=".$linha["id"];
			$result = $this->model->query($qery);
			$row = mysql_fetch_array($result);
			if (!$row["produto"]) {
				$this->entrada_estoque($linha["id"]);
			}

		}

	}

	protected function entrada_estoque($produto) {
		$query = "INSERT INTO estoque (produto,quantidade) VALUES(".$produto.", 0);";

		if ($this->model->query($query)) {
			return true;
		}else{
			return false;
		}

	}

	protected function dados() {

		$query = "SELECT * FROM estoque WHERE produto=".$_GET["var3"];

		$valores_db = $this->model->query($query);


		$linha = mysql_fetch_array($valores_db);

		$produto = $this->pegaDados("produtos",$_GET["var3"]);

		$this->view->nome = $produto["nome"]." - ".$produto["quantidade"]."x1";
		$this->view->quantidade = number_format($linha["quantidade"]);
	}

	protected function entrada() {
		$query = "SELECT * FROM estoque WHERE produto=".$_GET["var3"];

		$valores_db = $this->model->query($query);

		

		$linha = mysql_fetch_array($valores_db);

		$quantidade = $linha["quantidade"] + $_POST["quantidade"];

		$query = "UPDATE estoque SET quantidade=".$quantidade." WHERE produto=".$_GET["var3"];

		if ($this->model->query ( $query )) {
			$produto = $this->pegaDados("produtos",$_GET["var3"]);

			$this->Log("Deu entrada de ".$_POST["quantidade"]." do produto ".$_GET["var3"]." ('".htmlentities($produto["nome"])."') no estoque.");

			unset($_POST);
			header("Location: ".URL.$_GET["var1"]);
		}else{
			die(mysql_error());
		}

	}

	protected function saida() {
		$query = "SELECT * FROM estoque WHERE produto=".$_GET["var3"];

		$valores_db = $this->model->query($query);


		$linha = mysql_fetch_array($valores_db);

		$quantidade = $linha["quantidade"]-$_POST["quantidade"];

		if ($quantidade>=0) {

			$query = "UPDATE estoque SET quantidade=".$quantidade." WHERE produto=".$_GET["var3"];

			if ($this->model->query ( $query )) {
				
				$produto = $this->pegaDados("produtos",$_GET["var3"]);


				$this->Log("Deu saida de ".$_POST["quantidade"]." do produto ".$_GET["var3"]." ('".htmlentities($produto["nome"])."') no estoque.");

				unset($_POST);
				header("Location: ".URL.$_GET["var1"]);
			}else{
				die(mysql_error());
			}
			;
		}else{
			$this->error("Quantidade insuficiente em Estoque");
			return false;
		}

	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA estoque NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM estoque";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {




			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$produto = $this->pegaDados("produtos", $linha["produto"]);

			if ($produto==true) {


				$valor = $linha["quantidade"] * $produto["compra"];
				$this->total += $valor;
				$lista.= "

				<tr class='grade".$letra."'>
				<td class='center'>".$produto["id"]."</td>
				<td class='center'>".$produto["nome"]." - ".$produto["quantidade"]."x1</td>
				<td class='center'>".number_format($linha["quantidade"],2,",",".")."</td>
				<td class='center'>R$ ".number_format($valor,2,",",".")."</td>
				<td class='actBtns'>
				<a href='".URL.$_GET["var1"]."/Entrada/".$produto["id"]."' title='Entrada' class='tipS'><img
				src='". Folder."images/icons/control/16/sign-in.png'
				alt='' /> </a> <a href='".URL.$_GET["var1"]."/Saida/".$produto["id"]."' title='Saida' class='tipS'><img
				src='". Folder."images/icons/control/16/sign-out.png' alt='' />
				</a>
				</td>
				</tr>";
			}else{

				$this->deletar($linha["id"],"estoque");
			}
		}

		$this->view->lista = $lista;

	}



	protected function pega_estoque($id) {
		$query = "SELECT * FROM estoque WHERE produto=".$id;

		$result = $this->model->query($query);

		$linha = mysql_fetch_array($result);

		return $linha;
	}



}