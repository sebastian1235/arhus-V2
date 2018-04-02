// validar Medio de pago existente

var nombreTipoTerceroExistente = false;
 $("#nombreTipoTerceros").change(function () {
        var nombreTipoTercero = $("#nombreTipoTerceros").val();
        var datos = new FormData();
        datos.append("validarNombreTipoTercero", nombreTipoTercero);
        $.ajax({
            url: "views/ajax/ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function (respuesta) {
                if (respuesta == 0){
                    $("label[for='nombreTipoTercero'] span").html('<p>Este nombre de registro ya existe en la base de datos</p>');
                    nombreTipoTerceroExistente = true;
                }else{
                    $("label[for='nombreTipoTercero'] span").html('');
                    nombreTipoTerceroExistente = false;
                }


            }
        });

    });
// fin de validar Medio de pago

function validarRegistro(){
    var nombreTipoTerceros = document.querySelector("#nombreTipoTerceros").value;

    if(nombreTipoTerceros != ""){


        if(nombreTipoTerceroExistente){

            document.querySelector("label[for='nombreTipoTercero'] span").innerHTML = "<p>Este Nombre ya existe en la base de datos</p>";

            return false;
        }
    }

    return true;

}


