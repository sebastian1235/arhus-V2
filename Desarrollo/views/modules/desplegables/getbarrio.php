<?php

 include('../../models/conexion.php');

 $action = $_REQUEST['action'];
 
 if($action=="showAll"){
  
  $stmt=$dbcon->prepare('SELECT * FROM siax_sectores ORDER BY nombre_sec');
  $stmt->execute();
  
 }else{
  
  $stmt=$dbcon->prepare('SELECT * FROM siax_sectores WHERE nombre_sec=:cid ORDER BY nombre_sec');
  $stmt->execute(array(':cid'=>$action));
 }
 
 ?>
 <div class="row">
 <?php
 if($stmt->rowCount() > 0){
  
  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
  {
   extract($row);
 
   ?>
   <div class="col-xs-3">
   <div style="border-radius:3px; border:#cdcdcd solid 1px; padding:22px;"><?php echo $product_name; ?></div><br />
   </div>
   <?php  
  }
  
 }else{
  
  ?>
        <div class="col-xs-3">
   <div style="border-radius:3px; border:#cdcdcd solid 1px; padding:22px;"><?php echo $product_name; ?></div><br />
  </div>
        <?php  
 }
 
 
 ?>
 </div>