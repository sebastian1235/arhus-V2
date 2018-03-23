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
public function selectTipoTercero(){
        $respuesta = TercerosModel::vistaSelectsTipoTercero("ap_tipo_tercero");
        foreach ($respuesta as $row => $selectTipoTercero){
            echo '<option value="'.$selectTipoTercero["id_tipo_tercero"].'">'.$selectTipoTercero["nombre_tipo_ter"].'</option>';
        }

    }

    #Vista de Medio de Pago
   # public function vistaMedioPagoController(){
    #    $respuesta = MedioPagoModel::vistaMedioPago("siax_medio_pago");
     #   $activo = "";
      #  foreach ($respuesta as $row => $item){
       #     if ($item["activo_medio_pago"] == 0){
        #        $activo = "SI";
         #   }else{
          #     $activo = "NO";
           #          }
           # echo' <tr>   
            #        <td>' .$item["nombre_medio_pago"].'</td>
             #       <td>' .$activo.'</td>
              #      <td><a href="#medioPago'.$item["Id_medio_pago"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                #  </tr>
                  
                 # <div id="medioPago'.$item["Id_medio_pago"].'" class="modal fade">

                  #      <div class="modal-dialog modal-content">

                   #         <div class="modal-header" style="border:1px solid #eee">

                    #            <button type="button" class="close" data-dismiss="modal">X</button>

                     #           <h3 class="modal-title">Editar Medio pago</h3>

                      #      </div>

                       #     <div class="modal-body" style="border:1px solid #eee">
                            
                        #        <form style="padding:0px 10px" method="post" enctype="multipart/form-data">

                         #             <input name="idMedioPago" type="hidden" value="'.$item["Id_medio_pago"].'">
                                    
                          #           <div class="form-group">  
                           #           <input name="editarModoPago" type="text" class="form-control" value="'.$item["nombre_medio_pago"].'" required>
                            #         </div>
                             #         <div class="form-group">

                              #          <select name="editarActivo" class="form-control" required>
                               #             <option value="">Activo medio pago</option>
                                #            <option value="0">SI</option>
                                 #           <option value="1">NO</option>
                                  #      </select>

                                   #   </div>

                                    #    <div class="form-group text-center">
                                     #       <input type="submit" id="guardarMedioPago" value="Actualizar" class="btn btn-warning">
                                      #  </div>

                                #</form>

                           # </div>
                           # <div class="modal-footer" style="border:1px solid #eee">                    
                            #    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                           # </div>
                        
                       # </div>

                  # </div>';

       # }
   # }

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

