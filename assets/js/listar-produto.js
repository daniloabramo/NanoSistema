$("#buscar-produto").on("click", function() {
    var codigo = $("#codigo-produto").val();
    var nome_produto = $("#descricao-produto").val();
    var nome_fornecedor = $("#descricao-fornecedor").val();
    
    $.get(base_url + "pedido/listar", { 
        codigo: codigo,
        nome_produto: nome_produto,
        nome_fornecedor: nome_fornecedor
    }, function(data) {
        $("#listar-produto").html(data);
    });
});