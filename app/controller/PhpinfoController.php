<?php
class PhpinfoController extends Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		$this->view->render ( 'php/index' );
	}
}