<?php namespace core;
use \RedBeanPHP\R as R;

class signer {
    private static $login    = 'Admin';
	private static $password = '0b5e565d2ef46044c0f2f8c1f92d26200d1fd8cb'; // alpha!20_18

    public static function sign_in($login, $password) {
        if (static::$login === $login && static::$password === sha1($password)) {
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
        if(empty($login)) {
            $errors['login'] = 'Логін має бути довжиною від 6 до 20 символів';
        }

        if(!preg_match ( '/^[a-z0-9]+$/i', $login)) {
            $errors['login'] = 'Логін має складатися лише з цифр та / або латинських букв';
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введіть пошту правильно';
        }

        if(empty($password)) {
            $errors['login'] = 'Пароль має бути довжиною від 6 до 20 символів';
        }

        if(!preg_match ( '/^[a-z0-9]+$/i', $password)) {
            $errors['login'] = 'Пароль має складатися лише з цифр та / або латинських букв';
        }

        if($password !== $confirm) {
            $errors['cofirm'] = 'Паролі мають співпадати';
        }

        //Rules
        database::connect();
        if(static::login_exists($login)) {
            $errors['login'] = 'Користувач з таким логіном уже існує';
        }

        if(static::email_exists($email)) {
            $errors['email'] = 'Користувач з такою поштою уже існує';
        }

        if(empty($errors)) {
            $user = R::dispense( 'user' );
            $user->login = $login;
            $user->email = $email;
            $user->password = sha1($password);
            $user->name = $login;
            $user->status = 1;
            R::store( $user );
            database::close();

            $_SESSION[APP][SIGN]['status'] = true;
            $_SESSION[APP][SIGN]['level']  = 1;

            return true;
        }
        database::close();
        return $errors;
    }

    private static function try_login($login, $password) {
        database::connect();
        $row = R::getRow('SELECT * FROM user WHERE login = :login', ['login' => $login]);
        if(!empty($row)) {
            if($row['password'] == sha1($password)) {
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
        return !empty(R::getRow('SELECT * FROM user WHERE login = :login', ['login' => $login]));
    }

    private static function email_exists($email) {
        return !empty(R::getRow('SELECT * FROM user WHERE email = :email', ['email' => $email]));
    }
}