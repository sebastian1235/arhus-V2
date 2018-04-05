

<?php


$mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');

if($mysqli->connect_error){

    die('Error en la conexion' . $mysqli->connect_error);

}



if (substr($_FILES['excel']['name'],-3)=="csv")
{
    $fecha		= date("Y-m-d");
    $carpeta 	= "tmp_excel/";
    $excel  	= $fecha."-".$_FILES['excel']['name'];

    move_uploaded_file($_FILES['excel']['tmp_name'], "$carpeta$excel");

    $row = 0;

    $fp = fopen ("$carpeta$excel","r");

    //fgetcsv. obtiene los valores que estan en el csv y los extrae.

    mysqli_query($mysqli,"DELETE FROM demanda");

    while ($data = fgetcsv ($fp, 1000, ";"))
    {
        //si la linea es igual a 1 no guardamos por que serian los titulos de la hoja del excel.
        ($row!=0);



        mysqli_query($mysqli,"insert into demanda (	
									origen_dem, 
									tipo_cliente_dem, 
									fecha_llamada,
									 cod_dem, 
									 poliza_dem, 
									 usuario_captura, 
									 campana_demanda, 
									 chip_natural, 
									 estado_predio, 
									 tipo_predio, 
									 uso, 
									 mecado, 
									 nombre_cliente, 
									 num_doc, 
									 direccion, 
									 municipio, 
									 telefono, 
									 cod_trabajo_original, 
									 fecha_trab_dem, 
									 cod_ult_visit, 
									 res_ult_vis, 
									 fecha_ult_visita, 
									 usu_asig_primer_trab, 
									 fecha_prim_visit, 
									 respuesta_pv, 
									 fecha_cap_primera_visita, 
									 cod_contratista, 
									 nom_cont, 
									 distrito, 
									 malla, 
									 sector, 
									 descr_estado_dem, 
									 estrato, 
clase_dem ) VALUES ('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]','$data[21]','$data[22]','$data[23]','$data[24]','$data[25]','$data[26]','$data[27]','$data[28]','$data[29]','$data[30]','$data[31]','$data[32]','$data[33]')");



        $row++;

    }

    echo "<div class='alert alert-primary' role='alert'>
  subio satisfactoriamente
</div>";
   echo "<script>location.href='subirArchivo'</script>";

 mysqli_query($mysqli,"INSERT INTO `ap_solicitud`(`demanda_sol`,`poliza_sol`,`cedula_sol`,`nombre_sol`,`direccion_pol_sol`,`direccion_nueva_sol`,`telefono1_sol`,`barrio_sol`,`obs_estado_sol`, `fecha_prevista_sol`)SELECT cod_dem, poliza_dem, num_doc, nombre_cliente, direccion, direccion, telefono, sector, observacion, fecha_llamada FROM demanda_sin_sol");


}

?>