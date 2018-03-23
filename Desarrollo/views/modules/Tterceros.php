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
        <a href="registro_tercero" class="btn btn-warning">Nuevo Registro</a>
      </div>
      <div class="row table-responsive">
      <br>
      <h1>Terceros</h1>
     <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body table-responsive">
                <table id="tablas" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Contacto</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $verPerfiles = new tercero();
                    $verPerfiles -> vistaTercerosController();

                    ?>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

    </section>

<?php

include "views/modules/footer.php";

?>
    