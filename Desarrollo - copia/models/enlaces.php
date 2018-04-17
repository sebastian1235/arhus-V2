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
            $enlaces == "FregistroSol" ||
            $enlaces == "TSolicitudes" ||
            $enlaces == "registroDet_venta" ||
            $enlaces == "registro_asignacion" ||
            $enlaces == "registroCiudad" ||
            $enlaces == "registro_campana" ||
            $enlaces == "tipoAsignacion" ||
            $enlaces == "registro_items" ||
            $enlaces == "Titems" ||
            $enlaces == "registro_tercero" ||
            $enlaces == "Tcampanas" ||
            $enlaces == "procesar" ||
            $enlaces == "salir" ||
            $enlaces == "usuarioTercero" ||
            $enlaces == "registroSol1" ||
            $enlaces == "subirArchivo" ||
            $enlaces == "tipoInventario" ||
            $enlaces == "tipoTercero" ||
            $enlaces == "medioPago" ||
            $enlaces == "selects" ||
            $enlaces == "cotizacion" ||
            $enlaces == "detalles_cot" ||
            $enlaces == "Tcampanas"){

            $module = "views/modules/".$enlaces.".php";
        }

        else if($enlaces == "index"){
            $module = "views/modules/ingreso.php";
        }

        else{
            $module = "views/modules/error.php";
        }

        return $module;

    }

    }