 <?php

 $user="root";
 $pass="";
 $server="localhost";
 $bd="arhus";

 $con = mysqli_connect($server,$user,$pass,$bd);

 $result = mysqli_query($con,"SELECT * FROM ap_tipo_inv");

 while ($row = mysqli_fetch_array($result)){

 	 echo '<option value="'.$row['id_tipo_inv'].'">'.$row['nombre_tipo_inv'].'</option>';

 }

 ?>