
<?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";
$user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);
//desplegables anidados

$resul_localidad = mysqli_query($con,"SELECT * FROM siax_localidad");
$resul_barrio = mysqli_query($con,"SELECT * FROM siax_sectores");
$resul_asignacion = mysqli_query($con,"SELECT * FROM ap_asignacion");
$resul_asesor = mysqli_query($con,"SELECT Id_tercero, nombre_tercero, tipo_tercero FROM ap_terceros where tipo_tercero='4'");
$resul_estado = mysqli_query($con,"SELECT `id_estado_preventa`,`nombre_estado_preventa` FROM `ap_estado_preventa` WHERE `id_estado_preventa`='1'");

?>

<div class="row">

    <div class="col-md-12">
        <form class="form-horizontal" method="POST" id="formularioSolicitud" autocomplete="off">
            <h2 class="box-title text-yellow">Registrar solicitud</h2>
            <div class="box box-warning">
                <div class="container">
                    <br>
                    <legend>Datos de contacto</legend>



                    <div class="form-group">
                        <div class="col-md-5">
                            <label>Nombre del cliente:</label>
                            <input type="text" class="form-control" name="nombre_sol" required="" id="nombre_sol">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class=" col-md-4">
                            <label>Cedula:</label>
                            <input type="text" class="form-control" name="cedula_sol" required=""  id="cedula_sol">
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="">Localidad:</label>
                            <select class="form-control" id="localidad_sol"  name="localidad_sol">
                                <option value="">seleccionar localidad</option>
                                <?php while ($row = mysqli_fetch_array($resul_localidad)){
                                    echo '<option value="'.$row['id_loc'].'">'.$row['nombre_loc'].'</option>';

                                } ?>

                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Barrio:</label>
                            <select class="form-control" id="barrio_sol"  name="barrio_sol">
                                <option value="">Seleccionar barrio</option>
                                <?php while ($row = mysqli_fetch_array($resul_barrio)){
                                    echo '<option value="'.$row['cod_sec'].'">'.$row['nombre_sec'].'</option>';

                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group"  >
                        <div class=" col-md-4">
                            <label for="">Direccion:</label>
                            <input type="text" class="form-control" name="direccion_pol_sol" required="" id="direccion_pol_sol">
                        </div>



                    </div>


                    <div class="form-group">
                        <div class=" col-md-4">
                            <label for="">Telefono:</label>
                            <input type="text" class="form-control" name="telefono1_sol" required="" id="telefono1_sol" >
                        </div>

                        <div class=" col-md-4">
                            <label for="">Telefono opcional:</label>
                            <input type="text" class="form-control" name="telefono2_sol"  id="telefono2_sol" >
                        </div>

                        <div class=" col-md-3">
                            <label for="">Celular:</label>
                            <input type="text" class="form-control" name="celular_sol"  id="celular_sol" >
                        </div>

                        <div class=" col-md-4">
                            <br>
                            <label for="">Correo electronico:</label>
                            <input type="email" class="form-control" name="email_sol"  required="" id="email_sol" >
                        </div>

                    </div>

                    </fieldset>
                    <br>


                    <fieldset>
                        <legend>Datos de solicitiud:</legend>
                        <div class="form-group">
                            <div class=" col-md-6">
                                <input type="text" class="form-control" id="id_sol" name="id_sol" placeholder="id" style="visibility: hidden;" >
                            </div>
                        </div>

                        <div class="form-group">


                            <div class=" col-md-5">
                                <label for="">Numero de poliza</label>
                                <input type="text" class="form-control" id="poliza_sol"  name="poliza_sol">
                            </div>
                            <div class=" col-md-5">
                                <label for="">Cod Demanda</label>
                                <input type="text" class="form-control" id="demanda_sol"  name="demanda_sol">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                <label for="">Nombre asesor</label>
                                <select class="form-control" id="asesor_sol" name="asesor_sol">
                                    <option value="">Asesor</option>
                                    <?php while ($row = mysqli_fetch_array($resul_asesor)){
                                        echo '<option value="'.$row['Id_tercero'].'">'.$row['nombre_tercero'].'</option>';

                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="">Asignacion</label>
                                <select  class="form-control" id="estado_sol" name="estado_sol" >

                                    <?php while ($row = mysqli_fetch_array($resul_asignacion)){
                                        echo '<option value="'.$row['id_asignacion'].'">'.$row['tipo_asignacion'].'</option>';

                                    } ?>
                                </select>
                            </div>

                        </div>


                        <div class="form-group">
                            <div class=" col-md-5">
                                <label for="">servicio solicitado</label>

                                <input type="text" class="form-control" name="servicio_sol"  id="servicio_sol" >
                            </div>
                            <div class=" col-md-5">
                                <label for="">Observacion</label>
                                <textarea class="form-control" name="obs_sol"  id="obs_sol" ></textarea>
                            </div>
                            <div class="col-md-5">
                                <label for="">Estado</label>
                                <select disabled class="form-control" id="estado_sol" name="estado_sol" >

                                    <?php while ($row = mysqli_fetch_array($resul_estado)){
                                        echo '<option value="'.$row['id_estado_preventa'].'">'.$row['nombre_estado_preventa'].'</option>';

                                    } ?>
                                </select>
                            </div>
                            <!--<div class=" col-md-5">
                             <label for="">Observacion Estado de solicitud</label>
                             <textarea type="text" class="form-control" name="obs_estado_sol"  id="obs_estado_sol" placeholder="obs_estado_sol"></textarea>
                             </div>-->
                        </div>


                        <div class="form-group">
                            <div class=" col-md-3">
                                <label for="">Fecha prevista</label>
                                <input type="date" class="form-control" name="fecha_prevista_sol"  id="fecha_prevista_sol" placeholder="fecha_prevista_sol" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> >
                            </div>
                            <div class=" col-md-3">
                                <label for="">Fecha visita comercial</label>
                                <input type="date" class="form-control" name="fecha_visita_comerc_sol"  id="fecha_visita_comerc_sol" placeholder="fecha_visita_comerc_sol" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> >
                            </div>


                        </div>


                        <fieldset>
                            <legend>Subir archivos:</legend>

                            <div class="col-sm-8">

                                <label for="archivo" class="col-sm-2 control-label">Archivo</label>
                                <input type="file" class="form-control" id="archivo" name="archivo">
                            </div>
                        </fieldset>


                    </fieldset>




                    <div class="form-group">
                        <br>
                        <div class="col-sm-offset-5 col-sm-10">
                            <br>
                            <a href="TSolicitudes" class="btn btn-default">Regresar</a>
                            <button type="submit" align="center" class="btn btn-warning" name="guardarSolicitud" id="guardarSolicitud">Registrar</button>
                            <?php
                            $crearSolicitud = new solicitud();
                            $crearSolicitud  -> registroSolicitudController();
                            ?>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    <?php
    include "views/modules/footer.php";
    ?>
