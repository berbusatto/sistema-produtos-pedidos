<?php

namespace models;



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

    // No arquivo Produto.php

    public static function criaProduto($db, $descricao, $valor_venda, $estoque, $imagens = [])
    {
        $sql = "INSERT INTO produtos (descricao, valor_venda, estoque) VALUES (?, ?, ?)";
        $statement = $db->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $db->error);
        }
        $statement->bind_param("sdi", $descricao, $valor_venda, $estoque);

        if ($statement->execute()) {
            echo "Produto criado com sucesso.";
        } else {
            echo "Erro na criação do produto: " . $statement->error;
        }

        $statement->close();
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



    public  static function atualizaProduto($db, $id, $descricao, $valor_venda, $estoque)
    {

        $sql = "UPDATE produtos SET descricao = ?, valor_venda = ?, estoque = ? WHERE ID = ?";
        $statement = $db->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $db->error);
        }

        $statement->bind_param("sdii", $descricao, $valor_venda, $estoque, $id);

        if ($statement->execute()) {
            echo "Produto atualizado com sucesso.";
        } else {
            echo "Erro na atualização do produto: " . $statement->error;
        }

        $sql = "UPDATE imagens_produto SET produtoID = ?, imagem = ? WHERE ID = ?";

        $statement->close();

    }

    public static function excluiProduto($db, $id_produto)
    {

        $sql = "DELETE FROM produtos WHERE ID = ?";
        $statement = $db->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $db->error);
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