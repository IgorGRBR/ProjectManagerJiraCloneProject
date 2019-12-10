<?php namespace core;

abstract class controller {
    abstract function base(); 

    protected static function render($view, $data = []) {
        require VIEW . $view;
    }
}