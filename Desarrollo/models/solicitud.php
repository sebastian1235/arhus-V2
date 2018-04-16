<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:45 PM
 */

require_once "conexion.php";



class SolicitudModel
{

    #registro de medio de pago.
    public function registroSolicitud($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (
            poliza_sol,
            demanda_sol,
            asesor_sol,
            asignacion_sol,
            cedula_sol,
            nombre_sol,
            direccion_pol_sol,
            direccion_nueva_sol,
            barrio_sol,
            telefono1_sol,
            telefono2_sol,
            celular_sol,
            email_sol,
            servicio_sol,
            obs_sol,
            estado_sol,
            localidad_sol,
            fecha_prevista_sol,
            fecha_visita_comerc_sol,
            forma_pagogn_sol)
             VALUES (:poliza_sol,
            :demanda_sol,
            :asesor_sol,
            :asignacion_sol,
            :cedula_sol,
            :nombre_sol,
            :direccion_pol_sol,
            :direccion_pol_sol,
            :barrio_sol,
            :telefono1_sol,
            :telefono2_sol,
            :celular_sol,
            :email_sol,
            :servicio_sol,
            :obs_sol,
            '2',
            :localidad_sol,
            :fecha_visita_comerc_sol,
            :fecha_visita_comerc_sol,
            :forma_pagogn_sol)");
        $stmt->bindParam(":nombre_sol", $datosModel["nombre_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":cedula_sol", $datosModel["cedula_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":localidad_sol", $datosModel["localidad_sol"], PDO::PARAM_STRS);
        $stmt->bindParam(":barrio_sol", $datosModel["barrio_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_pol_sol", $datosModel["direccion_pol_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_pol_sol", $datosModel["direccion_nueva_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono1_sol", $datosModel["telefono1_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono2_sol", $datosModel["telefono2_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":celular_sol", $datosModel["celular_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":email_sol", $datosModel["email_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":poliza_sol", $datosModel["poliza_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":demanda_sol", $datosModel["demanda_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":asesor_sol", $datosModel["asesor_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":asignacion_sol", $datosModel["asignacion_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_sol", $datosModel["servicio_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":obs_sol", $datosModel["obs_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_sol", $datosModel["estado_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_prevista_sol", $datosModel["fecha_prevista_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_visita_comerc_sol", $datosModel["fecha_visita_comerc_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":forma_pagogn_sol", $datosModel["forma_pagogn_sol"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }

    public function registroCotizacion($datosModel, $tabla)
    {
       $stmt = Conexion::conectar()->prepare("UPDATE $tabla  SET poliza_sol=:poliza_sol, consecutivo_cot=:consecutivo_cot, estrato_cot= :estrato_cot, fecha_nac_cot=:fecha_nac_cot, forma_pago_cot=:forma_pago_cot, campana_cot=:campana_cot, tipo_cliente_cot=:tipo_cliente_cot, fecha_cot=:fecha_cot where id_sol=:id_sol");

       $stmt->bindParam(":poliza_sol", $datosModel["poliza_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":consecutivo_cot", $datosModel["consecutivo_cot"], PDO::PARAM_STR);
        $stmt->bindParam(":estrato_cot", $datosModel["estrato_cot"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nac_cot", $datosModel["fecha_nac_cot"], PDO::PARAM_STR);
         $stmt->bindParam(":forma_pago_cot", $datosModel["forma_pago_cot"], PDO::PARAM_STR);
         $stmt->bindParam(":campana_cot", $datosModel["campana_cot"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_cliente_cot", $datosModel["tipo_cliente_cot"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cot", $datosModel["fecha_cot"], PDO::PARAM_STR);
        $stmt->bindParam(":id_sol", $datosModel["id_sol"], PDO::PARAM_STR);
        

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }




#Vista Asigancion
    public function vistaSolicitud($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_sol, poliza_sol,asesor_sol, nombre_tercero, asignacion_sol, tipo_asignacion, nombre_sol, servicio_sol, nombre_estado_preventa, fecha_prevista_sol, fecha_visita_comerc_sol, barrio_sol, nombre_Sec, localidad_sol,nombre_loc, cedula_sol , telefono1_sol, telefono2_sol, celular_sol , direccion_nueva_sol, obs_estado_sol, nombre_tipo_cliente FROM $tabla left join ap_tipo_cliente on ap_solicitud.tipo_clientegn_sol=ap_tipo_cliente.id_tipo_cliente left join ap_terceros on ap_solicitud.asesor_sol=ap_terceros.Id_tercero left JOIN ap_asignacion on ap_solicitud.asignacion_sol=ap_asignacion.id_asignacion LEFT join ap_estado_preventa on ap_solicitud.estado_sol=ap_estado_preventa.id_estado_preventa left join siax_sectores on ap_solicitud.barrio_sol=siax_sectores.cod_sec left join siax_localidad on ap_solicitud.localidad_sol=siax_localidad.id_loc where eliminar='0'");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }


public function modificarSolicitud($datosModel, $tabla)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla  SET nombre_sol=:nombre_sol, cedula_sol=:cedula_sol, localidad_sol= :localidad_sol, barrio_sol=:barrio_sol, direccion_pol_sol=:direccion_pol_sol, telefono1_sol=:telefono1_sol, celular_sol=:celular_sol where id_sol=:id_sol");
        $stmt->bindParam(":nombre_sol", $datosModel["nombre_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":cedula_sol", $datosModel["cedula_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":localidad_sol", $datosModel["localidad_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":barrio_sol", $datosModel["barrio_sol"], PDO::PARAM_STR);
         $stmt->bindParam(":direccion_pol_sol", $datosModel["direccion_pol_sol"], PDO::PARAM_STR);
         $stmt->bindParam(":telefono1_sol", $datosModel["telefono1_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":celular_sol", $datosModel["celular_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":id_sol", $datosModel["id_sol"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        }

        else{

            return "error";
        }

        $stmt->close();


    }

    public function programarSolicitud($datosModel, $tabla)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla  SET asesor_sol=:asesor_sol, asignacion_sol=:asignacion_sol, fecha_visita_comerc_sol= :fecha_visita_comerc_sol, direccion_nueva_sol=:direccion_nueva_sol, estado_sol='2' where id_sol=:id_sol");
        $stmt->bindParam(":asesor_sol", $datosModel["asesor_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":asignacion_sol", $datosModel["tipo_asignacion"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_visita_comerc_sol", $datosModel["fecha_visita_comerc_sol"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_nueva_sol", $datosModel["direccion_nueva_sol"], PDO::PARAM_STR);
        
        $stmt->bindParam(":id_sol", $datosModel["id_sol"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        }

        else{

            return "error";
        }

        $stmt->close();


    }
     public function EliminarSolicitud($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla  SET eliminar=:eliminar where id_sol=:id_sol");
        $stmt->bindParam(":eliminar", $datosModel["eliminar"], PDO::PARAM_STR);
        $stmt->bindParam(":id_sol", $datosModel["id_sol"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        }

        else{

            return "error";
        }

        $stmt->close();


    }

     public function vistaAsesor($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT Id_tercero, nombre_tercero, tipo_tercero FROM $tabla where tipo_tercero='4'");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
     public function vistaAsigancion($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

     public function vistaEstado($tabla)
    {
    $stmt = Conexion::conectar()->prepare("SELECT id_estado_preventa, nombre_estado_preventa FROM $tabla WHERE id_estado_preventa='2'");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
    public function vistaFormaPago($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT Id_medio_pago, nombre_medio_pago FROM $tabla ");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
    public function vistaCampana($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_campana, nombre_campana FROM $tabla ");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
     public function vistaTipoCliente($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_tipo_cliente, nombre_tipo_cliente FROM $tabla ");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }
}