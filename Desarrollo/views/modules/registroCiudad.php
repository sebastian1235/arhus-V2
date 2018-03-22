<?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include"views/modules/header.php";
include"views/modules/navegacion.php";
?>

<div class="row">
    <div class="col-md-6">

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Ciudades</h3>
            </div>
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="Ciudad" name="ciudad" placeholder="Ciudad">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-warning"  name="submit" value="Agregar" action="registro_ciudad">Guardar</button>
                </div>
            </form>
            <?php
            $crearCiudades = new Ciudades();
            $crearCiudades -> registroCiudadController();
            ?>

        </div>
    </div>

    <div class="col-md-6">
        <div class="box">
            <div class="box-body table-responsive">
                <table id="tablas" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Ciudades</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $verCiudades = new Ciudades();
                    $verCiudades -> vistaCiudadController();
                    $verCiudades -> editarCiudadController();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






