<?php

class tercero
{

    public function registroTerceroController()
    {
        if (isset($_POST["nombre_tercero"])) {
            $datosController = array("nombre_tercero" => $_POST["nombre_tercero"],
                                "tipo_tercero" => $_POST["tipo_tercero"],
                                "nit_tercero" => $_POST["nit_tercero"],
                                "direccion_tercero" => $_POST["direccion_tercero"],
                                "e_mail_tercero" => $_POST["e_mail_tercero"],
                                "telefono1_tercero" => $_POST["telefono1_tercero"],
                                "telefono2_tercero" => $_POST["telefono2_tercero"],
                                "fax_tercero" => $_POST["fax_tercero"],
                                "Contacto_tercero" => $_POST["Contacto_tercero"],
                                "gran_contrib_tercero" => $_POST["gran_contrib_tercero"],
                                "autoretenedor_tercero" => $_POST["autoretenedor_tercero"],
                                "reg_comun_tercero" => $_POST["reg_comun_tercero"],
                                "responsable_materiales_tercero" => $_POST["responsable_materiales_tercero"],
                                "activo_tercero" => $_POST["activo_tercero"]);

               

            $respuesta = TercerosModel::registroTerceros($datosController, "ap_terceros");

            if ($respuesta == "ok") {
                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡La persona ha sido creada correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "Tterceros";
                           }
                         
                       }); 
                </script>';

            }
        }
    }


     #   $activo = "";
    public function vistaTercerosController(){
        $respuesta = TercerosModel::vistaTercero("ap_terceros");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
                    <td>' .$item["nombre_tercero"].'</td>
                    <td>' .$item["telefono1_tercero"].'</td>
                    <td>' .$item["e_mail_tercero"].'</td>
                    <td>' .$item["Contacto_tercero"].'</td>
                    <td><a href="#registroCiudad'.$item["Id_tercero"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroCiudad'.$item["Id_tercero"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Editar Ciudad</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                      <input name="idCiudad" type="hidden" value="'.$item["Id_tercero"].'">
                     <div class="form-group">  
                      <input name="editarCiudad" type="text" class="form-control" value="'.$item["nombre_tercero"].'" required>
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

