<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 29/03/2018
 * Time: 7:10 PM
 */

require_once "../../controllers/tipoTercero.php";
require_once "../../models/tipoTercero.php";

require_once "../../controllers/usuarioPerfil.php";
require_once "../../models/usuarioPerfil.php";



class Ajax{
    public $validarNombreTipoTercero; //Module TipoTercero.php
    public $validarNombreUsuario; // Module usuarioPerfil.php


    public function validarNombreTipoTerceroAjax(){
        $datos = $this->validarNombreTipoTercero;
        $respuesta = TipoTercero::validarNombreTipoTerceroController($datos);
        echo $respuesta;

    }

    public function validarNombrePerfilAjax(){
        $datos = $this->validarNombreUsuario;
        $respuesta = UsuarioPerfil::validarNombreUsuarioController($datos);
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