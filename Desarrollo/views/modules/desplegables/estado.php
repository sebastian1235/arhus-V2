 <?php

 $user="root";
 $pass="";
 $server="localhost";
 $bd="arhus";

 $con = mysqli_connect($server,$user,$pass,$bd);

 $result = mysqli_query($con,"SELECT * FROM ap_estado_preventa");

 while ($row = mysqli_fetch_array($result)){

 	 echo '<option value="'.$row['id_estado_preventa'].'">'.$row['nombre_estado_preventa'].'</option>';

 }

 ?>