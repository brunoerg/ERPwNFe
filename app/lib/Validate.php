<?php
class Validate {
	public function __construct() {

	}

	public function minlength($data, $arg) {

		if (strlen ( $data ) < $arg) {
			return "Sua resposta deve ter mais de $arg Letras<br>";
		}

	}

	public function maxlength($data, $arg) {

		if (strlen ( $data ) > $arg) {
			return "Sua resposta deve ter menos de $arg Letras<br>";
		}

	}
	public function int($data, $arg = false) {
		if ($arg == false) {
			if (! filter_var ( $data, FILTER_VALIDATE_INT )) {
				return "Sua resposta deve ser de Numeros inteiros1	.<br>";
			}
		} else {

			if (! filter_var ( $data, FILTER_VALIDATE_INT ) || strlen ( $data ) > $arg) {
				return "Sua resposta deve ser de Numeros inteiros e ter no maximo $arg Numeros.<br> ";
			}

		}

	}
	public function string($data) {
		if (! is_string ( $data ) && ereg ( "^[0-9]", $data )) {
			return "Sua resposta deve conter apenas letras<br>";
		}

	}

	private $invalido = false;

	public function cpf($cpf) {
		$cpf = preg_replace ( "/[\.-]/", "", $cpf );
		for($i = 0; $i <= 9; $i ++) {
			if ($cpf == str_repeat ( $i, 11 )) {
				$this->invalido = true;
			}

		}

		if ($this->invalido == 1 or strlen ( $cpf ) != 11 or ! is_numeric ( $cpf ) or $cpf == "12345678909") {
			return "CPF Inv&aacute;lido";

		}

		$res = $this->soma ( 10, $cpf );
		$dig1 = $this->pega_digito ( $res );
		$res2 = $this->soma ( 11, $cpf . $dig1 );
		$dig2 = $this->pega_digito ( $res2 );

		if ($cpf {9} != $dig1 or $cpf {10} != $dig2) {
			return "CPF Inv&aacute;lido";

		}else{
			return "CPF V&aacute;lido!";
		}

	}

	private function soma($num, $cpf) {
		$j = 0;
		$res = "";
		for($i = $num; $i >= 2; $i --) {
			$res += ($i * $cpf {$j});
			$j ++;
		}
		return $res;
	}

	private function pega_digito($res) {
		$dig = $res % 11;
		$dig = $dig < 2 ? $dig = 0 : $dig = 11 - $dig;
		return $dig;
	}

	function cnpj($cnpj) {
		$calcular = 0;
		$calcularDois = 0;
		for ($i = 0, $x = 5; $i <= 11; $i++, $x--) {
			$x = ($x < 2) ? 9 : $x;
			$number = substr($cnpj, $i, 1);
			$calcular += $number * $x;
		}
		for ($i = 0, $x = 6; $i <= 12; $i++, $x--) {
			$x = ($x < 2) ? 9 : $x;
			$numberDois = substr($cnpj, $i, 1);
			$calcularDois += $numberDois * $x;
		}

		$digitoUm = (($calcular % 11) < 2) ? 0 : 11 - ($calcular % 11);
		$digitoDois = (($calcularDois % 11) < 2) ? 0 : 11 - ($calcularDois % 11);

		if ($digitoUm <> substr($cnpj, 12, 1) || $digitoDois <> substr($cnpj, 13, 1)) {
			return "CNPJ Inv&aacute;lido!";
		}
			return "CNPJ V&aacute;lido!";
	}

	public function email() {
		if (! filter_var ( $this->dados ['valor'], FILTER_VALIDATE_EMAIL )) {
			$this->erro [] = sprintf ( "O campo %s s� aceita um e-mail v�lido", $this->dados ['nome'] );
		}
		return $this;
	}

	public function data() {
		//  99/99/9999
		if (! preg_match ( "/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $this->dados ['valor'] )) {
			$this->erro [] = sprintf ( "O campo %s s� aceita no formato 99-99-9999", $this->dados ['nome'] );
		}
		return $this;
	}

	public function tel() {
		//(99)9999-9999
		if (! preg_match ( "/^\([0-9]{2}\)[0-9]{4}\-[0-9]{4}$/", $this->dados ['valor'] )) {
			$this->erro [] = sprintf ( "O campo %s s� aceito o formato (99)9999-9999", $this->dados ['nome'] );
		}
		return $this;
	}

	public function alfanumerico($string) {


		$padrao = '/^[0-9a-zA-Záàãâéèẽêíìĩîóòõôúùũûç\s]+$/i';
		$padrao = utf8_decode ( $padrao );

		if (! preg_match ( $padrao, utf8_decode ( $string ) )) {
			return "O campo %s deve conter apenas letras e/ou n&uacute;meros";
		}

	}

	public function alfa($string) {

		$padrao = '/^[a-zA-Záàãâéèẽêíìĩîóòõôúùũûç\s]+$/i';
		$padrao = utf8_decode ( $padrao );

		if (! preg_match ( $padrao, utf8_decode ( $string ) )) {
			return "O campo %s deve conter apenas letras";
		}

	}
}