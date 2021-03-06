<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:09 PM
 */
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>
    <div class="row">
        <div class="col-md-5">
                <div class="col-md-12">
                    <div class="box box-warning">
                        <form role="form" id="formularioModoPago" method="post" enctype="multipart/form-data">
                            <div class="box-header with-border">
                                <h3 class="box-title">Modo de pago</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="medioPagoRegistro">Medio Pago<span></span></label>
                                    <input type="text" class="form-control" id="modoPago" name="modoPago" placeholder="Ingrese Modo de pago" required>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-warning" name="guardarModoPago" id="guardarModoPago">Guardar</button>
                            </div>
                        </form>

                        <?php
                        $crearModoPago = new medioPago();
                        $crearModoPago -> registroMedioPagoController();
                        ?>

                    </div>
                </div>
        </div>

        <div class="col-md-7">
            <div class="box">
                <div class="box-body">
                    <div class="box-body table-responsive">
                <table id="tablas" class="table table-striped">
                        <thead>
                        <tr>
                            <th>Medio pago</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $verMedioPago = new medioPago();
                        $verMedioPago -> vistaMedioPagoController();
                        $verMedioPago -> editarModelController();
                        $verMedioPago -> eliminarModelController();
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
