<?php
require_once '..\..\controllers\PedidoController.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <!--  Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Pedidos</h1>
        <div><a href="cadastraPedido.php" class="btn btn-info btn-sm">Cadastrar Pedido</a></div>
        <br>

        <table class="table table-bordered text-white">
            <thead>
            <tr>
                <th>ID</th>
                <th>Produtos</th>
                <th>Quantidade</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Data do Pedido</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>

            <?php
                $pedidoController = new PedidoController();

            ?>

<!--            Aqui você pode adicionar os dados dinamicamente com PHP -->
<!--            <tr>-->
<!--                <td>1</td>-->
<!--                <td>Produto A, Produto B</td>-->
<!--                <td>2, 3</td>-->
<!--                <td>Cliente 1</td>-->
<!--                <td>R$ 250,00</td>-->
<!--                <td>2023-08-01</td>-->
<!--                <td>-->
<!--                    <div class='d-flex flex-column'>-->
<!--                        <a href='#' class='btn btn-danger btn-sm'>Cancelar</a>-->
<!--                    </div>-->
<!--                </td>-->
<!--            </tr>-->

            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS (Optional for Bootstrap components functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
