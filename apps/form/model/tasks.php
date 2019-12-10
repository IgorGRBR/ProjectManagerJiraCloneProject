<?php namespace form\model;

use core\database as database;
use \RedBeanPHP\R as R;

class tasks {
    public static function getTasksByUserId($id) {
        database::connect();
        
        $res = R::load('user', $id);
        $res = $res->export();

        $owner_of_ids = R::getAll('select taskId from owner where userId = :userId', ['userId' => $id]);
        if(!empty($owner_of_ids)) {
            foreach($owner_of_ids as $task_id) {
                $task = R::getAll('select * from task where id = :taskId', ['taskId' => $task_id['taskId']]);
                $task_owners = R::getAll('select login from user where id in (select userId from owner where taskId = :taskId)', ['taskId' => $task_id['taskId']]);
                $task_requesters = R::getAll('select login from user where id in (select userId from requester where taskId = :taskId)', ['taskId' => $task_id['taskId']]);

                $task[0]['owners'] = $task_owners;
                $task[0]['requester'] = $task_requesters;

                $res['owns'][] = $task[0]; 
            }
        }

        database::close();

        return $res;
    }

    public static function getAll()
    {
        database::connect();
        

        $owner_of_ids = R::getAll('select id from task');
        $res = [];
        if(!empty($owner_of_ids)) {
            foreach($owner_of_ids as $task_id) {
                $task = R::getAll('select * from task where id = :taskId', ['taskId' => $task_id['id']]);
                $task_owners = R::getAll('select login from user where id in (select userId from owner where taskId = :taskId)', ['taskId' => $task_id['id']]);
                $task_requesters = R::getAll('select login from user where id in (select userId from requester where taskId = :taskId)', ['taskId' => $task_id['id']]);

                $task[0]['owners'] = $task_owners;
                $task[0]['requester'] = $task_requesters;

                $res['owns'][] = $task[0]; 
            }
        }

        database::close();

        return $res;
    }

    public static function getTaskById($id) {
        database::connect();
        $task = R::getAll('select * from task where id = :taskId', ['taskId' => $id]);
        
        $task_owners = R::getAll('select login from user where id in (select userId from owner where taskId = :taskId)', ['taskId' => $id]);
        $task_requesters = R::getAll('select login from user where id in (select userId from requester where taskId = :taskId)', ['taskId' => $id]);

        $task[0]['owners'] = $task_owners;
        $task[0]['requester'] = $task_requesters;

        database::close();
        return $task;
    }
}