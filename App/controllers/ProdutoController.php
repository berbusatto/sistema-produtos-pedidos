<?php

use models\Imagem;
use models\Produto;
require_once 'C:\DEV\excellent_sistemas\App\models\Produto.php';
require_once 'C:\DEV\excellent_sistemas\App\Database.php';
require_once 'C:\DEV\excellent_sistemas\App\models\Imagem.php';


class ProdutoController
{
    public static function criarProduto($descricao, $valorVenda, $estoque, $imagens)
    {
        $db = new Database();
        $conn = $db->getConn();

        // Cria o produto no banco de dados
        Produto::criaProduto($conn, $descricao, $valorVenda, $estoque);

        // Obter o ID do produto recém-inserido
        $produtoID = $conn->insert_id;

        // Criar as imagens associadas ao produto
        foreach ($imagens as $imagem) {
            Imagem::criarImagem($conn, $produtoID, $imagem);
        }
    }

    public static function atualizarProduto($id, $descricao, $valorVenda, $estoque)
    {
        $db = new Database();
        $conn = $db->getConn();

        // Adiciona novas imagens, se o usuário enviou alguma
        if (isset($_FILES["imagem"])) {
            $novasImagens = $_FILES["imagem"];
            foreach ($novasImagens["tmp_name"] as $novaImagem) {
                $imgData = file_get_contents($novaImagem);
                Imagem::criarImagem($conn, $id, $imgData);
            }
        }

        // Atualiza os dados do produto
        Produto::atualizaProduto($conn, $id, $descricao, $valorVenda, $estoque);
    }


    public static function excluiProduto($id_produto)
    {
        $db = new Database();
        $conn = $db->getConn();

        // Primeiro, buscamos as imagens relacionadas ao produto
        $imagensDoProduto = ProdutoController::buscarImagensDoProduto($id_produto);

        // Em seguida, excluímos as imagens
        foreach ($imagensDoProduto as $imagem) {
            ProdutoController::excluirImagem($imagem->getImagemID());
        }

        // Agora podemos excluir o produto
        Produto::excluiProduto($conn, $id_produto);
    }

    public function listarProdutos()
    {
        $db = new Database();
        return Produto::listaProdutos($db->getConn());
    }

    public static function buscarProduto($id)
    {
        $db = new Database();
        return Produto::buscaProduto($db->getConn(), $id);
    }

    public static function criarImagem($produtoID, $imagem)
    {
        $db = new Database();
        Imagem::criarImagem($db->getConn(), $produtoID, $imagem);
    }

    public static function buscarImagensDoProduto($produtoID)
    {
        $db = new Database();
        return Imagem::buscarImagensDoProduto($db->getConn(), $produtoID);
    }

    public static function atualizarImagem($imagemID, $produtoID, $imagem)
    {
        $db = new Database();
        Imagem::atualizarImagem($db->getConn(), $imagemID, $produtoID, $imagem);
    }

    public static function excluirImagem($imagemID)
    {
        $db = new Database();
        Imagem::excluirImagem($db->getConn(), $imagemID);
    }


}