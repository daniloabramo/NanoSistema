(function($){
    if (!$) { return; }

    function enviarAcao(id, acao) {
        var dados = {id, acao};

        $.ajax({
            url: base_url + "controle/atualizar_status",
            type: "POST",
            dataType: "json",
            data: dados,
            success: res => {
                $("#texto-alerta").text(res.msg);
                $("#modal").fadeIn();
                if (res.status === "sucesso") {
                    $("#status-" + id).text(res.novo_status || acao);
                }
            },
        });
    }

    $(document).on("click", ".btn-cancelar, .btn-finalizar", function(e){
        e.preventDefault();
        enviarAcao($(this).data("id"), $(this).data("acao"));
    });


})(window.jQuery);
