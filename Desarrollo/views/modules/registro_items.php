
<?php
include "views/modules/navegacion.php";
include "views/modules/header.php";
?><div class="row">
    <div class="col-md-12">
<h2  class="box-title">Registrar items de inventario</h2>
        <div class="box box-primary">
            <div class="box-header with-border">
                
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="container">
           <form class="form-horizontal" method="POST" action="registrar.php" autocomplete="off">
    

     
     
      <div class="form-group">

         <div class=" col-md-3">
          <label for="">Nombre:</label>
            <input  type="text" class="form-control" name="nombre_sol" required="" id="nombre_sol">
        </div>
         <div class=" col-md-3">
          <label for="">Codigo:</label>
            <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol">
        </div>
        <div class="col-md-3"> 
        <label for="">Tipo item:</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="">tipo de item</option>
            </select>
        </div> 
      </div>
   
  
    <div class="form-group">   
        <div class=" col-md-3">
          <label for="">Und_item:</label>
            <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol">
        </div>
         <div class=" col-md-3">
          <label for="">Precio item:</label>
            <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol">
        </div>
         <div class=" col-md-3">
          <label for="">Costo item:</label>
            <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol">
        </div>
         
        
      </div>
      <div class="form-group"  >
        <div class=" col-md-3">
          <label for="">Marca:</label>
            <input type="text" class="form-control" name="direccion_pol_sol" required="" id="direccion_pol_sol">
        </div>
 
        <div class=" col-md-3">
          <label for="">Codigo marca</label>
          <input type="text" class="form-control" name="direccion_nueva_sol"  id="direccion_nueva_sol" >
        </div>
        <div class=" col-md-3"> 
        <label for="">Dellate:</label>      
          <input type="text" class="form-control" name="telefono1_sol" required="" id="telefono1_sol" >
        </div>
  
    </div>


<br>


        


    

  

    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="Titems" class="btn btn-default">Regresar</a>
      <button type="submit" align="center" class="btn btn-primary" name="submit" value="Agregar" action="registroSol.php" >Registrar</button>
          
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
      