<?php

namespace models;

class ItemPedido
{
    private $descricaoProduto;
    private $quantidade;

    /**
     * @param $descricaoProduto
     * @param $quantidade
     */
    public function __construct($descricaoProduto, $quantidade)
    {
        $this->descricaoProduto = $descricaoProduto;
        $this->quantidade = $quantidade;
    }

    /**
     * @return mixed
     */
    public function getDescricaoProduto()
    {
        return $this->descricaoProduto;
    }

    /**
     * @return mixed
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }


}