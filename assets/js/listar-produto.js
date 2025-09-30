$(document).ready(function() {
    $("#buscar-produto").on("click", function() {
        var codigo = $("#codigo-produto").val();
        
        $.get(base_url + "pedido/listar", { codigo: codigo }, function(data) {
            $("#listar-produto").html(data);
        });

    });
});
