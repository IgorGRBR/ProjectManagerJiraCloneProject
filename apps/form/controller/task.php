<?php namespace form\controller;

use core\access     as access;
use core\controller as controller;
use form\model\tasks     as tasks;

class task extends controller {
    public function base() {
        access::deny_if_logged_out('sign');

        $data = tasks::getTaskById($_GET['task']);
        
        controller::render('task.php', $data);
    }
}