<?php

class items
{

    public function registroItemsController()
    {
        if (isset($_POST["nombre_item"])) {
            $datosController = array("nombre_item" => $_POST["nombre_item"],
                                      "codigo_item" => $_POST["codigo_item"],
                                      "tipo_item" => $_POST["tipo_item"],
                                      "und_item" => $_POST["und_item"],
                                      "precio_item" => $_POST["precio_item"],
                                      "costo_item" => $_POST["costo_item"],
                                      "marca_item" => $_POST["marca_item"],
                                      "cod_marca_item" => $_POST["cod_marca_item"],
                                      "detalle_item" => $_POST["detalle_item"]);


            $respuesta = ItemsModel::registroItems($datosController, "ap_items_inv");

            if ($respuesta == "ok") {
                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡El item ha sido creado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "Titems";
                           }
                         
                       }); 
                </script>';

            }
        }
    }


       public function vistaItemsController(){
        $respuesta = ItemsModel::vistaItems("ap_items_inv");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
                    <td>' .$item["codigo_item"].'</td>
                    <td>' .$item["nombre_item"].'</td>
                    <td>' .$item["precio_item"].'</td>
                    <td>' .$item["costo_item"].'</td>
                    <td>' .$item["detalle_item"].'</td>
                    <td><a href="#registroCiudad'.$item["Id_Item"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroCiudad'.$item["Id_Item"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Editar Ciudad</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                      <input name="idCiudad" type="hidden" value="'.$item["Id_Item"].'">
                     <div class="form-group">  
                      <input name="editarCiudad" type="text" class="form-control" value="'.$item["codigo_item"].'" required>
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

