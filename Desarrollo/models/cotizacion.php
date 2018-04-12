<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 21/03/2018
 * Time: 10:52 AM
 */

class CotizacionModel
{
    #registro Ciudad.
   

    #Vista Ciudad
    public function vistaCotizacion($tabla )
    {
        $stmt = Conexion::conectar()->prepare("SELECT sol_cot, consecutivo_cot, estrato_cot FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
    
}