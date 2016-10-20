<?php
class Session {
	function __construct() {
		session_start ();
	}
	function set($key, $value) {

		$_SESSION [$key] = $value;

	}

	function get($key) {

		return $_SESSION [$key];

	}

	function un_set($key) {
		unset($_SESSION[$key]);
	}
	function destroy() {

		session_destroy ();

	}
}