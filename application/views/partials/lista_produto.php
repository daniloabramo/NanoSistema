<?php if (!empty($produto)): ?>
    <?php foreach($produto as $prod): ?>
        <tr class="linha-produto"> 
            <td><?= $prod['codigo'] ?></td>
            <td>
            <?= $prod['produto_nome'] ?>
            <input type="hidden" class="produto-id" value="<?= $prod['id'] ?>">
            </td>
            <td><?= $prod['fornecedor_nome'] ?></td>
            <td><?= $prod['modelo_nome'] ?></td>
            <td><?= $prod['grupo_nome'] ?></td>
            <td><?= $prod['largura'].'x'.$prod['altura'].'x'.$prod['profundidade'] ?></td>
            <td><?= 'R$ ' . number_format($prod['custo_unitario'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7">Nenhum produto encontrado.</td>
    </tr>
<?php endif; ?>