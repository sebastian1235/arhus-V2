<?php


class asignacion
{

    public function registroAsignacionController()
    {
        if (isset($_POST["tipo_asignacion"])) {
            $datosController = array("tipo_asignacion" => $_POST["tipo_asignacion"],
                                "comision_obra_asignacion" => $_POST["comision_obra_asignacion"],
                                "comision_gasod_asignacion" => $_POST["comision_gasod_asignacion"],
                                "comision_fija_asignacion" => $_POST["comision_fija_asignacion"]);

            $respuesta = AsignacionModel::registroAsignacion($datosController, "ap_asignacion");

            if ($respuesta == "ok") {
                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡El usuario ha sido creado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "Tasignacion";
                           }
                         
                       }); 
                </script>';

            }
        }
    }


 public function vistaAsigancionController(){
        $respuesta = AsignacionModel::vistaAsigancion("ap_asignacion");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
                    <td>' .$item["tipo_asignacion"].'</td>
                    <td>' .$item["comision_obra_asignacion"].'</td>
                    <td>' .$item["comision_gasod_asignacion"].'</td>
                    <td>' .$item["comision_fija_asignacion"].'</td>
                    <td><a href="#registroAsignacion'.$item["id_asignacion"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroAsignacion'.$item["id_asignacion"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Editar Ciudad</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                      <input name="idAsiganacion" type="hidden" value="'.$item["id_asignacion"].'">
                            <div class="form-group">  
                                <input name="editarTipoAsignacion" type="text" class="form-control" value="'.$item["tipo_asignacion"].'" required>
                            </div>
                            <div class="form-group">  
                                <input name="editarComisionObraAsignacion" type="text" class="form-control" value="'.$item["comision_obra_asignacion"].'" required>
                            </div>
                            <div class="form-group">  
                                <input name="editarGasAsignacion" type="text" class="form-control" value="'.$item["comision_gasod_asignacion"].'" required>
                            </div>
                            <div class="form-group">  
                                <input name="editarComisionFija" type="text" class="form-control" value="'.$item["comision_fija_asignacion"].'" required>
                            </div>
                        <div class="form-group text-center">
                        <input type="submit" id="guardarAsignacion" value="Actualizar" class="btn btn-warning">
                      </div>
                </form>

              </div>
              <div class="modal-footer" style="border:1px solid #eee">          
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
                
                </div>

             </div>';

        }
    }
    public function editarAsignacionlController(){

        if (isset($_POST["editarTipoAsignacion"])) {
            $datosController = array("id_asignacion"=> $_POST["idAsiganacion"],
                                     "tipo_asignacion" => $_POST["editarTipoAsignacion"],
                                   "comision_obra_asignacion" => $_POST["editarComisionObraAsignacion"],
                                 "comision_gasod_asignacion" => $_POST["editarGasAsignacion"],
                                "comision_fija_asignacion" => $_POST["editarComisionFija"]);
            $respuesta = AsignacionModel::actualizarAsignacion($datosController, "ap_asignacion");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){
                    $_SESSION["id_asignacion"] = $_POST["idAsiganacion"];
                    $_SESSION["tipo_asignacion"] = $_POST["editarTipoAsignacion"];
                    $_SESSION["comision_obra_asignacion"] = $_POST["editarComisionObraAsignacion"];
                    $_SESSION["comision_gasod_asignacion"] = $_POST["editarGasAsignacion"];
                    $_SESSION["editarComisionFija"] = $_POST["editarComisionFija"];

                }

                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡El usuario ha sido editado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "Tasignacion";
                           }
                         
                       }); 
                </script>';

            }
        }
    }


}

