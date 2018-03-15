<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 13/03/2018
 * Time: 2:50 PM
 */

class UsuarioPerfil{
    public function guardarPerfilController(){
        $ruta = "";
        if (isset($_POST["nombreUsuario"])){
            if (isset($_FILES["nuevaImagen"]["tmp_name"])){
                $imagen = $_FILES["nuevaImagen"]["tmp_name"];
                $aleatorio = mr_rand(100,999);
                $ruta = "views/images/perfiles/perfil" . $aleatorio . ".jpg";
                $origen = imagecreatefromgd($imagen);
                $destino = imagecrop($origen, ["x"=>0, "y"=>0, "width"=>100, "height"=>100]);
                imagejpeg($destino,$ruta);
            }

            if ($ruta == ""){
                $ruta = "views/images/photo.jpg";
            }

            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nombreUsuario"])&&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["passwordUsuario"])&&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["emailUsuario"])){

                $encriptar = crypt($_POST["passwordUsuario"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $datosController = array("usuario"=>$_POST["nombreUsuario"],
                                        "password"=>$encriptar,
                                        "email"=>$_POST["emailUsuario"],
                                        "rol"=>$_POST["rolUsuario"],
                                        "photo"=>$ruta);
                
                
                $respuesta = PerfilModel::guardarPerfilModel($datosController, "usuarios");

                if ($respuesta == "ok"){
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
                               window.location = "perfil";
                           }
                         
                       }); 
                </script>';
                }
            }
            else{
                echo '<div class="alert alert-warning"><b>¡ERROR!</b> No ingrese caracteres especiales</div>';
            }
        }
    }

    #VISUALIZAR LOS PERFILES
    public function verPerfilesController(){
        $respuesta = PerfilModel::verPerfilesModel("usuarios");
        $rol = "";
        foreach($respuesta as $row => $item){

            if( $item["rol"] == 0){

                $rol = "Administrador";

            }

            else{

                $rol = "Editor";

            }

            echo ' <tr>
			        <td>'.$item["usuario"].'</td>
			        <td>'.$rol.'</td>
			        <td>'.$item["email"].'</td>
			        <td><a href="#perfil'.$item["id"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a>
			      </tr>

			       <div id="perfil'.$item["id"].'" class="modal fade">

				       	<div class="modal-dialog modal-content">

							<div class="modal-header" style="border:1px solid #eee">

								<button type="button" class="close" data-dismiss="modal">X</button>

								<h3 class="modal-title">Editar Perfil</h3>

							</div>

							<div class="modal-body" style="border:1px solid #eee">
							
								<form style="padding:0px 10px" method="post" enctype="multipart/form-data">

								      <input name="idPerfil" type="hidden" value="'.$item["id"].'">
								    
								     <div class="form-group">
								       
								      <input name="editarUsuario" type="text" class="form-control" value="'.$item["usuario"].'" required>

								     </div>

								      <div class="form-group">

								          <input name="editarPassword" type="password" placeholder="Ingrese la Contraseña hasta 10 caracteres" maxlength="10" class="form-control" required>

								      </div>

								      <div class="form-group">

								         <input name="editarEmail" type="email" value="'.$item["email"].'" class="form-control" required>

								      </div>

								      <div class="form-group">

								        <select name="editarRol" class="form-control" required>

								            <option value="">Seleccione el Rol</option>
								            <option value="0">Administrador</option>
								            <option value="1">Editor</option>

								        </select>

								      </div>

								       <div class="form-group text-center">

								       		<div style="display:block;">

										     	<img src="'.$item["photo"].'" width="20%" class="img-circle">

		       								 	<input type="hidden" value="'.$item["photo"].'" name="editarPhoto">

									   		</div>	    

							    		<input type="file" class="btn btn-default" name="editarImagen" style="display:inline-block; margin:10px 0">

								          <p class="text-center" style="font-size:12px">Tamaño recomendado de la imagen: 100px * 100px, peso máximo 2MB</p>

								       </div>

								        <div class="form-group text-center">

								    		<input type="submit" id="guardarPerfil" value="Actualizar Perfil" class="btn btn-primary">

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