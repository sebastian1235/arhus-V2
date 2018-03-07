<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 5/03/2018
 * Time: 6:18 PM
 */


class Enlaces{

    public function enlacesController(){

        if(isset($_GET["action"])){

            $enlaces = $_GET["action"];

        }

        else{

            $enlaces = "index";

        }

        $respuesta = EnlacesModels::enlacesModel($enlaces);

        include $respuesta;

    }


}