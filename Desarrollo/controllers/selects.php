<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 22/03/2018
 * Time: 5:01 PM
 */

class seletsController{
    public function selectCiudad(){
        $respuesta = selectsModels::vistaSelectsCiudad("siax_ciudad");
        foreach ($respuesta as $row => $SelectsCiudad){
            echo '<option value="'.$SelectsCiudad["id_ciu"].'">'.$SelectsCiudad["nombre_ciu"].'</option>';
        }

    }
    public function selectLocalidad(){
        $respuesta = selectsModels::vistaSelectslocalidad("siax_localidad");
        foreach ($respuesta as $row => $SelectsLocalidad){
            echo '<option value="'.$SelectsLocalidad["id_loc"].'">'.$SelectsLocalidad["nombre_loc"].'</option>';
        }

    }
    public function selectBarrio(){
        $respuesta = selectsModels::vistaSelectsBarrio("siax_sectores");
        foreach ($respuesta as $row => $SelectsBarrio){
            echo '<option value="'.$SelectsBarrio["cod_sec"].'">'.$SelectsBarrio["nombre_sec"].'</option>';
        }

    }
}