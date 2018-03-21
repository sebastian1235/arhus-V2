<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 21/03/2018
 * Time: 10:52 AM
 */

class CiudadModel
{
    #registro Ciudad.
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
    #Vista Ciudad
    public function vistaCiudad($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_ciu, nombre_ciu FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
    #Actualziar ciudad
    public function actualizarCiudad($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_ciu = :nombre_ciu WHERE id_ciu = :id_ciu");
        $stmt->bindParam(":nombre_ciu", $datosModel["editarCiudad"], PDO::PARAM_STR);
        $stmt->bindParam(":id_ciu", $datosModel["id_ciu"], PDO::PARAM_STR);
        if($stmt->execute()){

            return "ok";
        }
        else{

            return "error";
        }
        $stmt->close();


    }
}