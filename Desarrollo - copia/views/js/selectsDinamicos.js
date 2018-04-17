function cambiarValoresSelects(idpadre, idhijo){
    var valuepadre = $("#"+idpadre).val();

    $.ajax({
        data: { "idpadre":valuepadre, "idhijo":idhijo},
        type: "POST",
        url: "../controllers/selects.php",

        success: function(data) {
            $("#"+idhijo).html(data);

        }
    });
}

