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
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario, password, nombre, email, photo, rol) VALUES (:usuario, :password, :nombre, :email, :photo, :rol)");

        $stmt -> bindParam(":usuario",$datosModel["usuario"],PDO::PARAM_STR);
        $stmt -> bindParam(":password",$datosModel["password"],PDO::PARAM_STR);
        $stmt -> bindParam(":nombre",$datosModel["nombre"],PDO::PARAM_STR);
        $stmt -> bindParam(":email",$datosModel["email"],PDO::PARAM_STR);
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
    //Vista Usuarios
    public function verPerfilesModel($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT id, usuario, password, ap_terceros.nombre_tercero, email, rol, photo  FROM $tabla INNER JOIN ap_terceros on usuarios.nombre = ap_terceros.Id_tercero");
        $stmt -> execute();
        return $stmt ->fetchAll();
        $stmt -> close();
    }
    //Validación Usuarios
    public function validarNombreUsuarioModels($datosModel, $tabla){
        $stmt = Conexion::conectar()->prepare("SELECT usuario FROM $tabla WHERE usuario = :usuario");
        $stmt ->bindParam(":usuario", $datosModel, PDO::PARAM_STR);
        $stmt ->execute();
        return $stmt->fetch();
        $stmt ->close();
    }
}