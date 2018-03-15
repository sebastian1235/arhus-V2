<?php


$nombre_item=$_POST["nombre_item"];
$codigo_item=$_POST["codigo_item"];
$tipo_item=$_POST["tipo_item"];
$und_item=$_POST["und_item"];
$precio_item=$_POST["precio_item"];
$costo_item=$_POST["costo_item"];
$marca_item=$_POST["marca_item"];
$cod_marca_item=$_POST["cod_marca_item"];
$detalle_item=$_POST["detalle_item"];

	
$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
	
	

			mysqli_query($con,"INSERT INTO ap_items_inv  ( nombre_item, codigo_item, tipo_item, und_item, precio_item, costo_item, marca_item, cod_marca_item, detalle_item) VALUES ('$nombre_item','$codigo_item','$tipo_item','$und_item','$precio_item','$costo_item','$marca_item','$cod_marca_item','$detalle_item')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Agregado");</script> ';

				echo "<script>location.href='Titems'</script>";

				
?>
