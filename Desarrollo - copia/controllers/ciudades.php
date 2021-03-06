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

    public function selectCiudad(){
        $respuesta = CiudadModel::vistaCiudad("siax_ciudad");
        foreach ($respuesta as $row => $SelectsCiudad){
            echo '<option value="'.$SelectsCiudad["id_ciu"].'">'.$SelectsCiudad["nombre_ciu"].'</option>';
        }

    }

    public function registroLocalidadController()
    {
        if (isset($_POST["localidad"])) {
            $datosController = array( "localidad" => $_POST["localidad"],
                                      "codigoLocalidad" => $_POST["codigoLocalidad"],
                                      "idCiudad" => $_POST["idCiudad"]);

            $respuesta = CiudadModel::registroLocalidad($datosController, "siax_localidad");

            if ($respuesta == "ok") {
                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡La localidad se  ha sido creado correctamente!",
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
    public function registroSectorController()
    {
        if (isset($_POST["nombre_sec"])) {
            $datosController = array( "nombre_sec" => $_POST["nombre_sec"],
                                      "cod_sec" => $_POST["cod_sec"],
                                      "localidad" => $_POST["localidad"]);

            $respuesta = CiudadModel::registroSector($datosController, "siax_sectores");

            if ($respuesta == "ok") {
                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡La localidad se  ha sido creado correctamente!",
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
   

    #Vista Localidades
    public function vistaLocalidadController(){
        $respuesta = CiudadModel::vistaLocalidad("siax_localidad");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
            <td>' .$item["cod_loc"].'</td>
                    <td>' .$item["nombre_loc"].'</td>
                    
                    <td>' .$item["nombre_ciu"].'</td>
                    <td><a href="#registroCiudad'.$item["cod_loc"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroCiudad'.$item["cod_loc"].'" class="modal fade">
				       	<div class="modal-dialog modal-content">
							<div class="modal-header" style="border:1px solid #eee">
								<button type="button" class="close" data-dismiss="modal">X</button>
								<h3 class="modal-title">Editar Ciudad</h3>
							</div>
							<div class="modal-body" style="border:1px solid #eee">
								<form style="padding:0px 10px" method="post" enctype="multipart/form-data">
								      <input name="idCiudad" type="hidden" value="'.$item["cod_loc"].'">
								     <div class="form-group">  
								      <input name="editarCiudad" type="text" class="form-control" value="'.$item["nombre_loc"].'" required>
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
    public function selectLocalidad(){
        $respuesta = CiudadModel::vistaLocalidad("siax_localidad");
        foreach ($respuesta as $row => $SelectsCiudad){
            echo '<option value="'.$SelectsCiudad["id_loc"].'">'.$SelectsCiudad["nombre_loc"].'</option>';
        }

    }

    public function selectSector(){
        $respuesta = CiudadModel::vistaSector("siax_sectores");
        foreach ($respuesta as $row => $SelectsCiudad){
            echo '<option value="'.$SelectsCiudad["cod_sec"].'">'.$SelectsCiudad["nombre_sec"].'</option>';
        }

    }

    #Vista Localidades
    public function vistaSectorController(){
        $respuesta = CiudadModel::vistaSector("siax_sectores");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
                    <td>' .$item["cod_sec"].'</td>
                    <td>' .$item["nombre_sec"].'</td>
                    <td>' .$item["nombre_loc"].'</td>

                    <td><a href="#registroCiudad'.$item["cod_sec"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="registroCiudad'.$item["cod_sec"].'" class="modal fade">
				       	<div class="modal-dialog modal-content">
							<div class="modal-header" style="border:1px solid #eee">
								<button type="button" class="close" data-dismiss="modal">X</button>
								<h3 class="modal-title">Editar Ciudad</h3>
							</div>
							<div class="modal-body" style="border:1px solid #eee">
								<form style="padding:0px 10px" method="post" enctype="multipart/form-data">
								      <input name="idCiudad" type="hidden" value="'.$item["cod_sec"].'">
								     <div class="form-group">  
								      <input name="editarCiudad" type="text" class="form-control" value="'.$item["nombre_sec"].'" required>
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

}
