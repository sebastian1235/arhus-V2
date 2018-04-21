<?php

require_once"conexion.php";

class notificacionModel{

  public function NotificacionMoldel($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_sol, poliza_sol,asesor_sol, nombre_tercero, asignacion_sol, tipo_asignacion, nombre_sol, servicio_sol, nombre_estado_preventa, fecha_prevista_sol, fecha_visita_comerc_sol, barrio_sol, nombre_Sec, localidad_sol,nombre_loc, cedula_sol , telefono1_sol, telefono2_sol, celular_sol , direccion_nueva_sol, obs_estado_sol, nombre_tipo_cliente,estado_cot FROM $tabla left join ap_tipo_cliente on ap_solicitud.tipo_clientegn_sol=ap_tipo_cliente.id_tipo_cliente left join ap_terceros on ap_solicitud.asesor_sol=ap_terceros.Id_tercero left JOIN ap_asignacion on ap_solicitud.asignacion_sol=ap_asignacion.id_asignacion LEFT join ap_estado_preventa on ap_solicitud.estado_sol=ap_estado_preventa.id_estado_preventa left join siax_sectores on ap_solicitud.barrio_sol=siax_sectores.cod_sec left join siax_localidad on ap_solicitud.localidad_sol=siax_localidad.id_loc where estado_sol='2' ");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
    }

	
}