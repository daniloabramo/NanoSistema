$(document).ready(function() {
    $("#buscar-produto").on("click", function() {
        $.get(base_url + "pedido/listar", function(data) {
            $("#listar-produto").html(data);
        });
    });
});