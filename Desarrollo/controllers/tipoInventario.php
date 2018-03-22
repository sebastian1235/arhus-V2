<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 22/03/2018
 * Time: 2:13 PM
 */

class tipoInventarioController{
    public function selectTipoInventario(){
        $respuesta = TipoInventarioModel::vistaSelectTipoInventario("ap_tipo_inv");
        foreach ($respuesta as $row => $tipoInventarios){
            echo '<option value="'.$tipoInventarios["nombre_tipo_inv"].'">'.$tipoInventarios["nombre_tipo_inv"].'</option>';
        }

        }

}


