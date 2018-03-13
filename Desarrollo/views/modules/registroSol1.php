<?php

$id_sol=$_POST["id_sol"];
$poliza_sol=$_POST["poliza_sol"];
$demanda_sol=$_POST["demanda_sol"];
$asesor_sol=$_POST["asesor_sol"];
$asignacion_sol=$_POST["asignacion_sol"];
$cedula_sol=$_POST["cedula_sol"];
$nombre_sol=$_POST["nombre_sol"];
$direccion_pol_sol=$_POST["direccion_pol_sol"];
$direccion_nueva_sol=$_POST["direccion_nueva_sol"];
$barrio_sol=$_POST["barrio_sol"];
$telefono1_sol=$_POST["telefono1_sol"];
$telefono2_sol=$_POST["telefono2_sol"];
$celular_sol=$_POST["celular_sol"];
$email_sol=$_POST["email_sol"];
$servicio_sol=$_POST["servicio_sol"];
$obs_sol=$_POST["obs_sol"];
$estado_sol=$_POST["estado_sol"];
$fecha_prevista_sol=$_POST["fecha_prevista_sol"];
$fecha_visita_comerc_sol=$_POST["fecha_visita_comerc_sol"];
$obs_estado_sol=$_POST["obs_estado_sol"];
$forma_pagogn_sol=$_POST["forma_pagogn_sol"];
$localidad_sol=$_POST["localidad_sol"];

	
$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
	
	

			mysqli_query($con,"INSERT INTO ap_solicitud  (id_sol, poliza_sol, demanda_sol, asesor_sol, asignacion_sol, cedula_sol, nombre_sol, direccion_pol_sol, direccion_nueva_sol, barrio_sol, telefono1_sol, telefono2_sol, celular_sol, email_sol, servicio_sol, obs_sol, estado_sol, fecha_prevista_sol,fecha_visita_comerc_sol,obs_estado_sol,forma_pagogn_sol, localidad_sol) VALUES ('$id_sol','$poliza_sol','$demanda_sol','$asesor_sol','$asignacion_sol','$cedula_sol','$nombre_sol','$direccion_pol_sol','$direccion_nueva_sol','$barrio_sol','$telefono1_sol','$telefono2_sol','$celular_sol','$email_sol','$servicio_sol','$obs_sol','$estado_sol','$fecha_prevista_sol','$fecha_visita_comerc_sol','$obs_estado_sol','$forma_pagogn_sol','$localidad_sol')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Agregado");</script> ';

			echo "<script>location.href='TSolicitudes'</script>";

				
?>
