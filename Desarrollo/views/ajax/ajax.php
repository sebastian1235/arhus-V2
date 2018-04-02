<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 29/03/2018
 * Time: 7:10 PM
 */

require_once "../../controllers/modoPago.php";
require_once "../../models/modoPago.php";

class Ajax{
    public $validarModoPago;

    public function validarModoPagoAjax(){
        $datos = $this->validarModoPago;
        $respuesta = medioPago::validarModoPagoController($datos);
        echo $respuesta;

    }
}

$a = new Ajax();
$a ->validarModoPago = $_POST["validarMedioPago"];
$a ->validarModoPagoAjax();