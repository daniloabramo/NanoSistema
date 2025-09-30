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
    <main>
        <h2>Pedido</h2>
        <form action="<?= base_url()?>Pedido/inserir_pedido" method="post">
            <div id="etapa1" class="etapa">
                <h3>Adicionar Produto</h3>
                <div class="div">
                    <section class="filtros"><button type="button" id="buscar-produto">Buscar Produtos</button></section>
                    <table id="listar-produto"></table>
                </div>
                <h2>Produtos Adicionados</h2>
                <div class="div teste">
                    <p id="aguardando-produto">Nenhum produto adicionado!</p>
                    <table>
                        <colgroup>
                        <col style="width: 8%;"> <col style="width: 28%;"> <col style="width: 5%;"> <col style="width: 10%;"> <col style="width: 10%;"> <col style="width: 10%;"> <col style="width: 9%;"> </colgroup>
                        <tr class="head">
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
            </div> <!--Fim da Etapa 1-->
            <div id="etapa2" class="etapa">
                <h2>Forma de Pagamento</h2>
                <div class="div">
                    <section class="filtros">
                        <label for="forma-pagamento">Forma de Pagamento</label>
                        <select name="forma-pagamento" id="forma-pagamento">
                            <option value="">Selecione</option>
                        </select>
                        
                        <label for="instituicao">Instituição</label>
                        <select name="instituicao" id="instituicao" >
                            <option value="">Aguardando forma de pagamento...</option>
                        </select>

                        <div class="info-valor">
                            <label for="a-receber">À receber</label>
                            <div class="horizontal">
                                <p id="a-receber">R$ 00,00</p>
                            </div>
                        </div>

                        <div class="info-valor">
                            <label for="adicionar-valor">Adicionar Valor </label>
                            <div class="horizontal">
                                <p>R$:</p>
                            <input type="text" id="adicionar-valor" name="adicionar-valor" placeholder="">
                            <button type="button">+</button>
                            </div>
                        </div>

                        </div>
                            <div class="info-valor">
                            <label for="valor-total">Valor Total</label>
                            <div class="horizontal">
                                <p id="valor-total" name="valor-total">R$00,00</p>
                            </div>
                        </div>
                    </section>

                </div>
                    <div id="pagamento-adicionado" class="pagamento-adicionado">
                    <table class="table table-striped" id="tabela-pagamentos-adicionados">
                        <thead style="display: none;">
                        <tr>
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
            </div> <!--Fim da Etapa 2-->
            <div id="etapa3" class="etapa">
                
            <select id="lista_cliente" data-url="<?php echo base_url('pedido/get_cliente'); ?>">
                <option value="0">Selecione</option>
            </select>
            <span id="hidden_container"></span>
                
                
                <section><button id="grava-pedido" type="submit">Gravar</button></section>
            </div> <!--Fim da Etapa 3-->
        </form>
    </main>
    <script> var base_url = "<?= base_url(); ?>"; </script>
    <script src="<?= base_url('assets/js/listar-produto.js') ?>"></script>
    <script src="<?= base_url('assets/js/adicionar-produto.js') ?>"></script>
    <script src="<?= base_url('assets/js/select-instituicao.js') ?>"></script>
    <script src="<?= base_url('assets/js/select-cliente.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/validacao-pedido.js'); ?>"></script>
</body>
</html>

