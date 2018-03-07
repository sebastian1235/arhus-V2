   <?php include"views/modules/header.php";
 include"views/modules/navegacion.php"; ?>

  <section class="content container-fluid">
 <form class="form-horizontal" method="POST" action="registrar.php" autocomplete="off">
     
        <fieldset>
     
     <br>
      
<div class="form-group">
         <div class=" col-md-4">
          <label for="">Tipo de asignacion:</label>
            <input  type="text" class="form-control" name="nombre_sol"  id="nombre_sol">
        </div>
</div>
<div class="form-group">
         <div class=" col-md-4">
          <label for="">Comision por obra:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
         <div class=" col-md-4">
          <label for="">Comision por gasodomestico:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
         <div class=" col-md-4">
          <label for="">Comision fija:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-6">
         <input type="text" class="form-control" id="id_sol" name="id_sol" placeholder="id" style="visibility: hidden;" >
      </div>
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
          $mysqli = new mysqli('localhost', 'root', '', 'arhus');
  
  if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
  }
          $_pagi_sql=("SELECT * FROM `ap_asignacion`"); 

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <table class="table table-striped" ">
          <thead>
            <tr>
              <th>Tipo de asignacion</th>
              <th>Comision por obra</th>
              <th>Nombre por gasodomestico</th>
              <th>Nombre fija</th>
              
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
            <td><?php echo $arreglo['tipo_asignacion'];?> </td>
            <td><?php echo $arreglo['comision_obra_asignacion'];?></td>
            <td><?php echo $arreglo['comision_gasod_asignacion'];?></td>
            <td><?php echo $arreglo['comision_fija_asignacion'];?></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
        </tr>
          </tbody>
          <?php  } ?>
        </table>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>