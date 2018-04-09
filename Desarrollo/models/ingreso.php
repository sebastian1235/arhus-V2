<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 8/03/2018
 * Time: 5:51 PM
 */

require_once "conexion.php";
class IngresoModels{

    public function ingresoModel($datosModel, $tabla){

        $stmt = Conexion::conectar()->prepare("SELECT Id_tercero, usuario, password, e_mail_tercero, photo, tipo_tercero, intentos, nombre_tercero FROM $tabla WHERE usuario = :usuario");

        $stmt -> bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt -> fetch();

        $stmt -> close();

    }

    public function intentosModel($datosModel, $tabla){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET intentos = :intentos WHERE usuario = :usuario");

        $stmt -> bindParam(":intentos", $datosModel["actualizarIntentos"], PDO::PARAM_INT);
        $stmt -> bindParam(":usuario", $datosModel["usuarioActual"], PDO::PARAM_STR);

        if($stmt -> execute()){

            return "ok";

        }

        else{

            return "error";
        }

    }

    #VISUALIZAR PERFILES
    public function verPerfilesModel($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT Id_tercero, usuario, password, e_mail_tercero, tipo_tercero, photo, nombre_tercero FROM $tabla");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
    }

}