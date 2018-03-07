 <?php

 $user="root";
 $pass="";
 $server="localhost";
 $bd="arhus";

 $con = mysqli_connect($server,$user,$pass,$bd);

 $result = mysqli_query($con,"SELECT * FROM siax_localidad");

 while ($row = mysqli_fetch_array($result)){

 	 echo '<option value="'.$row['id_loc'].'">'.$row['nombre_loc'].'</option>';

 }

 ?>