<?php
class Controller {
	Protected $db;

	function __construct() {
		$this->model = new Model();

		$this->string = new strings();

		$this->view = new View();

		if ($_GET["var1"]!="WebService") {
			$this->WebService();
		}else{
			$this->info("");
		}
		

		if (date("d")<10) {
			$meses = array("","Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
			$this->info("<b>O fechamento do m&ecirc;s de <i>".$meses[date("m")-1]."</i> j&aacute; est&aacute; disponivel! <a href='".URL."Fechamento'>[ Clique aqui para Visualizar ]</a><b>");
		}

	}

	public function error($msg) {

		$this->Log($msg);

		$this->view->erro .= $msg."<br>";

	}

	public function info($msg="") {

		$this->view->erro .= $msg."<br>";

	}

	protected function Log($msg) {

		//session_start();

		$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		$data = date("d-m-y");
		$hora = date("H:i:s");
		$usuario = $_COOKIE["usuario"];

		$ip = $_SERVER["REMOTE_ADDR"];

		//pasta
		$pasta = "app/public/logs/";

		//Nome do arquivo:
		$arquivo = $pasta . "Log_$data.txt";

		//Texto a ser impresso no log:
		$texto = "\n[$hora][$usuario][$ip][$url]> $msg";

		$manipular = fopen("$arquivo", "a+b");
		fwrite($manipular, $texto);
		fclose($manipular);

		//return true;
	}

	/*
	 *
	 *
	 * FUNCAO EDITAR - EDITA NOTICIAS CADASTRADAS NO BANCO BANCO
	 *
	 *
	 *
	 */
	protected function editar($id, $tabela = false,$redirect=true) {

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
			$query .= "`$campos[$i]`= '" . ($_POST[$camp]) . "',";
		}
		$camp = $campos[$quant];
		$query .= "`$campos[$quant]`= '" . ($_POST[$camp]) . "' ";
		$query .= "WHERE id=" . $id . "";
		//$query .= ";";
		//$query = "UPDATE `Noticias` SET `titulo_br`='Wilker' Where id = 1"; //  LINHA DE TESTE

		//$this->error($query);

		if ($this->model->query($query)) {

			$this->Log("Alteracao na tabela $tabela na id=$id; query($query)");

			unset($_POST);
			if ($redirect==true) {
				header("Location: " . URL . $_GET["var1"]);
			}


			
		} else {
			die(mysql_error());
		}

	}

	protected function deletar($id, $tabela,$redirect=true) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}

		$query = "DELETE FROM ";
		$query .= "`" . $tabela . "` ";
		$query .= "WHERE id='" . $id . "'";
		$query .= ";";

		if ($this->model->query($query)) {

			$this->Log("Deletou da tabela $tabela a id=$id; query($query)");
			if ($redirect==true) {
				header("Location: " . URL . $_GET["var1"]);	
			}
			
		} else {
			die(mysql_error());
		}
	}

	/*
	 *
	 *
	 * FUNCOES ATIVAR E DESATIVAR
	 *
	 *
	 *
	 */
	protected function ativar($id, $tabela) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}
		// VARIAVEIS DE DADOS JA CADASTRADOS
		$query = "UPDATE " . $tabela . " SET pago=1 WHERE id=" . $id;

		//$this->error($query);
		if ($this->model->query($query)) {

			$this->Log("Alteracao na tabela $tabela para pago a id=$id; query($query)");

			header("Location: " . URL . $_GET["var1"]);
		} else {
			die(mysql_error());
		}

		//return true;
	}

	protected function desativar($id, $tabela) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}
		// VARIAVEIS DE DADOS JA CADASTRADOS
		$query = "UPDATE " . $tabela . " SET pago=0 WHERE id=" . $id;

		//$this->error($query);
		if ($this->model->query($query)) {
			$this->Log("Alteracao na tabela $tabela para em aberto a id=$id; query($query)");

			header("Location: " . URL . $_GET["var1"]);
		} else {
			die(mysql_error());
		}

		//return true;
	}

	/*
	 *
	 *
	 *  FUNCAO CADASTRAR - CADASTRA NOTICIAS NO BANCO
	 *
	 *
	 * */
	protected function cadastrar($tabela,$unset=true) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}
		


		$campos = array_keys($_POST);
		$quant = count($campos);
		$quant = ($quant - 1);
		$query = "INSERT INTO ";
		$query .= "`" . $tabela . "` (";
			for ($i = 0; $i < $quant; $i++) {
				$query .= "`" . $campos[$i] . "`,";
			}
			$query .= "`" . $campos[$quant] . "`) VALUES (";
			for ($i = 0; $i < $quant; $i++) {
				$camp = $campos[$i];
				$query .= "'" . ($_POST[$camp]) . "',";
			}
			$camp = $campos[$i];
			$query .= "'" . ($_POST[$camp]) . "')";


