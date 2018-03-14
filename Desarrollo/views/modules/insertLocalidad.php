<?php


$nombre_loc=$_POST["nombre_loc"];
$cod_loc=$_POST["cod_loc"];
$idciudad_loc=$_POST["idciudad_loc"];


$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
	
	

			mysqli_query($con,"INSERT INTO siax_localidad (nombre_loc, cod_loc, idciudad_loc ) VALUES ('$nombre_loc', '$cod_loc', '$idciudad_loc' )");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Agregado");</script> ';

				echo "<script>location.href='registro_ciudad'</script>";

				
?>
