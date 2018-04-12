<?php
/**
 * Created by PhpStorm.
 * User: giova
 * Date: 21/03/2018
 * Time: 10:52 AM
 */

class Cotizacion
{

    

    #Vista Localidades
    public function vistaCotizacionController(){
        $respuesta = CotizacionModel::vistaCotizacion("ap_cotizacion" ,"ap_solicitud");
        foreach ($respuesta as $row => $item){
            echo' <tr>   
                    <td>' .$item["sol_cot"].'</td>
                    <td>' .$item["consecutivo_cot"].'</td>
                    <td>' .$item["estrato_cot"].'</td>
              
                    </tr>';


                
                  


        }
    }

}
