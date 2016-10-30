<?php

class Logar extends Sql{

	private public $login;
	private public $senha;


	function login(){

		$this->login = $_POST["login"];
		$this->senha = $_POST["password"];


		$sql = mysql_query("SELECT * FROM login WHERE login = '".$this->login."'");
		while($linha = mysql_fetch_array($sql)){
			$login_id = $linha['id'];
			$login_db = $linha['login'];
			$senha_db = $linha['password'];
		}

		if($this->login!=$login_db){
			return false;
		}else{
			if($senha_db!=$this->senha){
				return false;
			}else{
				session_start();
				$_SESSION['login_usuario'] = $this->login;
				$_SESSION['senha_usuario'] = $this->senha;

				if (isset($_POST['lembrar'])){

					setcookie("Login", $_POST['login'], time()+60*60*24*100, "/");
					setcookie("Senha", $_POST['password'], time()+60*60*24*100, "/");

				}

				header("Location: ".URL."/br/Index ");

			}
		}
	} // FECHA FUNCAO LOGAR


	///////////////////////////////////////////////////////////////////////////////////////////////////////

	function logout(){

		session_start();

		unset($_SESSION["login_usuario"]);
		unset($_SESSION["senha_usuario"]);

		if($_SESSION["finan"]==true){
			unset($_SESSION["finan"]);
		}
		header("Location: login.php");

	} // FECHA FUNCAO SAIR


	///////////////////////////////////////////////////////////////////////////////////////////////////////



} // FECHA CLASS


