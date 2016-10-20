<?php

/*
 *
 * CLASSE AVULSASCONTROLLER
 *
 * @author Wilker J. Ferreira Adorno <wwdotk@gmail.com>
 * @version 5 BETA
 * @access public
 * @class AvulsasController -> Controle para pagina de Notas Avulsas
 *
 *
 *
 */ 



class AvulsasController extends Controller {

	
	function __construct() {


		parent::__construct ();	
	}


	/// FUNCAO INDEX CHAMA FUNCOES NECESSARIAS
	function index() {
		// DIRECIONA AS FUNCOES DEPENDEDNO DO VALOR DAS VARIAVEL GET var2
		switch ($_GET["var2"]) {


			// Cadastrar nova nota avulsa
			case "Cadastrar":
			

			// Se tiver post id ele chama funcao cadastrar
			if (isset($_POST["id"])) {
				$this->cadastrar("nfavulsas",$_GET["var3"]);
			}

			
			// Chama o view para renderizar a pagina app/view/avulsas/cadastrar.php
			$this->view->render ( 'avulsas/cadastrar' );

			break;

			// Editar nota avulsa
			case "Editar":
			

			// Se preenchido o input valor chama funcao editar
			if (isset($_POST["valor"])) {
				$this->editar($_GET["var3"],"nfavulsas",false);
				header("Location: ".URL."Avulsas");
			}

			// Chama funcao PegaId(tabela,id) para listar os dados do item
			$this->PegaId("nfavulsas",$_GET["var3"]);

			// Chama o view para renderizar a pagina app/view/avulsas/cadastrar.php
			$this->view->render ( 'avulsas/cadastrar' );

			break;


			// Deletar nota avulsa
			case "Deletar":

			$query = "DELETE FROM nfavulsas WHERE id=".$_GET["var3"];

			if ($this->model->query ( $query )) {
				header("Location: ".URL."Avulsas");
			}else{
				die(mysql_error());
			}

			break;


			// SE NENHUMA DAS ANTERIORES OU NENHUMA VAR2 COLOCADO CHAMA INDEX
			default:
			// Chama funcao para listar dados do banco;
			$this->listar();
			// Chama o view para renderizar a pagina app/view/avulsas/index.php
			$this->view->render ( 'avulsas/index' );
			break;
		}

	}


	/// FUNCAO LISTAR
	protected function listar() {

		$lista="";
		/// SELECIONA TODOS OS CAMPOS DE TODAS AS LINHAS DA TABELA PARA LISTAR
		$query = "SELECT * FROM nfavulsas";
		// CHAMA FUNCAO QUERY DA CLASSE MODEL
		$valores_db = $this->model->query($query);

		// DEFINE LETRA INICIAL PARA VARIACAO DE ESTILO NAS LINHAS
		$letra = "B";

		// ENQUANTO RETORNAR RESULTADO ELE ADICIONA LINHAS A VARIAVEL LISTA
		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$lista.= "

			<tr class='grade".$letra."'>
			<td class='center'>".$linha["id"]."</td>
			<td class='center'>".$linha["data"]."</td>
			<td class='center'>R$ ".number_format($linha["valor"],2)."</td>
			<td class='actBtns'>
			<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
			<img src='". Folder."images/icons/control/16/pencil.png' alt=''/> 
			</a> 
			<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
			<img src='". Folder."images/icons/control/16/clear.png' alt=''/>
			</a>
			</td>
			</tr>";

		}
		// coloca a lista na variavel view->lista
		$this->view->lista = $lista;

	}
}