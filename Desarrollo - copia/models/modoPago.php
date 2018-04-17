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
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_medio_pago) VALUES (:nombre_medio_pago)");
        $stmt->bindParam(":nombre_medio_pago", $datosModel["modoPago"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }



    #Vista de medio de pagos
    public function vistaMedioPago($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT Id_medio_pago, nombre_medio_pago FROM $tabla where eliminar='0'");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

    public function actualizarMedioPago($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_medio_pago = :nombre_medio_pago WHERE Id_medio_pago = :Id_medio_pago");
        $stmt->bindParam(":nombre_medio_pago", $datosModel["modoPago"], PDO::PARAM_STR);
        $stmt->bindParam(":Id_medio_pago", $datosModel["Id_medio_pago"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        }

        else{

            return "error";
        }

        $stmt->close();


    }
    #Validar Medio Pago
    public function validarModoPagoModel($datosModel, $tabla){
        $stmt = Conexion::conectar()->prepare("SELECT nombre_medio_pago FROM $tabla where nombre_medio_pago = : nombre_medio_pago");
        $stmt->bindParam(":nombre_medio_pago", $datosModel, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        $stmt->close();
    }
    //Eliminar medo de pago
    public function EliminarMedioPago($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla  SET eliminar=:eliminar where Id_medio_pago=:Id_medio_pago");
        $stmt->bindParam(":eliminar", $datosModel["eliminar"], PDO::PARAM_STR);
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
