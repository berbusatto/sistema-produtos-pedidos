<?php
require_once '../../controllers/ProdutoController.php';



// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $_POST["descricao"];
    $valorVenda = $_POST["valorVenda"];
    $estoque = $_POST["estoque"];
    $id_produto = $_POST["id_produto"];

    $produto = ProdutoController::buscarProduto($id_produto);
    $imagensDoProduto = ProdutoController::buscarImagensDoProduto($id_produto);

    if (!$produto) {
        echo "Produto não encontrado.";
        exit();
    } else {
        echo "ID do produto não informado.";
    }

    // Atualiza os dados do produto
    ProdutoController::atualizarProduto($id_produto, $descricao, $valorVenda, $estoque);

    // Redireciona para a página de listagem após atualizar o produto
    header("Location: listaProdutos.php");
    exit();
}
