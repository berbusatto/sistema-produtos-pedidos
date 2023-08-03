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
                <th>Cliente</th>
                <th>Data do Pedido</th>
                <th>Produtos</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
            </thead>

            <tbody>
            <?php

            $pedidoController = new PedidoController();
            $response = $pedidoController->listarPedidos();


            if (isset($response)) {
                foreach ($response as $pedido) {
                    echo "<tr>";
                    echo "<td>{$pedido->getId()}</td>";
                    echo "<td>{$pedido->getCliente()}</td>";
                    echo "<td>{$pedido->getDataPedido()}</td>";

                    echo "<td>";
                    echo "<table>";
                    foreach ($pedido->getItens() as $element) {
                        echo "<tr>";
                        echo "<td>{$element->getDescricaoProduto()}</td>";
                        echo "<td>{$element->getQuantidade()}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</td>";

                    echo "<td>{$pedido->getValorTotal()}</td>";

                    echo "<td>";
                    echo "<div class='d-flex flex-column'>";
                    echo "<a href='#' class='btn btn-danger btn-sm delete-pedido' data-id='{$pedido->getId()}' data-toggle='modal' data-target='#confirmDeleteModal'>Excluir</a>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-body">Tem certeza de que deseja excluir este pedido?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="#" class="btn btn-danger" id="confirmDeleteLink">Excluir</a>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#confirmDeleteModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const pedidoId = button.data('id');

                const confirmDeleteLink = $('#confirmDeleteLink');
                confirmDeleteLink.attr('href', 'excluiPedido.php?id=' + pedidoId);
            });
        });
    </script>
</body>
</html>
