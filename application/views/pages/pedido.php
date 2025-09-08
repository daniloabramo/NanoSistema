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
        <form action="">
            <div id="etapa1" class="etapa">
                <h3>Adicionar Produto</h3>
                <div class="div">
                    <section class="filtros"><button type="button" id="buscar-produto">Buscar Produtos</button></section>
                    <table>
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
                    <tbody id="listar-produto">                    
                    <tr class="produto adicionarProduto">
                        <td>0986591</td>
                        <td>Sofá Atenas - Molas ensacadas - 2 Mod. 100 cm teste3</td>
                        <td>ALCOBA INDUSTRIA COMERCIO DE MOVEIS</td>
                        <td>ML.ENS - Linha B</td>
                        <td>ESTOFADOS</td>
                        <td>123X123X123</td>
                        <td>R$ 9.363,00</td>
                    </tr>
                    </tbody>
                    </table>
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
                        <tbody id="lista-produto-adicionado">
                            
                            <tr>
                                <td>0001</td>
                                <td><p>Sofá</p></td>
                                <td><input type="number" value="300" min="1"></td>
                                <td>120 X 50 X 3</td>
                                <td class="estoque com-estoque"> <p class="val-unitario">R$ 400,00</p><input type="text" value="236" disabled></td>
                                <td>44.000,00</td>
                                <td><button class="excluir"><img src="<?php echo base_url('assets/icons/excluir.svg'); ?>" alt="Seta"></button></td>
                            </tr>
                        </tbody>
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
                        <label for="">Forma de Pagamento</label>
                        <select name="forma-pagamento" id="forma-pagamento">
                            <option value="">Selecione</option>
                            <option value="2">Pix</option>
                        </select>
                        
                        <label for="">Instituição</label>
                        <select name="instituição" id="instituição">
                            <option value="">Selecione</option>
                            <option value="3">Mastercard</option>
                        </select>

                        <div class="info-valor">
                            <label for="a-receber">À receber</label>
                            <div class="horizontal">
                                <p id="a-receber">R$ 00,00</p>
                            <!--<input type="text" name="a-receber" placeholder="9.000,00" disabled>-->
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
                                <p id="valor-total">R$00,00</p>
                            <input type="text" name="valor-total" placeholder="9.000,00" disabled>
                            </div>
                        </div>
                    </section>

                    </div>
                    <table>
                        <colgroup>
                        <col style="width: 15;"> <col style="width: 15;"> <col style="width: 8;"> <col style="width: 15%;"> <col style="width: 10%;"> <col style="width: 15%;"> <col style="width: 15%;"> </colgroup> <col style="width: 7;">
                        <tr class="head">
                            <th>Forma de Pagamento</th>
                            <th>Instituição</th>
                            <th>Parcelas</th>
                            <th>Juros (% a.m)</th>
                            <th>Valor à Vista  </th>
                            <th>Valor Parcela c/ Juros</th>
                            <th>Valor Total c/ Juros</th>
                            <th></th>
                        </tr>
                        <tbody>
                            <tr class="line">
                                <td>Cartão de Crédito</td>
                                <td>Visa</td>
                                <td>4x</td>
                                <td>1,99%</td>
                                <td>R$ 8.000,00</td>
                                <td>R$ 2.072,50	</td>
                                <td>R$ 8.290,00</td>
                                <td>Excluir</td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
            </div> <!--Fim da Etapa 2-->
            <div id="etapa3" class="etapa">
                <select name="clientes" id="">
                    <option value="0">Selecione</option>
                    <option value="1">Cliente 1</option>
                    <option value="1">Cliente 2</option>
                    <option value="1">Cliente 3</option>
                </select>
                <section><button type="submit">Gravar</button></section>
            </div> <!--Fim da Etapa 3-->
        </form>
    </main>
    <script> var base_url = "<?= base_url(); ?>"; </script>
    <script src="<?= base_url('assets/js/listar-produto.js') ?>"></script>
    <script src="<?= base_url('assets/js/adicionar-produto.js') ?>"></script>
</body>
</html>