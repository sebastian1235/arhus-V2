<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 29/03/2018
 * Time: 7:10 PM
 */

require_once "../../controllers/tipoTercero.php";
require_once "../../models/tipoTercero.php";

class Ajax{
    public $validarNombreTipoTercero;

    public function validarNombreTipoTerceroAjax(){
        $datos = $this->validarNombreTipoTercero;
        $respuesta = TipoTercero::validarNombreTipoTerceroController($datos);
        echo $respuesta;

    }
}
if (isset($_POST["validarNombreTipoTercero"])){
$a = new Ajax();
$a -> validarNombreTipoTercero = $_POST["validarNombreTipoTercero"];
$a -> validarNombreTipoTerceroAjax();
}