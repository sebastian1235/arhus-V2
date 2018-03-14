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
           <form class="form-horizontal" method="POST" action="registrar.php" autocomplete="off">
     
        <fieldset>
     
     <br>
     <div class="container">
      
<div class="form-group">
         <div class=" col-md-3">
          <label for="">Campaña :</label>
            <input  type="text" class="form-control" name="nombre_sol"  id="nombre_sol">
        </div>
         <div class=" col-md-3">
          <label for="">Detalle de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-3">
          <label for="">Aplicacion de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
      
</div>
<div class="form-group">
          <div class=" col-md-2">
          <label for="">Redescuento campaña</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-2">
          <label for="">Redescuento fijo:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-2">
          <label for="">Descuento financiacion</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
  </div>
      <div class="form-group" > 
         <div class=" col-md-2">
          <label for="">fecha inicio:</label>
            <input type="date" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-2">
          <label for="">fecha fin :</label>
            <input type="date" class="form-control" name="cedula_sol" id="cedula_sol">
          </div>
        <div class=" col-md-2">
          <label for="">Plazo maximo</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
         <div class=" col-md-2">
         <input type="text" class="form-control" id="id_sol" name="id_sol" placeholder="id" style="visibility: hidden;" >
      </div>
    </div>   
         

<div class="form-group">
 
       
          <div class=" col-md-4">
          <label for="">Vigencia de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-2">
          <label for="">Tasa de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        
      </div>
      <div class="form-group "> 
         
         <div class=" col-md-3">
          <label for="">Monto maximo:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
        </div>
        <div class=" col-md-3">
          <label for="">Condiciones de campaña:</label>
            <input type="text" class="form-control" name="cedula_sol" id="cedula_sol">
       </div>
     </div>
   

    <div class="form-group">
      <br>  
          <div class="col-sm-offset-5 col-sm-10">
            <br>
            <a href="Tcampanas" class="btn btn-default">Regresar</a>
      <button type="submit" align="center" class="btn btn-primary" name="submit" value="Agregar" action="registroSol.php" >Registrar</button>
          
        </div>
    </div>
      </div>
      </form> 
        </div>
 
  
    </section>
    <!-- /.content -->

  </div>
  