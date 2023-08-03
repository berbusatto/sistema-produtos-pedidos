<?php

require_once '../../controllers/ProdutoController.php';

if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];

    ProdutoController::excluiProduto($id_produto);
    header("Location: listaProdutos.php");
    exit;

}

