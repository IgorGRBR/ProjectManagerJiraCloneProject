<?php namespace form\controller;

use core\access     as access;
use core\controller as controller;

class home extends controller {
    public function base() {
        access::deny_if_logged_out('sign');

        controller::render('home.php');
    }
}