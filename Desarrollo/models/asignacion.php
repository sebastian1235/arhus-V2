<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:45 PM
 */

require_once "conexion.php";



class AsignacionModel
{

    #registro de medio de pago.
    public function registroAsignacion($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (tipo_asignacion, comision_obra_asignacion, comision_gasod_asignacion, comision_fija_asignacion) VALUES (:tipo_asignacion, :comision_obra_asignacion, :comision_gasod_asignacion, :comision_fija_asignacion)");
        $stmt->bindParam(":tipo_asignacion", $datosModel["tipo_asignacion"], PDO::PARAM_STR);
        $stmt->bindParam(":comision_obra_asignacion", $datosModel["comision_obra_asignacion"], PDO::PARAM_STR);
        $stmt->bindParam(":comision_gasod_asignacion", $datosModel["comision_gasod_asignacion"], PDO::PARAM_STR);
        $stmt->bindParam(":comision_fija_asignacion", $datosModel["comision_fija_asignacion"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }

     #Vista Asigancion
    public function vistaAsigancion($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_asignacion, tipo_asignacion, comision_obra_asignacion, comision_gasod_asignacion, comision_fija_asignacion FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

    public function actualizarAsignacion($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET tipo_asignacion = :tipo_asignacion WHERE id_asignacion = :id_asignacion");
        $stmt->bindParam(":tipo_asignacion", $datosModel["tipo_asignacion"], PDO::PARAM_STR);
        $stmt->bindParam(":id_asignacion", $datosModel["id_asignacion"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        }

        else{

            return "error";
        }

        $stmt->close();


    }
}