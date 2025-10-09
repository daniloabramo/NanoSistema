(function($){
    if (!$) { return; }

    var requisicaoAtual = null; 

    function enviarAcao(id, acao) {
        var dados = {id, acao};

        if (requisicaoAtual && requisicaoAtual.abort) {
            requisicaoAtual.abort();
        }

        requisicaoAtual = $.ajax({
            url: base_url + "controle/atualizar_status",
            type: "POST",
            dataType: "json",
            data: dados,
            success: res => {
                $("#texto-alerta").text(res.msg);
                $("#modal").fadeIn();
                if (res.status === "sucesso") {
                    $("#listar-pedido").load(base_url + "controle/listar");
                }
            },
            error: (jqXHR, textStatus) => {
                if (textStatus !== 'abort') {
                    console.error("Erro na requisição:", textStatus);
                }
            },
            complete: () => {
                limparRequisicao();
            }
        });
    }

    function limparRequisicao() {
        if (requisicaoAtual) {
            requisicaoAtual.onreadystatechange = null;
            requisicaoAtual.abort = null;
            requisicaoAtual = null;
        }
    }

    $(document).on("click", ".btn-cancelar, .btn-finalizar", function(e){
        e.preventDefault();
        enviarAcao($(this).data("id"), $(this).data("acao"));
    });

    $(window).on('beforeunload', () => {
        limparRequisicao();
    });

})(window.jQuery);
