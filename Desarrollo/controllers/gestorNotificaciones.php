<?php

class notificacion{

	public function NotificacionController(){
        $respuesta = notificacionModel::NotificacionMoldel("ap_solicitud");
       echo ' <a class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Solicitudes sin procesar</a>

  				<div class="collapse" id="collapseExample">
  				<br>
  				<div id="bandejaNotificacion"  class="col-lg-4 col-md-4 col-sm-6 col-xs-12">	
<h4 class="text-yellow">bandeja de notificacion</h4>';


        foreach ($respuesta as $row => $item){
            echo'
               <div class="card card-body">
 				<span class ="fa fa-times pull-right"></span>
				<h3>solicitud: '.$item["id_sol"].'</h3>
				<h5>Nombre cliente: '.$item["nombre_sol"].'</h5>
				<h5>Asesor: '.$item["nombre_tercero"].'</h5>
				<a href="#programarSol'.$item["id_sol"].'" data-toggle="modal"><span class="btn btn-warning fa fa-check"></span></a>

	
		
				<br>
  </div>
				';
				 echo'<div id="programarSol'.$item["id_sol"].'" class="modal fade">
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

             </div>';

        
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
                               window.location = "inicio";
                           }
                         
                       }); 
                </script>';

            }
        }
    }

}

?>