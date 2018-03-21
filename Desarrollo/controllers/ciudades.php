<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 21/03/2018
 * Time: 10:52 AM
 */

class Ciudades
{

    public function registroCiudadController()
    {
        if (isset($_POST["ciudad"])) {
            $datosController = array("ciudad" => $_POST["ciudad"]);

            $respuesta = CiudadModel::registroCiudad($datosController, "siax_ciudad");

            if ($respuesta == "ok") {
                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡La ciudad se  ha sido creado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "registroCiudad";
                           }
                         
                       }); 
                </script>';

            }
        }
    }

    #Vista de Medio de Pago
    public function vistaCiudadController(){
        $respuesta = CiudadModel::vistaCiudad("siax_ciudad");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
                    <td>' .$item["nombre_ciu"].'</td>
                    <td><a href="#registroCiudad'.$item["id_ciu"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroCiudad'.$item["id_ciu"].'" class="modal fade">
				       	<div class="modal-dialog modal-content">
							<div class="modal-header" style="border:1px solid #eee">
								<button type="button" class="close" data-dismiss="modal">X</button>
								<h3 class="modal-title">Editar Ciudad</h3>
							</div>
							<div class="modal-body" style="border:1px solid #eee">
								<form style="padding:0px 10px" method="post" enctype="multipart/form-data">
								      <input name="idCiudad" type="hidden" value="'.$item["id_ciu"].'">
								     <div class="form-group">  
								      <input name="editarCiudad" type="text" class="form-control" value="'.$item["nombre_ciu"].'" required>
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

    public function editarCiudadController(){

        if (isset($_POST["editarCiudad"])) {
            $datosController = array("id_ciu"=> $_POST["idCiudad"],
                                      "editarCiudad" => $_POST["editarCiudad"]);
            $respuesta = CiudadModel::actualizarCiudad($datosController, "siax_ciudad");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){
                    $_SESSION["id_ciu"] = $_POST["idCiudad"];
                    $_SESSION["ciudad"] = $_POST["editarCiudad"];
                }
                echo '<script>
                       swal({
                            title: "!Ok",
                            text: "¡La ciudad se  ha sido creado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "registroCiudad";
                           }
                         
                       }); 
                </script>';

            }
        }
    }

}
