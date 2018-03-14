<?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>


<section class="content container-fluid">

      <div class="row">
      
      </div>
      
      <div class="row">
        <a href="registro_tercero" class="btn btn-primary">Nuevo Registro</a>
      </div>
      <div class="row table-responsive">
      <br>
      <h1>Solicitudes</h1>
      <div >
         <?php
          
  $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
  
  if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
  }
          $_pagi_sql=("SELECT * FROM `ap_terceros`"); 

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Poliza</th>
              <th>Asignacion</th>
              <th>Contacto</th>

              <th></th>
            </tr>
          </thead>
          <?php 
      $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){
      ?>
          <tbody>
             <tr>
            <td><?php echo $arreglo['nombre_tercero'];?> </td>
            <td><?php echo $arreglo['telefono1_tercero'];?></td>
            <td><?php echo $arreglo['e_mail_tercero'];?></td>
            <td><?php echo $arreglo['Contacto_tercero'];?> </td>

            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
        </tr>
          </tbody>
          <?php  } ?>
        </table>
      </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
          </div>
          
          <div class="modal-body">
            ¿Desea eliminar este registro?
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a class="btn btn-danger btn-ok">Delete</a>
          </div>
        </div>
      </div>
    </div>
    
    <script>
      $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        
        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
      });
    </script>

    </section>

<?php

include "views/modules/footer.php";

?>
    