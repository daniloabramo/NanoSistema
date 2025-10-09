document.addEventListener("DOMContentLoaded", function () {
    let etapaAtual = 1;

    function mostrarEtapa(numero) {
        document.querySelectorAll('.etapa').forEach(div => div.style.display = 'none');
        const etapa = document.getElementById('etapa' + numero);
        if (etapa) etapa.style.display = 'block';

        document.querySelectorAll('.abas a').forEach(link => link.classList.remove('ativo'));
        document.querySelector('.abas a[data-etapa="' + numero + '"]')?.classList.add('ativo');

        etapaAtual = numero;
    }

    window.proximaEtapa = function () {
        if (etapaAtual < 3) mostrarEtapa(etapaAtual + 1);
    };
    window.voltarEtapa = function () {
        if (etapaAtual > 1) mostrarEtapa(etapaAtual - 1);
    };

    document.querySelectorAll('.abas a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const etapa = parseInt(this.getAttribute('data-etapa'));
            if (!isNaN(etapa)) {
                mostrarEtapa(etapa);
            }
        });
    });

    mostrarEtapa(1);
});