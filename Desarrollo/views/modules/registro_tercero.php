
<?php
include "views/modules/navegacion.php";
include "views/modules/header.php";
?><div class="row">
    <div class="col-md-12">
<h2  class="box-title">Registrar solicitud</h2>
        <div class="box box-primary">
            <div class="box-header with-border">
                
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="container">
           <form class="form-horizontal" method="POST" action="registrar.php" autocomplete="off">
     
        <fieldset>
<legend>Datos de contacto:</legend>
     
     
      <div class="form-group">
     <div class="col-md-4"> 
        <label for="">Tipo tercero:</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="">seleccionar tercero</option>
            </select>
        </div> </div>
        <div class="form-group">
         <div class=" col-md-4">
          <label for="">Nombre:</label>
            <input  type="text" class="form-control" name="nombre_sol" required="" id="nombre_sol">
          </div>
          <div class=" col-md-3">
          <label for="">Nit:</label>
            <input  type="text" class="form-control" name="nombre_sol" required="" id="nombre_sol">
          </div>
        </div>
        <div class="form-group">
         <div class=" col-md-4">
          <label for="">Direccion:</label>
            <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol">
        </div>
           <div class=" col-md-3">
        
          <label for="">Correo electronico:</label>
          <input type="text" class="form-control" name="email_sol"  required="" id="email_sol" >
        </div>
    
      </div>
   


    <div class="form-group">
        <div class=" col-md-3"> 
        <label for="">Telefono:</label>      
          <input type="text" class="form-control" name="telefono1_sol" required="" id="telefono1_sol" >
        </div>

        <div class=" col-md-3">
          <label for="">Telefono opcional:</label>
          <input type="text" class="form-control" name="telefono2_sol"  id="telefono2_sol" >
        </div>

        <div class=" col-md-3"> 
          <label for="">Fax:</label>
          <input type="text" class="form-control" name="celular_sol"  id="celular_sol" >
        </div>
        </div>
       
        
    <div class="form-group">   

        <div class=" col-md-4">
          <label for="">contacto:</label>
            <input type="text" class="form-control" name="direccion_pol_sol" required="" id="direccion_pol_sol">
        </div>
  <div class="col-md-2"> 
        <label for="">Gran contribuyente:</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
         <div class="col-md-2"> 
        <label for="">Auto retenedor:</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
         
  
    </div>
    <div class="form-group">
        
 <div class="col-md-3"> 
        <label for="">Regimen comun :</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
       <div class="col-md-3"> 
        <label for="">Responsable de materiales :</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
          <div class="col-md-3"> 
        <label for="">Grupo nomina</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="1">tipo nomina</option>
        
            </select>
        </div>
        <div class="col-md-2"> 
        <label for="">Activar :</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
      </div>

      
    
          

       

  

    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="Tterceros" class="btn btn-default">Regresar</a>
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
      