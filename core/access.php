<?php namespace core;

use core\router as router;
use core\signer as signer;

class access {
    public static function deny_if_logged_in($redirect = '') {
        if (signer::is_in()) 
            router::redirect(APP . DIRECTORY_SEPARATOR . $redirect);
    }

    public static function deny_if_logged_out($redirect = '') {
        if (!signer::is_in()) 
            router::redirect(APP . DIRECTORY_SEPARATOR . $redirect);
    }
}