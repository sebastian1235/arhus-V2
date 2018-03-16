<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:07 PM
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
                <form role="form" id="formularioTipoTercero" method="post" enctype="multipart/form-data">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tipo Tercero</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nombreTipoTercero" name="nombreTipoTerceros" placeholder="Ingrese nombre de tipo tercero" required>
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" id="descripcionTipoTercero" name="descripcionTipoTercero" placeholder="Descripción" required></textarea>
                        </div>

                        <div class="form-group">
                            <select class="form-control" name="grupoTipoTercero" required>
                                <option value="">Grupo tipo tercero</option>
                                <option value="PERSONA">PERSONA</option>
                                <option value="EMPRESA">EMPRESA</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning" name="guardarTipoTercero" id="guardarTipoTercero">Guardar</button>
                    </div>
                </form>

                <?php
                $crearTipoTercero = new TipoTercero();
                $crearTipoTercero -> registroTipoTerceroController();
                ?>

            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Tipo Persona</th>
                        <th>Descripción</th>
                        <th>Grupo Tipo Tercero</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $verTipoTercero = new TipoTercero();
                    $verTipoTercero -> vistaTipoTercero();
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
