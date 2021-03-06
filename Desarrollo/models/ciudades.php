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

    #registro Localidad
    public function registroLocalidad($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_loc, cod_loc, idciudad_loc) VALUES (:nombre_loc, :cod_loc, :idciudad_loc)");
        $stmt->bindParam(":nombre_loc", $datosModel["localidad"], PDO::PARAM_STR);
        $stmt->bindParam(":cod_loc", $datosModel["codigoLocalidad"], PDO::PARAM_STR);
        $stmt->bindParam(":idciudad_loc", $datosModel["idCiudad"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }
    #vista Localidad
    public function vistaLocalidad($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT `nombre_loc`,`cod_loc`, nombre_ciu FROM $tabla inner join siax_ciudad on siax_localidad.idciudad_loc=siax_ciudad.id_ciu");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
    #Vista Sector
    public function vistaSector($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT `cod_sec`,`nombre_sec`,nombre_loc FROM $tabla inner join siax_localidad on siax_sectores.localidad=siax_localidad.id_loc");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

    public function registroSector($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_sec, cod_sec, localidad) VALUES (:nombre_sec, :cod_sec, localidad)");
        $stmt->bindParam(":nombre_sec", $datosModel["nombre_sec"], PDO::PARAM_STR);
        $stmt->bindParam(":cod_sec", $datosModel["cod_sec"], PDO::PARAM_STR);
        $stmt->bindParam(":localidad", $datosModel["localidad"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }
}