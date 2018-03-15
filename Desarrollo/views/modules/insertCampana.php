<?php


$nombre_campana=$_POST["nombre_campana"];
$descuente_campana=$_POST["descuente_campana"];
$desc_financ_campana=$_POST["desc_financ_campana"];
$plazo_max_campana=$_POST["plazo_max_campana"];
$detalle_campana=$_POST["detalle_campana"];
$aplicacion_campana=$_POST["aplicacion_campana"];
$desde_campana=$_POST["desde_campana"];
$hasta_campana=$_POST["hasta_campana"];
$vigente_campana=$_POST["vigente_campana"];
$tasa_campana=$_POST["tasa_campana"];
$descuento_fijo_campana=$_POST["descuento_fijo_campana"];
$manto_max_campana=$_POST["manto_max_campana"];
$condiciones_campana=$_POST["condiciones_campana"];

	
$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
	
	

			mysqli_query($con,"INSERT INTO siax_campana  (nombre_campana, descuente_campana, desc_financ_campana, plazo_max_campana, detalle_campana,  aplicacion_campana, desde_campana, hasta_campana, vigente_campana, tasa_campana, descuento_fijo_campana, manto_max_campana, condiciones_campana) VALUES ('$nombre_campana','$descuente_campana','$desc_financ_campana','$plazo_max_campana','$detalle_campana','$aplicacion_campana','$desde_campana','$hasta_campana','$vigente_campana','$tasa_campana','$descuento_fijo_campana','$manto_max_campana','$condiciones_campana')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Agregado");</script> ';

			//echo "<script>location.href='Tcampanas'</script>";

				
?>
