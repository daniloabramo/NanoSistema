<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js" integrity="sha256-C6CB9UYIS9UJeqinPHWTHVqh/E1uhG5Twh+Y5qFQmYg=" crossorigin="anonymous"></script>
    <title>Pedido</title>
</head>
<body>
    <?php echo $menu; ?>
    <main>
        <h2>Pedido</h2>
        <section class="abas">
            <h4><a href="#pedido" data-etapa="1">Gerar Pedido</a></h4> 
            <img src="<?php echo base_url('assets/icons/arrow.svg'); ?>" alt="Seta">
            <h4><a href="pagamento" data-etapa="2">Forma de Pagamento</a></h4> 
            <img src="<?php echo base_url('assets/icons/arrow.svg'); ?>" alt="Seta">
            <h4><a href="#cliente" data-etapa="3">Dados Cliente</a></h4> 
        </section>
        <form action="<?= base_url()?>Pedido/inserirPedido" method="post">
            <div id="etapa1" class="etapa">
                <h3>Adicionar Produto</h3>
        <div class="div" >
            <section class="filtros">
                <div class="filtro">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo-produto" placeholder="Digite o código" class="form-control" style="width: 30; display: inline-block; margin-right: 10px;">
                </div>
                <div class="filtro">
                    <label for="descricao">Descrição</label>
                    <input type="text" id="descricao-produto" name="descricao" placeholder="Digite a descrição" class="form-control" style="width: 50; display: inline-block; margin-right: 10px;">
                </div>
                <div class="filtro">
                    <label for="fornecedor">Fornecedor</label>
                    <select id="descricao-fornecedor" name="fornecedor" class="form-control">
                        <?php echo $select_fornecedor; ?>
                    </select>
                </div>
                <div class="bottom"><button type="button" class="btn" id="buscar-produto">Buscar Produtos</button></div>
            </section>
            <table id="listar-produto"></table>
        </div>
                <h3>Produtos Adicionados</h3>
                <div class="div teste">
                    <p id="aguardando-produto">Nenhum produto adicionado!</p>
                    <table>
                        <colgroup>
                        <col style="width: 8%;"> <col style="width: 28%;"> <col style="width: 5%;"> <col style="width: 10%;"> <col style="width: 10%;"> <col style="width: 10%;"> <col style="width: 9%;"> </colgroup>
                        <tr id="head-produto-adicionado" class="head">
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Qtd.</th>
                            <th>L x P x A</th>
                            <th>R$ Unit.</th>
                            <th>R$ Total</th>
                            <th>Remover</th>
                        </tr>
                        <tbody id="lista-produto-adicionado"></tbody>
                    </table>
                    <section class="total">
                        <div class="total-geral">
                            <h4>Total Geral</h4>
                            <p id="total-geral">R$ 00,00</p>
                        </div>
                    </section>
                </div>
                <section class="etapas">
                    <button class="btn" type="button" onclick="proximaEtapa(2)">Próximo</button>
                </section>
            </div> <!--Fim da Etapa 1-->
            <div id="etapa2" class="etapa">
                <h3>Forma de Pagamento</h3>
                <div class="div">
                    <section class="filtros pagamento">
                        <div class="container">
                            <div class="filtro">
                                <label for="forma-pagamento">Forma de Pagamento</label>
                                <select name="forma-pagamento" id="forma-pagamento">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                            
                            <div class="filtro">
                                <label for="instituicao">Instituição</label>
                                <select name="instituicao" id="instituicao" >
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                            <div class="info-valor">
                                <label for="adicionar-valor">Adicionar Valor </label>
                                <div class=" container">
                                    <p class="valor">R$</p>
                                    <input type="text" id="receber-valor" name="adicionar-valor" placeholder="">
                                    <button id="adicionar-valor"  type="button"><img src="<?php echo base_url('assets/icons/adicionar.svg'); ?>" alt="Adicionar Pagamento"></button>
                                </div>
                            </div>
                        </div>

                        <div class="valores">
                            <div class="info-valor">
                                <label for="a-receber">À receber</label>
                                <div class="container">
                                    <p class="valor">R$</p>
                                    <div class="valor-campo">
                                        <p id="a-receber">00,00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="info-valor">
                                <label for="valor-total">Valor Total</label>
                                <div class="container">
                                    <p class="valor">R$</p>
                                    <div class="valor-campo">
                                        <p id="valor-total" name="valor-total">00,00</p>
                                    </div>
                            </div>
                        </div>
                    </section>

                    <div id="pagamento-adicionado" class="pagamento-adicionado">
                    <table class="table" id="tabela-pagamentos-adicionados">
                        <thead style="display: none;">
                        <tr class="head">
                            <th>Forma Pagamento</th>
                            <th>Instituição</th>
                            <th>Qtd. Parcelas</th>
                            <th>Valor Parcela</th>
                            <th>Total</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                    <tbody></tbody>
                    </table>
                    </div>

                </div>
                    <section class="etapas">
                    <button class="btn" type="button" onclick="voltarEtapa(1)">Voltar</button>
                    <button class="btn" type="button" onclick="proximaEtapa(3)">Próximo</button>
                </section>
                </div> 
            </div> <!--Fim da Etapa 2-->
            <div id="etapa3" class="etapa"> 
            <h3>Cliente</h3>               
            <div class="div">
                <div class="filtros">
                    <div class="filtro">
                        <label for="cliente">Cliente:</label>
                        <select id="lista_cliente" data-url="<?php echo base_url('pedido/buscarCliente'); ?>">
                            <option value="0">Selecione</option>
                        </select>
                    </div>
                </div>
                <span id="hidden_container"></span>
            </div>
            <!--Fim da Etapa 3-->
        </form>
            <section class="etapas">
                <button class="btn" type="button" onclick="voltarEtapa(2)">Voltar</button>
                <button id="grava-pedido" class="btn" name="finalizar" type="submit">Gravar</button>
            </section> 
    </main>

    <script> var base_url = "<?= base_url(); ?>"; </script>
    <script src="<?= base_url('assets/js/listar-produto.js') ?>"></script>
    <script src="<?= base_url('assets/js/adicionar-produto.js') ?>"></script>
    <script src="<?= base_url('assets/js/etapa-pedido.js') ?>"></script>
    <script src="<?= base_url('assets/js/select-instituicao.js') ?>"></script>
    <script src="<?= base_url('assets/js/select-cliente.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/validacao-pedido.js'); ?>"></script>
</body>
</html>

