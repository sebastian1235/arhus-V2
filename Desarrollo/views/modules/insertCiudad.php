<?php


$nombre_ciu=$_POST["nombre_ciu"];
	
$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
	
	

			mysqli_query($con,"INSERT INTO siax_ciudad (nombre_ciu) VALUES ('$nombre_ciu')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Agregado");</script> ';

			//echo "<script>location.href='registro_ciudad'</script>";

				
?>
