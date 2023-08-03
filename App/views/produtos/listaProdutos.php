<?php
    require_once '..\..\controllers\ProdutoController.php';
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Cadastro de Produtos</title>
        <!--  Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Jquery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    </head>
    <body class="bg-dark text-white">
        <div class="container mt-5">
            <h1 class="mb-4">Lista de Produtos</h1>

            <div><a href="cadastraProduto.php" class="btn btn-info btn-sm">Cadastrar Produto</a></div>
            <br>

            <table class="table table-bordered text-white">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Descrição</th>
                    <th>Valor de Venda</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>

                <?php
                    $produtoController = new ProdutoController();
                    $response = $produtoController->listarProdutos();

                if (isset($response)) {
                    foreach ($response as $element) {
                        echo "<tr>";
                        echo "<td>{$element->getId()}</td>";

                        // Exibir as imagens do produto
                        $imagens = ProdutoController::buscarImagensDoProduto($element->getId());

                        if (!empty($imagens)) {
                            echo "<td>";
                            foreach ($imagens as $imagem) {
                                $imagemBase64 = base64_encode($imagem->getImagem());
                                echo "<img src='data:image/jpeg;base64,{$imagemBase64}' alt='Imagem do Produto' style='max-height: 100px; max-width: 100px;'>";
                            }
                            echo "</td>";
                        } else {
                            echo "<td></td>";
                        }

                        echo "<td>{$element->getDescricao()}</td>";
                        echo "<td>{$element->getValorVenda()}</td>";
                        echo "<td>{$element->getEstoque()}</td>";
                        echo "<td>";
                        echo "<div class='d-flex flex-column'>";
                        echo "<a href='editaProduto.php?id={$element->getId()}' class='btn btn-primary btn-sm mb-2'>Editar</a>";
                        echo "<a href='#' class='btn btn-danger btn-sm delete-product' data-id='{$element->getId()}' data-toggle='modal' data-target='#confirmDeleteModal'>Excluir</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Modal de confirmação de exclusão -->
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
                        <p class="text-body">Tem certeza de que deseja excluir este produto?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <a href="#" class="btn btn-danger" id="confirmDeleteLink">Excluir</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // jquery para a exclusão do produto via modal
            $(document).ready(function() {
                $('#confirmDeleteModal').on('show.bs.modal', function (event) {
                    const button = $(event.relatedTarget);
                    const productId = button.data('id');

                    const confirmDeleteLink = $('#confirmDeleteLink');
                    confirmDeleteLink.attr('href', 'excluiProduto.php?id=' + productId);
                });
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
