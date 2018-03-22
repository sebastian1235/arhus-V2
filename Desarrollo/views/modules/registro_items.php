<?php
session_start();
if(!$_SESSION["validar"]){
    header("location:ingreso");
    exit();
}
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>
<div class="row">
    <div class="col-md-12">
<h2  class="text-yellow">Registrar items de inventario</h2>
        <div class="box box-warning">
            <div class="box-header with-border">
                
            </div>
            <div class="container">
           <form class="form-horizontal" method="POST" id="registroItems" autocomplete="off">
      <div class="form-group">

         <div class=" col-md-3">
            <label for="">Nombre:</label>
            <input  type="text" class="form-control" name="nombre_item"  id="nombre_item" required>
        </div>
         <div class=" col-md-3">
          <label for="">Codigo:</label>
            <input type="text" class="form-control" name="codigo_item"  id="codigo_item" required>
        </div>
        <div class="col-md-3"> 
        <label for="">Tipo item:</label>         
            <select class="form-control" id="tipo_item"  name="tipo_item" required>
            <option value="0">Seleccione tipo de item</option>
                <?php
                $SelectTipoItem = new tipoInventarioController();
                $SelectTipoItem -> selectTipoInventario();
                ?>
            </select>
        </div> 
      </div>
   
  
    <div class="form-group">   
        <div class=" col-md-3">
          <label for="">Und_item:</label>
            <input type="text" class="form-control" name="und_item"   id="und_item" required>
        </div>
         <div class=" col-md-3">
          <label for="">Precio item:</label>
            <input type="text" class="form-control" name="precio_item"   id="precio_item" required>
        </div>
         <div class=" col-md-3">
          <label for="">Costo item:</label>
            <input type="text" class="form-control" name="costo_item"   id="costo_item" required>
        </div>
         
        
      </div>
      <div class="form-group">
        <div class=" col-md-3">
          <label for="">Marca:</label>
            <input type="text" class="form-control" name="marca_item"  id="marca_item" required>
        </div>
 
        <div class=" col-md-3">
          <label for="">Codigo marca</label>
          <input type="text" class="form-control" name="cod_marca_item"  id="cod_marca_item" required>
        </div>
        <div class=" col-md-3"> 
        <label for="">Dellate:</label>      
          <input type="text" class="form-control" name="detalle_item"  id="detalle_item"required>
        </div>
  
    </div>


<br>


    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="Titems" class="btn btn-default">Regresar</a>
      <button type="submit" align="center" class="btn btn-primary" name="guardarItems" id="guardarItems"  >Registrar</button>
           <?php
                        $crearAsigancion = new items();
                        $crearAsigancion -> registroItemsController();
                        ?>  
        </div>
    </div>
     
      </div> 

      </form>
        </div>
</div>
    </div>


<?php

include "views/modules/footer.php";

?>
      