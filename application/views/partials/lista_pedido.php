<colgroup>
<col style="width: 10%;"> <col style="width:8%;"> <col style="width: 10%;"> <col style="width: 13%;"> <col style="width: 15%;"> <col style="width: 10%;"> <col style="width: 9%;"> <col style="width: 9%;"></colgroup>
<tr class="head">
    <th>Data</th>
    <th>N° Pedido</th>
    <th>CPF</th>
    <th>Nome do Cliente</th>
    <th>Status</th>
    <th>Imprimir</th>
    <th>Cancelar</th>
    <th>Finalizar</th>
</tr>
<tbody>
<?php if (!empty($pedido)): ?>
    <?php foreach($pedido as $ped): ?>
        <tr class="linha-pedido"> 
            <td><?= $ped['data_cadastro'] ?></td>
            <td><?= $ped['id'] ?></td>
            <td><?= $ped['cpf'] ?></td>
            <td><?= $ped['nome_completo'] ?></td>
            <td id="<?= $ped['id'] ?>"> <?= $ped['status_descricao'] ?></td>
            <td><button>Imprimir</button></td>
            <td><button type="button" class="btn-cancelar" data-id="<?= $ped['id'] ?>" data-acao="cancelar">Cancelar</button></td>
            <td><button type="button" class="btn-finalizar" data-id="<?= $ped['id'] ?>" data-acao="finalizar">Finalizar</button></td>
            </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7">Nenhum produto encontrado.</td>
    </tr>
<?php endif; ?>
</tbody>

