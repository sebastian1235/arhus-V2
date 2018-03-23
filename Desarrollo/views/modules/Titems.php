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
        <a href="registro_items" class="btn btn-warning">Nuevo Registro</a>
      </div>
      <div class="row table-responsive">
      <br>
      <h1>Items de inventario</h1>
      <div >
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body table-responsive">
                <table id="tablas" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Codigo </th>
                        <th>Item</th>
                        <th>Precio</th>
                        <th>Costo</th>
                        <th>Detalle</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $verPerfiles = new items();
                    $verPerfiles -> vistaItemsController();

                    ?>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<?php

include "views/modules/footer.php";

?>
    