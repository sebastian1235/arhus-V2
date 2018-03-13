<?php


$tipo_asignacion=$_POST["tipo_asignacion"];
$comision_obra_asignacion=$_POST["comision_obra_asignacion"];
$comision_gasod_asignacion=$_POST["comision_gasod_asignacion"];
$comision_fija_asignacion=$_POST["comision_fija_asignacion"];



	
$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
	
	

			mysqli_query($con,"INSERT INTO ap_asignacion  ( tipo_asignacion, comision_obra_asignacion, comision_gasod_asignacion, comision_fija_asignacion) VALUES ('$tipo_asignacion','$comision_obra_asignacion','$comision_gasod_asignacion','$comision_fija_asignacion')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Agregado");</script> ';

			echo "<script>location.href='Tasignacion'</script>";

				
?>
