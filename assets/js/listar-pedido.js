$("#buscar-pedido").on("click", function() {
    var id = $("#id-pedido").val();
    var nome_completo = $("#cliente").val();
    var status = $("#descricao-status").val();
    var data_inicio = $("#data-inicio").val();
    var data_fim = $("#data-fim").val();

    $.get(base_url + "controle/listar", { 
        id: id,
        nome_completo: nome_completo,
        status: status,
        data_inicio: data_inicio,
        data_fim: data_fim
    }, function(data) {
        $("#listar-pedido").html(data);
    });
});