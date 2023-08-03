<?php
require_once '../../controllers/PedidoController.php';
date_default_timezone_set('America/Sao_Paulo');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produtos = $_POST["produtos_selecionados"];
    $dataPedido = date('Y-m-d H:i');
    $valorTotal = $_POST["valorTotal"];
    $emailCliente = $_POST["email"];
    $quantidades = $_POST["quantidades"];

    var_dump($quantidades);

    PedidoController::cadastrarPedido($dataPedido, $valorTotal, $emailCliente, $produtos, $quantidades);

    header("Location: listaPedidos.php");
    exit();

}
