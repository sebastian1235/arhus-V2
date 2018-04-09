<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 8/03/2018
 * Time: 5:51 PM
 */
session_start();
class Ingreso{

    public function ingresoController(){

        if(isset($_POST["usuarioIngreso"])){

            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuarioIngreso"])&&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["passwordIngreso"])){

                $encriptar = crypt($_POST["passwordIngreso"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $datosController = array("usuario"=>$_POST["usuarioIngreso"],
                                        "password"=>$encriptar);

                $respuesta = IngresoModels::ingresoModel($datosController, "ap_terceros");

                $intentos = $respuesta["intentos"];
                $usuarioActual = $_POST["usuarioIngreso"];
                $maximoIntentos = 2;

                if($intentos < $maximoIntentos){

                    if($respuesta["usuario"] == $_POST["usuarioIngreso"] && $respuesta["password"] == $encriptar){

                        $intentos = 0;

                        $datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);

                        $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "ap_terceros");
                        $_SESSION["validar"] = true;
                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["Id_tercero"] = $respuesta["Id_tercero"];
                        $_SESSION["password"] = $respuesta["password"];
                        $_SESSION["e_mail_tercero"] = $respuesta["e_mail_tercero"];
                        $_SESSION["photo"] = $respuesta["photo"];
                        $_SESSION["tipo_tercero"] = $respuesta["tipo_tercero"];
                        $_SESSION["nombre_tercero"] = $respuesta["nombre_tercero"];
                        echo '<script> window.location = "inicio"</script>';
                    }

                    else{

                        ++$intentos;

                        $datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);

                        $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "ap_terceros");

                        echo '<div class="alert alert-danger">Error al ingresar</div>';

                    }

                }

                else{
                    $intentos = 0;

                    $datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);

                    $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

                    echo '<div class="alert alert-danger">Ha fallado 3 veces, demuestre que no es un robot</div>';

                }

            }

        }
    }

}

