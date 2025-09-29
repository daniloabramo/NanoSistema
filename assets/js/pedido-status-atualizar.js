(function($){
    if (!$) { console.error('❌ jQuery não encontrado'); return; }

    function enviarAcao(id, acao) {
        console.log("📌 Capturado:", {id, acao});
        var dados = {id, acao};

        $.ajax({
            url: base_url + "controle/atualizar_status",
            type: "POST",
            dataType: "json",
            data: dados,
            beforeSend: () => console.log("⏳ Enviando...", dados),
            success: res => {
                console.log("✅ Resposta:", res);
                if (res.status === "ok") {
                    $("#status-" + id).text(res.novo_status || acao);
                    console.log("🔧 Status atualizado:", res.novo_status || acao);
                } else {
                    console.warn("⚠️ Erro:", res.msg);
                }
            },
            error: (xhr,s,e) => console.error("❌ AJAX erro:", s, e, xhr.responseText)
        });
    }

    $(document).on("click", ".btn-cancelar, .btn-finalizar", function(e){
        e.preventDefault();
        enviarAcao($(this).data("id"), $(this).data("acao"));
    });

    $(document).on("click", ".btn-imprimir", function(){
        console.log("🖨️ Imprimir pedido:", $(this).data("id"));
    });

})(window.jQuery);
