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
    <div class="col-md-8">
        <div class="col-md-12 table-responsive">
            <div class="box box-warning">
                <form class="form" method="POST" id="formularioAsignacion" autocomplete="off" enctype="multipart/form-data">
                    <div class="box-header with-border">
                        <h2 class="text-yellow">Registro de asignación</h2>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Tipo de asignacion:</label>
                            <input  type="text" class="form-control" name="tipo_asignacion"  id="tipo_asignacion" required>
                        </div>
                        <div class="form-group">
                            <label for="">Comision por obra:</label>
                            <input type="text" class="form-control" name="comision_obra_asignacion" id="comision_obra_asignacion" required>
                        </div>
                        <div class="form-group">
                            <label for="">Comision por gasodomestico:</label>
                            <input type="text" class="form-control" name="comision_gasod_asignacion" id="comision_gasod_asignacion" required>
                        </div>
                        <div class="form-group">
                            <label for="">Comision fija:</label>
                            <input type="text" class="form-control" name="comision_fija_asignacion" id="comision_fija_asignacion" required>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning" name="guardarUsuario" id="guardarUsuario">Guardar</button>
                        <a href="tipoAsignacion"><buttom type="submit" class="btn btn-warning" name="guardarUsuario" id="guardarUsuario">Volver</buttom></a>
                    </div>
                </form>
                <?php
                $crearAsignacion = new asignacion();
                $crearAsignacion -> registroAsignacionController();
                ?>
            </div>
        </div>
    </div>
</div>






