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
                                        "contribuyente"=>$_POST["contriTercero"],
                                        "retenedor"=>$_POST["retenedorTercero"],
                                        "regimen"=>$_POST["regimenTercero"],
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

        $contribuyente = "";
        if ($item["gran_contrib_tercero"] == 0){
            $contribuyente = "SI";
        }else{
            $contribuyente= "NO";
        }
        $autoretenedor = "";
        if ($item["autoretenedor_tercero"] == 0){
            $autoretenedor = "SI";
        }else{
            $autoretenedor= "NO";
        }
        $regimen = "";
        if ($item["reg_comun_tercero"] == 0){
            $regimen = "SI";
        }else{
            $regimen= "NO";
        }

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

								       <div class="form-group text-center col-md-12">
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
                                    <label>Gran Contribuyente</label>
                                    <input type="text" class="form-control" value="'.$contribuyente.'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Autoretenedor</label>
                                    <input type="text" class="form-control" value="'.$autoretenedor.'" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Regimen Comun</label>
                                    <input type="text" class="form-control" value="'.$regimen.'" disabled>
                                </div>
                                
                                <div class="form-group col-md-12 text-center">
                                    <img src="'.$item["photo"].'" width="20%" class="img-circle">
		       						<input type="hidden" value="'.$item["photo"].'" name="editarPhoto">
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