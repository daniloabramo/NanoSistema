$("#buscar-pedido").on("click", function() {
    var id = $("#id-pedido").val();
    var status = $("#descricao-status").val();
    var data_inicio = $("#data-inicio").val();
    var data_fim = $("#data-fim").val();

    $.get(base_url + "controle/listar", { 
        id: id,
        status: status,
        data_inicio: data_inicio,
        data_fim: data_fim
    }, function(data) {
        $("#listar-pedido").html(data);
    });
});