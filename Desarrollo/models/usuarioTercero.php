<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 13/03/2018
 * Time: 3:11 PM
 */

require_once "conexion.php";

class UsuarioTerceroModel{
    //Guadar Perfil
    public function guardarTercerosModel($datosModel, $tabla){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_tercero, nit_tercero, telefono1_tercero, telefono2_tercero, fax_tercero, direccion_tercero, e_mail_tercero, usuario, password, tipo_tercero, gran_contrib_tercero, autoretenedor_tercero, reg_comun_tercero, photo) VALUES (:nombre_tercero, :nit_tercero, :telefono1_tercero, :telefono2_tercero, :fax_tercero, :direccion_tercero, :e_mail_tercero, :usuario, :password, :tipo_tercero, :gran_contrib_tercero, :autoretenedor_tercero, :reg_comun_tercero, photo :photo)");
        $stmt -> bindParam(":nombre_tercero",$datosModel["nombre"],PDO::PARAM_STR);
        $stmt -> bindParam(":nit_tercero",$datosModel["nit"],PDO::PARAM_STR);
        $stmt -> bindParam(":telefono1_tercero",$datosModel["telUsno"],PDO::PARAM_STR);
        $stmt -> bindParam(":telefono2_tercero",$datosModel["telDos"],PDO::PARAM_STR);
        $stmt -> bindParam(":fax_tercero",$datosModel["fax"],PDO::PARAM_STR);
        $stmt -> bindParam(":direccion_tercero",$datosModel["direccion"],PDO::PARAM_STR);
        $stmt -> bindParam(":e_mail_tercero",$datosModel["email"],PDO::PARAM_STR);
        $stmt -> bindParam(":usuario",$datosModel["usuario"],PDO::PARAM_STR);
        $stmt -> bindParam(":password",$datosModel["password"],PDO::PARAM_STR);
        $stmt -> bindParam(":tipo_tercero",$datosModel["rol"],PDO::PARAM_INT);
        $stmt -> bindParam(":gran_contrib_tercero",$datosModel["contribuyente"],PDO::PARAM_INT);
        $stmt -> bindParam(":autoretenedor_tercero",$datosModel["retenedor"],PDO::PARAM_INT);
        $stmt -> bindParam(":reg_comun_tercero",$datosModel["regimen"],PDO::PARAM_INT);
        $stmt -> bindParam(":photo",$datosModel["photo"],PDO::PARAM_STR);
        if ($stmt->execute()){
            return "ok";
        }
        else{
            return "error";
        }
        $stmt->close();
    }
    //Vista Usuarios
    public function verTerceroModel($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT *  FROM $tabla ");
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
     //Actualizar usuarios terceros
    public function editarUsuarioTerceroModel($datosModel, $tabla){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_tercero = :nombre_tercero, nit_tercero = :nit_tercero, telefono1_tercero = :telefono1_tercero, telefono2_tercero = :telefono2_tercero, fax_tercero = :fax_tercero, direccion_tercero = :direccion_tercero, e_mail_tercero = :e_mail_tercero, usuario = :usuario, password = :password, tipo_tercero = :tipo_tercero, gran_contrib_tercero = :gran_contrib_tercero, autoretenedor_tercero = :autoretenedor_tercero, reg_comun_tercero = :reg_comun_tercero, photo = :photo WHERE Id_tercero = :Id_tercero");
        $stmt -> bindParam(":nombre_tercero", $datosModel["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":nit_tercero", $datosModel["nit"], PDO::PARAM_STR);
        $stmt -> bindParam(":telefono1_tercero", $datosModel["telUsno"], PDO::PARAM_STR);
        $stmt -> bindParam(":telefono2_tercero", $datosModel["telDos"], PDO::PARAM_STR);
        $stmt -> bindParam(":fax_tercero", $datosModel["fax"], PDO::PARAM_STR);
        $stmt -> bindParam(":direccion_tercero", $datosModel["direccion"], PDO::PARAM_STR);
        $stmt -> bindParam(":e_mail_tercero", $datosModel["email"], PDO::PARAM_STR);
        $stmt -> bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);
        $stmt -> bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo_tercero", $datosModel["rol"], PDO::PARAM_INT);
        $stmt -> bindParam(":gran_contrib_tercero", $datosModel["retenedor"], PDO::PARAM_INT);
        $stmt -> bindParam(":autoretenedor_tercero", $datosModel["retenedor"], PDO::PARAM_INT);
        $stmt -> bindParam(":reg_comun_tercero", $datosModel["regimen"], PDO::PARAM_INT);
        $stmt -> bindParam(":photo", $datosModel["photo"], PDO::PARAM_STR);
        $stmt -> bindParam(":Id_tercero", $datosModel["id"], PDO::PARAM_INT);

        if($stmt->execute()){

            return "ok";
        }

        else{

            return "error";
        }

        $stmt->close();

    }
}