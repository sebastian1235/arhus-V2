<?php
	
	$mysqli = new mysqli('localhost', 'root', '', 'arhus');
	
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>