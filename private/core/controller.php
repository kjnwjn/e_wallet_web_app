<?php
class Controller{
    public function model($model){
        require_once './private/model/'.$model.'.php';
        return new $model;
    }
    public function view($view,$data=[]){
        require_once './private/view/'.$view.'.php';
    }
    public function utils(){ 
        require_once './private/utils/utils.php';
        return new Util;
    }

}