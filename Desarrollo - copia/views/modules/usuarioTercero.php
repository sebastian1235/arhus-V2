<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 12/03/2018
 * Time: 12:04 PM
 */
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>


<!--registrar usuarios-->
<div class="row">
    <div class="col-md-10">
        <div>
            <button  id="registroPerfil" class="btn btn-warning" style="margin-bottom:20px">Registrar Tercero</button>
        </div>
        <div class="col-md-12 table-responsive">
            <div class="box box-warning">
            <form role="form" id="formularioPerfil" method="post"  style="display:none" onsubmit="return validarNombreRegistro()">
                <div class="box-header with-border">
                    <h3 class="box-title">Información Tercero </h3>
                </div>

                <div class="box-body">
                    <div class="form-group col-md-6">
                        <label for="nombreTercero">Nombre</label>
                        <input type="text" class="form-control" id="nombreTercero" name="nombreTercero" placeholder="Ingrese nombre maximo 25 caracteres" maxlength="25" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nitTercero">Nit</label>
                        <input type="text" class="form-control" id="nitTercero" name="nitTercero" placeholder="Ingrese nit maximo 12 caracteres" maxlength="12" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="telUnoTercero">Telefono</label>
                        <input type="tel" class="form-control" id="telUnoTercero" name="telUnoTercero" placeholder="Ingrese Telefono hasta 9 caracteres" maxlength="10" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telDosTercero">Telefono 2</label>
                        <input type="tel" class="form-control" id="telDosTercero" name="telDosTercero" placeholder="Ingrese Telefono hasta 9 caracteres" maxlength="10">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="faxTercero">Fax</label>
                        <input type="tel" class="form-control" id="faxTercero" name="faxTercero" placeholder="Ingrese Fax hasta 12 caracteres" maxlength="12">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="direccionTercero">Direccion</label>
                        <input type="text" class="form-control" id="direccionTercero" name="direccionTercero" placeholder="Ingrese dirección hasta 20 caracteres">
                    </div>
                    <div class="box-header with-border col-md-12">
                        <h3 class="box-title">Registro de usuario Tercero</h3>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="usuarioTercero">Usuario<span></span></label>
                        <input type="text" class="form-control" id="usuarioTercero" name="usuarioTercero" placeholder="Ingrese usuario hasta 15 caracteres" required maxlength="15">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="emailTercero">Email</label>
                        <input type="email" class="form-control" id="emailTercero" name="emailTercero" placeholder="Ingrese el Correo Electrónico" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="passwordTercero">Contraseña</label>
                        <input type="password" class="form-control" id="passwordTercero" name="passwordTercero" placeholder="Ingrese la contraseña hasta 15 caracteres" required maxlength="15">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="grupoTercero">Grupo</label>
                        <select class="form-control" name="grupoTercero" required>
                            <option value="0">Seleccione grupo</option>
                            <option value="1">Administrador</option>
                            <option value="2">Analista</option>
                            <option value="3">Asesor Comercial</option>
                            <option value="4">Tecnico</option>
                        </select>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-warning" name="guardarUsuario" id="guardarUsuario">Guardar</button>
                </div>
            </form>
            <?php
            $crearTerceros = new UsuarioTercero();
            $crearTerceros -> guardarTercerosController();
            ?>
        </div>
        </div>
    </div>
<!--Fin registrar usuarios-->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body table-responsive">
                <table id="tablas" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Grupo</th>
                        <th>Información Tercero</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $verTerceros = new UsuarioTercero();
                    $verTerceros -> verUsuarioTerceroController();
                    $verTerceros -> editarTerceroUsuarioController();
                    ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>








<?php
include "views/modules/footer.php";
?>
