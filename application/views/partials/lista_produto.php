<tbody>
<colgroup>
<col style="width: 8%;"> <col style="width: 28%;"> <col style="width: 20%;"> <col style="width: 15%;"> <col style="width: 10%;"> <col style="width: 10%;"> <col style="width: 9%;"> </colgroup>
<tr class="head">
    <th>Cód.</th>
    <th>Descrição</th>
    <th>Fornecedor</th>
    <th>Modelo</th>
    <th>Grupo</th>
    <th>Medida</th>
    <th>Valor</th>
</tr>
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
</tbody>