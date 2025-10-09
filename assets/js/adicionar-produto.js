$(document).ready(function() {
    $("#head-produto-adicionado").hide();
    $(".total-geral").hide();

    $("#listar-produto").on("click", ".linha-produto", function() {
        let id = $(this).find(".produto-id").val();
        let addedProductRow = $('#lista-produto-adicionado tr[data-id="' + id + '"]');

        if (addedProductRow.length) {
            let qtyInput = addedProductRow.find('.qtd');
            let currentQty = parseInt(qtyInput.val());
            let maxStock = parseInt(qtyInput.attr('max'));
            
            if (currentQty < maxStock) {
                qtyInput.val(currentQty + 1);
                atualizarTotalGeral();
            } else {
                alert('Quantidade máxima em estoque atingida.');
            }
        } else {
            $.post(base_url + "pedido/adicionado", { ids: [id] }, function(newRow) {
                $("#lista-produto-adicionado").append(newRow);
                atualizarVisibilidadeCabecalho();
                atualizarTotalGeral();
            });
        }
    });

    $("#lista-produto-adicionado").on("click", ".remover", function() {
        $(this).closest("tr").remove();
        atualizarVisibilidadeCabecalho();
        atualizarTotalGeral();
    });

    $('#lista-produto-adicionado').on('change input', '.qtd', function() {
        atualizarTotalGeral();
    });
});

function atualizarVisibilidadeCabecalho() {
    let temProdutos = $('#lista-produto-adicionado tr').length > 0;
    $("#head-produto-adicionado").toggle(temProdutos);
    $("#aguardando-produto").toggle(!temProdutos);
    $(".total-geral").toggle(temProdutos);
}

function atualizarTotalGeral() {
    let total = 0;
    $('#lista-produto-adicionado tr').each(function() {
        let quantidade = parseInt($(this).find('.qtd').val()) || 0;
        let precoTexto = $(this).find('.val-unitario').text();
        let precoUnitario = parseFloat(precoTexto.replace('R$', '').replace(/\./g, '').replace(',', '.')) || 0;
        total += quantidade * precoUnitario;
    });
    const totalFormatado = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    $('#total-geral').text(totalFormatado);

    const totalSemSimbolo = total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    $('#a-receber, #valor-total').text(totalSemSimbolo);
}
