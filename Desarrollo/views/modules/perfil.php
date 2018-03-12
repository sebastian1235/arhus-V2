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
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <h1>Hola <?php echo $_SESSION["usuario"];?>
            <span class="btn btn-info fa fa-pencil pull-left" id="btnEditarPerfil" style="font-size:10px; margin-right:10px"></span></h1>

        <div style="position:relative">
            <img src="<?php echo $_SESSION["photo"];?>" class="img-circle pull-right">
    </div>
</div>



<?php
include "views/modules/footer.php";
?>
