<?php
require_once '../../controllers/ProdutoController.php';

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $_POST["descricao"];
    $valorVenda = $_POST["valorVenda"];
    $estoque = $_POST["estoque"];

    // Verifica se foram enviadas imagens
    if (isset($_FILES["imagem"])) {
        $imagens = $_FILES["imagem"];

        $imagensBinarias = array();
        foreach ($imagens["tmp_name"] as $index => $tmp_name) {
            // Verifica se a imagem foi carregada com sucesso
            if (is_uploaded_file($tmp_name)) {
                // Lê o conteúdo da imagem em binário e adiciona ao array de imagens binárias
                $imagensBinarias[] = file_get_contents($tmp_name);
            }
        }

        // Cria o produto com as imagens
        ProdutoController::criarProduto($descricao, $valorVenda, $estoque, $imagensBinarias);

        // Redirecionar para a página de listagem após cadastrar o produto
        header("Location: listaProdutos.php");
        exit();
    }
}
