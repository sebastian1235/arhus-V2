<?php

class tercero
{

    public function registroTerceroController()
    {
        if (isset($_POST["nombre_tercero"])) {
            $datosController = array("nombre_tercero" => $_POST["nombre_tercero"],
                                "tipo_tercero" => $_POST["tipo_tercero"],
                                "nit_tercero" => $_POST["nit_tercero"],
                                "direccion_tercero" => $_POST["direccion_tercero"],
                                "e_mail_tercero" => $_POST["e_mail_tercero"],
                                "telefono1_tercero" => $_POST["telefono1_tercero"],
                                "telefono2_tercero" => $_POST["telefono2_tercero"],
                                "fax_tercero" => $_POST["fax_tercero"],
                                "Contacto_tercero" => $_POST["Contacto_tercero"],
                                "gran_contrib_tercero" => $_POST["gran_contrib_tercero"],
                                "autoretenedor_tercero" => $_POST["autoretenedor_tercero"],
                                "reg_comun_tercero" => $_POST["reg_comun_tercero"],
                                "responsable_materiales_tercero" => $_POST["responsable_materiales_tercero"],
                                "activo_tercero" => $_POST["activo_tercero"]);

               

            $respuesta = TercerosModel::registroTerceros($datosController, "ap_terceros");

            if ($respuesta == "ok") {
                echo '<script>

                       swal({
                            title: "!Ok",
                            text: "¡La persona ha sido creada correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                       },
                       function(isConfirm) {
                           if (isConfirm){
                               window.location = "Tterceros";
                           }
                         
                       }); 
                </script>';

            }
        }
    }
        public function selectTipoTercero(){
        $respuesta = TipoTerceroModel::vistaTipoTercero("ap_tipo_tercero");
        foreach ($respuesta as $row => $selectTipoTercero){
            echo '<option value="'.$selectTipoTercero["id_tipo_tercero"].'">'.$selectTipoTercero["nombre_tipo_ter"].'</option>';
        }

    }
}

