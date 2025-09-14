$(document).ready(function() {

    function parseFloatBRL(valor) {
        if (typeof valor !== 'string') return 0;
        return parseFloat(valor.replace('R$', '').replace(/\./g, '').replace(',', '.').trim());
    }

    function validarEstadoBotaoGravar() {
        const botaoGravar = $('#grava-pedido');
        
        const valorAReceber = parseFloatBRL($('#a-receber').text());
        const clienteId = $('#lista_cliente').val();
        const numPagamentos = $('#tabela-pagamentos-adicionados tbody tr').length;

        const valorReceberZerado = (valorAReceber === 0);
        const temPagamentos = (numPagamentos > 0);
        const clienteSelecionado = (clienteId !== null && parseInt(clienteId, 10) > 0);

        if (valorReceberZerado && temPagamentos && clienteSelecionado) {
            botaoGravar.prop('disabled', false);
        } else {
            botaoGravar.prop('disabled', true);
        }
    }

    $('#lista_cliente').on('change', function() {
        validarEstadoBotaoGravar();
    });

    const observerConfig = {
        childList: true,
        subtree: true,
        characterData: true
    };
    
    const aReceberNode = document.getElementById('a-receber');
    const tabelaPagamentosNode = document.querySelector('#tabela-pagamentos-adicionados tbody');
    
    const observerCallback = function() {
        validarEstadoBotaoGravar();
    };
    
    const observer = new MutationObserver(observerCallback);

    if (aReceberNode) {
        observer.observe(aReceberNode, observerConfig);
    }
    
    if (tabelaPagamentosNode) {
        observer.observe(tabelaPagamentosNode, { childList: true });
    }

    validarEstadoBotaoGravar();
});