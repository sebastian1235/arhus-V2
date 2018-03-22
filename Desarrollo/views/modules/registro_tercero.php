
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
$resul_items = mysqli_query($con,"SELECT * FROM ap_tipo_tercero");
?><div class="row">
    <div class="col-md-12">
<h2  class="box-title">Registrar Tercero</h2>
        <div class="box box-primary">
            <div class="box-header with-border">
                
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="container">
           <form class="form-horizontal" method="POST" id="registroTerceros" autocomplete="off">
     
        <fieldset>
<legend>Datos de contacto:</legend>
     
     
      <div class="form-group">
           <div class="col-md-4"> 
        <label for="">Tipo tercero:</label>         
            <select class="form-control" id="tipo_tercero"  name="tipo_tercero">
            <option value="">seleccionar tercero</option>
                <?php while ($row = mysqli_fetch_array($resul_items)){
                    echo '<option value="'.$row['id_tipo_tercero'].'">'.$row['nombre_tipo_ter'].'</option>';

                } ?>
            </select>
        </div>
     </div>
        <div class="form-group">
      
         <div class=" col-md-4">
          <label for="">Nombre:</label>
            <input  type="text" class="form-control" name="nombre_tercero"  id="nombre_tercero">
          </div>
          <div class=" col-md-3">
          <label for="">Nit:</label>
            <input  type="text" class="form-control" name="nit_tercero"  id="nit_tercero">
          </div>
        </div>
        <div class="form-group">
         <div class=" col-md-4">
          <label for="">Direccion:</label>
            <input type="text" class="form-control" name="direccion_tercero"   id="direccion_tercero">
        </div>
           <div class=" col-md-3">
        
          <label for="">Correo electronico:</label>
          <input type="text" class="form-control" name="e_mail_tercero"   id="e_mail_tercero" >
        </div>
    
      </div>
   


    <div class="form-group">
        <div class=" col-md-3"> 
        <label for="">Telefono:</label>      
          <input type="text" class="form-control" name="telefono1_tercero"  id="telefono1_tercero" >
        </div>

        <div class=" col-md-3">
          <label for="">Telefono opcional:</label>
          <input type="text" class="form-control" name="telefono2_tercero"  id="telefono2_tercero" >
        </div>

        <div class=" col-md-3"> 
          <label for="">Fax:</label>
          <input type="text" class="form-control" name="fax_tercero"  id="fax_tercero" >
        </div>
        </div>
       
        
    <div class="form-group">   

        <div class=" col-md-4">
          <label for="">contacto:</label>
            <input type="text" class="form-control" name="Contacto_tercero" required="" id="Contacto_tercero">
        </div>
  <div class="col-md-2"> 
        <label for="">Gran contribuyente:</label>         
            <select class="form-control" id="gran_contrib_tercero"  name="gran_contrib_tercero">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
         <div class="col-md-2"> 
        <label for="">Auto retenedor:</label>         
            <select class="form-control" id="autoretenedor_tercero"  name="autoretenedor_tercero">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
         
  
    </div>
    <div class="form-group">
        
 <div class="col-md-3"> 
        <label for="">Regimen comun :</label>         
            <select class="form-control" id="reg_comun_tercero"  name="reg_comun_tercero">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
       <div class="col-md-3"> 
        <label for="">Responsable de materiales :</label>         
            <select class="form-control" id="responsable_materiales_tercero"  name="responsable_materiales_tercero">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
       
        <div class="col-md-2"> 
        <label for="">Activar :</label>         
            <select class="form-control" id="activo_tercero" "" name="activo_tercero">
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
     <button type="submit" align="center" class="btn btn-primary" name="guardarTerceros" id="guardarTerceros"  >Registrar</button>
           <?php
                $crearTerceros = new tercero();
                $crearTerceros -> registroTerceroController();
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
      