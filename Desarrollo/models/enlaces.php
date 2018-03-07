<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 5/03/2018
 * Time: 6:22 PM
 */

class EnlacesModels{

    public function enlacesModel($enlaces){

        if($enlaces == "inicio" ||
            $enlaces == "ingreso" ||
            $enlaces == "crud" ||
            $enlaces == "FregistroSol" ||
            $enlaces == "TSolicitudes" ||
            $enlaces == "registroDet_venta" ||
            $enlaces == "" ||
            $enlaces == "" ||
            $enlaces == "" ||
            $enlaces == ""){

            $module = "views/modules/".$enlaces.".php";
        }

        else if($enlaces == "index"){
            $module = "views/modules/ingreso.php";
        }

        else{
            $module = "views/modules/ingreso.php";
        }

        return $module;

    }

    }