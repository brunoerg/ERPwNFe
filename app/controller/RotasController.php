<?php
class RotasController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {

		switch ($_GET["var2"]) {
			case "Adicionar":

			if ($_POST["vendedor"]!=0) {
				$this->cadastrar("rotas");
				$id = $this->pegaIdRota();
				header("Location: ".URL."Rotas/Editar/".$id);
			}elseif ($_POST["vendedor"]=="0") {

				$this->error("Selecione um Vendedor");

			}
			
			$this->vendedor();

			$this->view->render ( 'rotas/novo' );
			break;

			case "Editar":

			if (isset($_POST["deletar"])) {
				$this->deletarCidade($_POST["id"]);
			}

			if (isset($_POST["cidade"])&&$_POST["cidade"]!="0") {
				$this->cadastrarCidade($_POST["cidade"]);
			}elseif($_POST["cidade"]=="0" && isset($_POST["nomeCidade"])){

			}
			$this->cidades();
			$this->municipios();
			
			$this->view->render ( 'rotas/editar' );
			break;

			case "Deletar":

			$this->deletar($_GET["var3"], "rotas");

			$this->listar();

				//Futuramente criar lista com os rotas
				//$this->view->pdf = $this->pdf();
			$this->view->render ( 'rotas/index' );
			break;

			
			break;

			case "Detalhes":
			$this->gerarWaypoints();
			$this->view->render ( 'rotas/detalhes' );
			break;

			case "Atualizar":
			$this->GerarRotas();
			
			break;

			default:

			$this->listar();
			$this->view->render ( 'rotas/index' );
			break;
		}
	}

	private function GerarRotas(){
		$query = "SELECT id FROM funcionarios WHERE funcao=1";
		$sql = $this->model->query($query);

		while($linha = mysql_fetch_assoc($sql)){
			$_POST["vendedor"] = $linha["id"];
			if($this->cadastrar("rotas")){
				$rota = $this->pegaIdRota();
				$vendedor[$linha["id"]] = $this->pegaCidades($linha["id"],$rota);
			}

			
		}

		print_r($vendedor);
	}
	private function pegaCidades($vendedor,$rota){
		$query = "SELECT cidade FROM clientes WHERE vendedor=".$vendedor;
		$sql = $this->model->query($query);
		
		$cidades = array();
		while($linha = mysql_fetch_assoc($sql)){
			if (!in_array($linha["cidade"], $cidades)) { 
				array_push($cidades, $linha["cidade"]);
				$this->cadastrarCidade($linha["cidade"],$rota);
			}
		}
		return $cidades;
	}

	private function pegaIdRota(){
		$query = "SELECT id FROM rotas ORDER BY id DESC LIMIT 1";
		$sql = $this->model->query($query);

		$linha = mysql_fetch_assoc($sql);

		return $linha["id"];
	}

	private function deletarCidade($id){
		$query = "UPDATE municipios SET rota=0 WHERE codigo=".$id;
		$sql = $this->model->query($query);
	}

	private function cadastrarCidade($id,$rota){
		$query = "UPDATE municipios SET rota=".$rota." WHERE codigo=".$id;
		$sql = $this->model->query($query);
	}


	/*
	 *
	 *
	 *
	 * // FUNCAO LISTAR - LISTA rotas NA PAGINA PRINCIPAL
	 *
	 *
	 *
	 *
	 * */
	protected function listar() {



		$lista="";
		//$valores_db = mysql_query();

		$query = "SELECT * FROM rotas";

		$valores_db = $this->model->query($query);
		$letra = "B";


		while ($linha = mysql_fetch_array($valores_db)) {

			if ($letra=="B") {
				$letra="A";
			}elseif ($letra=="A") {
				$letra = "B";
			}

			$vendedor = $this->pegaDados("funcionarios", $linha["vendedor"]);
			$qntCidades = $this->contaCidades($linha["id"]);
			$lista.= "

			<tr class='grade".$letra."'>
				<td class='center'>".$linha["id"]."</td>
				<td class='center'>".htmlspecialchars($vendedor["nome"])."</td>
				<td class='center'>".($linha["descricao"])."</td>
				<td class='center'>".$qntCidades."</td>
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

	protected function contaCidades($id){

		$query = "SELECT codigo FROM municipios WHERE rota=".$id;

		$sql = $this->model->query($query);
		$i=0;
		while($linha = mysql_fetch_array($sql)){
			$i++;
		}

		return $i;

	}


	private function vendedor(){

		$query = "SELECT * FROM funcionarios WHERE funcao=1";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			if (isset($this->view->vendedor) && $linha["id"]==$this->view->vendedor) {
				$lista .="<option value='".$linha["id"]."' selected>".$linha["nome"]."</option>";
			}else{
				$lista .="<option value='".$linha["id"]."'>".$linha["nome"]."</option>";
			}
		}


		$this->view->vendedores = $lista;
	}

	private function cidades(){

		$query = "SELECT * FROM municipios WHERE rota!=".$_GET["var3"]." AND codigo LIKE ('52%') ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){

			$lista .="<option value='".$linha["codigo"]."'>".ucwords(strtolower((utf8_encode($linha["nome"]))))."</option>";
		}


		$this->view->selectCidades = $lista;
	}

	protected function gerarWaypoints(){
		$query = "SELECT nome,codigo FROM municipios WHERE rota=".$_GET['var3']." ORDER BY nome";

		$sql = $this->model->query($query);
		$waypoints = array();
		while($linha = mysql_fetch_array($sql)){
			if ($i==9) {
				break;
			}
			$andress = ucwords(strtolower(utf8_encode($linha["nome"])));
			$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address='".urlencode($andress).",Go'&sensor=false");
			
			$json = json_decode($json);

			$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

			if ($lat !="" && $long !="") {
				$cidades .= "<li>".ucwords(strtolower((utf8_encode($linha["nome"]))))." - $lat , $long </li>";
				array_push($waypoints, ("{location: '$lat , $long' }"));
			}

			

			$i++;
			
		}
		$this->view->cidades = $cidades;
		$this->view->waypoints = implode(",\n", $waypoints);
		

	}

	protected function municipios(){
		$query = "SELECT * FROM municipios WHERE rota=".$_GET['var3']." ORDER BY nome";

		$sql = $this->model->query($query);

		while($linha = mysql_fetch_array($sql)){
			$this->view->cidades .= "<li><form method='post'>".ucwords(strtolower((utf8_encode($linha["nome"]))))." <input type='hidden' name='id' value='".$linha["codigo"]."'> <input type='submit' name='deletar' value='[ Deletar ]' style='border:none;padding:0px;'></form></li>";
		}
	}


	

}