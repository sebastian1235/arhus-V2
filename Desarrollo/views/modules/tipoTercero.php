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
                <form role="form" id="formularioTipoTercero" method="post" onsubmit="return validarRegistro()">

                    <div class="box-header with-border">
                        <h3 class="box-title">Tipo Tercero</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nombreTipoTercero">Nombre tipo tercero <span></span> </label>
                            <input type="text" class="form-control" id="nombreTipoTerceros" name="nombreTipoTerceros" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="nombreTipoTercero">Descripción</label>
                            <textarea type="text" class="form-control" id="descripcionTipoTercero" name="descripcionTipoTercero" placeholder=""></textarea>
                        </div>

                        <div class="form-group">
                            <select class="form-control" name="grupoTipoTercero" required>
                                <option value="0">Grupo tipo tercero</option>
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
               <div class="box-body table-responsive">
                <table id="tablas" class="table table-striped">
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
                    $verTipoTercero -> vistaTipoTerceroController();
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
