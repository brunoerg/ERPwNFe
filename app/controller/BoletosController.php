<?php
class BoletosController extends Controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
		switch ($_GET["var2"]) {

			

			case "Adicionar" :
			if ($_POST["cliente"]) {
				unset($_POST["idCliente"]);
				if($this->cadastrar("boletos")){
					$number = $this->pega_numero();

					header("Location: ".URL."Pdf/Boleto/".$number);
				}else{
					$this->info("Erro ao cadastrar o Boleto");
				}

			}

			$this->view->render('boletos/novo');
			break;

			case "Editar" :
			if (isset($_POST["emissao"])) {
				unset($_POST["idCliente"]);
				$this->editar($_GET["var3"], "boletos");
			}

			$this->pegaId("boletos", $_GET["var3"]);

			$this->view->render('boletos/novo');
			break;

			case "Pago" :
			$this->pagar();

			$this->listar();

			$this->view->render('boletos/index');
			break;

			case "Aberto" :
			$this->desativar($_GET["var3"], "boletos");

			$this->listar();

			$this->view->render('boletos/index');
			break;

			case "Deletar" :
			$this->deletar($_GET["var3"], "boletos");

			$this->listar();

				//Futuramente criar lista com os boletos
				//$this->view->pdf = $this->pdf();
			$this->view->render('boletos/index');
			break;

			default :
			$this->listar();
			$this->view->render('boletos/index');
			break;
		}
	}

	private function bancos() {

		$query = "SELECT * FROM bancos ORDER BY nome";

		$sql = $this->model->query($query);

		while ($linha = mysql_fetch_array($sql)) {

			if (isset($this->view->banco) && $linha["id"] == $this->view->banco) {
				$lista .= "<option value='" . $linha["id"] . "' selected>" . $linha["nome"] . "</option>";
			} else {
				$lista .= "<option value='" . $linha["id"] . "'>" . $linha["nome"] . "</option>";
			}
		}

		$this->view->vendedores = $lista;
	}

	protected function pega_numero(){

		$query="SELECT * FROM boletos ORDER BY id DESC";
		$sql = $this->model->query($query);

		$linha = mysql_fetch_array($sql);
		return $linha["id"];
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

		$lista = "";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM boletos";

		$valores_db = $this->model->query($query);
		$letra = "B";

		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra == "B") {
				$letra = "A";
			} elseif ($letra == "A") {
				$letra = "B";
			}

			$cliente = $this->pegaDados("clientes", $linha["cliente"]);

			$lista .= "

			<tr class='grade" . $letra . "'>
			<td class='center'>" . $linha["id"] . "</td>
			<td class='center'><a href='".URL."Clientes/Relatorio/".$cliente["id"]."' target='_blank'>" . (htmlspecialchars($cliente["nome"])) . "</a></td>
			<td class='center'>R$ " . number_format($linha["valor"], 2) . "</td>
			<td class='center'>" . $linha["emissao"] . "</td>
			<td class='center'>" . $linha["vencimento"] . "</td>
			<td class='center'>
			<a href='" . URL . "Pdf/Boleto/" . $linha["id"] . "' target='_blank' title='Imprimir' class='tipS'><img
			src='" . Folder . "images/icons/control/16/print.png'
			alt='' /> </a></td>
			<td class='center'>
			";
			if ($linha["pago"] != 0) {
				$lista .= "
				<a href='" . URL . $_GET["var1"] . "/Aberto/" . $linha["id"] . "' title='Aberto' class='tipS'>
				<img src='" . Folder . "images/icons/control/16/check.png' alt='' /> 
				</a>";
			} else {
				$lista .= "
				<a href='" . URL . $_GET["var1"] . "/Pago/" . $linha["id"] . "' title='Pago' class='tipS'>
				<img src='" . Folder . "images/icons/control/16/busy.png' alt='' /> 
				</a>";
			}

			$lista .= "</td>
			<td class='actBtns'>
			<a href='" . URL . $_GET["var1"] . "/Editar/" . $linha["id"] . "' title='Editar' class='tipS'><img
			src='" . Folder . "images/icons/control/16/pencil.png'
			alt='' /> </a> <a href='" . URL . $_GET["var1"] . "/Deletar/" . $linha["id"] . "' title='Deletar' class='tipS'><img
			src='" . Folder . "images/icons/control/16/clear.png' alt='' />
			</a>
			</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}

	

	protected function pagar(){
		$_POST["titulo"] = "Serviço Cobrança Banco do Brasil referente ao boleto de ID ".$_GET["var3"];
		$_POST["valor"] = 3.18;
		$_POST["data"] = date("d-m-Y");
		$_POST["tipo"] = 3;
		$_POST["pagamento"] = 5;

		

		if($this->cadastrar("despesas")){

			$this->updateBoleto($_GET["var3"]);

			$this->ativar($_GET["var3"], "boletos");
		}	
		
	}

	
	protected function updateBoleto($boleto){
		$query = "UPDATE boletos SET vencimento='".date("d-m-Y")."' WHERE id=".$boleto;
		if($this->model->query($query)){
			return true;
		}else{
			die("Erro em atualizar o boleto em Boletos");
		}

	}
	

}
