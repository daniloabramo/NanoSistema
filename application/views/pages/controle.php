<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js" integrity="sha256-C6CB9UYIS9UJeqinPHWTHVqh/E1uhG5Twh+Y5qFQmYg=" crossorigin="anonymous"></script>
    <!--<link rel="stylesheet" href="/assets/style/style.css">-->

    <title>Controle de Pedidos</title>
</head>
<body>
    <h2>Controle de Pedidos</h2>
    <main>
        <div class="div">
            <section class="filtros">
            <select id="descricao-status" name="status" class="form-control">
                <?php echo $select_status; ?>
            </select>

            <input type="text" id="id-pedido" placeholder="Digite o código" class="form-control" style="width: 30; display: inline-block; margin-right: 10px;">

            <label for="data-inicio">Data Início:</label>
            <input type="date" id="data-inicio">

            <label for="data-fim">Data Fim:</label>
            <input type="date" id="data-fim">

            <button type="button" id="buscar-pedido">Buscar Pedido</button></section>
            <table id="listar-pedido">
            </table>
        </div>
    </main>
    <script> var base_url = "<?= base_url(); ?>"; </script>
    <script src="<?= base_url('assets/js/listar-pedido.js') ?>"></script>
    <script src="<?= base_url('assets/js/pedido-status-atualizar.js') ?>"></script>
    

    
</body>
</html>