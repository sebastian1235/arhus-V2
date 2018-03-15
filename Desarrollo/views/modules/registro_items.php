
<?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";


$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
//desplegables anidados
$resul_items = mysqli_query($con,"SELECT * FROM ap_tipo_inv");
?><div class="row">
    <div class="col-md-12">
<h2  class="box-title">Registrar items de inventario</h2>
        <div class="box box-primary">
            <div class="box-header with-border">
                
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="container">
           <form class="form-horizontal" method="POST" action="insertItems" autocomplete="off">
    

     
     
      <div class="form-group">

         <div class=" col-md-3">
          <label for="">Nombre:</label>
            <input  type="text" class="form-control" name="nombre_item"  id="nombre_item">
        </div>
         <div class=" col-md-3">
          <label for="">Codigo:</label>
            <input type="text" class="form-control" name="codigo_item"  id="codigo_item">
        </div>
        <div class="col-md-3"> 
        <label for="">Tipo item:</label>         
            <select class="form-control" id="tipo_item"  name="tipo_item">
            <option value="">tipo de item</option>
            <?php while ($row = mysqli_fetch_array($resul_items)){
                    echo '<option value="'.$row['id_tipo_inv'].'">'.$row['nombre_tipo_inv'].'</option>';

                } ?>

            </select>
        </div> 
      </div>
   
  
    <div class="form-group">   
        <div class=" col-md-3">
          <label for="">Und_item:</label>
            <input type="text" class="form-control" name="und_item"   id="und_item">
        </div>
         <div class=" col-md-3">
          <label for="">Precio item:</label>
            <input type="text" class="form-control" name="precio_item"   id="precio_item">
        </div>
         <div class=" col-md-3">
          <label for="">Costo item:</label>
            <input type="text" class="form-control" name="costo_item"   id="costo_item">
        </div>
         
        
      </div>
      <div class="form-group"  >
        <div class=" col-md-3">
          <label for="">Marca:</label>
            <input type="text" class="form-control" name="marca_item"  id="marca_item">
        </div>
 
        <div class=" col-md-3">
          <label for="">Codigo marca</label>
          <input type="text" class="form-control" name="cod_marca_item"  id="cod_marca_item" >
        </div>
        <div class=" col-md-3"> 
        <label for="">Dellate:</label>      
          <input type="text" class="form-control" name="detalle_item"  id="detalle_item" >
        </div>
  
    </div>


<br>


    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="Titems" class="btn btn-default">Regresar</a>
      <button type="submit" align="center" class="btn btn-primary" name="submit" value="Agregar" action="registro_items" >Registrar</button>
          
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
      