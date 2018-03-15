<?php



$nombre_sec=$_POST["nombre_sec"];
$localidad=$_POST["localidad"];


$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
	
	

			mysqli_query($con,"INSERT INTO siax_sectores( nombre_sec, localidad ) VALUES ( '$nombre_sec', '$localidad')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Agregado");</script> ';

				echo "<script>location.href='registro_ciudad'</script>";

				
?>
