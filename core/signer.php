<?php namespace core;

class signer {
    private static $login    = 'Admin';
	private static $password = '0b5e565d2ef46044c0f2f8c1f92d26200d1fd8cb'; // alpha!20_18

    public static function sign_in($login, $password) {


        
        if (static::$login === $login && static::$password === sha1($password)) {
            $_SESSION[APP][SIGN]['status'] = true;
            $_SESSION[APP][SIGN]['level']  = 0;
        }
    }

    public static function is_in(){
        return $_SESSION[APP][SIGN]['status'] === true;
    }

    public static function sign_out() {
        unset($_SESSION[APP][SIGN]);
    }

    public static function validate_registration($login, $email, $password, $confirm, $agreement) {
        return true;
        
        //TODO
        return ['login' => '',
                'email' => '',
                'password' => '',
                'confirm' => '',
                'agreement' => ''];
    }
}