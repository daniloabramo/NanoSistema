<?php if (!empty($produto)): ?>
    <?php foreach($produto as $prod): ?>
        <tr data-id="<?= $prod['id'] ?>">
            <td><?= str_pad($prod['codigo'], 4, '0', STR_PAD_LEFT) ?>
                <input type="hidden" name="produtos[<?= $prod['id'] ?>][id]" value="<?= $prod['id'] ?>"></td>
            <td><?= $prod['produto_nome'] ?></td>
            <td><input type="number" class="qtd" name="produtos[<?= $prod['id'] ?>][quantidade]" value="1" min="1" max="<?= $prod['estoque'] ?>"></td>
            <td><?= $prod['largura'].' X '.$prod['profundidade'].' X '.$prod['altura'] ?></td>
            <td class="val-unitario"><?= 'R$ ' . number_format($prod['preco_unitario'], 2, ',', '.') ?>
                <input type="text" name="estoque" class="estoque" value="<?= $prod['estoque'] ?>" disabled></td>
            <td class="val-total"><?= 'R$ ' . number_format($prod['preco_unitario'], 2, ',', '.') ?></td>
            <td><button class="remover btn" name="remover" type="button">
                <img src="<?php echo base_url('assets/icons/excluir.svg'); ?>" alt="Remover"></button></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="7" style="text-align: center;">Nenhum produto selecionado.</td></tr>
<?php endif; ?>


