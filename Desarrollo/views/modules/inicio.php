<?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}

include "views/modules/navegacion.php";
include "views/modules/header.php";


?>
    <div class="jumbotron">
        <h1 class="text-yellow">Bienvenido - <?php echo $_SESSION["nombre_tercero"];?></h1>


    <div class="row">
        <div class="col-md-12">
            <p>Bienvenido al panel de control de negocios para contratista de Gas Naturas -  ARHUS.</p>
        </div>
    </div>
    </div>

<?php

include "views/modules/footer.php";

?>