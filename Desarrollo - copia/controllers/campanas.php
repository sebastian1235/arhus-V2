<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:45 PM
 */

class campanas
{

    public function registroCampanasController()
    {
        if (isset($_POST["nombre_campana"])) {
            $datosController = array("nombre_campana" => $_POST["nombre_campana"],
                                "detalle_campana" => $_POST["detalle_campana"],
                                "comision_gasod_asignacion" => $_POST["comision_gasod_asignacion"],
                                "aplicacion_campana" => $_POST["aplicacion_campana"],
                               "descuente_campana" => $_POST["descuente_campana"],
                                "descuento_fijo_campana" => $_POST["descuento_fijo_campana"],
                              "desc_financ_campana" => $_POST["desc_financ_campana"],
                            "desde_campana" => $_POST["desde_campana"],
                           "hasta_campana" => $_POST["hasta_campana"],
                          "plazo_max_campana" => $_POST["plazo_max_campana"],
                         "vigente_campana" => $_POST["vigente_campana"],
                       "tasa_campana" => $_POST["tasa_campana"],
                           "manto_max_campana" => $_POST["manto_max_campana"],
                          "condiciones_campana" => $_POST["condiciones_campana"]);

            $respuesta = CampanaModel::registroCampana($datosController, "siax_campana");

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
                               window.location = "Tcampanas";
                           }
                         
                       }); 
                </script>';

            }
        }
    }


    public function vistaCampanaController(){
        $respuesta = CampanaModel::vistaCampana("siax_campana");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
                    <td>' .$item["nombre_campana"].'</td>
                    <td>' .$item["descuente_campana"].'</td>
                    <td>' .$item["desc_financ_campana"].'</td>
                    <td>' .$item["detalle_campana"].'</td>
                    <td><a href="#registroCampana'.$item["id_campana"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroCampana'.$item["id_campana"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Editar Ciudad</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                      <input name="idCampana" type="hidden" value="'.$item["id_campana"].'">
                     <div class="form-group">  
                      <input name="nombreCampana" type="text" class="form-control" value="'.$item["nombre_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="descuenteCampana" type="text" class="form-control" value="'.$item["descuente_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="descFinancCampana" type="text" class="form-control" value="'.$item["desc_financ_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="plazoMaxCampana" type="text" class="form-control" value="'.$item["plazo_max_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="detalleCampana" type="text" class="form-control" value="'.$item["detalle_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="aplicacionCampana" type="text" class="form-control" value="'.$item["aplicacion_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="desdeCampana" type="text" class="form-control" value="'.$item["desde_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="hastaCampana" type="text" class="form-control" value="'.$item["hasta_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="vigenteCampana" type="text" class="form-control" value="'.$item["vigente_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="tasaCampana" type="text" class="form-control" value="'.$item["tasa_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="descuentoFijoCampana" type="text" class="form-control" value="'.$item["descuento_fijo_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="mantoMaxCampana" type="text" class="form-control" value="'.$item["manto_max_campana"].'" >
                                     </div>
                                     <div class="form-group">  
                      <input name="condicionesCampana" type="text" class="form-control" value="'.$item["condiciones_campana"].'" >
                                     </div>
                        <div class="form-group text-center">
                        <input type="submit" id="guardarCampana" value="Actualizar" class="btn btn-warning">
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
        public function editarCampanaController(){

        if (isset($_POST["nombreCampana"])) {
            $datosController = array("id_campana"=> $_POST["idCampana"],
                                "nombre_campana" => $_POST["nombreCampana"],
                                "descuente_campana" => $_POST["descuenteCampana"],
                                "desc_financ_campana" => $_POST["descFinancCampana"],
                                "plazo_max_campana" => $_POST["plazoMaxCampana"],
                                "detalle_campana" => $_POST["detalleCampana"],
                                "aplicacion_campana" => $_POST["aplicacionCampana"],
                                "desde_campana" => $_POST["desdeCampana"],
                                "hasta_campana" => $_POST["hastaCampana"],
                                "vigente_campana" => $_POST["vigenteCampana"],
                                "tasa_campana" => $_POST["tasaCampana"],
                                "descuento_fijo_campana" => $_POST["descuentoFijoCampana"],
                                "manto_max_campana" => $_POST["mantoMaxCampana"],
                                "condiciones_campana" => $_POST["condicionesCampana"]);
            $respuesta = CampanaModel::actualizarCampana($datosController, "siax_campana");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){
                    $_SESSION["id_campana"] = $_POST["idCampana"];
                    $_SESSION["nombre_campana"] = $_POST["nombreCampana"];
                    $_SESSION["descuente_campana"] = $_POST["descuenteCampana"];
                    $_SESSION["desc_financ_campana"] = $_POST["descFinancCampana"];
                    $_SESSION["plazo_max_campana"] = $_POST["plazoMaxCampana"];
                    $_SESSION["detalle_campana"] = $_POST["detalleCampana"];
                    $_SESSION["aplicacion_campana"] = $_POST["aplicacionCampana"];
                    $_SESSION["desde_campana"] = $_POST["desdeCampana"];
                    $_SESSION["hasta_campana"] = $_POST["hastaCampana"];
                    $_SESSION["vigente_campana"] = $_POST["vigenteCampana"];
                    $_SESSION["tasa_campana"] = $_POST["tasaCampana"];
                    $_SESSION["descuento_fijo_campana"] = $_POST["descuentoFijoCampana"];
                    $_SESSION["manto_max_campana"] = $_POST["mantoMaxCampana"];
                    $_SESSION["condiciones_campana"] = $_POST["condicionesCampana"];
                  
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
                               window.location = "Tcampanas";
                           }
                         
                       }); 
                </script>';

            }
        }
    }

}

