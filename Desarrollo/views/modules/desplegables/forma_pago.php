 <?php

 $user="root";
 $pass="";
 $server="localhost";
 $bd="arhus";

 $con = mysqli_connect($server,$user,$pass,$bd);

 $result = mysqli_query($con,"SELECT * FROM ap_forma_pago");

 while ($row = mysqli_fetch_array($result)){

 	 echo '<option value="'.$row['Id_forma_ap'].'">'.$row['nombre_forma_ap'].'</option>';

 }

 ?>