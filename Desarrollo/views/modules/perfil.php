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



<div class="row">

    <!--registrar usuarios-->
    <div class="col-md-7">
        <div>
            <button  id="registroPerfil" class="btn btn-warning" style="margin-bottom:20px">Registrar Usuario</button>
        </div>
        <div class="box box-warning">
            <form role="form" id="formularioPerfil" method="post" enctype="multipart/form-data">
                <div class="box-header with-border">
                    <h3 class="box-title">Registro de perfiles</h3>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Ingrese el nombre de Usuario hasta 10 caracteres" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" placeholder="Ingrese la contraseña hasta 10 caracteres" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="emailUsuario" name="emailUsuario" placeholder="Ingrese el Correo Electrónico" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="rolUsuario" required>
                            <option value="">Seleccione el rol</option>
                            <option value="0">Administrador</option>
                            <option value="1">Asesor</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <input type="file" id="subirFotoUsuario" style="display:inline-block; margin:10px 0">
                        <p class="help-block">Tamaño recomendado de la imagen: 100px * 100px, peso máximo 2MB</p>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-warning" name="guardarUsuario" id="guardarUsuario">Guardar Perfil</button>
                </div>
            </form>

            <?php
            $crearPerfil = new UsuarioPerfil();
            $crearPerfil -> guardarPerfilController();
            ?>

        </div>
    </div>

    <div class="col-md-5">
        <h1>Hola <?php echo $_SESSION["usuario"];?>
            <span class="btn btn-info fa fa-pencil pull-left" id="btnEditarPerfil" style="font-size:10px; margin-right:10px"></span></h1>

        <div style="position:relative">
            <img src="<?php echo $_SESSION["photo"];?>" class="img-circle pull-right">
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Usuarios</th>
                        <th>Perfil</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>






<?php
include "views/modules/footer.php";
?>
