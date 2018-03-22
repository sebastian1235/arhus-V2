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
                    <td><a href="#registroCiudad'.$item["id_campana"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroCiudad'.$item["id_campana"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Editar Ciudad</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                      <input name="idCiudad" type="hidden" value="'.$item["id_campana"].'">
                     <div class="form-group">  
                      <input name="editarCiudad" type="text" class="form-control" value="'.$item["nombre_campana"].'" required>
                                     </div>
                        <div class="form-group text-center">
                        <input type="submit" id="guardarCiudad" value="Actualizar" class="btn btn-warning">
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
    #public function editarModelController(){

     #   if (isset($_POST["editarModoPago"])) {
      #      $datosController = array("Id_medio_pago"=> $_POST["idMedioPago"],
       #                               "modoPago" => $_POST["editarModoPago"],
        #                              "activo" => $_POST["editarActivo"]);
         #   $respuesta = MedioPagoModel::actualizarMedioPago($datosController, "siax_medio_pago");
#
 #           if ($respuesta == "ok") {
  #              if(isset($_POST["actualizarSesion"])){
#
 #                   $_SESSION["Id_medio_pago"] = $_POST["idMedioPago"];
  #                  $_SESSION["modoPago"] = $_POST["editarModoPago"];
   #                 $_SESSION["activo"] = $_POST["editarActivo"];
#                }

    #            echo '<script>

     #                  swal({
      #                      title: "!Ok",
       #                     text: "¡El usuario ha sido editado correctamente!",
        #                    type: "success",
         #                   confirmButtonText: "Cerrar",
          #                  closeOnConfirm: false
                      # }
           #            function(isConfirm) {
            #               if (isConfirm){
             #                  window.location = "medioPago";
              #            }
               #          
               #        }); 
                #</script>';

            #}
       # }
   # }

}

