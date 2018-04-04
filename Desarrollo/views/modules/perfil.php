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
    <div class="col-md-8">
        <div>
            <button  id="registroPerfil" class="btn btn-warning" style="margin-bottom:20px">Registrar Usuario</button>
        </div>
        <div class="col-md-12 table-responsive">
            <div class="box box-warning">
            <form role="form" style="display:none" id="formularioPerfil" method="post" onsubmit="return validarNombreRegistro()">
                <div class="box-header with-border">
                    <h3 class="box-title">Registro de Usuarios</h3>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label for="nombreUsuario">Usuario<span></span></label>
                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Ingrese el nombre de Usuario hasta 10 caracteres" required>
                    </div>
                    <div class="form-group">
                        <label for="passwordUsuario">Contraseña</label>
                        <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" placeholder="Ingrese la contraseña hasta 10 caracteres" required>
                    </div>
                    <div class="form-group">
                        <label for="nombreTercero">Nombre</label>
                        <select class="form-control" name="nombreTercero" id="nombreTercero" required>
                            <option value="0">Seleccione Nombre</option>
                            <?php
                            $seleccionarNombreTercero = new UsuarioPerfil();
                            $seleccionarNombreTercero -> selectNombreTercero();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombreTercero">Email Tercero</label>
                        <input type="text" class="form-control" id="emailUsuario" name="emailUsuario" placeholder="Ingrese el Correo Electrónico" required>
                    </div>
                    <div class="form-group">
                        <label for="rolUsuario">Grupo</label>
                        <select class="form-control" name="rolUsuario" required>
                            <option value="0">Seleccione grupo</option>
                            <option value="0">Administrador</option>
                            <option value="1">Analista</option>
                            <option value="2">Asesor</option>
                            <option value="3">Tecnico</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <input type="file" id="subirFotoUsuario" style="display:inline-block; margin:10px 0">
                        <p class="help-block">Tamaño recomendado de la imagen: 100px * 100px, peso máximo 2MB</p>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-warning" name="guardarUsuario" id="guardarUsuario">Guardar</button>
                </div>
            </form>

            <?php
            $crearPerfil = new UsuarioPerfil();
            $crearPerfil -> guardarPerfilController();
            ?>

        </div>
        </div>
    </div>
<!--Fin registrar usuarios-->

    <div class="col-md-4">
        <h1>Hola <?php echo $_SESSION["usuario"];?>
<!--            <span class="btn btn-warning fa fa-pencil pull-left" id="btnEditarPerfil" style="font-size:10px; margin-right:10px"></span>-->
        </h1>
        <h4>Email: <?php echo $_SESSION["email"];?></h4>
        <h4>Perfil: <?php

            if( $_SESSION["rol"] == 0){
                echo "Administrador";
            }
            else{
                echo "Asesor";
            }
            ?>
        </h4>
    </div>

</div>

<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-body table-responsive">
                <table id="tablas" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>grupo</th>
                        <th>email</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $verPerfiles = new UsuarioPerfil();
                    $verPerfiles -> verPerfilesController();

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
