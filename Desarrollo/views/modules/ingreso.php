<div class="login-box">
    <div class="login-logo">
        <h1><b>Arhus Ingenieros</b></h1>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Iniciar Sesión</p>

        <form method="post" id="formIngreso" onsubmit="return validarIngreso()">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Usuario" name="usuarioIngreso">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Contraseña" name="passwordIngreso">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <?php

            $ingreso = new Ingreso();
            $ingreso -> ingresoController();

            ?>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-warning btn-block btn-flat" value="Enviar"> Ingresar</button>
                </div>
            </div>
        </form>
    </div>
</div>
