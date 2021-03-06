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


        <div class="form-group">
            <div class="col-md-2">
                <a href="FregistroSol" class="btn btn-warning">Nuevo Registro</a>
            </div>
            <div class="col-md-2">
                <a href="subirArchivo" class="btn btn-warning">Subir demanda</a>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="tablas" class="table table-striped">
                            <thead>
                            <tr>
                              <th>Programar</th>
                              <th>Modificar</th>
                                <th>Eliminar</th>
                                <th>cotizar</th>
                                <th>Id</th>
                                <th>Asignacion</th>
                                <th>asesor</th>
                                <th>Nombre de solicitud</th>
                                <th>Servicio</th>
                                <th>Estado</th>
                                <th>Fecha prevista</th>
                                <th>Fecha visita</th>
                                <th>Barrio</th>
                                <th>Localidad</th>
                                <th>cedula</th>
                                <th>Direccion</th>
                                <th>Telefonos</th>
                                <th>Observacion</th>

                                

                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $verSol = new solicitud();
                            $verSol -> ModificarCotizacionController();
                            $verSol -> vistaSolicitudController();
                            $verSol -> programarModelController();
                            $verSol -> eliminarModelController();
                            $verSol ->modificarModelController();



                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
                            </div>

                            <div class="modal-body">
                                ¿Desea eliminar este registro?
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-danger btn-ok">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $('#confirm-delete').on('show.bs.modal', function(e) {
                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

                        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
                    });
                </script>

</section>

<?php

include "views/modules/footer.php";

?>
    