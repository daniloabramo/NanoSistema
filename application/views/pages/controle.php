<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style/style.css'); ?>">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js" integrity="sha256-C6CB9UYIS9UJeqinPHWTHVqh/E1uhG5Twh+Y5qFQmYg=" crossorigin="anonymous"></script>
    <title>Controle de Pedidos</title>
</head>
<body>
    <?php echo $menu; ?>
    <main>
        <h2>Controle de Pedidos</h2>
        <h3>Filtro de Busca</h3>
        <div class="div">
            <section class="filtros">
            <div class="filtro">
                <label for="id-pedido">Código:</label>
                <input type="text" id="id-pedido" placeholder="9999" name="codigo" class="form-control" style="width: 4rem; display: inline-block; margin-right: 10px;">
            </div>     
            
            <div class="filtro">
                <label for="cliente">Cliente</label>
                <input type="text" id="cliente" placeholder="Nome" name="nome" class="form-control" style="width: 4rem; display: inline-block; margin-right: 10px;">
            </div>   

            <div class="filtro">
                <label for="descricao-status">Status:</label>
                <select id="descricao-status" name="status" class="form-control">
                    <?php echo $select_status; ?>
                </select>
            </div>

            <div class="filtro-data">
                <div class="filtro">
                    <label for="data-inicio">Data Início:</label>
                    <input type="date" id="data-inicio" name="data">
                </div>
                <div class="filtro">
                    <label for="data-fim">Data Fim:</label>
                    <input type="date" id="data-fim" name="data">
                </div>
            </div>
            </section>
        </div>
        <button type="button" class="btn" id="buscar-pedido">Buscar Pedido</button>
        <div class="filtro">
            <section class="lista">
                <table id="listar-pedido"></table>
            </section>
        </div>    
    </main>   
    
    <script> var base_url = "<?= base_url(); ?>"; </script>
    <script src="<?= base_url('assets/js/modal.js') ?>"></script>
    <script src="<?= base_url('assets/js/listar-pedido.js') ?>"></script>
    <script src="<?= base_url('assets/js/pedido-status-atualizar.js') ?>"></script>
</body>
</html>