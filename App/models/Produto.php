<?php

namespace models;



use Database;
use ProdutoController;

class Produto
{
    private $id;
    private $descricao;
    private $valorVenda;
    private $estoque;
    private $imagem;

    public function __construct($id, $descricao, $valorVenda, $estoque)
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->valorVenda = $valorVenda;
        $this->estoque = $estoque;
    }

    public static function listaProdutos($db){
        $sql = "SELECT ID, descricao, valor_venda, estoque FROM produtos";
        $result = $db->query($sql);

        $products = array();

        while ($row = $result->fetch_assoc()) {
            $products[] = new Produto($row['ID'],$row['descricao'], $row['valor_venda'], $row['estoque']);
        }

        return $products;
    }

    public static function criaProduto($conn, $descricao, $valor_venda, $estoque, $imagens = [])
    {
        $sql = "INSERT INTO produtos (descricao, valor_venda, estoque) VALUES (?, ?, ?)";
        $statement = $conn->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $conn->error);
        }
        $statement->bind_param("sdi", $descricao, $valor_venda, $estoque);

        if ($statement->execute()) {
            echo "Produto criado com sucesso.";
        } else {
            echo "Erro na criação do produto: " . $statement->error;
        }
        $statement->close();

        $produtoID = $conn->insert_id;

        foreach ($imagens as $imagem) {
            Imagem::criarImagem($conn, $produtoID, $imagem);
        }


    }



    // Dentro da classe models\Produto
    public static function buscaProduto($conn, $id)
    {
        $sql = "SELECT ID, descricao, valor_venda, estoque FROM produtos WHERE ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $produtoData = $result->fetch_assoc();

        if ($produtoData) {
            $produto = new Produto(
                $produtoData['ID'],
                $produtoData['descricao'],
                $produtoData['valor_venda'],
                $produtoData['estoque']
            );

            return $produto;
        } else {
            return null;
        }
    }



    public  static function atualizaProduto($conn, $id, $descricao, $valor_venda, $estoque)
    {

        $sql = "UPDATE produtos SET descricao = ?, valor_venda = ?, estoque = ? WHERE ID = ?";
        $statement = $conn->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $conn->error);
        }

        $statement->bind_param("sdii", $descricao, $valor_venda, $estoque, $id);

        if ($statement->execute()) {
            echo "Produto atualizado com sucesso.";
        } else {
            echo "Erro na atualização do produto: " . $statement->error;
        }

        if (isset($_FILES["imagem"])) {
            $novasImagens = $_FILES["imagem"];
            foreach ($novasImagens["tmp_name"] as $novaImagem) {
                $imgData = file_get_contents($novaImagem);
                Imagem::criarImagem($conn, $id, $imgData);
            }
        }
        $statement->close();

    }

    public static function excluiProduto($conn, $id_produto)
    {
        $imagensDoProduto = ProdutoController::buscarImagensDoProduto($id_produto);

        foreach ($imagensDoProduto as $imagem) {
            ProdutoController::excluirImagem($imagem->getImagemID());
        }

        $sql = "DELETE FROM produtos WHERE ID = ?";
        $statement = $conn->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $conn->error);
        }

        $statement->bind_param("i", $id_produto);

        if ($statement->execute()) {
            echo "Produto excluído com sucesso.";
        } else {
            echo "Erro ao excluir produto: " . $statement->error;
        }

        $statement->close();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getValorVenda()
    {
        return $this->valorVenda;
    }


    public function setValorVenda($valorVenda)
    {
        $this->valorVenda = $valorVenda;
    }

    public function getEstoque()
    {
        return $this->estoque;
    }

    public function setEstoque($estoque)
    {
        $this->estoque = $estoque;
    }

    public function getImagem()
    {
        return $this->imagem;
    }


    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }


}