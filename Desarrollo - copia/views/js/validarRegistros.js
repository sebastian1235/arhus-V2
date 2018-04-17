// validar Medio de pago existente

var nombreTipoTerceroExistente = false;
var nombreUsuariolExistente = false;

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
                    $("label[for='nombreTipoTerceros'] span").html('<p>Este nombre de registro ya existe en la base de datos</p>');
                    nombreTipoTerceroExistente = true;
                }else{
                    $("label[for='nombreTipoTerceros'] span").html('');
                    nombreTipoTerceroExistente = false;
                }


            }
        });

    });

// fin de validar Medio de pago

// Validar nombreUsuario
$("#usuarioTercero").change(function () {
    var nombreUsuario = $("#usuarioTercero").val();
    var datos = new FormData();
    datos.append("validarNombreUsuario", nombreUsuario);
    $.ajax({
        url: "views/ajax/ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success:function (respuesta) {
            if (respuesta == 0){
                $("label[for='usuarioTercero'] span").html('<p>Este nombre ya existe en la base de datos</p>');
                nombreUsuariolExistente = true;
            }else{
                $("label[for='usuarioTercero'] span").html('');
                nombreUsuariolExistente = false;
            }


        }
    });

});

function validarRegistro() {
    var nombreTipoTerceros = document.querySelector("#nombreTipoTerceros").value;
    if (nombreTipoTerceros != "") {
        if (nombreTipoTerceroExistente) {
            document.querySelector("label[for='nombreTipoTerceros'] span").innerHTML = "<p>Este Nombre ya existe en la base de datos</p>";
            return false;
        }
    }

}

function validarNombreRegistro(){
    var nombreUsuario = document.querySelector("#usuarioTercero").value;
    if(nombreUsuario != ""){
        if(nombreUsuariolExistente){
            document.querySelector("label[for='usuarioTercero'] span").innerHTML = "<p>Este Nombre ya existe en la base de datos</p>";
            return false;
        }
    }
    return true;
}



//  Fin Validar nombreUsuario





