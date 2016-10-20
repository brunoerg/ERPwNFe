<?php
class VencimentosController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		switch ($_GET["var2"]) {
			case "Adicionar":

			if ($_POST["cedente"]) {

				$this->cadastrar("vencimentos");

			}
			$this->view->render ( 'vencimentos/novo' );
			break;

			case "Editar":

			if ($_POST["cedente"]) {
				$this->editar($_GET["var3"],"vencimentos");
			}

			$this->pegaId("vencimentos",$_GET["var3"]);
			$this->view->render ( 'vencimentos/novo' );
			break;

			case "Juros":
			if ($_POST["ignorar"]) {
				unset($_POST["ignorar"]);
				$_POST["pago"]  = 1;
				$this->editar($_GET["var3"],"vencimentos",false);
				header("Location: ".URL."Index");
			}elseif ($_POST["valor"]) {
				$this->juros();
			}

			$this->view->render ( 'vencimentos/juros' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "vencimentos");

			$this->listar();

				//Futuramente criar lista com os vencimentos
				//$this->view->pdf = $this->pdf();
			$this->view->render ( 'vencimentos/index' );
			break;

			case "Pago":

			$this->ativar($_GET["var3"], "vencimentos");
			//$this->pagar();

			echo "Pago com Sucesso!";
			//$this->listar();


			//$this->view->render ( 'vencimentos/index' );
			break;

			case "Aberto":


			$this->desativar($_GET["var3"], "vencimentos");

			$this->listar();

			$this->view->render ( 'vencimentos/index' );
			break;

			default:

			$this->listar();
			$this->view->render ( 'vencimentos/index' );
			break;
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
		//$valores_db = mysql_query();

		$query = "SELECT * FROM vencimentos";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".htmlspecialchars($linha["cedente"])."</td>
			<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
			<td class='center'>".$linha["vencimento"]."</td>
			<td class='center'>
			";
			if ($linha["pago"]!=0) {
				$lista.= "
				<a href='".URL.$_GET["var1"]."/Aberto/".$linha["id"]."' title='Aberto' class='tipS'>
				<img src='". Folder."images/icons/control/16/check.png' alt='' /> 
				</a>";
			}else{
				$lista.= "
				<a href='".URL.$_GET["var1"]."/Pago/".$linha["id"]."' title='Pago' class='tipS'>
				<img src='". Folder."images/icons/control/16/busy.png' alt='' /> 
				</a>";
			}

			$lista.= "</td>
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'><img
			src='". Folder."images/icons/control/16/pencil.png'
			alt='' /> </a> <a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'><img
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
	 * FUNCAO PEGA ID - PEGA NOTICIA CADASTRADA NO BANCO BANCO
	 *
	 *
	 *
	 */
	protected function pegaId($tabela,$id) {


		$valores_db = $this->model->query("SELECT * FROM `".$tabela."` WHERE id=".$id);
		$linha = mysql_fetch_array($valores_db);


		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);


		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i]	= $linha[$variaveis[$i]];
		}
		if ($linha["fornecedor"]==1) {
			$this->view->fornecedor="checked";
		}

	}

	protected function pagar(){
		$dadosVencimento = $this->pegaDados("vencimentos",$_GET["var3"]);
		

		if ($dadosVencimento["vencimento"]!=date("d-m-Y")) {
			$dataPagamento = array(date("d"),date("m"),date("Y"));
			$dataVencimento = explode("-", $dadosVencimento["vencimento"]);

			if (date("w",mktime(0, 0, 0, $dataVencimento[1], $dataVencimento[0], $dataVencimento[2]))==6) {


				$dataTeste = implode("-", $dataPagamento);
				

				if (date("d-m-Y",mktime(0, 0, 0, $dataVencimento[1], $dataVencimento[0]+2, $dataVencimento[2]))==$dataTeste) {
					$this->ativar($_GET["var3"], "vencimentos");
				}elseif (date("d-m-Y",mktime(0, 0, 0, $dataVencimento[1], $dataVencimento[0]+1, $dataVencimento[2]))==$dataTeste) {
					$this->ativar($_GET["var3"], "vencimentos");
				}else{
					header("Location: ".URL."Vencimentos/Juros/".$_GET["var3"]);
				}


			}elseif (date("w",mktime(0, 0, 0, $dataVencimento[1], $dataVencimento[0], $dataVencimento[2]))==0) {

				$dataTeste = implode("-", $dataPagamento);

				if (date("d-m-Y",mktime(0, 0, 0, $dataVencimento[1], $dataVencimento[0]+1, $dataVencimento[2]))==$dataTeste) {
					$this->ativar($_GET["var3"], "vencimentos");
				}else{
					header("Location: ".URL."Vencimentos/Juros/".$_GET["var3"]);
				}


			}else{

				header("Location: ".URL."Vencimentos/Juros/".$_GET["var3"]);

			}
		}else{
			$this->ativar($_GET["var3"], "vencimentos");
		}

	}

	protected function juros(){

		$_POST["titulo"] = "Juros referente ao pagamento do Vencimento de ID ".$_GET["var3"];
		$_POST["data"] = date("d-m-Y");
		$_POST["tipo"] = 3;
		$_POST["pagamento"] = 0;
		$juros = $_POST["valor"];
		if($this->cadastrar("despesas")){
			$dadosVencimento = $this->pegaDados("vencimentos",$_GET["var3"]);
			$_POST["valor"] = $juros+$dadosVencimento["valor"];
			$_POST["pago"]  = 1;
			$this->editar($_GET["var3"],"vencimentos");
		}
	}


}