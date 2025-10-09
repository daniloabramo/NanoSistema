<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style/impressao.css'); ?>">
    <title>Impressão</title>
</head>
<body>
    <main>
    <section class="dados-pedido separacao">
        <div class="informacoes">
            <h4>Obrigado Pela Preferência</h4>
            <h6>Pedido: Nº <?= $pedido['pedido_id'] ?></h6>
        </div>
        <div class="logo"><img src="<?php echo base_url($pedido['logo']); ?>" alt="logo expresso"></div>
    </section>
    <section class="dados-cliente separacao">
        <h6>Dados do Cliente</h6>
        <div class="horizontal">
            <p>Nome: <?= $pedido['nome_completo'] ?></p>
            <p>CPF/IE: <?= !empty($pedido['cpf']) ? $pedido['cpf'] : $pedido['ie'] ?></p>
        </div>
        <div class="horizontal">
            <p>Email: <?= $pedido['email'] ?></p>
            <p>Celular: <?= $pedido['celular'] ?></p>
        </div>
    </section>
    <section class="descricao-pedido separacao ">
        <table>
            <colgroup>
            <col style="width: 8%;"> <col style="width: 32%;"> <col style="width: 15%;"> <col style="width: 15%;"> <col style="width: 10%;"><col style="width: 20%;"></colgroup>
            <tr class="head">
                <th>Cód.</th>
                <th>Descriçao</th>
                <th>Medidas</th>
                <th>Preço</th>
                <th>Qtd</th>
                <th>Total</th>
            </tr>
            
            <?php if (!empty($item)): ?>
                <?php foreach($item as $ped): ?>
                <tr>
                <td><?= str_pad($ped['codigo'], 4, '0', STR_PAD_LEFT) ?></td>
                <td><?= $ped['produto_nome'] ?></td>
                <td><?= $ped['largura'].' x '.$ped['altura'].' x '.$ped['profundidade'] ?></td>
                <td><?= 'R$ ' . number_format($ped['preco_unitario'], 2, ',', '.') ?></td>
                <td><?= str_pad($ped['quantidade'], 2, '0', STR_PAD_LEFT) ?></td>
                <td><?= 'R$ ' . number_format ($ped['quantidade'] * $ped['preco_unitario'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

    </section>

    <section class="metodo-de-pagamento-pedido separacao">
        <h6>Total Pedido</h6>
        <table>
            <colgroup>
            <col style="width: 40;"> <col style="width: 20%;"> <col style="width: 20%;"> <col style="width: 20%;"></colgroup>
            <tr class="head">
                <th>Método de Pagamento</th>
                <th>Qtd. Parc.</th>
                <th>Valor da Parcela</th>
                <th>Total</th>
            </tr>

            <?php if (!empty($pagamento)): ?>
                <?php foreach($pagamento as $ped): ?>
                <tr>
                <td><?= $ped['forma_pagamento_descricao'] .' / '. $ped['instituicao_descricao']  ?></td>
                <td><?= str_pad($ped['numero_parcelas'], 2, '0', STR_PAD_LEFT) ?></td>
                <td><?= 'R$ '. number_format( $ped['valor'] / $ped['numero_parcelas'], 2, ',', '.') ?></td>
                <td><?= 'R$ '. number_format( $ped['valor'], 2, ',', '.') ?></td>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td class="sem-borda"></td>
                <td class="sem-borda"></td>
                <td class="sem-borda"></td>
                <td class="valor-total"><?= 'R$ '. $pedido['valor_total'] ?></td>
            </tr>
        </table>
    </section>    

    <section class="dados-empresa separacao">
        <h6>Dados da Empresa</h6>
        <div class="horizontal">
            <p>Nome: <?= $pedido['nome_fantasia'] ?></p>
            <p>CNPJ: <?= $pedido['cnpj'] ?></p>
        </div>
        <div class="horizontal">
            <p>Telefone: <?= $pedido['empresa_celular'] ?></p>
            <p>Email: <?= $pedido['empresa_email'] ?></p>
        </div>
    </section>

    <div class="imprimir">
        <button type="button" onclick="window.print()">
            <img src="<?php echo base_url('assets/icons/impressora.svg'); ?>" alt="Imprimir">
            <p>Imprimir</p>
        </button>
    </div>

    <style>
        @media print {
            .imprimir {
                display: none ;
            }
            main{
                border: none;
                box-shadow: none;
            }

            img{
                image-rendering: pixelated;
            }

        }
    </style>