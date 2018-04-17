<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 29/03/2018
 * Time: 7:10 PM
 */

require_once "../../controllers/tipoTercero.php";
require_once "../../models/tipoTercero.php";

require_once "../../controllers/usuarioTercero.php";
require_once "../../models/usuarioTercero.php";



class Ajax{
    public $validarNombreTipoTercero; //Module TipoTercero.php
    public $validarNombreUsuario; // Module usuarioTercero.php


    public function validarNombreTipoTerceroAjax(){
        $datos = $this->validarNombreTipoTercero;
        $respuesta = TipoTercero::validarNombreTipoTerceroController($datos);
        echo $respuesta;

    }

    public function validarNombrePerfilAjax(){
        $datos = $this->validarNombreUsuario;
        $respuesta = UsuarioTercero::validarNombreUsuarioController($datos);
        echo $respuesta;

    }
}

if (isset($_POST["validarNombreTipoTercero"])){
    $a = new Ajax();
    $a -> validarNombreTipoTercero = $_POST["validarNombreTipoTercero"];
    $a -> validarNombreTipoTerceroAjax();
}

if (isset($_POST["validarNombreUsuario"])){
    $b = new Ajax();
    $b -> validarNombreUsuario = $_POST["validarNombreUsuario"];
    $b -> validarNombrePerfilAjax();
}