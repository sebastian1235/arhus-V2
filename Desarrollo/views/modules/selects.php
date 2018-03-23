<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 22/03/2018
 * Time: 5:03 PM
 */

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>
<div class="col-md-12">
    <h2  class="text-yellow">Selects</h2>
    <div class="box box-warning">
        <div class="box-header with-border">
        <div class="container">
            <form class="form-horizontal" method="POST" id="registroSelectss">
                <div class="form-group">
                    <div class="col-md-3">
                        <label for=""></label>
                        <select class="form-control" id="tipo_item"  name="tipo_item" onchange="cambiarValoresSelects(this.id, 'localidad')" required>
                            <option value="0">Seleccione Ciudad</option>
                            <?php
                            $SelectCiudad = new seletsController();
                            $SelectCiudad -> selectCiudad();
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for=""></label>
                        <select class="form-control" id="localidad"  name="tipo_item" required>
                            <option value="0">Seleccione localidad</option>
                            <?php
                            $SelectLocalidad = new seletsController();
                            $SelectLocalidad -> selectLocalidad();
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for=""></label>
                        <select class="form-control" id="tipo_item"  name="tipo_item" required>
                            <option value="0">Seleccione Barrio</option>
                            <?php
                            $SelectBarrio = new seletsController();
                            $SelectBarrio -> selectBarrio();
                            ?>
                        </select>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
    </div>
<?php
include "views/modules/footer.php";
?>

