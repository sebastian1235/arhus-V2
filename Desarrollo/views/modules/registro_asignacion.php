   <?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
    include"views/modules/header.php";
 include"views/modules/navegacion.php"; ?>

  <section class="content container-fluid">
        <h2 class="box-title">Registro de asignacion</h2>
      <div class="box box-warning">
            <div class="box-header with-border">
                
        <small>Campañas y redescuentos</small>
            </div>
            <!-- /.box-header -->
            <!-- form start --><div class="container">
          <form class="form-horizontal" method="POST" id="formularioAsignacion" autocomplete="off">
     
    

      
<div class="form-group">
         <div class=" col-md-3">
          <label for="">Tipo de asignacion:</label>
            <input  type="text" class="form-control" name="tipo_asignacion"  id="tipo_asignacion">
        </div>
</div>
<div class="form-group">
         <div class=" col-md-3">
          <label for="">Comision por obra:</label>
            <input type="text" class="form-control" name="comision_obra_asignacion" id="comision_obra_asignacion">
        </div>
         <div class=" col-md-3">
          <label for="">Comision por gasodomestico:</label>
            <input type="text" class="form-control" name="comision_gasod_asignacion" id="comision_gasod_asignacion">
        </div>
         <div class=" col-md-3">
          <label for="">Comision fija:</label>
            <input type="text" class="form-control" name="comision_fija_asignacion" id="comision_fija_asignacion">
        </div>
        
</div>
   

    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="Tasignacion" class="btn btn-default">Regresar</a>
      <button type="submit" align="center" class="btn btn-warning" name="guardarAsignacion" id="guardarAsignacion">Registrar</button>
 <?php
                        $crearAsigancion = new asignacion();
                        $crearAsigancion -> registroAsignacionController();
                        ?>          
        </div>
    </div>
      </div>
      </form>   
        </div>
 
 
    </section>
    <!-- /.content -->
  </div>