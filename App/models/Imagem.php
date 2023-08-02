<?php

namespace models;
class Imagem
{
    private $imagemID;
    private $produtoID;
    private $imagem;

    public static function criarImagem($db, $produtoID, $imagem)
    {
        $sql = "INSERT INTO imagens_produto (produtoID, imagem) VALUES (?, ?)";
        $statement = $db->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $db->error);
        }

        $statement->bind_param("is", $produtoID, $imagem);

        if ($statement->execute()) {
            echo "Imagem criada com sucesso.";
        } else {
            echo "Erro na criação da imagem: " . $statement->error;
        }

        $statement->close();
    }

    // Método para buscar todas as imagens de um produto pelo ID do produto
    public static function buscarImagensDoProduto($db, $produtoID)
    {
        $sql = "SELECT ID, produtoID, imagem FROM imagens_produto WHERE produtoID = ?";
        $statement = $db->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $db->error);
        }

        $statement->bind_param("i", $produtoID);
        $statement->execute();
        $result = $statement->get_result();

        $imagens = array();
        while ($row = $result->fetch_assoc()) {
            $imagens[] = new Imagem($row['ID'], $row['produtoID'], $row['imagem']);
        }

        return $imagens;
    }


    // Método para atualizar uma imagem específica de um produto
    public static function atualizarImagem($db, $imagemID, $produtoID, $imagem)
    {
        $sql = "UPDATE imagens_produto SET produtoID = ?, imagem = ? WHERE produtoID = ?";
        $statement = $db->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $db->error);
        }

        $statement->bind_param("ibi", $produtoID, $imagem, $imagemID);

        if ($statement->execute()) {
            echo "Imagem atualizada com sucesso.";
        } else {
            echo "Erro na atualização da imagem: " . $statement->error;
        }

        $statement->close();
    }

    // Método para excluir uma imagem específica de um produto
    public static function excluirImagem($db, $imagemID)
    {
        $sql = "DELETE FROM imagens_produto WHERE ID = ?";
        $statement = $db->prepare($sql);

        if (!$statement) {
            die('Erro no SQL: ' . $db->error);
        }

        $statement->bind_param("i", $imagemID);

        if ($statement->execute()) {
            echo "Imagem excluída com sucesso.";
        } else {
            echo "Erro ao excluir imagem: " . $statement->error;
        }

        $statement->close();
    }

    /**
     * @return mixed
     */
    public function getImagemID()
    {
        return $this->imagemID;
    }

    /**
     * @param mixed $imagemID
     */
    public function setImagemID($imagemID)
    {
        $this->imagemID = $imagemID;
    }

    /**
     * @return mixed
     */
    public function getProdutoID()
    {
        return $this->produtoID;
    }

    /**
     * @param mixed $produtoID
     */
    public function setProdutoID($produtoID)
    {
        $this->produtoID = $produtoID;
    }

    /**
     * @return mixed
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * @param mixed $imagem
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }


    /**
     * @param $imagemID
     * @param $produtoID
     * @param $imagem
     */
    public function __construct($imagemID, $produtoID, $imagem)
    {
        $this->imagemID = $imagemID;
        $this->produtoID = $produtoID;
        $this->imagem = $imagem;
    }


}