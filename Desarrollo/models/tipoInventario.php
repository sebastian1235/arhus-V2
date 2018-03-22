<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 22/03/2018
 * Time: 12:20 PM
 */
require_once "conexion.php";


class TipoInventarioModel{
    public function vistaSelectTipoInventario($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_tipo_inv, nombre_tipo_inv, venta_tipo_inv, activo_tipo_inv, global_tipo_inv, grupo_tipo_inv, empresa_tipo_inv FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
}


