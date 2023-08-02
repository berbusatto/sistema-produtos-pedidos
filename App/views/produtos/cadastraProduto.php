<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de cadastro de produtos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <h1 class="mb-4">Cadastro de Produtos</h1>

    <form method="post" action="criaProduto.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao" required>
        </div>

        <div class="form-group">
            <label for="valorVenda" class="form-label">Valor de Venda:</label>
            <input type="number" class="form-control" id="valorVenda" name="valorVenda" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="estoque" class="form-label">Estoque:</label>
            <input type="number" class="form-control" id="estoque" name="estoque" required>
        </div>

        <div class="form-group">
            <label class="form-label">Imagens:</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="imagem" name="imagem[]" multiple>
                <label class="custom-file-label" for="imagem">Escolher arquivo</label>
            </div>
        </div>

        <!-- Lista de miniaturas -->
        <div id="miniaturasCaixa" class="mt-3 border p-3" style="display: none;">
            <h5>Imagens Carregadas:</h5>
            <ul id="miniaturas" class="list-unstyled"></ul>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cadastrar Produto</button>
    </form>
</div>



<!--  Colocar em um asset se der tempo -->
<script>
    document.getElementById('imagem').addEventListener('change', function() {
        const miniaturasCaixa = document.getElementById('miniaturasCaixa');
        const miniaturasList = document.querySelector('#miniaturas');

        const existingMiniaturas = document.querySelectorAll('.miniatura');
        existingMiniaturas.forEach(miniatura => {
            miniaturasList.appendChild(miniatura);
        });

        const files = this.files;
        if (files.length > 0) {
            miniaturasCaixa.style.display = 'block'; // Exibir a caixa de miniaturas
        } else {
            miniaturasCaixa.style.display = 'none'; // Ocultar a caixa de miniaturas
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(event) {
                const listItem = document.createElement('li');
                listItem.classList.add('d-flex', 'align-items-center', 'mb-3', 'miniatura');

                const img = document.createElement('img');
                img.src = event.target.result;
                img.alt = file.name;
                img.classList.add('img-thumbnail', 'mr-3');
                img.style.width = '64px'; // Definir o tamanho da miniatura

                const fileName = document.createElement('span');
                fileName.textContent = file.name;

                listItem.appendChild(img);
                listItem.appendChild(fileName);
                miniaturasList.appendChild(listItem);
            }

            reader.readAsDataURL(file);
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
