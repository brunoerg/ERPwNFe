<?php
class DataBase {


	function __construct() {

		mysql_connect ( HOST, USER, PASS ) or die(mysql_error());

		mysql_select_db(DB) or die(mysql_error());
			

	}

	public function insert($table, $data) {
		$campos = array_keys ( $data );
		$quant = count ( $campos );
		$quant = ($quant - 1);
		$query = "INSERT INTO ";
		$query .= "`" . $table . "` (";
		for($i = 0; $i < $quant; $i ++) {
			$query .= "`" . $campos [$i] . "`,";
		}
		$query .= "`" . $campos [$quant] . "`) VALUES (";
		for($i = 0; $i < $quant; $i ++) {
			$camp = $campos [$i];
			$query .= "'" . $data [$camp] . "',";
		}
		$camp = $campos [$i];
		$query .= "'" . $data [$camp] . "')";
		$query .= ";";
		$sql = mysql_query ( $query );
		return $sql;

	}

	public function select($table, $data, $where, $sinal, $order = "id", $max = "") {
		$wher = array_keys ( $where );
		$quant = count ( $data );
		$quant = ($quant - 1);
		$W = $wher [0];
		$query = "SELECT ";
		if ($data!="*") {
			for($i = 0; $i < $quant; $i ++) {
				$query .= $data [$i] . ", ";
			}
			$query .= $data [$quant];
		}else{
			$query .= " * ";
		}

		$query .= " FROM ";
		$query .= "`" . $table . "` ";

		$query .= " WHERE '" . $W . "'";
		$query .= $sinal;
		$query .= "'" . $where [$W] . "'";
		$query .= " ORDER BY " . $order;
		$query .= $max;
		$query .= "";
		$sql = mysql_query ( $query ) or die ( mysql_error () );

		//echo $query;


		return $sql;
	}

	public function delete($table, $id) {

		$query = "DELETE FROM ";
		$query .= "`" . $table . "` ";
		$query .= "WHERE 'id'='" . $id . "'";
		$query .= ";";
		$sql = mysql_query ( $query );
		return $sql;

	} // FECHA FUNCTION DELETE FROM -  SQL


	public function update($table, $data, $where) {
		$wher = array_keys ( $where );
		$W = $wher [0];
		$campos = array_keys ( $data );
		$quant = count ( $campos );
		$quant = ($quant - 1);
		$query = "UPDATE ";
		$query .= "'" . $table . "' ";
		$query .= "SET ";
		for($i = 0; $i < $quant; $i ++) {
			$camp = $campos [$i];
			$query .= "'$campos[$i]'= '" . $data [$camp] . "',";
		}
		$camp = $campos [$quant];
		$query .= "'$campos[$quant]'= '" . $data [$camp] . "' ";
		$query .= "WHERE '$wher[0]'='" . $where [$W] . "'";
		$query .= ";";

		$sql = mysql_query ( $query );
		return $sql;

	}

	public function query_insert($table, $data) {
		$campos = array_keys ( $data );
		$quant = count ( $campos );
		$quant = ($quant - 1);
		$query = "INSERT INTO ";
		$query .= "`" . $table . "` (";
		for($i = 0; $i < $quant; $i ++) {
			$query .= "`" . $campos [$i] . "`,";
		}
		$query .= "`" . $campos [$quant] . "`) VALUES (";
		for($i = 0; $i < $quant; $i ++) {
			$camp = $campos [$i];
			$query .= "'" . $data [$camp] . "',";
		}
		$camp = $campos [$i];
		$query .= "'" . $data [$camp] . "')";
		$query .= ";";


		return $query;

	}

	public function query_select($table, $data, $where, $sinal, $order = "id DESC", $max = "") {
		$wher = array_keys ( $where );
		$quant = count ( $data );
		$quant = ($quant - 1);
		$W = $wher [0];
		$query = "SELECT ";
		if ($data!="*") {
			for($i = 0; $i < $quant; $i ++) {
				$query .= $data [$i] . ", ";
			}
			$query .= $data [$quant];
		}else{
			$query .= " * ";
		}

		$query .= " FROM ";
		$query .= "`" . $table . "` ";

		$query .= " WHERE '" . $W . "'";
		$query .= $sinal;
		$query .= "'" . $where [$W] . "'";
		$query .= " ORDER BY " . $order;
		$query .= $max;
		$query .= "";



		return $query;
	}

	public function query_delete($table, $id) {

		$query = "DELETE FROM ";
		$query .= "`" . $table . "` ";
		$query .= "WHERE 'id'='" . $id . "'";
		$query .= ";";

		return $query;

	} // FECHA FUNCTION DELETE FROM -  SQL


	public function query_update($table, $data, $where) {
		$wher = array_keys ( $where );
		$W = $wher [0];
		$campos = array_keys ( $data );
		$quant = count ( $campos );
		$quant = ($quant - 1);
		$query = "UPDATE ";
		$query .= "'" . $table . "' ";
		$query .= "SET ";
		for($i = 0; $i < $quant; $i ++) {
			$camp = $campos [$i];
			$query .= "'$campos[$i]'= '" . $data [$camp] . "',";
		}
		$camp = $campos [$quant];
		$query .= "'$campos[$quant]'= '" . $data [$camp] . "' ";
		$query .= "WHERE '$wher[0]'='" . $where [$W] . "'";
		$query .= ";";

		return $query;

	}

	public function query($query) {

		$sql = mysql_query ( $query );
		return $sql;

	}
}