<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:45 PM
 */

require_once "conexion.php";



class CampanaModel
{

    #registro de medio de pago.
    public function registroCampana($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_campana, descuente_campana, desc_financ_campana, plazo_max_campana, detalle_campana  , aplicacion_campana, desde_campana, hasta_campana, vigente_campana, tasa_campana, descuento_fijo_campana, manto_max_campana, condiciones_campana) VALUES (:nombre_campana, :descuente_campana, :desc_financ_campana, :plazo_max_campana, :detalle_campana, :aplicacion_campana, :desde_campana, :hasta_campana, :vigente_campana, :tasa_campana, :descuento_fijo_campana, :manto_max_campana, :condiciones_campana)");
        $stmt->bindParam(":nombre_campana", $datosModel["nombre_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":descuente_campana", $datosModel["descuente_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":desc_financ_campana", $datosModel["desc_financ_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":plazo_max_campana", $datosModel["plazo_max_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":detalle_campana", $datosModel["detalle_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":aplicacion_campana", $datosModel["aplicacion_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":desde_campana", $datosModel["desde_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":hasta_campana", $datosModel["hasta_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":vigente_campana", $datosModel["vigente_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":tasa_campana", $datosModel["tasa_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":descuento_fijo_campana", $datosModel["descuento_fijo_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":manto_max_campana", $datosModel["manto_max_campana"], PDO::PARAM_STR);
        $stmt->bindParam(":condiciones_campana", $datosModel["condiciones_campana"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }

    #Vista de medio de pago.s

    #public function vistaMedioPago($tabla)
    #{
     #   $stmt = Conexion::conectar()->prepare("SELECT Id_medio_pago, nombre_medio_pago, activo_medio_pago FROM $tabla");
      #  $stmt->execute();
       # return $stmt->fetchAll();
       # $stmt->close();
   # }

    #public function actualizarMedioPago($datosModel, $tabla)
    #{
     #   $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_medio_pago = :nombre_medio_pago, activo_medio_pago = :activo_medio_pago WHERE Id_medio_pago = :Id_medio_pago");
      #  $stmt->bindParam(":nombre_medio_pago", $datosModel["modoPago"], PDO::PARAM_STR);
       # $stmt->bindParam(":activo_medio_pago", $datosModel["activo"], PDO::PARAM_STR);
        #$stmt->bindParam(":Id_medio_pago", $datosModel["Id_medio_pago"], PDO::PARAM_STR);

        #if($stmt->execute()){

          #  return "ok";
        #}

        #else{

         #   return "error";
        #}

        #$stmt->close();


    #}
}