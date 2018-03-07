<?php include"views/modules/header.php";
 include"views/modules/navegacion.php" ?>

<form class="form-horizontal" method="POST" action="registrar.php" autocomplete="off">
     
        <fieldset>
<legend>Datos de contacto:</legend>
     
     
      <div class="form-group">

         <div class=" col-md-4">
          <label for="">Nombre:</label>
            <input  type="text" class="form-control" name="nombre_sol"  id="nombre_sol">
        </div>
         <div class=" col-md-4">
          <label for="">Cedula:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
      </div>
   
  
    <div class="form-group">   
        <div class="col-md-4"> 
        <label for="">Barrio:</label>         
            <select class="form-control" id="barrio_sol" name="barrio_sol">
            <option value="">seleccionar barrio</option>
            </select>
        </div> 
        <div class="col-md-4"> 
        <label for="">Localidad:</label>         
            <select class="form-control" id="localidad_sol" name="localidad_sol">
            <option value="">seleccionar barrio</option>
            </select>
        </div> 
      </div>
      <div class="form-group"  >
        <div class=" col-md-4">
          <label for="">Direccion:</label>
            <input type="text" class="form-control" name="direccion_pol_sol"  id="direccion_pol_sol">
        </div>
 
        <div class=" col-md-4">
          <label for="">Direccion 2</label>
          <input type="text" class="form-control" name="direccion_nueva_sol"  id="direccion_nueva_sol" >
        </div>
  
    </div>


    <div class="form-group">
        <div class=" col-md-4"> 
        <label for="">Telefono:</label>      
          <input type="text" class="form-control" name="telefono1_sol"  id="telefono1_sol" >
        </div>

        <div class=" col-md-4">
          <label for="">Telefono opcional:</label>
          <input type="text" class="form-control" name="telefono2_sol"  id="telefono2_sol" >
        </div>

        <div class=" col-md-4"> 
          <label for="">Celular:</label>
          <input type="text" class="form-control" name="celular_sol"  id="celular_sol" >
        </div>
          
        <div class=" col-md-4">
          <br>
          <label for="">Correo electronico:</label>
          <input type="text" class="form-control" name="email_sol"  id="email_sol" >
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
        <select class="form-control" id="estado_sol" name="estado_sol">
             
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
            <option value="">seleccionar barrio</option>
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
      <button type="submit" align="center" class="btn btn-primary" name="submit" value="Agregar" action="registroSol.php" >Registrar</button>
          
        </div>
    </div>
     
      </div>  
      </form> 