<?php

use models\Pedido;

class PedidoController {
    private $pedidoModel;

    public function __construct($conexao)
    {
        $this->pedidoModel = new Pedido($conexao);
    }

    public function listarPedidos()
    {
        return $this->pedidoModel->listarPedidos();
    }

    public function cadastrarPedido($dataPedido, $valorTotal, $cliente, $produtos, $quantidades)
    {
        $this->pedidoModel->cadastrarPedido($dataPedido, $valorTotal, $cliente, $produtos, $quantidades);
    }

    public function excluirPedido($pedidoId)
    {
        $this->pedidoModel->excluirPedido($pedidoId);
    }

    public function buscarPedidoPorId($pedidoId)
    {
        return $this->pedidoModel->buscarPedidoPorId($pedidoId);
    }
}