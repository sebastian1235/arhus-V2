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
        foreach ($respuesta as $row => $item){
            if ($item["rol" == 0]){
                $rol = "Adminstrador";

            }
            else{
                $rol = "Editor";

            }
            echo '
                <tr>
                    <td>' . $item["usuario"] . '</td>
                    <td>' . $rol . '</td>
                    <td>' . $item["email"] . '</td>    
                </tr>
               ';
        }
    }

}