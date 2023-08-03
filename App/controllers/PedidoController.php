<?php

use models\Pedido;

require_once 'C:\DEV\excellent_sistemas\App\Database.php';
require_once 'C:\DEV\excellent_sistemas\App\models\Pedido.php';

class PedidoController {


    public static function listarPedidos()
    {
        $db = new Database();
        return Pedido::listarPedidos($db->getConn());
    }

    public static function cadastrarPedido($dataPedido, $valorTotal, $cliente, $produtos, $quantidades)
    {
        $db = new Database();

        Pedido::cadastraPedido($db->getConn(), $dataPedido ,$valorTotal, $cliente, $produtos, $quantidades);
    }

    public static function excluirPedido($pedidoId)
    {
        $db = new Database();
        Pedido::excluiPedido($db->getConn(), $pedidoId);
    }

    public static function buscarPedidoPorId($pedidoId)
    {
        $db = new Database();
        return Pedido::buscarPedidoPorId($db->getconn(),$pedidoId);
    }
}