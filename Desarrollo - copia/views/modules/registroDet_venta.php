  <?php
  session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
  include "views/modules/navegacion.php";
  include "views/modules/header.php";
  ?>
    <section class="content-header">
      <h1>
        Detalle de venta
        <small>Optional description</small>
      </h1> 

    <!-- Main content -->
    <section class="content container-fluid">
 <form class="form-horizontal" method="POST" action="registrar.php" autocomplete="off">
     
        <fieldset>
     
     <br>
      
<div class="form-group">
  <div class=" col-md-4">
          <label for="">Detalle de venta:</label>
            <input  type="text" class="form-control" name="nombre_sol"  id="nombre_sol">
        </div>
        <div class="col-md-4">
        <label for="">Codigo</label>
          <select class="form-control" id="codigo_det_venta" name="codigo_det_venta">
             
          </select>
        </div>
         
         <div class=" col-md-4">
          <label for="">Descripcion de venta:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        
       
</div>
<div class="form-group">
         
        
         <div class=" col-md-4">
          <label for="">Precio de venta:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
          <div class=" col-md-4">
          <label for="">Cantidad:</label>
            <input  type="text" class="form-control" name="nombre_sol"  id="nombre_sol">
        </div>
         <div class="col-md-4">
        <label for="">Tipo producto</label>
          <select class="form-control" id="tipo_det_venta" name="tipo_det_venta">
             
          </select>
        </div>
        <div class=" col-md-6">
         <input type="text" class="form-control" id="id_sol" name="id_sol" placeholder="id" style="visibility: hidden;" >
      </div>
</div>
<div class="form-group">
       
</div>
   

    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="tablaSol.php" class="btn btn-default">Regresar</a>
      <button type="submit" align="center" class="btn btn-primary" name="submit" value="Agregar" action="registroSol.php" >Registrar</button>
          
        </div>
    </div>
      
      </form> 
 <div class="row table-responsive">
         <?php

      
          
  $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
  
  if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
  }
          $_pagi_sql=("SELECT * FROM `ap_detalle_venta`"); 

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <table class="table table-striped" ">
          <thead>
            <tr>
              <th>Id</th>
              <th>Detalle</th>
              <th>Codigo </th>
              <th>Descripcion</th>
              <th>Tipo de venta</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Total</th>

              
              
              <th></th>
              <th></th>
            </tr>
          </thead>
          <?php 
      $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){
      ?>
          <tbody>
             <tr>
            <td><?php echo $arreglo[''];?> </td>
            <td><?php echo $arreglo[''];?></td>
            <td><?php echo $arreglo[''];?></td>
            <td><?php echo $arreglo[''];?></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
        </tr>
          </tbody>
          <?php  } ?>
        </table>
      </div>
    </div>
    </section>

    <?php

    include "views/modules/footer.php";

    ?>