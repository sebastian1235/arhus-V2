<?php


require_once "conexion.php";



class TercerosModel
{
    public function registroTerceros($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla ( nombre_tercero, direccion_tercero, telefono1_tercero, telefono2_tercero, fax_tercero, nit_tercero, tipo_tercero, e_mail_tercero, Contacto_tercero, gran_contrib_tercero, autoretenedor_tercero, activo_tercero, reg_comun_tercero, responsable_materiales_tercero ) VALUES (:nombre_tercero, :direccion_tercero, :telefono1_tercero, :telefono2_tercero, :fax_tercero, :nit_tercero, :tipo_tercero, :e_mail_tercero, :Contacto_tercero, :gran_contrib_tercero, :autoretenedor_tercero, :activo_tercero, :reg_comun_tercero, :responsable_materiales_tercero)");
        $stmt->bindParam(":tipo_tercero", $datosModel["tipo_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_tercero", $datosModel["nombre_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":nit_tercero", $datosModel["nit_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_tercero", $datosModel["direccion_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":e_mail_tercero", $datosModel["e_mail_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono1_tercero", $datosModel["telefono1_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono2_tercero", $datosModel["telefono2_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":fax_tercero", $datosModel["fax_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":Contacto_tercero", $datosModel["Contacto_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":gran_contrib_tercero", $datosModel["gran_contrib_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":autoretenedor_tercero", $datosModel["autoretenedor_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":reg_comun_tercero", $datosModel["reg_comun_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":responsable_materiales_tercero", $datosModel["responsable_materiales_tercero"], PDO::PARAM_STR);
        $stmt->bindParam(":activo_tercero", $datosModel["activo_tercero"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }
}