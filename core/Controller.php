<?php
class Controller {

    public function view($folder, $file, $data = []){
        require_once "../app/views/$folder/$file.php";
    }

    public function model($model){
        require_once "../app/models/" . $model . ".php";
        return new $model;
    }
}