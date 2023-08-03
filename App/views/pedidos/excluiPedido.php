<?php

require_once '../../controllers/PedidoController.php';

if (isset($_GET['id'])) {
    $id_pedido = $_GET['id'];

    PedidoController::excluirPedido($id_pedido);
    header("Location: listaPedidos.php");
    exit;
}