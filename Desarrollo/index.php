<?php
///**
// * Created by PhpStorm.
// * User: giova
// * Date: 5/03/2018
// * Time: 4:05 PM
// */

require_once "controllers/template.php";
require_once "controllers/enlaces.php";
require_once "controllers/ingreso.php";
require_once "controllers/usuarioPerfil.php";
require_once "controllers/modoPago.php";
require_once "controllers/tipoTercero.php";
require_once "controllers/asignacion.php";
require_once "controllers/campanas.php";
require_once "controllers/items.php";
require_once "controllers/terceros.php";
require_once "controllers/ciudades.php";

require_once "models/enlaces.php";
require_once "models/ingreso.php";
require_once "models/usuarioPerfil.php";
require_once "models/modoPago.php";
require_once "models/tipoTercero.php";
require_once "models/asignacion.php";
require_once "models/campanas.php";
require_once "models/items.php";
require_once "models/terceros.php";
require_once "models/ciudades.php";

$template = new TemplateController();
$template -> template();