(function($) {
    if (!$) {
        return;
    }

    function enviarAcao(id, acao) {
        var dados = {id, acao};

        $.ajax({
            url: base_url + "controle/atualizarStatus",
            type: "POST",
            dataType: "json",
            data: dados,
            success: function(res) {
                $("#texto-alerta").text(res.msg);
                $(".modal-alerta").removeClass("modal-ok modal-info modal-erro").addClass("modal-" + res.status);
                $("#modal").css("display", "flex");

                if (res.status === "erro") {
                    $(".modal-container")
                        .removeClass("bounce-in")
                        .addClass("shake")
                        .one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
                        $(this).removeClass("shake");
                    });
                }   

                if (res.status === "ok") {
                    $("#status-" + id).text(res.novo_status || acao);
                }
            },
        });
    }

    $(document).on("click", ".btn-cancelar, .btn-finalizar", function(e){
        e.preventDefault();
        enviarAcao($(this).data("id"), $(this).data("acao"));
    });

    $(document).ready(function() {
        const modal = document.getElementById('modal');
        const fecharBtn = document.getElementById('fechar-modal');
        const okBtn = document.getElementById('ok-btn');

        if(fecharBtn) {
            fecharBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }
        if(okBtn) {
            okBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }
        if(modal) {
            modal.addEventListener('click', (event) => {
                if (event.target === modal || event.target.classList.contains('modal-overlay')) {
                    modal.style.display = 'none';
                }
            });
        }
    });
})(window.jQuery);
