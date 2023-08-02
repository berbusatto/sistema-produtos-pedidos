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
        Produto::criaProduto($db->getConn(), $descricao, $valorVenda, $estoque, $imagens);
    }

    public static function atualizarProduto($id, $descricao, $valorVenda, $estoque)
    {
        $db = new Database();
        Produto::atualizaProduto($db->getConn(), $id, $descricao, $valorVenda, $estoque);
    }

    public static function excluiProduto($id_produto)
    {
        $db = new Database();
        Produto::excluiProduto($db->getConn(), $id_produto);
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

    public static function buscarImagensDoProduto($produtoID)
    {
        $db = new Database();
        return Imagem::buscarImagensDoProduto($db->getConn(), $produtoID);
    }

    public static function excluirImagem($imagemID)
    {
        $db = new Database();
        Imagem::excluirImagem($db->getConn(), $imagemID);
    }
}