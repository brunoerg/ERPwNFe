<?php
class UsuariosController extends Controller {
	function __construct() {
		parent::__construct ();
		$this->tabela = "login";
	}

	function index() {


		if ($_GET["var2"]=="Novo") {


			$this->error("Preencha todos os dados corretamente e cuide bem de sua senha.");


			if ($_POST["nome"]) {
				try {


					$_POST["senha"] = md5($_POST["senha"].CRIPT);

					$this->cadastrar("login");

				} catch (Exception $e) {

					$this->error("Erro ao Cadastrar");

				}
			}



			$this->view->render ( 'usuarios/novo' );


		}elseif (strstr($_GET["var2"],"Editar")) {

			$this->error("Preencha todos os dados corretamente e cuide bem de sua senha.");

			$id = explode("-", $_GET["var2"]);

			if ($_POST["nome"]) {
				if ($_POST["senha"]=="") {

					unset($_POST["senha"]);
					unset($_POST["password2"]);

				}else{

					$_POST["senha"] = md5($_POST["senha"].CRIPT);
					unset($_POST["password2"]);

				}

				if (is_uploaded_file($_FILES["foto"]["tmp_name"])) {

					$_POST["foto"] = $this->upload(1,$id[1]);

					if ($_POST["foto"]!=false) {
						$this->editar($id[1],"login");
					}else{
						$this->error("Erro ao trocar as fotos, tente novamente");
					}
				}else{



					$this->editar($id[1],"login");

				}

			}



			$this->pegaId($id[1]);

			$this->view->render ( 'usuarios/novo' );
		}else{

			/// PAGINA PRINCIPAL E SUAS VARIAVEIS

			$id = explode("-", $_GET["var2"]);


			if (strstr($_GET["var2"], "Desativar")) {
				$this->desativar($id[1],"login");
			}
			if (strstr($_GET["var2"], "Ativar")) {
				$this->ativar($id[1],"login");
			}
			if (strstr($_GET["var2"], "Deletar")) {

				$name = $this->pega_antiga($id[1]);

				$content_dir = "app/public/images/uploads/usuarios/"; // pasta onde o arquivo ser� movido

				//deleta antiga

				if (file_exists($content_dir.$name)) {
					if(!unlink($content_dir.$name)){

						$this->error("Erro ao substituir a antiga Foto! Tente novamente...");
						return false;

					}else{
						if (!unlink($content_dir."thumb/".$name)) {
							$this->error("Erro ao substituir a antiga Foto! Tente novamente...");
							return false;
						}else{

							$this->deletar($id[1],"login");


						}
					}
				}

			}


			$this->view->lista = $this->listar($this->tabela);


			$this->view->render ( 'usuarios/index' );
		}
	}



	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA usuariosS NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar($tabela) {

		if (!$tabela) {
			$tabela = $_GET["var1"];
		}

		$lista="";
		//$valores_db = mysql_query();

		$valores_db = $this->model->query("SELECT * FROM ".$tabela." WHERE id>0");
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}
			$lista.= "
		
			<tr class='grade".$letra."'>
				<td class='center'> ".$linha["id"]." </td>
				<td class='center'>".$linha["nome"]."</td>
				<td class='actBtns'>";
			session_start();
			if ($linha["login"]==$_COOKIE["login_usuario"]) {
				$lista.= "
				<a href='".URL.$_GET["var1"]."/Editar-".$linha["id"]."' title='Editar' class='tipS'><img
						src='". Folder."images/icons/control/16/pencil.png'
						alt='' /> </a> <a href='".URL.$_GET["var1"]."/Deletar-".$linha["id"]."' title='Excluir' class='tipS'><img
						src='". Folder."images/icons/control/16/clear.png' alt='' />
				</a>
				";
			}else{
				$lista.="Nenhuma A&ccedil;&atilde;o";
			}

			$lista.= "</td>
				</tr>";

		}
		return $lista;

	}



	/*
	 *
	 *
	 * FUNCAO PEGA ID - PEGA NOTICIA CADASTRADA NO BANCO BANCO
	 *
	 *
	 *
	 */
	protected function pegaId($id) {


		//$query = $this->db->query_select($_GET["var1"],"*",array("id"=>$this->vars[1]),"=");
			
		$valores_db = $this->model->query("SELECT * FROM ".$this->tabela." WHERE id=".$id);
		$linha = mysql_fetch_array($valores_db);

		//VARIAVEIS DO BANCO
		$variaveis = array_keys($linha);
		$count = count($variaveis);

		for ($i = 0; $i < $count; $i++) {
			$this->view->$variaveis[$i]	= $linha[$variaveis[$i]];
		}

	}
	/*
	 *
	 *
	 *  FUNCAO CADASTRAR (SOBREPOSICAO) - CADASTRA  NO BANCO
	 *
	 *
	 * */
	protected function cadastrar() {

		if ($_POST["password2"]==$_POST["senha"] and $_POST["senha"]!="") {

			unset($_POST["password2"]);

			$campos = array_keys ( $_POST );
			$quant = count ( $campos );
			$quant = ($quant - 1);
			$query = "INSERT INTO ";
			$query .= "`" . $this->tabela . "` (";
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

				$this->Log("Cadatrou um novo usuario! Nome: ".$_POST["nome"]);
				header("Location: ".URL.$_GET["var1"]);
			}else{
				die(mysql_error());
			}



		}else{


			$this->view->nome 	= $_POST["nome"];
			$this->view->login 	= $_POST["login"];



			$this->error("As senhas n&atilde;o conferem!");

		}



	}




}