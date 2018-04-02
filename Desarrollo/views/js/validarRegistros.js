// validar Medio de pago existente

var medioPagoExistente = false;

    $("#modoPagoRegistro").change(function () {
        var medioPago = $("#modoPagoRegistro").val();
        var datos = new FormData();
        datos.append("validarMedioPago", medioPago);
        $.ajax({
            url: "views/ajax/ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function (respuesta) {
                if (respuesta == 0){
                    $("label[for='medioPagoRegistro'] span").html('<p>Este Medio de Pago ya existe en la base de datos</p>');
                    medioPagoExistente = true;
                }else{
                    $("label[for='medioPagoRegistro'] span").html("");
                    medioPagoExistente = false;
                }
            }
        });

    });
// fin de validar Medio de pago

