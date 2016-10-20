<?php
class FuncionariosController extends Controller {
	function __construct() {
		parent::__construct ();
		
	}

	function index() {

		switch ($_GET["var2"]) {
			case "GetEfetivacao":
			ob_end_clean();
			$this->GetEfetivacao();
			break;

			case "UploadDocumentos":
			ob_end_clean();
			$this->UploadDocumentos("app/public/documentos/".md5($_GET["var3"])."/",md5($_GET["var3"]));
			break;


			case "DeletarFoto":
			ob_end_clean();
			if (unlink("app/public/funcionarios/".$_POST["file"])) {
				echo "ok";
				unset($_POST["file"]);

				$_POST["foto"]="0";
				$this->editar($_POST["id"],"funcionarios");
			}else{
				echo "false";
			}
			break;

			case "DeletarDoc":
			ob_end_clean();
			if (unlink("app/public/documentos/".md5($_POST["id"])."/".$_POST["file"])) {
				echo "ok";
			}else{
				echo "false";
			}
			break;

			case "Upload":
			$this->UploadFoto();
			break;

			case "Adicionar":

			$this->limpaFotos();

			if (isset($_POST["nome"])) {
				foreach ($_POST as $key => $value) {
					if (strstr($key,"_name") || strstr($key,"_status") || strstr($key,"_count")) {
						unset($_POST[$key]);
					}
				}
				$this->cadastrar("funcionarios");
			}

			$this->funcao();
			$this->view->render ( 'funcionarios/novo' );
			break;

			case "Editar":

			if (!is_dir("app/public/documentos/".md5($_GET["var3"]))) {
				mkdir("app/public/documentos/".md5($_GET["var3"]),0777);
			}

			if (isset($_POST["nome"])) {
				foreach ($_POST as $key => $value) {
					if (strstr($key,"_name") || strstr($key,"_status") || strstr($key,"_count")) {
						unset($_POST[$key]);
					}
				}
				
				$this->editar($_GET["var3"],"funcionarios",false);
			}

			$this->pegaId("funcionarios",$_GET["var3"]);

			$this->listaDocs("app/public/documentos/".md5($_GET["var3"])."/",md5($_GET["var3"]));

			$this->funcao();
			$this->view->render ( 'funcionarios/novo' );
			break;


			case "Relatorio":

			if (!is_dir("app/public/documentos/".md5($_GET["var3"]))) {
				mkdir("app/public/documentos/".md5($_GET["var3"]),0777);
			}

			$this->pegaId("funcionarios",$_GET["var3"]);

			$this->listaDocs("app/public/documentos/".md5($_GET["var3"])."/",md5($_GET["var3"]));

			$this->listagens();
			$this->view->render ( 'funcionarios/relatorio' );
			break;
			case "Demitir":

			if (isset($_POST["demissao"])) {
				$_POST["ativo"]=0;
				$this->editar($_GET["var3"],"funcionarios");
			}

			$this->pegaId("funcionarios",$_GET["var3"]);

			$this->listagens();
			$this->view->render ( 'funcionarios/demitir' );
			break;

			case "Efetivar":

			if (isset($_GET["var3"])) {
				$_POST["demissao"]="0";
				$_POST["ativo"]=1;
				$this->editar($_GET["var3"],"funcionarios");
			}
			header("Location: ".URL.$_GET["var1"]."/Relatorio/".$_GET["var3"]);

			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "funcionarios");

			$this->listar();

			$this->view->render ( 'funcionarios/index' );
			break;

			default:
			$this->limpaFotos();
			$this->listar();
			$this->view->render ( 'funcionarios/index' );
			break;
		}
	}


	protected function listagens(){
		switch ($this->view->estadoCivil) {
			case '0':
			$this->view->estadoCivil = "Solteiro";
			break;

			case '1':
			$this->view->estadoCivil = "Casado";
			break;

			case '2':
			$this->view->estadoCivil = "Divorciado";
			break;

			case '3':
			$this->view->estadoCivil = "Outro";
			break;

			default:
			$this->view->estadoCivil = "<i>Não Cadastrado!</i>";
			break;
		}
		$funcao = $this->pegaDados("funcoes",$this->view->funcao);
		$this->view->funcao = $funcao["nome"];

		if ($this->view->banco) {
			$banco = $this->pegaDados("bancos",$this->view->banco);
			$this->view->banco = $banco["nome"];
		}else{
			$this->view->banco = "<i>Nenhum Banco Cadastrada!</i>";
			$this->view->agencia = "<i>Nenhuma Agência Cadastrada!</i>";
			$this->view->conta = "<i>Nenhuma Conta Cadastrada!</i>";
		}
		
	}


	protected function funcao() {
		$query = "SELECT * FROM funcoes";

		$valores_db = $this->model->query($query);

		while ($linha = mysql_fetch_array($valores_db)) {

			if ($this->view->funcao==$linha["id"]) {
				$lista .= "
				<input type='radio' name='funcao' class='funcoes' value='".$linha["id"]."' id='func".$linha["id"]."' comissao='".$linha["comissao"]."' checked/>
				<label for='func".$linha["id"]."'>".$linha["nome"]."</label>
				";
			}else{


				$lista .= "
				<input type='radio' name='funcao' class='funcoes' value='".$linha["id"]."' id='func".$linha["id"]."'  comissao='".$linha["comissao"]."' /> 
				<label for='func".$linha["id"]."'>".$linha["nome"]."</label>
				";
			}
		}

		$this->view->funcoes = $lista;

		$this->bancos();
	}

	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA funcionarios NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM funcionarios";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$funcao = $this->pegaDados("funcoes", $linha["funcao"]);

			if ($linha["ativo"]=="1") {
				$lista.= "

				<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".$linha["nome"]."</td>
				<td class='center'>".$linha["telefone"]."</td>
				<td class='center'>".$linha["cpf"]."</td>
				<td class='center'>".$linha["admissao"]."</td>
				<td class='center'>".$funcao["nome"]."</td>
				<td class='actBtns'>
				<a href='".URL.$_GET["var1"]."/Relatorio/".$linha["id"]."' title='Ver o Relatório' class='tipS'>
				<img src='". Folder."images/icons/control/16/attibutes.png' alt='' /> 
				</a>
				<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
				<img src='". Folder."images/icons/control/16/pencil.png' alt='' /> 
				</a> 
				<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
				<img src='". Folder."images/icons/control/16/clear.png' alt='' />
				</a>
				</td>
				</tr>";
			}else{
				$listaInativa.= "

				<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".$linha["nome"]."</td>
				<td class='center'>".$linha["telefone"]."</td>
				<td class='center'>".$linha["cpf"]."</td>
				<td class='center'>".$linha["demissao"]."</td>
				<td class='center'>".$funcao["nome"]."</td>
				<td class='actBtns'>
				<a href='".URL.$_GET["var1"]."/Relatorio/".$linha["id"]."' title='Ver o Relatório' class='tipS'>
				<img src='". Folder."images/icons/control/16/attibutes.png' alt='' /> 
				</a>
				<a href='".URL.$_GET["var1"]."/Editar/".$linha["id"]."' title='Editar' class='tipS'>
				<img src='". Folder."images/icons/control/16/pencil.png' alt='' /> 
				</a> 
				<a href='".URL.$_GET["var1"]."/Deletar/".$linha["id"]."' title='Deletar' class='tipS'>
				<img src='". Folder."images/icons/control/16/clear.png' alt='' />
				</a>
				</td>
				</tr>";
			}

		}

		$this->view->lista = $lista;
		$this->view->listaInativa = $listaInativa;

	}




	protected function UploadFoto(){

		if (is_uploaded_file($_FILES["file"]['tmp_name'])) {

			$targetDir = "app/public/funcionarios/";

			$tipos = array(".jpg",".jpeg",".png");
			foreach ($tipos as $value) {
				if(strstr($_FILES['file']['name'],$value)) {
					$tipo = $value;
				}
			}

			$arquivo = md5(date("d-m-Y/H:i:s")).$tipo;
			if (move_uploaded_file($_FILES['file']['tmp_name'], $targetDir.$arquivo)) {
				ob_end_clean();
				echo $arquivo;
			}
		}else{
			echo "Nenhuma Imagem Enviada!";
		}

	}

	protected function UploadDocumentos($dir,$id){

		if (is_uploaded_file($_FILES["file"]['tmp_name'])) {

			$arquivo = trim($_FILES["file"]['name']);
			$arquivo = preg_replace('/[^\w\._]+/', '', $arquivo);
			$arquivo = str_replace(" ", "_", $arquivo);

			if (move_uploaded_file($_FILES['file']['tmp_name'], $dir.$arquivo)) {
				ob_end_clean();
				if(strstr($_FILES['file']['name'],".pdf")) {
					echo "<li><p><a target='_blank' link='".Folder."documentos/".$id."/".$arquivo."' class='docsView' style='float:left;font-size:20px;color:#0C0C0C;'><img src='".Folder."images/icons/control/new/pdf.png' alt='' height='24' />".$arquivo."</a><input type='button' class='DeletarDoc' file='".$arquivo."' style='float:left;margin-left:20px;' value='X'></p><br></li>";
				}elseif (strstr($_FILES['file']['name'],".jpg") || strstr($_FILES['file']['name'],".jpeg") || strstr($_FILES['file']['name'],".png")) {
					echo "<li><p><a target='_blank' link='".Folder."documentos/".$id."/".$arquivo."' class='docsView' style='float:left;font-size:20px;color:#0C0C0C;'><img src='".Folder."images/icons/control/new/photo.png' alt='' height='24' />".$arquivo."</a><input type='button' class='DeletarDoc' file='".$arquivo."' style='float:left;margin-left:20px;' value='X'></p><br></li>";
				}else{
					echo "<li><p><a target='_blank' link='".Folder."documentos/".$id."/".$arquivo."' class='docsView' style='float:left;font-size:20px;color:#0C0C0C;'><img src='".Folder."images/icons/control/new/doc.png' alt='' height='24' />".$arquivo."</a><input type='button' class='DeletarDoc' file='".$arquivo."' style='float:left;margin-left:20px;' value='X'></p><br></li>";
				}
				
			}
		}else{
			echo "Nenhuma Imagem Enviada!";
		}	
	}

	private function bancos(){

		$query = "SELECT * FROM bancos ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->banco) && $linha["id"]==$this->view->banco) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->bancos = $lista;
	}

	protected function listaDocs($dir,$id){
		
		$diretorio = dir($dir);


		while($arquivo = $diretorio -> read()){
			if (is_file($dir.$arquivo) && $arquivo!=".DS_Store") {

				if(strstr($arquivo,".pdf")) {
					$html.= "<li><p><a target='_blank' link='".Folder."documentos/".$id."/".$arquivo."' class='docsView' style='float:left;font-size:20px;color:#0C0C0C;'><img src='".Folder."images/icons/control/new/pdf.png' alt='' height='24' />".$arquivo."</a><input type='button' class='DeletarDoc' file='".$arquivo."' style='float:left;margin-left:20px;' value='X'></p><br></li>";
				}elseif (strstr($arquivo,".jpg") || strstr($arquivo,".jpeg") || strstr($arquivo,".png")) {
					$html.= "<li><p><a target='_blank' link='".Folder."documentos/".$id."/".$arquivo."' class='docsView' style='float:left;font-size:20px;color:#0C0C0C;'><img src='".Folder."images/icons/control/new/photo.png' alt='' height='24' />".$arquivo."</a><input type='button' class='DeletarDoc' file='".$arquivo."' style='float:left;margin-left:20px;' value='X'></p><br></li>";
				}else{
					$html.= "<li><p><a target='_blank' link='".Folder."documentos/".$id."/".$arquivo."' class='docsView' style='float:left;font-size:20px;color:#0C0C0C;'><img src='".Folder."images/icons/control/new/doc.png' alt='' height='24' />".$arquivo."</a><input type='button' class='DeletarDoc' file='".$arquivo."' style='float:left;margin-left:20px;' value='X'></p><br></li>";
				}
			}
		}

		$this->view->docs = $html;
	}

	protected function limpaFotos(){
		$dir = "app/public/funcionarios/";
		$diretorio = dir($dir);


		while($arquivo = $diretorio -> read()){

			if($this->pegaFoto($arquivo)==false){
				unlink($dir.$arquivo);
			}
		}
	}
	protected function pegaFoto($foto){
		$query = "SELECT foto FROM funcionarios WHERE foto='".$foto."'";
		$sql = $this->model->query($query);

		$linha = mysql_fetch_assoc($sql);

		if ($linha["foto"]!=0 || $linha["foto"]==true) {
			return true;
		}else{
			return false;
		}
	}

	protected function GetEfetivacao(){
		$dataAdm = explode("-", $_POST["admissao"]);

		$data = date("d-m-Y",mktime(0, 0, 0, $dataAdm[1], ($dataAdm[0]+$_POST["dias"]), $dataAdm[2]));

		ob_end_clean();
		echo $data;
	}

}