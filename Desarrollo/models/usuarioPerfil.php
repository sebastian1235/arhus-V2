<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 13/03/2018
 * Time: 3:11 PM
 */

require_once "conexion.php";

class PerfilModel{
    //Guadar Perfil
    public function guardarPerfilModel($datosModel, $tabla){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario, password, email, photo, rol) VALUES (:usuario, :password, :email, :photo, :rol)");

        $stmt -> bindParam(":usuario",$datosModel["usuario"],PDO::PARAM_STR);
        $stmt -> bindParam(":password",$datosModel["password"],PDO::PARAM_STR);
        $stmt -> bindParam(":email",$datosModel["email"],PDO::PARAM_STR);
        $stmt -> bindParam(":photo",$datosModel["photo"],PDO::PARAM_STR);
        $stmt -> bindParam(":rol",$datosModel["rol"],PDO::PARAM_STR);

        if ($stmt->execute()){
            return "ok";
        }
        else{
            return "error";
        }
        $stmt->close();
    }

    public function verPerfilesModel($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT id, usuario, password,  email, rol, photo FROM $tabla");
        $stmt -> execute();
        return $stmt ->fetchAll();
        $stmt -> close();
    }

}