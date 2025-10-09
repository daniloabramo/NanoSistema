<colgroup>
<col style="width: 12%;"> <col style="width:10%;"> <col style="width: 12%;"> <col style="width: 15%;"> <col style="width: 17%;"> <col style="width: 12%;"> <col style="width: 11%;"> <col style="width: 11%;"></colgroup>
<tr class="head">
    <th>Data</th>
    <th>N° Pedido</th>
    <th>CPF / IE</th>
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
            <td><?= !empty($ped['cpf']) ? $ped['cpf'] : $ped['ie'] ?></td>
            <td><?= $ped['nome_completo'] ?></td>
            <td id="<?= $ped['id'] ?>"> <?= $ped['status_descricao'] ?></td>
            <td><button class="acao" name="imprimir" type="button" title="Imprimir" onclick="window.open('<?php echo base_url('Pedido/Detalhes_Pedido/' . urlencode(base64_encode($ped['id']))); ?>', '_blank')"><img src="<?php echo base_url('assets/icons/impressao.svg'); ?>" alt="Imprimir"></button></td>
            <td><button type="button" name="cancelar" class="btn-cancelar acao" data-id="<?= $ped['id'] ?>" data-acao="cancelar">
                    <?php if(strtolower($ped['status_descricao']) === 'cancelado'): ?>
            <img src="<?= base_url('assets/icons/ativar.svg'); ?>" alt="Ativar">
        <?php else: ?>
            <img src="<?= base_url('assets/icons/cancelar.svg'); ?>" alt="Cancelar">
        <?php endif; ?>
            </button></td>
            <td><button type="button" name="finalizar" title="Finalizar" class="btn-finalizar acao" data-id="<?= $ped['id'] ?>" data-acao="finalizar"><img src="<?php echo base_url('assets/icons/finalizar.svg'); ?>" alt="Finalizar"></button></button></td>
            </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7">Nenhum pedido encontrado.</td>
    </tr>
<?php endif; ?>
</tbody>

