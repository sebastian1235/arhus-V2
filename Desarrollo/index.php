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


require_once "models/enlaces.php";
require_once "models/ingreso.php";


//require_once "models/include/estado.php";
//require_once "models/include/forma_pago.php";
//require_once "models/include/getbarrio.php";
//require_once "models/include/items.php";
//require_once "models/include/localidad.php";
//require_once "models/include/tercero.php";
//require_once "models/include/tipo_inv.php";


$template = new TemplateController();
$template -> template();