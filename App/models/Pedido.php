<?php

namespace models;
require_once 'ItemPedido.php';



class Pedido
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDataPedido()
    {
        return $this->dataPedido;
    }

    /**
     * @return mixed
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @return mixed
     */
    public function getItens()
    {
        return $this->itens;
    }
    private $dataPedido;
    private $valorTotal;
    private $cliente;
    private $itens;

    /**
     * @param mixed $itens
     */
    public function setItens($itens)
    {
        $this->itens = $itens;
    }

    /**
     * @param $id
     * @param $dataPedido
     * @param $valorTotal
     * @param $cliente
     * @param $itens
     */
    public function __construct($id, $dataPedido, $valorTotal, $cliente, $itens)
    {
        $this->id = $id;
        $this->dataPedido = $dataPedido;
        $this->valorTotal = $valorTotal;
        $this->cliente = $cliente;
        $this->itens = $itens;
    }


    public static function listarPedidos($conn)
    {
        $query = "SELECT p.ID, pr.descricao, p.data_pedido, p.valor_total, p.cliente, ip.quantidade
            FROM pedidos AS p 
            JOIN itens_pedido AS ip 
            ON ip.pedidoID = p.ID
            JOIN produtos AS pr
            ON ip.produtoID = pr.ID";

        $result = mysqli_query($conn, $query);
        $pedidos = array();

        while ($row = mysqli_fetch_assoc($result)) {

            $pedidoId = $row['ID'];

            $pedidoArray = array_filter($pedidos, function($element) use ($pedidoId){
                return ($element->getId() == $pedidoId);
            });

            $pedido = current($pedidoArray);

            if(!$pedido){
                $pedido = new Pedido($pedidoId, $row['data_pedido'], $row['valor_total'], $row['cliente'], array());
                $pedidos[] = $pedido;
            }

            $itemPedido = new ItemPedido($row['descricao'],$row['quantidade']);
            $itensArray = $pedido->getItens();

            $itensArray[] = $itemPedido;
            $pedido->setItens($itensArray);

        }

        return $pedidos;
    }

    public static function cadastraPedido($conn, $dataPedido, $valorTotal, $cliente, $produtos, $quantidades)
    {

        $query = "INSERT INTO pedidos (data_pedido, valor_total, cliente) VALUES ('$dataPedido', $valorTotal, '$cliente')";
        mysqli_query($conn, $query);
        $pedidoId = mysqli_insert_id($conn);

        for ($i = 0; $i < count($produtos); $i++) {
            $produtoId = $produtos[$i];
            $quantidade = $quantidades[$i];
            if($quantidade == 0){
                continue;
            }

            $query = "INSERT INTO itens_pedido (pedidoID, produtoID, quantidade) VALUES ($pedidoId, $produtoId, $quantidade)";
            mysqli_query($conn, $query);
        }
    }

    public static function excluiPedido($conn, $pedidoId)
    {

       $query = "DELETE FROM itens_pedido WHERE pedidoID = $pedidoId";
       mysqli_query($conn, $query);

       $query = "DELETE FROM pedidos WHERE ID = $pedidoId";
       mysqli_query($conn, $query);
    }

    public static function buscarItensPedidoPorId($conn, $pedidoId)
    {

        $query = "SELECT * FROM itens_pedido WHERE pedidoID = $pedidoId";
        $result = mysqli_query($conn, $query);
        $itensPedido = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $itensPedido[] = $row;
        }

        return $itensPedido;
    }

    public static function buscarPedidoPorId($conn,$pedidoId)
    {



        $query = "SELECT * FROM pedidos WHERE ID = $pedidoId";
        $result = mysqli_query($conn, $query);
        $pedido = mysqli_fetch_assoc($result);

        if (!$pedido) {
            return null;
        }


        $itensPedido = Pedido::buscarItensPedidoPorId($conn, $pedidoId);

        $pedidoObj = array(
            'id' => $pedidoId,
            'dataPedido' => $pedido['data_pedido'],
            'valorTotal' => $pedido['valor_total'],
            'cliente' => $pedido['cliente'],
            'itens' => $itensPedido
        );

        return $pedidoObj;
    }
}