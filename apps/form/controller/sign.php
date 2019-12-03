<?php namespace form\controller;

use core\signer     as signer;
use core\access     as access;
use core\router     as router;
use core\controller as controller;

class sign extends controller {

    public function base() {
        access::deny_if_logged_in('home');
        controller::render('sign.php');
    }

    public function in() {
        access::deny_if_logged_in('home');
        
        $login    = $_POST['login'];
        $password = $_POST['password'];
        
        signer::sign_in($login, $password);

        if (signer::is_in()) {
            header('HTTP/1.1 200');
        } else {
            header('HTTP/1.1 401');
        }
    }

    public function out() {
        access::deny_if_logged_out('home');
        signer::sign_out();
        router::redirect();
    }

    public function up() {
        access::deny_if_logged_in('home');
        controller::render('signup.php');
    }

    public function register() {
        access::deny_if_logged_in('home');

        $login      = $_POST['login'];
        $email      = $_POST['email'];
        $password   = $_POST['password'];
        $confirm    = $_POST['confirm'];
        $agreement  = $_POST['agreement'];

        $register = signer::validate_registration($login, $email, $password, $confirm, $agreement);

        if ($register === true) {
            header('HTTP/1.1 200');
        } else {
            header('HTTP/1.1 401');
            echo json_encode($register);
            exit;
        }
    }

    public function confirm() {
        access::deny_if_logged_in('home');
        echo 'confirm';
    }
}