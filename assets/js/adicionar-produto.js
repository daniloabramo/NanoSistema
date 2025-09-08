$(document).ready(function() {

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
                $("#aguardando-produto").hide();
                $("#lista-produto-adicionado").append(newRow);
                atualizarTotalGeral();
            });
        }
    });

    $("#lista-produto-adicionado").on("click", ".remover", function() {
        $(this).closest("tr").remove();
        if ($('#lista-produto-adicionado tr').length === 0) {
            $("#aguardando-produto").show();
        }
        atualizarTotalGeral();
    });

    $('#lista-produto-adicionado').on('change input', '.qtd', function() {
        atualizarTotalGeral();
    });

});

function atualizarTotalGeral() {
    let total = 0;
    $('#lista-produto-adicionado tr').each(function() {
        let quantidade = parseInt($(this).find('.qtd').val()) || 0;
        let precoTexto = $(this).find('.val-unitario').text();
        let precoUnitario = parseFloat(precoTexto.replace('R$', '').replace(/\./g, '').replace(',', '.')) || 0;
        total += quantidade * precoUnitario;
    });
    const totalFormatado = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    $('#total-geral, #a-receber,#valor-total').text(totalFormatado);
}
