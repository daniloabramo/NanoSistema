<option value="0"><?= isset($opcao_padrao) ? $opcao_padrao : 'Selecione' ?></option>
<?php foreach($dados as $item): ?>
    <option value="<?= $item[$valor_coluna] ?>"><?= $item[$exibir_coluna] ?></option>
<?php endforeach; ?>


