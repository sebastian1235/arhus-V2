<?php

session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";

?>


<section class="content container-fluid">
      <div class="row">
      
      </div>
      
      <div class="row">
        <a href="registro_campana" class="btn btn-primary">Nuevo Registro</a>
      </div>
      <h1>  Campañas</h1>
      <div class="row table-responsive">
      <br>
      
      <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body table-responsive">
                <table id="tablas" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Tipo de asignacion</th>
                        <th>Comision obra</th>
                        <th>Comision gasodomestico</th>
                        <th>Comision fija</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $verPerfiles = new campanas();
                    $verPerfiles -> vistaCampanaController();

                    ?>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
    </div>