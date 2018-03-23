<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 22/03/2018
 * Time: 5:01 PM
 */
class selectsModels {
    public function vistaSelectsCiudad($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

    public function vistaSelectslocalidad($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
    public function vistaSelectsBarrio($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

    public function selectBycode($tabla, $codlocalidad)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

}