<?php

/**
 *  - Preencher um formul�rio
 *  - Postar em php
 *  - Higienizar
 *  - Validar
 *  - Retornar dados
 * 	- Escrever ao banco de dados
 **/

include "Validate.php";
include "Strings.php";

class Form {

	/** @var array $_currentItem contem o item postado agora*/
	private $_currentItem = null;

	/** @var array $_postData contem os dados postados*/
	private $_postData = array ();

	/** @var object $_val � o objeto validador*/
	private $_val = array ();

	/** @var object $_string � o objeto de tratamento de strings*/
	private $_string = array ();

	/** @var array $_error contem o erro de formulario atual*/
	private $_error = array ();
	/**
	 *
	 *
	 * - O CONSTRUTOR INSTANCIA O VALIDADOR
	 *
	 *
	 **/
	function __construct() {
		$this->_val = new Validate ( );
		$this->_string = new Strings ( );

	}

	/**
	 *
	 *
	 * - THIS IS TO RUN POST
	 * - @param STRING $FIELD - THE HTML FIELDNAME TO POST
	 *
	 **/

	public function post($field) {

		$this->_postData [$field] = $_POST [$field];
		$this->_currentItem = $field;
		return $this;
	}

	/**
	 *
	 *
	 * - THIS IS TO FETCH
	 *
	 *
	 **/
	public function fetch($fieldName = false) {

		if ($fieldName) {
				
			if (isset ( $this->_postData [$fieldName] )) {
				return $this->_postData [$fieldName];
			} else {
				return false;
			}
		} else {
			return $this->_postData;
		}

	}
	/**
	 *
	 *
	 * - THIS IS TO VALIDATE
	 *
	 *
	 **/
	public function val($type, $arg = false) {

		if ($arg == false) {
			$error = $this->_val->{$type} ( $this->_postData [$this->_currentItem] );
		} else {
			$error = $this->_val->{$type} ( $this->_postData [$this->_currentItem], $arg );
		}
		echo $error;
		if ($error) {
			$this->_error [$this->_currentItem] = $error;

		}

		return $this;
	}

	public function str($type, $arg=false) {

		if ($arg == false) {
			$error = $this->_string->{$type} ( $this->_postData [$this->_currentItem] );
		} else {
			$error = $this->_string->{$type} ( $this->_postData [$this->_currentItem], $arg );
		}
		echo $error;

		if ($error) {
			$this->_error [$this->_currentItem] = $error;

		}

		return $this;
	}

	public function submit() {

		if (empty ( $this->_error )) {
				
			return true;

		} else {
				
			throw new Exception ( "Formulario com Erros!" );

		}

	}

}