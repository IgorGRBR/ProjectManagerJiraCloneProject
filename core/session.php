<?php namespace core;

class session {
    public static function start() {
		session_start();
		session_regenerate_id();
	}

	public static function end() {
		session_unset();
		session_destroy();
	}

	public static function get($key) {
		return $_SESSION[APP][$key];
	}

	public static function set($key, $value) {
		$_SESSION[APP][$key] = $value;
	}
}