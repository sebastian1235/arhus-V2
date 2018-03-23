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
                    <td><a href="#registroAsigacnion'.$item["id_asignacion"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroAsigacnion'.$item["id_asignacion"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Editar Asigancion</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                      <input name="id_asignacion" type="hidden" value="'.$item["id_asignacion"].'">
                     <div class="form-group">  
                      <input name="tipoAsignacion" type="text" class="form-control" value="'.$item["tipo_asignacion"].'" required>
                                     </div>
                                     <div class="form-group">  
                      <input name="comisionObraAsignacion" type="text" class="form-control" value="'.$item["comision_obra_asignacion"].'" required>
                                     </div>
                                     <div class="form-group">  
                      <input name="comisionGasodAsignacion" type="text" class="form-control" value="'.$item["comision_gasod_asignacion"].'" required>
                                     </div>
                                     <div class="form-group">  
                      <input name="comisionFijaAsignacion" type="text" class="form-control" value="'.$item["comision_fija_asignacion"].'" required>
                                     </div>
                        <div class="form-group text-center">
                        <input type="submit" id="guardarAsigancion" value="Actualizar" class="btn btn-warning">
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

    public function editarModelController(){

       if (isset($_POST["tipoAsignacion"])) {
           $datosController = array("id_asignacion" => $_POST["idAsignacion"],
                                      "tipo_asignacion"=> $_POST["tipoAsignacion"],
                                      "comision_obra_asignacion" => $_POST["comisionObraAsignacion"],
                                      "comision_gasod_asignacion" => $_POST["comisionGasodAsignacion"],
                                    "comision_fija_asignacion" => $_POST["comisionFijaAsignacion"]);
           $respuesta = AsignacionModel::actualizarAsignacion($datosController, "ap_asignacion");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){

                   $_SESSION["id_asignacion"] = $_POST["idAsignacion"];
                    $_SESSION["tipo_asignacion"] = $_POST["tipoAsignacion"];
                   $_SESSION["comision_obra_asignacion"] = $_POST["comisionObraAsignacion"];
                   $_SESSION["comision_gasod_asignacion"] = $_POST["comisionGasodAsignacion"];
                    $_SESSION["comision_fija_asignacion"] = $_POST["comisionFijaAsignacion"];

               }

                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡El usuario ha sido editado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       }
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "Tasignacion";
                          }
                         
                       }); 
                #</script>';

            }
        }
    }

}

