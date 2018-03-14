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

$result = mysqli_query($con,"SELECT * FROM siax_sectores");

$resul_localidad = mysqli_query($con,"SELECT * FROM siax_localidad");
$resul_asesor = mysqli_query($con,"SELECT * FROM ap_terceros");
$resul_estado = mysqli_query($con,"SELECT * FROM ap_estado_preventa");
$resul_fp = mysqli_query($con,"SELECT * FROM ap_forma_pago");
?>





<div class="row">
    <div class="col-md-12">
<h2  class="box-title">Registrar solicitud</h2>
        <div class="box box-primary">
            <div class="box-header with-border">
                
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="container">
           <form class="form-horizontal" method="POST" action="registroSol1" autocomplete="off">
     
        <fieldset>
<legend>Datos de contacto:</legend>
     
     
      <div class="form-group">

         <div class=" col-md-4">
          <label for="">Nombre:</label>
            <input  type="text" class="form-control" name="nombre_sol" required="" id="nombre_sol">
        </div>
         <div class=" col-md-4">
          <label for="">Cedula:</label>
            <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol">
        </div>
      </div>
   
  
    <div class="form-group">   
        <div class="col-md-4"> 
        <label for="">Barrio:</label>         
            <select class="form-control" id="barrio_sol" required="" name="barrio_sol">
              <option value="">seleccionar barrio</option>
            <option value=""><?php while ($row = mysqli_fetch_array($result)){

                    echo '<option value="'.$row['cod_sec'].'">'.$row['nombre_sec'].'</option>';

                } ?></option>
            </select>
        </div> 
        <div class="col-md-4"> 
        <label for="">Localidad:</label>         
            <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
            <option value="">seleccionar barrio</option>
              <option value=""><?php while ($row = mysqli_fetch_array($resul_localidad)){
                    echo '<option value="'.$row['id_loc'].'">'.$row['nombre_loc'].'</option>';

                } ?></option>
            </select>
        </div> 
      </div>
      <div class="form-group"  >
        <div class=" col-md-4">
          <label for="">Direccion:</label>
            <input type="text" class="form-control" name="direccion_pol_sol" required="" id="direccion_pol_sol">
        </div>
 
        <div class=" col-md-4">
          <label for="">Direccion 2</label>
          <input type="text" class="form-control" name="direccion_nueva_sol"  id="direccion_nueva_sol" >
        </div>
  
    </div>


    <div class="form-group">
        <div class=" col-md-4"> 
        <label for="">Telefono:</label>      
          <input type="text" class="form-control" name="telefono1_sol" required="" id="telefono1_sol" >
        </div>

        <div class=" col-md-4">
          <label for="">Telefono opcional:</label>
          <input type="text" class="form-control" name="telefono2_sol"  id="telefono2_sol" >
        </div>

        <div class=" col-md-3">
          <label for="">Celular:</label>
          <input type="text" class="form-control" name="celular_sol"  id="celular_sol" >
        </div>
          
        <div class=" col-md-4">
          <br>
          <label for="">Correo electronico:</label>
          <input type="text" class="form-control" name="email_sol"  required="" id="email_sol" >
        </div>
        
     </div>
      
   </fieldset>
<br>


         <fieldset>
     <legend>Datos de solicitiud:</legend>
      <div class="form-group">
      <div class=" col-md-6">
         <input type="text" class="form-control" id="id_sol" name="id_sol" placeholder="id" style="visibility: hidden;" >
      </div>
       </div>
      
      <div class="form-group">
        

      <div class=" col-md-5">
        <label for="">Numero de poliza</label>
          <input type="text" class="form-control" id="poliza_sol"  name="poliza_sol" placeholder="Numero de poliza">
      </div>
       <div class=" col-md-5">
        <label for="">Demanda</label>
          <input type="text" class="form-control" id="demanda_sol"  name="demanda_sol" placeholder="Demanda">
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-5">
        <label for="">Nombre asesor</label>
          <select class="form-control" id="asesor_sol" name="asesor_sol">
            <option value="">Asesor</option>
             <option value=""><?php while ($row = mysqli_fetch_array($resul_asesor)){
                    echo '<option value="'.$row['Id_tercero'].'">'.$row['nombre_tercero'].'</option>';

                } ?></option>
          </select>
        </div>
        <div class=" col-md-5">
      <label for="">Asignacion de solicitud</label>
        <input type="text" class="form-control" id="asignacion_sol"  name="asignacion_sol" placeholder="Asigacion solicitud">
        </div>
         
      </div>
   
      
<div class="form-group">
      <div class=" col-md-5">
        <label for="">servicio solicitud</label> 
        
        <input type="text" class="form-control" name="servicio_sol"  id="servicio_sol" placeholder="servicio_sol">
        </div>
       <div class=" col-md-5">
        <label for="">Observacion solicitud</label>
        <textarea class="form-control" name="obs_sol"  id="obs_sol" placeholder="obs_sol"></textarea>
        </div>
         <div class="col-md-5">
        <label for="">Estado de solicitud</label>
        <select class="form-control" id="estado_sol" name="estado_sol" >
          <option value="">Estado</option>
              <option value=""><?php while ($row = mysqli_fetch_array($resul_estado)){
                    echo '<option value="'.$row['id_estado_preventa'].'">'.$row['nombre_estado_preventa'].'</option>';

                } ?></option>
        </select>
        </div>
        <div class=" col-md-5">
        <label for="">Observacion Estado de solicitud</label>
        <textarea type="text" class="form-control" name="obs_estado_sol"  id="obs_estado_sol" placeholder="obs_estado_sol"></textarea>
        </div>
</div>
          

      <div class="form-group">
          <div class=" col-md-3">
          <label for="">Fecha prevista solicitud</label>
          <input type="date" class="form-control" name="fecha_prevista_sol"  id="fecha_prevista_sol" placeholder="fecha_prevista_sol">
          </div>
          <div class=" col-md-3">  
          <label for="">Fecha visita comercial solicitud</label>  
          <input type="date" class="form-control" name="fecha_visita_comerc_sol"  id="fecha_visita_comerc_sol" placeholder="fecha_visita_comerc_sol">
          </div>
           <div class="col-md-4"> 
            <label for="">Forma de pago:</label>         
            <select class="form-control" id="forma_pagogn_sol" name="forma_pagogn_sol">
            <option value="">seleccionar forma de pago</option>
             <option value=""><?php while ($row = mysqli_fetch_array($resul_fp)){
                    echo '<option value="'.$row['Id_forma_ap'].'">'.$row['nombre_forma_ap'].'</option>';

                } ?></option>
            </select>
        </div> 

      </div>   
           
        
        <fieldset>
          <legend>Subir archivos:</legend>
       
          <div class="col-sm-8">
  
            <label for="archivo" class="col-sm-2 control-label">Archivo</label>
            <input type="file" class="form-control" id="archivo" name="archivo">
          </div>
          </fieldset>
        

    </fieldset>
    

  

    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="TSolicitudes" class="btn btn-default">Regresar</a>
      <button type="submit" align="center" class="btn btn-primary" name="submit" value="Agregar" action="FregistroSol.php" >Registrar</button>
          
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
      