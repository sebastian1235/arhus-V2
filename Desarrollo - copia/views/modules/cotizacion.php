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


       
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="tablas" class="table table-striped">
                            <thead>
                            <tr>
                            
                           
                                <th>Id</th>
                                <th>Poliza</th>
                                 <th>Nombre</th>
                                <th>Consecutivo</th>
                                <th>Forma de pago</th>
                                <th>Campaña</th>
                            
                                

                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $verSol = new solicitud();
                            $verSol -> vistaCotizacionController();
                      



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
    