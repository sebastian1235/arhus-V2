   <?php include"views/modules/header.php";
 include"views/modules/navegacion.php"; ?>

  <section class="content container-fluid">
    <h2 class="box-title">Registro de campañas</h2>
      <div class="box box-primary">
            <div class="box-header with-border">
                
        <small>Campañas y redescuentos</small>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           <form class="form-horizontal" method="POST" action="registrar.php" autocomplete="off">
     
        <fieldset>
     
     <br>
     <div class="container">
      
<div class="form-group">
         <div class=" col-md-3">
          <label for="">Campaña :</label>
            <input  type="text" class="form-control" name="nombre_sol"  id="nombre_sol">
        </div>
         <div class=" col-md-3">
          <label for="">Detalle de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-3">
          <label for="">Aplicacion de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
      
</div>
<div class="form-group">
          <div class=" col-md-2">
          <label for="">Redescuento campaña</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-2">
          <label for="">Redescuento fijo:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-2">
          <label for="">Descuento financiacion</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
  </div>
      <div class="form-group" > 
         <div class=" col-md-2">
          <label for="">fecha inicio:</label>
            <input type="date" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-2">
          <label for="">fecha fin :</label>
            <input type="date" class="form-control" name="cedula_sol" id="cedula_sol">
          </div>
        <div class=" col-md-2">
          <label for="">Plazo maximo</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
         <div class=" col-md-2">
         <input type="text" class="form-control" id="id_sol" name="id_sol" placeholder="id" style="visibility: hidden;" >
      </div>
    </div>   
         

<div class="form-group">
 
       
          <div class=" col-md-4">
          <label for="">Vigencia de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-2">
          <label for="">Tasa de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        
      </div>
      <div class="form-group "> 
         
         <div class=" col-md-3">
          <label for="">Monto maximo:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-3">
          <label for="">Condiciones de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
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
      </div>
      </form> 
        </div>
 
 <div class="row table-responsive">
         <?php
          $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
  
  if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
  }
          $_pagi_sql=("SELECT * FROM `siax_campana`"); 

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <table id="example2" class="table table-bordered table-hover"   >
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
            <td><?php echo $arreglo['nombre_campana'];?> </td>
            <td><?php echo $arreglo['descuente_campana'];?></td>
            <td><?php echo $arreglo['desc_financ_campana'];?></td>
                
            <td><?php echo $arreglo['detalle_campana'];?></td>
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
  