<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 13/03/2018
 * Time: 2:50 PM
 */

class UsuarioTercero{
    public function guardarTercerosController(){
        $ruta = "";
        if (isset($_POST["nombreTercero"])){
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

            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuarioTercero"])&&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["passwordTercero"])&&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["emailTercero"])){

                $encriptar = crypt($_POST["passwordTercero"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $datosController = array("nombre"=>$_POST["nombreTercero"],
                                        "nit"=>$_POST["nitTercero"],
                                        "telUsno"=>$_POST["telUnoTercero"],
                                        "telDos"=>$_POST["telDosTercero"],
                                        "fax"=>$_POST["faxTercero"],
                                        "direccion"=>$_POST["direccionTercero"],
                                        "email"=>$_POST["emailTercero"],
                                        "usuario"=>$_POST["usuarioTercero"],
                                        "password"=>$encriptar,
                                        "rol"=>$_POST["grupoTercero"],
                                        "photo"=>$ruta);
                $respuesta = UsuarioTerceroModel::guardarTercerosModel($datosController, "ap_terceros");

                if ($respuesta == "ok"){
                    echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡El usuario Tercero ha sido creado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "usuarioTercero";
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
    public function verUsuarioTerceroController()
    {
        $respuesta = UsuarioTerceroModel::verTerceroModel("ap_terceros");
        $rol = "";


        foreach ($respuesta as $row => $item) {
            if ($item["tipo_tercero"] == 1) {

                $rol = "Administrador";

            }else if ($item["tipo_tercero"] == 2) {

                $rol = "Analista";

            }else if ($item["tipo_tercero"] == 3) {

                $rol = "Asesor Comercial";

            }else{

                $rol= "Tecnico";
            }

            echo ' <tr>
                    <td>'.$item["nombre_tercero"].'</td>
			        <td>'.$item["e_mail_tercero"].'</td>
			        <td>'.$rol.'</td>
			        <td><a href="#verTerceros'.$item["Id_tercero"].'" data-toggle="modal"><span class="btn btn-warning glyphicon glyphicon-user"></span></a></td>
			        <td><a href="#editarTerceros'.$item["Id_tercero"].'" data-toggle="modal"><span class="btn btn-warning  fa fa-pencil"></span></a></td>
			        <td><a href="index.php?action=perfil&idBorrar='.$item["Id_tercero"].'&borrarImg='.$item["photo"].'"><span class="btn btn-danger fa fa-times"></span></a></td>
			      </tr>';

                echo '
                      <div id="editarTerceros'.$item["Id_tercero"].'" class="modal fade">
				       	<div class="modal-dialog modal-content">
							<div class="modal-header" style="border:1px solid #eee">
								<button type="button" class="close" data-dismiss="modal">X</button>
								<h3 class="modal-title">Editar datos Tercero</h3>
							</div>
							<div class="modal-body" style="border:1px solid #eee">	
								<form style="padding:0px 10px" method="post" enctype="multipart/form-data">
								      <input name="idTercero" type="hidden" value="'.$item["Id_tercero"].'">
                                    <div class="form-group col-md-6">
                                        <label for="nombreTercero">Nombre</label>
                                        <input type="text" class="form-control" value="'.$item["nombre_tercero"].'" id="nombreTercero" name="EditarNombreTercero" maxlength="25" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nitTercero">Nit</label>
                                        <input type="text" class="form-control" value="'.$item["nit_tercero"].'" id="nitTercero" name="EditarNitTercero" maxlength="12" required>
                                    </div>
                                     <div class="form-group col-md-6">
                                        <label for="telUnoTercero">Telefono</label>
                                        <input type="tel" class="form-control" id="telUnoTercero" name="EditarTelUnoTercero" value="'.$item["telefono1_tercero"].'"  maxlength="10" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="telDosTercero">Telefono 2</label>
                                        <input type="tel" class="form-control" id="telDosTercero" name="EditarTelDosTercero" value="'.$item["telefono2_tercero"].'" maxlength="10">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="faxTercero">Fax</label>
                                        <input type="tel" class="form-control" id="faxTercero" name="EditarFaxTercero" value="'.$item["fax_tercero"].'" maxlength="12">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="direccionTercero">Direccion</label>
                                        <input type="text" class="form-control" id="direccionTercero" value="'.$item["direccion_tercero"].'" name="EditarDireccionTercero">
                                    </div>               
                                    <div class="box-header with-border col-md-12">
                                        <h3 class="box-title">Registro de usuario Tercero</h3>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="usuarioTercero">Usuario<span></span></label>
                                        <input type="text" class="form-control" id="usuarioTercero" name="EditarUsuarioTercero" value="'.$item["usuario"].'" required maxlength="15">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="emailTercero">Email</label>
                                        <input type="email" class="form-control" id="emailTercero" name="EditarEmailTercero" value="'.$item["e_mail_tercero"].'" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="passwordTercero">Contraseña</label>
                                        <input type="password" class="form-control" id="passwordTercero" name="EditarPasswordTercero" value="'.$item["password"].'" required maxlength="15">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="grupoTercero">Grupo</label>
                                        <select class="form-control" name="EditarGrupoTercero" required>
                                            <option value="0">Seleccione Grupo</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Analista</option>
                                            <option value="3">Asesor Comercial</option>
                                            <option value="4">Tecnico</option>
                                        </select>
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

			       </div>
                ';



			      echo '                  
                    <div id="verTerceros'.$item["Id_tercero"].'" class="modal fade">
				       	<div class="modal-dialog modal-content">
							<div class="modal-header" style="border:1px solid #eee">
								<button type="button" class="close" data-dismiss="modal">X</button>
								<h3 class="modal-title">Información Tercero</h3>
							</div>
							<div class="modal-body" style="border:1px solid #eee">
								<form style="padding:0px 10px">
								 <div class="form-group col-md-6">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" value="'.$item["nombre_tercero"].'" disabled>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Nit</label>
                                    <input type="text" class="form-control" value="'.$item["nit_tercero"].'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" value="'.$item["telefono1_tercero"].'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Telefono 2</label>
                                    <input type="text" class="form-control" value="'.$item["telefono2_tercero"].'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Fax</label>
                                    <input type="text" class="form-control" value="'.$item["fax_tercero"].'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Dirección</label>
                                    <input type="text" class="form-control" value="'.$item["direccion_tercero"].'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="'.$item["e_mail_tercero"].'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Usuario</label>
                                    <input type="text" class="form-control" value="'.$item["usuario"].'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tipo Tercero</label>
                                    <input type="text" class="form-control" value="'.$rol.'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control" value="'.$item["password"].'" disabled>
                                </div>
								</form>

							<div class="modal-footer" style="border:1px solid #eee">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							</div>
							
							
				       	    </div>
				       	    


			       </div>
			       ';
        }

    }
    public function editarTerceroUsuarioController(){

        $ruta = "";

        if(isset($_POST["EditarNombreTercero"])){

            if(isset($_FILES["editarImagen"]["tmp_name"])){

                $imagen = $_FILES["editarImagen"]["tmp_name"];

                $aleatorio = mt_rand(100, 999);

                $ruta = "views/images/perfiles/perfil".$aleatorio.".jpg";

                $origen = imagecreatefromjpeg($imagen);

                $destino = imagecrop($origen, ["x"=>0, "y"=>0, "width"=>100, "height"=>100]);

                imagejpeg($destino, $ruta);

            }

            if($ruta == ""){

                $ruta = $_POST["editarPhoto"];
            }

            if($ruta != "" && $_POST["editarPhoto"] != "views/images/photo.jpg"){

                unlink($_POST["editarPhoto"]);

            }

            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["EditarUsuarioTercero"])&&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["EditarPasswordTercero"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["EditarEmailTercero"])){

                $encriptar = crypt($_POST["EditarPasswordTercero"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $datosController = array("id"=>$_POST["idTercero"],
                    "nombre"=>$_POST["EditarNombreTercero"],
                    "nit"=>$_POST["EditarNitTercero"],
                    "telUsno"=>$_POST["EditarTelUnoTercero"],
                    "telDos"=>$_POST["EditarTelDosTercero"],
                    "fax"=>$_POST["EditarFaxTercero"],
                    "direccion"=>$_POST["EditarDireccionTercero"],
                    "email"=>$_POST["EditarEmailTercero"],
                    "usuario"=>$_POST["EditarUsuarioTercero"],
                    "password"=>$encriptar,
                    "rol"=>$_POST["EditarGrupoTercero"],
                    "photo"=>$ruta);

                $respuesta = UsuarioTerceroModel::editarUsuarioTerceroModel($datosController, "ap_terceros");

                if($respuesta == "ok"){

                    if(isset($_POST["actualizarSesion"])){

                        $_SESSION["id"] = $_POST["idTercero"];
                        $_SESSION["nombre"] = $_POST["EditarNombreTercero"];
                        $_SESSION["nit"] = $_POST["EditarNitTercero"];
                        $_SESSION["telUsno"] = $_POST["EditarTelUnoTercero"];
                        $_SESSION["telDos"] = $_POST["EditarTelDosTercero"];
                        $_SESSION["fax"] = $_POST["EditarFaxTercero"];
                        $_SESSION["direccion"] = $_POST["EditarDireccionTercero"];
                        $_SESSION["email"] = $_POST["EditarEmailTercero"];
                        $_SESSION["usuario"] = $_POST["EditarUsuarioTercero"];
                        $_SESSION["password"] = $encriptar;
                        $_SESSION["rol"] = $_POST["EditarGrupoTercero"];
                        $_SESSION["photo"] = $ruta;

                    }

                    echo'<script>

						swal({
							  title: "¡OK!",
							  text: "¡El usuario ha sido editado correctamente!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								    window.location = "usuarioTercero";
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

    public function selectNombreTercero(){
        $respuesta = TercerosModel::vistaTercero("ap_terceros");
        foreach ($respuesta as $row => $SelectsCiudad){
            echo '<option value="'.$SelectsCiudad["Id_tercero"].'">'.$SelectsCiudad["nombre_tercero"].'</option>';
        }

    }
    //Validacion de usuario
    public function validarNombreUsuarioController($validarNombreUsuario){
        $datosController = $validarNombreUsuario;
        $respuesta = UsuarioTerceroModel::validarNombreUsuarioModels($datosController, "ap_terceros");
        if (count($respuesta["usuario"]) > 0){
            echo 0;
        }else{
            echo 1;
        }

    }

}