<?php namespace core;
use \RedBeanPHP\R as R;

class signer {
    private static $login    = 'admin1';
	private static $password = 'admin1';

    public static function sign_in($login, $password) {
        if (static::$login === $login && static::$password === $password) {
            $_SESSION[APP][SIGN]['status'] = true;
            $_SESSION[APP][SIGN]['level']  = 0;
            return true;
        }

        return static::try_login($login, $password);
    }

    public static function is_in(){
        return $_SESSION[APP][SIGN]['status'] === true;
    }

    public static function sign_out() {
        unset($_SESSION[APP][SIGN]);
    }

    public static function validate_registration($login, $email, $password, $confirm) {
        
        //Validation phase
        $errors = [];
        if(strlen($login) < 6 || strlen($login) > 20) {
            $errors['login'] = 'Логін має бути довжиною від 6 до 20 символів';
        }

        if(!preg_match ( '/^[a-z0-9]+$/i', $login)) {
            $errors['login'] = 'Логін має складатися лише з цифр та / або латинських букв';
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введіть пошту правильно';
        }

        if(strlen($password) < 6 || strlen($password) > 20) {
            $errors['login'] = 'Пароль має бути довжиною від 6 до 20 символів';
        }

        if(!preg_match ( '/^[a-z0-9]+$/i', $password)) {
            $errors['login'] = 'Пароль має складатися лише з цифр та / або латинських букв';
        }

        if($password !== $confirm) {
            $errors['cofirm'] = 'Паролі мають співпадати';
        }

        //Rules
        if(static::login_exists($login)) {
            $errors['login'] = 'Користувач з таким логіном уже існує';
        }

        if(static::email_exists($email)) {
            $errors['email'] = 'Користувач з такою поштою уже існує';
        }

        if(empty($errors)) {

            database::connect();
            $user = R::dispense( 'user' );

            $user->login = $login;
            $user->email = $email;
            $user->password = sha1($password);
            $user->status = 1;
            
            $id = R::store( $user );
            database::close();

            $_SESSION[APP][SIGN]['id'] = $id;
            $_SESSION[APP][SIGN]['status'] = true;
            $_SESSION[APP][SIGN]['level']  = 1;

            return true;
        }

        return $errors;
    }

    private static function try_login($login, $password) {
        database::connect();
        $row = R::getRow('SELECT * FROM user WHERE login = :login', ['login' => $login]);
        if(!empty($row)) {
            if($row['password'] == sha1($password)) {
                $_SESSION[APP][SIGN]['id'] = $row["id"];
                $_SESSION[APP][SIGN]['status'] = true;
                $_SESSION[APP][SIGN]['level']  = $row['status']; 
                database::close();    
                return true;       
            }
        }
        database::close();

        return ['login' => 'Невірний логін та / або пароль'];
    }

    private static function login_exists($login) {
        database::connect();
        $res = !empty(R::getRow('SELECT * FROM user WHERE login = :login', ['login' => $login]));
        database::close();
        return $res;
    }

    private static function email_exists($email) {
        database::connect();
        $res = !empty(R::getRow('SELECT * FROM user WHERE email = :email', ['email' => $email]));
        database::close();
        return $res;
    }
}