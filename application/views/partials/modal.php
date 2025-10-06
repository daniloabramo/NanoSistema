<div id="modal" class="modal-fundo">
  <div class="modal-overlay"></div> 
  <div class="modal-container">
    <div class="modal-alerta <?= isset($tipo) ? 'modal-' . htmlspecialchars($tipo) : '' ?>">
      <p id="texto-alerta"><?= isset($mensagem) ? htmlspecialchars($mensagem) : '' ?></p>
      <button class="modal-fechar" id="fechar-modal" aria-label="Fechar Modal">&times;</button>
    </div>
    <div class="modal-interacao">
      <button class="modal-ok" id="ok-btn">OK</button>
    </div>
  </div>
</div>
