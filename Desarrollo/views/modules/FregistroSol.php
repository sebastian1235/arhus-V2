
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
		 <form class="form-horizontal" method="POST" id="formularioSolicitud" autocomplete="off">
            <h2 class="box-title text-yellow">Registrar solicitud</h2>
        <div class="box box-warning">
        	<div class="container">
            <br>
            <legend>Datos de contacto</legend>



                <div class="form-group">
                    <div class="col-md-5">
                        <label>Nombre del cliente:</label>
                        <input type="text" class="form-control" name="nombre_sol" required="" id="nombre_sol">
                    </div>
                </div>
   
       <div class="form-group">
         <div class=" col-md-4">
          <label>Cedula:</label>
          <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol">
         </div>
       </div>
   
  
    <div class="form-group"> 
     <div class="col-md-4"> 
        <label for="">Localidad:</label>         
            <select class="form-control" id="localidad_sol"  name="localidad_sol">
            <option value="">seleccionar localidad</option>
                 <?php
                $localidad = new solicitud();
                $localidad  -> selectLocalidad();
                  ?> 
               
            </select>
        </div>
        <div class="col-md-4"> 
        <label for="">Barrio:</label>         
            <select class="form-control" id="barrio_sol"  name="barrio_sol">
              <option value="">Seleccionar barrio</option>
                   
            </select>
        </div> 
      </div>

      <div class="form-group"  >
        <div class=" col-md-4">
          <label for="">Direccion:</label>
            <input type="text" class="form-control" name="direccion_pol_sol" required="" id="direccion_pol_sol">
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
          <input type="email" class="form-control" name="email_sol"  required="" id="email_sol" >
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
          <input type="text" class="form-control" id="poliza_sol"  name="poliza_sol">
      </div>
       <div class=" col-md-5">
        <label for="">Cod Demanda</label>
          <input type="text" class="form-control" id="demanda_sol"  name="demanda_sol">
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-5">
        <label for="">Nombre asesor</label>
          <select class="form-control" id="asesor_sol" name="asesor_sol">
            <option value="">Asesor</option>
             
          </select>
        </div>
         <div class="col-md-5">
        <label for="">Asignacion</label>
        <select  class="form-control" id="estado_sol" name="estado_sol" >
          
           
        </select>
        </div>
         
      </div>
   
      
<div class="form-group">
      <div class=" col-md-5">
        <label for="">servicio solicitado</label> 
        
        <input type="text" class="form-control" name="servicio_sol"  id="servicio_sol" >
        </div>
       <div class=" col-md-5">
        <label for="">Observacion</label>
        <textarea class="form-control" name="obs_sol"  id="obs_sol" ></textarea>
        </div>
         <div class="col-md-5">
        <label for="">Estado</label>
        <select disabled class="form-control" id="estado_sol" name="estado_sol" >
          
             
        </select>
        </div>
       <!--<div class=" col-md-5">
        <label for="">Observacion Estado de solicitud</label>
        <textarea type="text" class="form-control" name="obs_estado_sol"  id="obs_estado_sol" placeholder="obs_estado_sol"></textarea>
        </div>-->
</div>
          

      <div class="form-group">
          <div class=" col-md-3">
          <label for="">Fecha prevista</label>
          <input type="date" class="form-control" name="fecha_prevista_sol"  id="fecha_prevista_sol" placeholder="fecha_prevista_sol" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> >
          </div>
          <div class=" col-md-3">  
          <label for="">Fecha visita comercial</label>  
          <input type="date" class="form-control" name="fecha_visita_comerc_sol"  id="fecha_visita_comerc_sol" placeholder="fecha_visita_comerc_sol" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> >
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
      <button type="submit" align="center" class="btn btn-warning" name="guardarSolicitud" id="guardarSolicitud">Registrar</button>
         	<?php
                $crearSolicitud = new solicitud();
                $crearSolicitud  -> registroSolicitudController();
            ?> 
        </div>
    </div>
     		 
      </div> 

      </form>



</div>
<!--</div>-->

   



<?php
include "views/modules/footer.php";
?>
