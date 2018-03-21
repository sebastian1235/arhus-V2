<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 21/03/2018
 * Time: 10:52 AM
 */

class CiudadModel
{

    #registro de medio de pago.
    public function registroCiudad($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_ciu) VALUES (:nombre_ciu)");
        $stmt->bindParam(":nombre_ciu", $datosModel["ciudad"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }

    #Vista de medio de pago.s

    public function vistaMedioPago($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT Id_medio_pago, nombre_medio_pago, activo_medio_pago FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

    public function actualizarMedioPago($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_medio_pago = :nombre_medio_pago, activo_medio_pago = :activo_medio_pago WHERE Id_medio_pago = :Id_medio_pago");
        $stmt->bindParam(":nombre_medio_pago", $datosModel["modoPago"], PDO::PARAM_STR);
        $stmt->bindParam(":activo_medio_pago", $datosModel["activo"], PDO::PARAM_STR);
        $stmt->bindParam(":Id_medio_pago", $datosModel["Id_medio_pago"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        }

        else{

            return "error";
        }

        $stmt->close();


    }
}