if ($this->model->query($query)) {

	$this->Log("Cadastro na tabela $tabela; query($query)");

	$this->view->banco = $_POST["banco"];
	$this->view->numero = $_POST["numero"] + 1;
	$this->info("Cadastro feito com Sucesso!");
	if ($unset==true) {
		unset($_POST);
	}

	return true;
} else {
	die(mysql_error());
}

}

	/*
	 *
	 *
	 * FUNCAO PEGA ID - PEGA NOTICIA CADASTRADA NO BANCO BANCO
	 *
	 *
	 *
	 */
	protected function pegaId($tabela, $id) {

		$valores_db = $this->model->query("SELECT * FROM `" . $tabela . "` WHERE id=" . $id);

		$linha = mysql_fetch_assoc($valores_db);

		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);

		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i] = $linha[$variaveis[$i]];
		}

	}

	/*
	 *
	 *
	 * FUNCAO PEGA ID - PEGA NOTICIA CADASTRADA NO BANCO BANCO
	 *
	 *
	 *
	 */
	protected function pegaIdCodigo($tabela, $codigo) {

		$valores_db = $this->model->query("SELECT * FROM `" . $tabela . "` WHERE codigo=" . $codigo);

		$linha = mysql_fetch_assoc($valores_db);

		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);

		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i] = ucwords(strtolower(utf8_encode($linha[$variaveis[$i]])));
		}

	}

	public function pegaDados($tabela, $id) {
		$query = "SELECT * FROM " . $tabela . " WHERE id=" . $id;

		$result = $this->model->query($query);

		$linha = mysql_fetch_assoc($result);

		return $linha;
	}

	protected function pegaDadosCodigo($tabela, $id) {
		$query = "SELECT * FROM " . $tabela . " WHERE codigo=" . $id;

		$result = $this->model->query($query);

		$linha = mysql_fetch_assoc($result);

		return $linha;
	}
	protected function pegaDadosNumero($tabela, $id) {
		$query = "SELECT * FROM " . $tabela . " WHERE numero=" . $id;

		$result = $this->model->query($query);

		$linha = mysql_fetch_assoc($result);

		return $linha;
	}


	protected function pegaCheque($numero) {

		$valores_db = $this->model->query("SELECT * FROM `cheques` WHERE numero=" . $numero);

		$linha = mysql_fetch_assoc($valores_db);

		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);

		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i] = $linha[$variaveis[$i]];
		}

	}


	function formatarCpfCnpj($campo, $formatado = true){

		if ($campo != "") {
			

	//retira formato
			$codigoLimpo = ereg_replace("[' '-./ t]",'',$campo);
	// pega o tamanho da string menos os digitos verificadores
			$tamanho = (strlen($codigoLimpo) -2);
	//verifica se o tamanho do código informado é válido
			if ($tamanho != 9 && $tamanho != 12){
				return false; 
			}

			if ($formatado){ 
		// seleciona a máscara para cpf ou cnpj
				$mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 

				$indice = -1;
				for ($i=0; $i < strlen($mascara); $i++) {
					if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
				}
		//retorna o campo formatado
				$retorno = $mascara;

			}else{
		//se não quer formatado, retorna o campo limpo
				$retorno = $codigoLimpo;
			}

			return $retorno;
		}else{
			return "";
		}
		
	}


	protected function WebService() {
		$dados = array();
		$dir = "app/public/webservice/";
		
		$direct = dir($dir);

		while($arquivo = $direct->read()){
			
			if (strstr($arquivo, ".xml")) {
				$var = explode("_", $arquivo);
				
				$dados[$var[1]]++;
			}

		}
		
		
		if ($dados) {
			foreach ($dados as $key => $value) {

				$vendedor = $this->pegaDados("funcionarios",$key);
				$vendedores .= "<b>".$vendedor["nome"]." [ ".$value." ]</b>, ";
			}
			$this->view->erro .= "Dados do(s) Vendedor(es) ".$vendedores." Recebidos! <a href='".URL."WebService'>Clique Aqui para visualizar</a>.";
		}

		

	}


}