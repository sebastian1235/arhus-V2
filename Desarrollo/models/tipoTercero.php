<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 11:33 PM
 */

require_once "conexion.php";



class TipoTerceroModel
{
    public function registroTipoTercero($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_tipo_ter, descripcion_tipo_ter, Grupo_tipo_ter) VALUES (:nombre_tipo_ter, :descripcion_tipo_ter, :Grupo_tipo_ter)");
        $stmt->bindParam(":nombre_tipo_ter", $datosModel["nombreTipoTercero"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_tipo_ter", $datosModel["descripcionTipoTercero"], PDO::PARAM_STR);
        $stmt->bindParam(":Grupo_tipo_ter", $datosModel["grupoTipoTercero"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }

    public function vistaTipoTercero($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_tipo_tercero ,nombre_tipo_ter, descripcion_tipo_ter, Grupo_tipo_ter FROM $tabla");
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
