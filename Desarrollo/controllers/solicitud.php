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
                    <td><a href="#programarSol'.$item["id_sol"].'" data-toggle="modal"><span class="btn btn-warning fa fa-check"></span></a></td>
                    <td><a href="#modificarSol'.$item["id_sol"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                    <td><a href="#eliminarSol'.$item["id_sol"].'" data-toggle="modal"><span class="btn btn-warning fa fa-pencil"></span></a></td>
                    <td><a href="cotizacion?'.$item["id_sol"].' "><span class="btn btn-warnig fa fa-trash"></span></a></td>
                    
                    <td>' .$item["id_sol"].'</td>
                    
                    <td>' .$item["asignacion_sol"].'.' .$item["tipo_asignacion"].'</td>
                    <td>' .$item["asesor_sol"].'.'.$item["nombre_tercero"].'</td>
                    <td>' .$item["nombre_sol"].'</td>
                    <td>' .$item["servicio_sol"].'</td>
                    <td>' .$item["nombre_estado_preventa"].'</td>
                    <td>' .$item["fecha_prevista_sol"].'</td>
                    <td>' .$item["fecha_visita_comerc_sol"].'</td>
                    <td>'.$item["barrio_sol"].'.'.$item["nombre_Sec"].'</td>
                    <td>'.$item["localidad_sol"].'.'.$item["nombre_loc"].'</td>
                    <td>' .$item["cedula_sol"].'</td>
                    <td>' .$item["direccion_nueva_sol"].'</td>
                    <td>' .$item["telefono1_sol"].'-'.$item["telefono2_sol"].'-'.$item["celular_sol"].'</td>
                    <td>' .$item["obs_estado_sol"].'</td>
                  </tr>  

                  <div id="programarSol'.$item["id_sol"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Programar '.$item["nombre_sol"].' Direccion '.$item["direccion_nueva_sol"].'</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                <input name="idSolicitud" type="hidden" value="'.$item["id_sol"].'">
                <div class="form-group">  
                
                  <input disabled name="EditarfechaPrevistaSol" type="text" class="form-control" value="'.$item["fecha_prevista_sol"].'" required>
                
                  
                </div>
                
                <div class="form-group">
                <label for="">Nombre asesor</label>
                <select class="form-control" id="EditarAsesor" name="EditarASesor">
                <option value="'.$item["asesor_sol"].'">'.$item["nombre_tercero"].'</option>
                <option value="0">Nuevo asesor</option>';
                                    
                            $seleccionarSector = new solicitud();
                            $seleccionarSector -> selectAsesor();
                            
                          echo  '</select>
                            </div>

                                     <div class="form-group">
                <label for=""> Asignacion</label>
                <select class="form-control" id="editarTipoAsignacion" name="editarTipoAsignacion">
                <option value="'.$item["asignacion_sol"].'">'.$item["tipo_asignacion"].'</option>
                <option value="0">Asigancion nueva</option>';
                                    
                            $seleccionarSector = new solicitud();
                            $seleccionarSector -> selectAsigancion();
                            
                          echo  '</select>
                            </div>
                        <div class="form-group">
                           
                          <label for="">Fecha visita</label>
                          <input name="EditarFechaVisitaComercial" type="text" class="form-control" value="'.$item["fecha_visita_comerc_sol"].'" required>
                         
                      
                        </div>
                                     <div class="form-group"> 
                                     <label for="">Direccion nueva</label> 
                      <input name="EditarDireccionNueva" type="text" class="form-control" value="'.$item["direccion_nueva_sol"].'" required>
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

             </div>
             <div id="eliminarSol'.$item["id_sol"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">desea Eliminar '.$item["nombre_sol"].' Direccion '.$item["direccion_nueva_sol"].'</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                <input name="idSolicitud" type="hidden" value="'.$item["id_sol"].'">
                <div class="form-group">
                <label for="">Nombre asesor</label>
                <select class="form-control" id="borrar" name="EliminarSol">
                <option value="0">No</option>
                <option value="1">Si</option>';
                                    
                            
                            
                          echo  '</select>
                            </div>
                
           
                                    
                        <div class="form-group text-center">
                        <input type="submit" id="eliminarSol" value="Continuar" class="btn btn-danger">
                      </div>
                </form>

              </div>
              <div class="modal-footer" style="border:1px solid #eee">          
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
                
                </div>

             </div>

              <div id="modificarSol'.$item["id_sol"].'" class="modal fade">
                <div class="modal-dialog modal-content">
              <div class="modal-header" style="border:1px solid #eee">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">Programar '.$item["nombre_sol"].' Direccion '.$item["direccion_nueva_sol"].'</h3>
              </div>
              <div class="modal-body" style="border:1px solid #eee">
                <form style="padding:0px 10px" method="post" enctype="multipart/form-data">
                <input name="idSolicitud" type="hidden" value="'.$item["id_sol"].'">
                <div class="form-group">  
                
                  <div class="form-group">
                        <div class="col-md-6">
                            <label>Nombre del cliente:</label>
                            <input type="text" class="form-control" name="nombre_sol" required="" id="nombre_sol" value='.$item["nombre_sol"].'>
                            </div>
                             <div class="col-md-6">
                        <label>Cedula:</label>
                            <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol"  value='.$item["cedula_sol"].'>
                            </div>

                    </div>
                    



                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="">Localidad:</label>
                            <select class="form-control" id="localidad_sol"  name="localidadSol">
                            <option value="'.$item[""].'">'.$item["nombre_loc"].'</option>
                                <option value="">seleccionar localidad</option>';
                               
                                
                            $seleccionarSector = new Ciudades();
                            $seleccionarSector -> selectLocalidad();
                          

                           echo'</select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Barrio:</label>
                            <select class="form-control" id="barrio_sol"  name="barrio_sol">
                            <option value="'.$item["barrio_sol"].'">'.$item["nombre_Sec"].'</option>
                                <option value="">Seleccionar barrio</option>';
                           
                            $seleccionarSector = new Ciudades();
                            $seleccionarSector -> selectSector();
                         
                           echo'</select>
                        </div>
                        </div>

                    <div class="form-group"  >
                       
                            <label for="">Direccion:</label>
                            <input type="text" class="form-control" name="direccion_pol_sol" required="" id="direccion_pol_sol" value='.$item["direccion_nueva_sol"].'>
                      
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
             </div>'


             ;

     
             


        }
    }
    public function modificarModelController(){

        if (isset($_POST["nombre_sol"])) {
            $datosController = array("id_sol"=> $_POST["idSolicitud"],
                                      "nombre_sol" => $_POST["nombre_sol"],
                                      "cedula_sol" => $_POST["cedula_sol"],
                                      "localidad_sol" => $_POST["localidadSol"], 
                                      "barrio_sol" => $_POST["barrio_sol"],
                                      "direccion_pol_sol" => $_POST["direccion_pol_sol"]);

            $respuesta = SolicitudModel::modificarSolicitud($datosController, "ap_solicitud");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){
                    $_SESSION["id_sol"] = $_POST["idSolicitud"];
                    $_SESSION["nombre_sol"] = $_POST["nombre_sol"];
                    $_SESSION["cedula_sol"] = $_POST["cedula_sol"];
                    $_SESSION["localidad_sol"] = $_POST["localidadSol"];
                    $_SESSION["barrio_sol"] = $_POST["barrio_sol"];
                    $_SESSION["direccion_pol_sol"] = $_POST["direccion_pol_sol"];
               

                }

                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡Programado correctamente!",
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
     public function programarModelController(){

        if (isset($_POST["EditarASesor"])) {
            $datosController = array("id_sol"=> $_POST["idSolicitud"],
                                      "asesor_sol" => $_POST["EditarASesor"],
                                      "tipo_asignacion" => $_POST["editarTipoAsignacion"],
                                      "fecha_visita_comerc_sol" => $_POST["EditarFechaVisitaComercial"], 
                                      "direccion_nueva_sol" => $_POST["EditarDireccionNueva"]);

            $respuesta = SolicitudModel::programarSolicitud($datosController, "ap_solicitud");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){
                    $_SESSION["id_sol"] = $_POST["idSolicitud"];
                    $_SESSION["asesor_sol"] = $_POST["EditarASesor"];
                    $_SESSION["tipo_asignacion"] = $_POST["editarTipoAsignacion"];
                    $_SESSION["fecha_visita_comerc_sol"] = $_POST["EditarFechaVisitaComercial"];
                    $_SESSION["direccion_nueva_sol"] = $_POST["EditarDireccionNueva"];
               

                }

                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡Programado correctamente!",
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
    public function eliminarModelController(){

        if (isset($_POST["EliminarSol"])) {
            $datosController = array("id_sol"=> $_POST["idSolicitud"],
                                      "eliminar" => $_POST["EliminarSol"]
                                     );
            $respuesta = SolicitudModel::EliminarSolicitud($datosController, "ap_solicitud");

            if ($respuesta == "ok") {
                if(isset($_POST["actualizarSesion"])){
                    $_SESSION["id_sol"] = $_POST["idSolicitud"];
                    $_SESSION["eliminar"] = $_POST["EliminarSol"];
                

                }
                if ($_POST["EliminarSol"] == 0) {
                 echo '<script>
                                swal({
                                  title: "!No",
                                  text: "Se elimino el registro!",
                                  
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
                   else{
                    echo '<script>

                             swal({
                                  title: "!Ok",
                                  text: "¡Eliminado correctamente!",
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
                  # code...
                
                 
                
            }
        }
    }

     public function selectAsesor(){
        $respuesta = SolicitudModel::vistaAsesor("ap_terceros");
        foreach ($respuesta as $row => $SelectsCiudad){
            echo '<option value="'.$SelectsCiudad["Id_tercero"].'">'.$SelectsCiudad["nombre_tercero"].'</option>';
        }

    }

    public function selectAsigancion(){
        $respuesta = SolicitudModel::vistaAsigancion("ap_asignacion");
        foreach ($respuesta as $row => $SelectsCiudad){
            echo '<option value="'.$SelectsCiudad["id_asignacion"].'">'.$SelectsCiudad["tipo_asignacion"].'</option>';
        }

    }

    public function selectEstado(){
        $respuesta = SolicitudModel::vistaEstado("ap_estado_preventa");
        foreach ($respuesta as $row => $SelectsCiudad){
            echo '<option value="'.$SelectsCiudad["id_estado_preventa"].'">'.$SelectsCiudad["nombre_estado_preventa"].'</option>';
        }

    }


    public function vistacotizacionController(){
        $respuesta = SolicitudModel::vistaSolicitud("ap_solicitud");
        foreach ($respuesta as $row => $item){

                  $id_sol=$item["id_sol"];
                  $item["asignacion_sol"];
                  $item["tipo_asignacion"];
                  $item["asesor_sol"];
                  $item["nombre_tercero"];
                  $item["nombre_sol"];
                  $item["servicio_sol"];
                  $item["nombre_estado_preventa"];
                  $item["fecha_prevista_sol"];
                  $item["fecha_visita_comerc_sol"];
                  $item["barrio_sol"];
                  $item["nombre_Sec"];
                  $item["localidad_sol"];
                  $item["nombre_loc"];
                  $item["cedula_sol"];
                  $item["direccion_nueva_sol"];
                  $item["telefono1_sol"];
                  $item["telefono2_sol"];
                  $item["celular_sol"];
                  $item["obs_estado_sol"];
                  
                }
              }

}

