$(document).ready(function() {

    function parseFloatBRL(valor) {
        if (typeof valor !== 'string') return 0;
        return parseFloat(valor.replace('R$', '').replace(/\./g, '').replace(',', '.').trim());
    }

    function formatBRL(valor) {
        return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor);
    }

    // Nova função para formatar sem símbolo R$
    function formatarSemSimbolo(valor) {
        return valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function atualizarVisibilidadeHeader() {
        const tabela = $('#tabela-pagamentos-adicionados');
        const thead = tabela.find('thead');
        const numLinhas = tabela.find('tbody tr').length;

        if (numLinhas > 0) {
            thead.fadeIn('fast');
        } else {
            thead.fadeOut('fast');
        }
    }

    $.post(base_url + "pedido/buscarFormaPagamento", function(data) {
        let formas = JSON.parse(data);
        $.each(formas, function(i, item) {
            $("#forma-pagamento").append(
                $("<option>", {
                    value: item.id,
                    text: item.descricao
                })
            );
        });
    });

    $("#forma-pagamento").on("change", function() {
        let idForma = $(this).val();
        $("#instituicao").empty().append('<option value="">Carregando...</option>');
        if (idForma) {
            $.post(base_url + "pedido/buscarInstituicao/" + idForma, function(data) {
                let instituicoes = JSON.parse(data);
                $("#instituicao").empty().prop("disabled", false);
                $("#instituicao").append('<option value="">Selecione</option>');
                if (instituicoes.length > 0) {
                    $.each(instituicoes, function(i, inst) {
                        let descricao = inst.descricao;
                        if (inst.numero_parcelas && inst.numero_parcelas > 0) {
                            descricao += " - " + inst.numero_parcelas + "x";
                        }
                        $("#instituicao").append($("<option>", { value: inst.id, text: descricao }));
                    });
                } else {
                    $("#instituicao").append($("<option>", { value: "", text: "Nenhuma instituição disponível" }));
                }
            });
        } else {
            $("#instituicao").empty()
                .append('<option value="">Selecione</option>')
                .prop("disabled", true);
        }
    });

    function processarAdicaoPagamento() {
        const instituicaoId = $('#instituicao').val();
        const valorAdicionarStr = $('#receber-valor').val();
        
        if (!instituicaoId) {
            alert('Selecione a forma de pagamento e a instituição.');
            return;
        }

        const valorAdicionar = parseFloatBRL(valorAdicionarStr);
        if (isNaN(valorAdicionar) || valorAdicionar <= 0) {
            alert('Insira um valor válido.');
            return;
        }

        const valorAReceber = parseFloatBRL($('#a-receber').text());
        if (valorAdicionar > valorAReceber) {
            alert('O valor a adicionar não pode ser maior que o valor à receber.');
            return;
        }

        $.post(base_url + 'pedido/adicionar_pagamento', { instituicao_id: instituicaoId, valor: valorAdicionar }, function(response) {
            if (response.success) {
                const dados = response.data;
                const novaLinha = `
                    <tr data-valor="${dados.valor_total}">
                        <td>${dados.descricao_pagamento}</td>
                        <td>
                            ${dados.descricao}
                            <input type="hidden" name="instituicao[]" value="${instituicaoId}">
                            <input type="hidden" name="total_parcela[]" value="${dados.valor_total}">
                        </td>
                        <td>${dados.numero_parcelas}x</td>
                        <td>${formatBRL(dados.valor_parcela)}</td>
                        <td>${formatBRL(dados.valor_total)}</td>
                        <td><button type="button" name="remover" class="btn excluir"><img src="${base_url}assets/icons/excluir.svg" alt="Remover"></button></td>
                    </tr>
                `;
                $('#tabela-pagamentos-adicionados tbody').append(novaLinha);
        
                const novoValorAReceber = valorAReceber - valorAdicionar;
                $('#a-receber').text(formatarSemSimbolo(novoValorAReceber));

                $('#receber-valor').val('');
                $('#instituicao').val('');
                $('#forma-pagamento').val('').trigger('change');
        
                atualizarVisibilidadeHeader();

            } else {
                alert('Erro: ' + response.message);
            }
        }, 'json');
    }

    $('#adicionar-valor').on('click', function() {
        processarAdicaoPagamento();
    });

    $('#receber-valor').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            processarAdicaoPagamento();
        }
    });

    $('#pagamento-adicionado').on('click', '.excluir', function() {
        const linha = $(this).closest('tr');
        const valorLinha = parseFloat(linha.data('valor'));
        
        const valorAReceberAtual = parseFloatBRL($('#a-receber').text());
        const novoValorAReceber = valorAReceberAtual + valorLinha;

        $('#a-receber').text(formatarSemSimbolo(novoValorAReceber));
        
        linha.remove();
        atualizarVisibilidadeHeader();
    });

    const targetNode = document.getElementById('valor-total');
    if (targetNode) {
        const config = { characterData: true, childList: true, subtree: true };

        const callback = function(mutationsList, observer) {
            $('#tabela-pagamentos-adicionados tbody').empty();
            atualizarVisibilidadeHeader();

            const novoValorTotal = parseFloatBRL($('#valor-total').text());
            $('#a-receber').text(formatarSemSimbolo(novoValorTotal));
        };

        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
    }
});
