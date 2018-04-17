<?php
class Conexion{

    public function conectar(){

        $link = new PDO("mysql:host=localhost;dbname=arhus","root","mysql");
        return $link;

    }

}