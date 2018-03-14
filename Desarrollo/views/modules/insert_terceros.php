<?php


$nombre_tercero=$_POST["nombre_tercero"];
$direccion_tercero=$_POST["direccion_tercero"];
$telefono1_tercero=$_POST["telefono1_tercero"];
$telefono2_tercero=$_POST["telefono2_tercero"];
$fax_tercero=$_POST["fax_tercero"];
$nit_tercero=$_POST["nit_tercero"];
$tipo_tercero=$_POST["tipo_tercero"];
$e_mail_tercero=$_POST["e_mail_tercero"];
$Contacto_tercero=$_POST["Contacto_tercero"];
$gran_contrib_tercero=$_POST["gran_contrib_tercero"];
$autoretenedor_tercero=$_POST["autoretenedor_tercero"];

$reg_comun_tercero=$_POST["reg_comun_tercero"];
$responsable_materiales_tercero=$_POST["responsable_materiales_tercero"];
$grupo_nomina_tercero=$_POST["grupo_nomina_tercero"];




	
$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
	
	

			mysqli_query($con,"INSERT INTO ap_terceros  ( nombre_tercero, direccion_tercero, telefono1_tercero, telefono2_tercero,fax_tercero, nit_tercero,tipo_tercero, e_mail_tercero, Contacto_tercero, gran_contrib_tercero, autoretenedor_tercero, reg_comun_tercero, responsable_materiales_tercero, grupo_nomina_tercero ) VALUES ('$nombre_tercero','$direccion_tercero','$telefono1_tercero','$telefono2_tercero','$fax_tercero','$nit_tercero','$tipo_tercero','$e_mail_tercero','$Contacto_tercero','$gran_contrib_tercero','$autoretenedor_tercero','$reg_comun_tercero','$responsable_materiales_tercero','$grupo_nomina_tercero')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Agregado");</script> ';

				echo "<script>location.href='Tterceros'</script>";

				
?>
