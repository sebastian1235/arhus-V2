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
              <a href="registro_asignacion" class="btn btn-warning">Nuevo Registro</a>
          </div>

          <div class="col-md-12">
              <h1 class="text-yellow">Asignación</h1>
          </div>

          <div class="col-md-12">
              <div class="box">
                  <div class="box-body table-responsive">
                      <table id="tablas" class="table table-striped">
                          <thead>
                          <tr>
                              <th>Tipo de asignación</th>
                              <th>Comisión obra</th>
                              <th>Comisión gasodomestico</th>
                              <th>Comisión fija</th>
                              <th></th>
                              <th></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          $verAsignacion = new asignacion();
                          $verAsignacion -> vistaAsigancionController();
                          $verAsignacion -> editarAsignacionlController();
                          ?>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
