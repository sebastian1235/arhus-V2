<?php
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>


<section class="content container-fluid">

      <div class="row">
      
      </div>
      
      <div class="row">
        <a href="registro_items" class="btn btn-primary">Nuevo Registro</a>
      </div>
      <div class="row table-responsive">
      <br>
      <h1>Items de inventario</h1>
      <div >
         <?php
          
  $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
  
  if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
  }
          $_pagi_sql=("SELECT * FROM `ap_items_inv`"); 

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Item</th>
              <th>Precio</th>
              <th>Costo</th>
              <th>Detalle</th>
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
            <td><?php echo $arreglo['codigo_item'];?> </td>
            <td><?php echo $arreglo['nombre_item'];?></td>
            <td><?php echo $arreglo['precio_item'];?></td>
            <td><?php echo $arreglo['costo_item'];?> </td>
            <td><?php echo $arreglo['detalle_item'];?></td>
        

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
    