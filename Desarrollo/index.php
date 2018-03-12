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


$template = new TemplateController();
$template -> template();