<?php
class Model {
	function  __construct(){
		$this->Db = new DataBase();
	}

	public function query($query) {
		try {
			$sql = mysql_query($query) or die(mysql_error()."<br>".$query."<br>".$e);

			return $sql;
			
		} catch (Exception $e) {
			echo "Erro: ".$e;
		}
		

		
	}
}