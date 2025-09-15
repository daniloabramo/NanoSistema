$(document).ready(function() {
    $("#buscar-pedido").on("click", function() {
        $.get(base_url + "controle/listar", function(data) {
            $("#listar-pedido").html(data);
        });
    });
});