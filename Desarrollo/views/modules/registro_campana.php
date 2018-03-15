   <?php 
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
   include"views/modules/header.php";
 include"views/modules/navegacion.php"; ?>

  <section class="content container-fluid">
    <h2 class="box-title">Registro de campañas</h2>
      <div class="box box-primary">
            <div class="box-header with-border">
                
        <small>Campañas y redescuentos</small>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           <form class="form-horizontal" method="POST" action="insertCampana" autocomplete="off">
     
        <fieldset>
     
     <br>
     <div class="container">
      
<div class="form-group">
         <div class=" col-md-3">
          <label for="">Campaña :</label>
            <input  type="text" class="form-control" name="nombre_campana"  id="nombre_campana">
        </div>
         <div class=" col-md-3">
          <label for="">Detalle de campaña:</label>
            <input type="text" class="form-control" name="detalle_campana" id="detalle_campana">
        </div>
        <div class=" col-md-3">
          <label for="">Aplicacion de campaña:</label>
            <input type="text" class="form-control" name="aplicacion_campana" id="aplicacion_campana">
        </div>
      
</div>
<div class="form-group">
          <div class=" col-md-2">
          <label for="">Redescuento campaña</label>
            <input type="text" class="form-control" name="descuente_campana" id="descuente_campana">
        </div>
        <div class=" col-md-2">
          <label for="">Redescuento fijo:</label>
            <input type="text" class="form-control" name="descuento_fijo_campana" id="descuento_fijo_campana">
        </div>
        <div class=" col-md-2">
          <label for="">Descuento financiacion</label>
            <input type="text" class="form-control" name="desc_financ_campana" id="desc_financ_campana">
        </div>
  </div>
      <div class="form-group" > 
         <div class=" col-md-2">
          <label for="">fecha inicio:</label>
            <input type="date" class="form-control" name="desde_campana" id="desde_campana">
        </div>
        <div class=" col-md-2">
          <label for="">fecha fin :</label>
            <input type="date" class="form-control" name="hasta_campana" id="hasta_campana">
          </div>
        <div class=" col-md-2">
          <label for="">Plazo maximo</label>
            <input type="text" class="form-control" name="plazo_max_campana" id="plazo_max_campana">
        </div>
        
    </div>   
         

<div class="form-group">
 
       
          <div class=" col-md-4">
          <label for="">Vigencia de campaña:</label>
             <select class="form-control" id="vigente_campana"  name="vigente_campana">
            <option value="1">Si</option>
            <option value="0">No</option>
            </select>
        </div>
        <div class=" col-md-2">
          <label for="">Tasa de campaña:</label>
            <input type="text" class="form-control" name="tasa_campana" id="tasa_campana">
        </div>
        
      </div>
      <div class="form-group "> 
         
         <div class=" col-md-3">
          <label for="">Monto maximo:</label>
            <input type="text" class="form-control" name="manto_max_campana" id="manto_max_campana">
        </div>
        <div class=" col-md-3">
          <label for="">Condiciones de campaña:</label>
            <input type="text" class="form-control" name="condiciones_campana" id="condiciones_campana">
       </div>
     </div>
   

    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="Tcampanas" class="btn btn-default">Regresar</a>
      <button type="submit" align="center" class="btn btn-primary" name="submit" value="Agregar" action="registro_campana" >Registrar</button>
          
        </div>
    </div>
      </div>
      </form> 
        </div>
 
  
    </section>
    <!-- /.content -->

  </div>
  