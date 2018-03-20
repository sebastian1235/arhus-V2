<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:45 PM
 */

require_once "conexion.php";



class MedioPagoModel
{

    #registro de medio de pago.
    public function registroMedioPago($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_medio_pago, activo_medio_pago) VALUES (:nombre_medio_pago, :activo_medio_pago)");
        $stmt->bindParam(":nombre_medio_pago", $datosModel["modoPago"], PDO::PARAM_STR);
        $stmt->bindParam(":activo_medio_pago", $datosModel["editarActivo"], PDO::PARAM_STR);

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
