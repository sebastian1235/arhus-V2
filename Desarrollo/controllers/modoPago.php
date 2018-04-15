<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:45 PM
 */

class medioPago
{

    public function registroMedioPagoController()
    {
        if (isset($_POST["modoPago"])) {
            $datosController = array("modoPago" => $_POST["modoPago"],
                                        "activo" => $_POST["activo"]);

            $respuesta = MedioPagoModel::registroMedioPago($datosController, "siax_medio_pago");

            if ($respuesta == "ok") {
                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡El Medio de pago ha sido creado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "medioPago";
                           }
                         
                       }); 
                </script>';

            }
        }
    }

    #Vista de Medio de Pago
    public function vistaMedioPagoController(){
        $respuesta = MedioPagoModel::vistaMedioPago("siax_medio_pago");
        $activo = "";
        foreach ($respuesta as $row => $item){
            if ($item["activo_medio_pago"] == 0){
                $activo = "SI";
            }else{
                $activo = "NO";
            }
            echo' <tr>   
                    <td>' .$item["nombre_medio_pago"].'</td>
                    <td>' .$activo.'</td>
                    <td><a href="#medioPago'.$item["Id_medio_pago"].'" data-toggle="modal"><span class="btn btn-warning glyphicon glyphicon-pencil"></span></a></td>
                    <td><a href="#EliminarMedioPago'.$item["Id_medio_pago"].'" data-toggle="modal"><span class="btn btn-warning glyphicon glyphicon glyphicon-remove"></span></a></td>
                  </tr>
                  
                  <div id="medioPago'.$item["Id_medio_pago"].'" class="modal fade">

				       	<div class="modal-dialog modal-content">

							<div class="modal-header" style="border:1px solid #eee">

								<button type="button" class="close" data-dismiss="modal">X</button>

								<h3 class="modal-title">Editar Medio pago</h3>

							</div>

							<div class="modal-body" style="border:1px solid #eee">
							
								<form style="padding:0px 10px" method="post" enctype="multipart/form-data">
								      <input name="idMedioPago" type="hidden" value="'.$item["Id_medio_pago"].'">    
								     <div class="form-group">  
								      <input name="editarModoPago" type="text" class="form-control" value="'.$item["nombre_medio_pago"].'" required>
                                     </div>
								      <div class="form-group">

								        <select name="editarActivo" class="form-control" required>
								            <option value="">Activo medio pago</option>
								            <option value="0">SI</option>
								            <option value="1">NO</option>
								        </select>

								      </div>

								        <div class="form-group text-center">
								    		<input type="submit" id="guardarMedioPago" value="Actualizar" class="btn btn-warning">
								    	</div>

								</form>

							</div>
							<div class="modal-footer" style="border:1px solid #eee">					
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							</div>
				        
				       	</div>

			       </div>
			      <div id="EliminarMedioPago'.$item["Id_medio_pago"].'" class="modal fade">
			        <div class="modal-dialog modal-content">
						<div class="modal-header" style="border:1px solid #eee">
							<button type="button" class="close" data-dismiss="modal">X</button>
							<h3 class="modal-title">¿Desea eliminar  '.$item["nombre_medio_pago"].'?</h3>
						</div>
							<div class="modal-body" style="border:1px solid #eee">							
								<form style="padding:0px 10px" method="post" enctype="multipart/form-data">
								      <input name="idMedioPago" type="hidden" value="'.$item["Id_medio_pago"].'">    
								      <div class="form-group">
								        <select name="eliminarMedioPago" class="form-control" required>
								            <option value="0">NO</option>
								            <option value="1">Si</option>
								        </select>
								      </div>
								        <div class="form-group text-center">
								    		<input type="submit" id="guardarMedioPago" value="Eliminar" class="btn btn-danger">
								    	</div>
								</form>
							</div>
							<div class="modal-footer" style="border:1px solid #eee">					
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							</div>
				        
				       	</div>

			       </div>
			       ';

        }
    }

    public function editarModelController(){

        if (isset($_POST["editarModoPago"])) {
            $datosController = array("Id_medio_pago"=> $_POST["idMedioPago"],
                                      "modoPago" => $_POST["editarModoPago"],
                                      "activo" => $_POST["editarActivo"]);
            $respuesta = MedioPagoModel::actualizarMedioPago($datosController, "siax_medio_pago");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){

                    $_SESSION["Id_medio_pago"] = $_POST["idMedioPago"];
                    $_SESSION["modoPago"] = $_POST["editarModoPago"];
                    $_SESSION["activo"] = $_POST["editarActivo"];
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
                               window.location = "medioPago";
                           }
                         
                       }); 
                </script>';

            }
        }
    }


    #Validar medio Pago Existente
    public function validarModoPagoController($validarMedioPago){
        $datosController = $validarMedioPago;
        $respuesta = MedioPagoModel::validarModoPagoModel($datosController, "siax_medio_pago");
        if (count($respuesta["nombre_medio_pago"]) > 0){
            echo 0;
        }
        else{
            echo 1;
        }

    }

    public function EliminarModelController(){

        if (isset($_POST["editarModoPago"])) {
            $datosController = array("Id_medio_pago"=> $_POST["idMedioPago"],
                "modoPago" => $_POST["editarModoPago"],
                "activo" => $_POST["editarActivo"]);
            $respuesta = MedioPagoModel::actualizarMedioPago($datosController, "siax_medio_pago");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){

                    $_SESSION["Id_medio_pago"] = $_POST["idMedioPago"];
                    $_SESSION["modoPago"] = $_POST["editarModoPago"];
                    $_SESSION["activo"] = $_POST["editarActivo"];
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
                               window.location = "medioPago";
                           }
                         
                       }); 
                </script>';

            }
        }
    }




}

