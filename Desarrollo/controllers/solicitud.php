<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 15/03/2018
 * Time: 6:45 PM
 */

class solicitud
{

    public function registroSolicitudController()
    {
        if (isset($_POST["nombre_sol"])) {
            $datosController = array("nombre_sol" => $_POST["nombre_sol"],
                "cedula_sol" => $_POST["cedula_sol"],
                "localidad_sol" => $_POST["localidad_sol"],
                "barrio_sol" => $_POST["barrio_sol"],
                "direccion_pol_sol" => $_POST["direccion_pol_sol"],
                "direccion_nueva_sol" => $_POST["direccion_pol_sol"],
                "telefono1_sol" => $_POST["telefono1_sol"],
                "telefono2_sol" => $_POST["telefono1_sol"],
                "celular_sol" => $_POST["celular_sol"],
                "email_sol" => $_POST["email_sol"],
                "poliza_sol" => $_POST["poliza_sol"],
                "demanda_sol" => $_POST["demanda_sol"],
                "asesor_sol" => $_POST["asesor_sol"],
                "asignacion_sol" => $_POST["asignacion_sol"],
                "servicio_sol" => $_POST["servicio_sol"],
                "obs_sol" => $_POST["obs_sol"],
                "estado_sol" => $_POST["estado_sol"],
                "fecha_prevista_sol" => $_POST["fecha_prevista_sol"],
                "fecha_visita_comerc_sol" => $_POST["fecha_visita_comerc_sol"],
                "forma_pagogn_sol" => $_POST["forma_pagogn_sol"]);

            $respuesta = SolicitudModel::registroSolicitud($datosController, "ap_solicitud");

            if ($respuesta == "ok") {
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
                               window.location = "TSolicitudes";
                           }
                         
                       }); 
                </script>';

            }
        }
    }


    public function vistaSolicitudController(){
        $respuesta = SolicitudModel::vistaSolicitud("ap_solicitud");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
                    <td>' .$item["id_sol"].'</td>
                    <td>' .$item["poliza_sol"].'</td>
                    <td>' .$item["tipo_asignacion"].'</td>
                    <td>' .$item["nombre_tercero"].'</td>
                    <td>' .$item["nombre_sol"].'</td>
                    <td>' .$item["servicio_sol"].'</td>
                    <td>' .$item["nombre_estado_preventa"].'</td>
                    <td>' .$item["fecha_prevista_sol"].'</td>
                    <td>' .$item["fecha_visita_comerc_sol"].'</td>
                    <td>' .$item["nombre_Sec"].'</td>
                    <td>' .$item["nombre_loc"].'</td>


                    <td><a href="#programarSol'.$item["id_sol"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                    <td><a href="#registroCiudad'.$item["id_sol"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                  </tr>  
                  <div id="programarSol'.$item["id_sol"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Programar</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                      <input name="id_solicitud" type="hidden" value="'.$item["id_sol"].'">
                     <div class="form-group">  
                      <input name="EditarfechaPrevistaSol" type="text" class="form-control" value="'.$item["fecha_prevista_sol"].'" required>
                                     </div>
                                     <div class="form-group">  
                      <input name="EditarfechaVisitaComercSol" type="text" class="form-control" value="'.$item["fecha_visita_comerc_sol"].'" required >
                                     </div>
                                     <div class="form-group">  
                      <input name="EditarnombreTercero" type="text" class="form-control" value="'.$item["nombre_tercero"].'" required>
                                     </div>
                                      <div class="form-group">  
                      <input name="EditarnombreEstadoPreventa" type="text" class="form-control" value="'.$item["nombre_estado_preventa"].'" required>
                                     </div>
                        <div class="form-group text-center">
                        <input type="submit" id="programarSol" value="Actualizar" class="btn btn-warning">
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
    public function programarModelController(){

        if (isset($_POST["fechaPrevistaSol"])) {
            $datosController = array("id_solicitud" => $_POST["id_solicitud"],
                "EditarfechaPrevistaSol"=> $_POST["EditarfechaPrevistaSol"],
                "EditarfechaVisitaComercSol" => $_POST["EditarfechaVisitaComercSol"],
                "EditarnombreTercero" => $_POST["EditarnombreTercero"],
                "EditarnombreEstadoPreventa" => $_POST["EditarnombreEstadoPreventa"]);
            $respuesta = SolicitudModel::programarSolicitud($datosController, "ap_solicitud");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){

                    $_SESSION["id_sol"] = $_POST["id_solicitud"];
                    $_SESSION["fechaPrevistaSol"] = $_POST["EditarfechaPrevistaSol"];
                    $_SESSION["fechaVisitaComercSol"] = $_POST["EditarfechaVisitaComercSol"];
                    $_SESSION["nombreTercero"] = $_POST["EditarnombreTercero"];
                    $_SESSION["nombreEstadoPreventa"] = $_POST["EditarnombreEstadoPreventa"];
                }

                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡La solicitud ha sido programada correctamente!",
                            type: "success",
                           confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       }
                     function(isConfirm) {
                           if (isConfirm){
                               window.location = "TSolicitudes
                               ";
                          }
                       
                      }); 
                </script>';

            }
        }
    }

}

