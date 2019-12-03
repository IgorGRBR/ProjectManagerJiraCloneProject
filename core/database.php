<?php namespace core;

use \RedBeanPHP\R as R;

class database {

    private static $host = '127.0.0.1';
    private static $user = 'root';
    private static $pass = '';
    private static $name = 'JiraClone';

    public static function connect()
    {
        try {
            R::setup( 'mysql:host='.self::$host.';dbname='.self::$name, self::$user, self::$pass);
        } catch (\Exception $e) {
            try {
                R::selectDatabase('default');
            } catch (\Exception $e) {
                exit($e->getMessage());
            }
        }
    }

    public static function close()
    {
        R::close();
    }
}