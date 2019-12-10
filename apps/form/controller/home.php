<?php namespace form\controller;

use core\access     as access;
use core\controller as controller;
use form\model\tasks     as tasks;

class home extends controller {
    public function base() {
        access::deny_if_logged_out('sign');


        $data = tasks::getTasksByUserId($_SESSION[APP][SIGN]['id']);
        if($_SESSION[APP][SIGN]['level'] == 0) {
            $data = tasks::getAll();
        }

        
        
        controller::render('home.php', $data);
    }
}