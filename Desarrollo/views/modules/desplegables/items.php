 <?php

 $user="root";
 $pass="";
 $server="localhost";
 $bd="arhus";

 $con = mysqli_connect($server,$user,$pass,$bd);

 $result = mysqli_query($con,"SELECT * FROM ap_items_inv");

 while ($row = mysqli_fetch_array($result)){

 	 echo '<option value="'.$row['Id_item'].'">'.$row['nombre_item'].'</option>';

 }

 ?>