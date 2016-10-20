<?php
class CatalogoController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		switch ($_GET["var2"]) {
			case "Adicionar":

				if (isset($_POST["nome"])) {
					$this->cadastrar("produtos");
				}
				$this->distribuidor();
				$this->view->render ( 'catalogo/novo' );
				break;

			case "Editar":

				if (isset($_POST["nome"])) {
					$this->editar($_GET["var3"],"produtos");
				}

				$this->pegaId("produtos",$_GET["var3"]);
				$this->distribuidor();
				$this->view->render ( 'catalogo/novo' );
				break;

			case "Deletar":

				$this->deletar($_GET["var3"], "produtos");

				$this->listar();
				$this->view->pdf = $this->pdf();
				$this->view->pdf2 = $this->pdfp();
				$this->view->render ( 'catalogo/index' );
				break;

					
					
			default:
				$this->listar();
				
				$this->view->render ( 'catalogo/index' );
				break;
		}

	}

	private function distribuidor(){

		$query = "SELECT * FROM fornecedores ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->distribuidor) && $linha["id"]==$this->view->distribuidor) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->distribuidor = $lista;
	}





	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA catalogo NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM produtos";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$lucro = ($linha["venda"]-$linha["compra"])/$linha["venda"];

			$lucro = $lucro * 100;

			$distribuidor = $this->pegaDados("fornecedores", $linha["distribuidor"]);
			$lista.= "
		
			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
				<td class='left'>".$linha["nome"]." - ".$linha["quantidade"]."x1</td>
                <td class='center'>".$distribuidor["nome"]."</td>
                <td class='center'>".number_format($linha["peso"],2)." Kg</td>
                <td class='center'>R$ ".number_format($linha["compra"],2)."</td>
				<td class='center'>R$ ".number_format($linha["venda"],2)."</td>
				<td class='center'>".number_format($lucro,2)."%</td>
				<td class='actBtns'>
				<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'><img
						src='". Folder."images/icons/control/16/pencil.png'
						alt='' /> </a> <a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Excluir' class='tipS'><img
						src='". Folder."images/icons/control/16/clear.png' alt='' />
				</a>
				</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}





	/*
	 *
	 *
	 *  FUNCAO CADASTRAR - CADASTRA NOTICIAS NO BANCO
	 *
	 *
	 * */
	protected function cadastrar($tabela) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}
		if($_POST["data"]){
			$_POST["data"].=", ".date('H:i:s');
		}

		//$_POST["ativo"] = 0;

		$campos = array_keys ( $_POST );
		$quant = count ( $campos );
		$quant = ($quant - 1);
		$query = "INSERT INTO ";
		$query .= "`" . $tabela . "` (";
		for($i = 0; $i < $quant; $i ++) {
			$query .= "`" . $campos [$i] . "`,";
		}
		$query .= "`" . $campos [$quant] . "`) VALUES (";
		for($i = 0; $i < $quant; $i ++) {
			$camp = $campos [$i];
			$query .= "'" . $this->string->preparar($_POST [$camp]) . "',";
		}
		$camp = $campos [$i];
		$query .= "'" . $this->string->preparar($_POST [$camp]) . "')";
		//$query .= ";";

		if ($this->model->query ( $query )) {

			if($this->entrada_estoque()){

				$this->Log("Cadastro na tabela $tabela; query($query)");


				unset($_POST);
				header("Location: ".URL.$_GET["var1"]);
			}
		}else{
			die(mysql_error());
		}


	}

	protected function entrada_estoque() {
		$produto = $this->pega_produto("produtos", $_POST["nome"], $_POST["quantidade"]);
		$query = "INSERT INTO estoque (produto,quantidade) VALUES(".$produto["id"].", 0);";

		if ($this->model->query($query)) {
			return true;
		}else{
			return false;
		}

	}

	protected function pega_produto($tabela,$id,$quantidade) {
		$query = "SELECT * FROM ".$tabela." WHERE nome='".$id."' AND quantidade=".$quantidade."";

		$result = $this->model->query($query);

		$linha = mysql_fetch_array($result);

		return $linha;
	}




}