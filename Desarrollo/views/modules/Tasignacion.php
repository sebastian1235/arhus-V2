  <?php
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>

<section class="content container-fluid">
      <div class="row">
      
      </div>
      
      <div class="row">
        <a href="registro_asignacion" class="btn btn-primary">Nuevo Registro</a>
      </div>
      <div class="row table-responsive">
      <br>
      
      <div class="container" >
 
<div class="row table-responsive">
         <?php
          $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
  
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