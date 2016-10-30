<?php
class MunicipiosController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		switch ($_GET["var2"]) {
			case "Adicionar":

			if (isset($_POST["codigo"])) {

				$this->cadastrar("municipios");

			}
			$this->view->render ( 'municipios/novo' );
			break;

			case "Editar":

			if (isset($_POST["codigo"])) {
				$this->editar($_GET["var3"],"municipios");
			}

			$this->pegaIdCodigo("municipios",$_GET["var3"]);
			$this->view->render ( 'municipios/novo' );
			break;


			case "Deletar":

			$this->deletar($_GET["var3"], "municipios");

			$this->listar();


			$this->view->render ( 'municipios/index' );


			break;

			case "Pesquisar":

			$this->buscaMunicipio();
			break;

			default:

			$this->listar();
			$this->view->render ( 'municipios/index' );
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

		$query = "SELECT * FROM municipios";

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
				<td class='center'>".$linha["codigo"]."</td>
				<td class='center'>".ucwords(strtolower(htmlspecialchars(utf8_encode($linha["nome"]))))."</td>
				<td class='center'><a href='".URL."Rotas/Detalhes/".$linha["rota"]."'>".($linha["rota"])."</a></td>
				<td class='actBtns'>
					<a href='".URL.$_GET["var1"]."/Editar/".$linha["codigo"]."' title='Editar' class='tipS'>
						<img src='". Folder."images/icons/control/16/pencil.png' alt='' /> 
					</a> 
					<a href='".URL.$_GET["var1"]."/Deletar/".$linha["codigo"]."' title='Deletar' class='tipS'>
						<img src='". Folder."images/icons/control/16/clear.png' alt='' />
					</a>
				</td>
			</tr>";

		}

		$this->view->lista = $lista;

	}

/*
	 *
	 *
	 * FUNCAO EDITAR - EDITA NOTICIAS CADASTRADAS NO BANCO BANCO
	 *
	 *
	 *
	 */
protected function editar($id, $tabela = false) {

	if (!$tabela) {
		$tabela = $_GET["var1"];
	}

	$campos = array_keys($_POST);
	$quant = count($campos);
	$quant = ($quant - 1);
	$query = "UPDATE ";
	$query .= "`" . $tabela . "` ";
	$query .= "SET ";
	for ($i = 0; $i < $quant; $i++) {
		$camp = $campos[$i];
		$query .= "`$campos[$i]`= '" . $this -> string -> preparar($_POST[$camp]) . "',";
	}
	$camp = $campos[$quant];
	$query .= "`$campos[$quant]`= '" . $this -> string -> preparar($_POST[$camp]) . "' ";
	$query .= "WHERE codigo=" . $id . "";
		//$query .= ";";
		//$query = "UPDATE `Noticias` SET `titulo_br`='Wilker' Where id = 1"; //  LINHA DE TESTE

		//$this->error($query);

	if ($this -> model -> query($query)) {

		$this -> Log("Alteracao na tabela $tabela na id=$id; query($query)");

		unset($_POST);
		header("Location: " . URL . $_GET["var1"]);
	} else {
		die(mysql_error());
	}

}


protected function buscaMunicipio(){

	  //// LINK PARA PESQUISA DE MUNICIPIOS
	  //////  $_POST['cidade'] É PASSADA POR AJAX OU FORMULARIO
	$url = "http://www.ibge.gov.br/home/geociencias/areaterritorial/area.php?nome=".$_POST["cidade"];

	  ////EXECUTA A URL
	$cURL = curl_init($url);
	curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);

	  /// $resultado  PEGA O HTML DA PAGINA COM OS RESULTADOS DA BUSCA
	$resultado = curl_exec($cURL);

	  ///// FECHA CONEXAO
	curl_close($cURL);


	  ////// $html DIVIDE A PAGINA EM DUAS E COLOCA EM UM ARRAY
	$html = explode("<p><b>Resultados</b></p>", $resultado);
	  //// EXCLUI A PRIMEIRA PARTE DO HTML, TUDO ANTES DA PARTE DOS RESULTADOS
	unset($html[0]);
	  //// $resultados DIVIDE AS PROXIMAS TAGS E COLOCA EM UM ARRAY, CADA INDEX DO ARRAY É UM RESULTADO
	$resultados = explode("<tr", $html[1]);

	  //// EXCLUI O PRIMEIRO INDEX QUE SAO DADOS NAO USADOS POSTERIORMENTE
	unset($resultados[0]);

		///// PARA CADA INDEX DA VARIAVEL RESULTADOS ELE TRABALHA O HTML E RETORNA SOMENTE OS DADOS
	foreach ($resultados as $key=>$values) {

		$xhtml = explode('<td', $values);
		unset($xhtml[0]);
			////// NA VARIAVEL XHTML CONTEM OS DADOS RETORNADOS PELA PESQUISA
			///// $xhtml[0] = Titulos da tabela
			///// $xhtml[1] = Código UF 	  
			///// $xhtml[2] = UF  	 
			///// $xhtml[3] = Código Município
			///// $xhtml[4] = Município 	 
			///// $xhtml[5] = Área (Km2) 

		$uf = str_replace('align="center">', "", $xhtml[2]);
		$uf = str_replace('</td>', "", $uf);
			/// EXCLUI POSSIVEIS ESPACOS E ARMAZENA A UF NA VARIAVEL
		$uf = trim($uf);

		$codigo = str_replace('align="center">', "", $xhtml[3]);
		$codigo = str_replace('</td>', "", $codigo);
			/// EXCLUI POSSIVEIS ESPACOS E ARMAZENA O CODIGO NA VARIAVEL
		$codigo = trim($codigo);


		$cidade = str_replace('>', "", $xhtml[4]);
		$cidade = str_replace('</td', "", $cidade);
			/// EXCLUI POSSIVEIS ESPACOS E ARMAZENA A CIDADE NA VARIAVEL
		$cidade = trim($cidade);
	    	////// FICA A CRITERIO COMO VOCE VAI QUERER RETORNAR ESSES DADOS,
	    	////// USEI LISTAGEM EM HTML
		if (trim($uf)=="GO") {
			$txt[$key] = "
			<ul>
				<li>Codigo: ".trim($codigo)."</li>
				<li>Cidade: ".utf8_encode(trim($cidade))."</li>
				<li>UF: ".(trim($uf))."</li>
			</ul>";

		}
		
	}
		/////EXCLUI OS TITULOS DAS TABELAS, FICA A SEU CRITERIO TRABALHA-LOS	
	unset($txt[1]);
		/////// SE HOUVER RESULTADOS SERÁ UM ARRAY SE NAO RETORNARA A MENSAGEM
	if (is_array($txt)) {
			//// TRANSFORMA O ARRAY EM STRING SEPARANDO CADA RESULTADO COM UM <BR>
		$return = implode("<br>", $txt);
	}else{
			///// MENSAGEM DE RETORNO CASO NAO HAJA RESULTADOS
		$return = "Nenhum Resultado";
	}

		///// RETORNA A LISTAGEM DE RESULTADOS
	echo $return;

}


}