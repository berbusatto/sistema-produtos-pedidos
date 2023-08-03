<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de cadastro de pedidos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <h1 class="mb-4">Cadastro de Pedidos</h1>

    <form id="formPedido" method="post" action="criaPedido.php">
        <!-- Lista de produtos do banco de dados -->
        <div class="table-responsive">
            <table class="table table-dark table-bordered">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Imagem</th>
                    <th>Valor de Venda</th>
                    <th>Estoque</th>
                    <th>Quantidade</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require_once '../../controllers/ProdutoController.php';

                $produtoController = new ProdutoController();
                $produtos = $produtoController->listarProdutos();

                $count = 0;
                if (!empty($produtos)) {
                    foreach ($produtos as $produto) {
                        $imagens = $produtoController->buscarImagensDoProduto($produto->getId());
                        $imagemBase64 = !empty($imagens) ? base64_encode($imagens[0]->getImagem()) : null;

                        echo "<tr>";
                        echo "<td>{$produto->getDescricao()}</td>";
                        echo "<td>";
                        if ($imagemBase64) {
                            echo "<img src='data:image/jpeg;base64,{$imagemBase64}' alt='Imagem do Produto' style='max-height: 100px; max-width: 100px;'>";
                        }
                        echo "</td>";
                        echo "<td data-valor-venda='{$produto->getValorVenda()}'>{$produto->getValorVenda()}</td>";
                        echo "<td>{$produto->getEstoque()}</td>";
                        echo "<td class='col-2'>";
                        echo "<div class='input-group'>";
                        echo "<input type='number' class='form-control quantidade' name='quantidades[{$count}]' min='0' max='{$produto->getEstoque()}' value='0'>";
                        echo "</div>";
                        echo "</td>";
                        echo "<input type='hidden' name='produtos_selecionados[]' value='{$produto->getId()}'>";
                        echo "</tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum produto encontrado no banco de dados.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Campos para email e valor total do pedido -->
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email para contato:</label>
            <div class="col-sm-4">
                <input type="email" class="form-control form-control-sm" id="email" name="email" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="valorTotal" class="col-sm-2 col-form-label">Valor Total do Pedido:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" id="valorTotal" name="valorTotal" value="0.00" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Criar Pedido</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantidadesInputs = document.querySelectorAll('.quantidade');
        quantidadesInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                alterarQuantidade(this);
            });
        });

        function alterarQuantidade(input) {
            const quantidade = parseInt(input.value);
            const estoque = parseInt(input.getAttribute('max'));
            if (isNaN(quantidade) || quantidade < 0) {
                input.value = 0;
            } else if (quantidade > estoque) {
                input.value = estoque;
            }
            atualizarValorTotal();
        }

        function atualizarValorTotal() {
            let valorTotal = 0;
            quantidadesInputs.forEach(function(input) {
                const quantidade = parseInt(input.value) || 0; // Defina como 0 se não for um número válido
                const valorVenda = parseFloat(input.closest('tr').querySelector('td[data-valor-venda]').getAttribute('data-valor-venda'));
                valorTotal += quantidade * valorVenda;
            });

            document.getElementById('valorTotal').value = valorTotal.toFixed(2);
        }
    });
</script>
</body>
</html>
