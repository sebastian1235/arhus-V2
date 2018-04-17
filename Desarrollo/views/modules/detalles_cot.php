
<?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";

            $crearTerceros = new solicitud();
            $crearTerceros -> vistaCotizacionController();
         

                    $poliza=$item[0];
                    $nombre=$item[1];
                    $consecutivo=$item[2];
                    $forma_pago=$item[3];
                    $campana=$item[4];
                    

?>                      

<div class="row">

    <div class="col-md-12">
         <form class="form-horizontal" method="POST" id="formularioSolicitud" autocomplete="off">
                      <input name="id_sol" type="hidden" value="$detalle">
                
                          <div class="form-group">
                               <div class="col-md-4">
                                   <label>No. de Poliza</label>
                                   <input type="text" class="form-control" name="poliza_sol" required="" id="poliza_sol" value="$detalle">
                               </div>
                               <div class="col-md-4">
                                   <label>consecutivo_cot</label>
                                   <input type="text" class="form-control" name="consecutivo_cot" required="" id="consecutivo_cot">
                               </div>
                               <div class="col-md-4">
                                   <label>estrato_cot</label>
                                   <input type="text" class="form-control" name="estrato_cot" required="" id="estrato_cot">
                               </div>
                               
                          </div>

                         
                          <div class="form-group">
                          <div class="col-md-4">
                                  <label>Fecha_nac_cot</label>
                                  <input type="DATE" class="form-control" name="fecha_nac_cot" required="" id="fecha_nac_cot">
                              </div>
                               
                                <div class="col-md-4">
                                      <label for="">Forma de pago</label>
                                      <select class="form-control" id="forma_pago_cot" name="forma_pago_cot">
                                          <option value="0">Forma de pago </option>';
                                          
                                  $seleccionarSector = new solicitud();
                                  $seleccionarSector -> selectFormaPago();
                                 
                                      echo'</select>
                                </div>
                               
                          </div>
                          
                      
                          <div class="form-group">
                          <div class="col-md-4">
                                      <label for="">Campaña</label>
                                      <select class="form-control" id="campana_cot" name="campana_cot">
                                          <option value="0">Campaña</option>';
                                          
                                  $seleccionarSector = new solicitud();
                                  $seleccionarSector -> selectCampana();
                                 
                                      echo'</select>
                                </div>
                               <div class="col-md-4">
                                      <label for="">Tipo cliente</label>
                                      <select class="form-control" id="tipo_cliente_cot" name="tipo_cliente_cot">
                                          <option value="0">Tipo cliente</option>';
                                          
                                  $seleccionarSector = new solicitud();
                                  $seleccionarSector -> selectTipoCliente();
                                 
                                     echo' </select>
                                </div>
                              <div class=" col-md-4">
                                  <label>fecha_cot </label>
                                  <input type="DATE" class="form-control" name="fecha_cot" required=""  id="fecha_cot" value="'.$item["telefono1_sol"].'">
                              </div>
                                
                          </div>
                          <br>
                          

                      
                            <div class="modal-footer" style="border:1px solid #eee">  
                            <br>
                           <div class=" col-md-12">
                            <br>
                            <div class="form-group text-center">
                           

                             <input type="submit" id="formularioCotizacion" value="Actualizar" class="btn btn-warning">
                             <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
                           </div>
                         </div>
                        </form>
    </div>
    ?>
    <?php  
    include "views/modules/footer.php";
?>
    
