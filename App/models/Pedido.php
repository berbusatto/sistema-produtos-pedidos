<?php

namespace models;

class Pedido
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function listarPedidos()
    {
        // Implemente o código para listar os pedidos do banco de dados
        $query = "SELECT * FROM pedidos";
        $result = mysqli_query($this->conexao, $query);
        $pedidos = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $pedidoId = $row['ID'];
            $itensPedido = $this->buscarItensPedidoPorId($pedidoId);
            $pedido = array(
                'id' => $pedidoId,
                'dataPedido' => $row['data_pedido'],
                'valorTotal' => $row['valor_total'],
                'cliente' => $row['cliente'],
                'itens' => $itensPedido
            );
            $pedidos[] = $pedido;
        }

        return $pedidos;
    }

    public function cadastrarPedido($dataPedido, $valorTotal, $cliente, $produtos, $quantidades)
    {
        // Implemente o código para cadastrar um novo pedido no banco de dados
        // Certifique-se de tratar as informações corretamente antes de inseri-las no banco

        // Primeiro, insira o pedido na tabela "pedidos"
        $query = "INSERT INTO pedidos (data_pedido, valor_total, cliente) VALUES ('$dataPedido', $valorTotal, '$cliente')";
        mysqli_query($this->conexao, $query);
        $pedidoId = mysqli_insert_id($this->conexao);

        // Em seguida, insira os itens do pedido na tabela "itens_pedido"
        for ($i = 0; $i < count($produtos); $i++) {
            $produtoId = $produtos[$i];
            $quantidade = $quantidades[$i];

            $query = "INSERT INTO itens_pedido (pedidoID, produtoID, quantidade) VALUES ($pedidoId, $produtoId, $quantidade)";
            mysqli_query($this->conexao, $query);
        }
    }

    public function excluirPedido($pedidoId)
    {
        // Implemente o código para excluir um pedido e seus itens associados do banco de dados

        // Primeiro, exclua os itens do pedido da tabela "itens_pedido"
        $query = "DELETE FROM itens_pedido WHERE pedidoID = $pedidoId";
        mysqli_query($this->conexao, $query);

        // Em seguida, exclua o pedido da tabela "pedidos"
        $query = "DELETE FROM pedidos WHERE ID = $pedidoId";
        mysqli_query($this->conexao, $query);
    }

    public function buscarItensPedidoPorId($pedidoId)
    {
        // Implemente o código para buscar os itens de um pedido específico pelo ID do pedido

        $query = "SELECT * FROM itens_pedido WHERE pedidoID = $pedidoId";
        $result = mysqli_query($this->conexao, $query);
        $itensPedido = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $itensPedido[] = $row;
        }

        return $itensPedido;
    }

    public function buscarPedidoPorId($pedidoId)
    {
        // Implemente o código para buscar um pedido específico pelo ID

        // Primeiro, busque os dados do pedido na tabela "pedidos"
        $query = "SELECT * FROM pedidos WHERE ID = $pedidoId";
        $result = mysqli_query($this->conexao, $query);
        $pedido = mysqli_fetch_assoc($result);

        if (!$pedido) {
            return null; // Retorna null se o pedido não for encontrado
        }

        // Em seguida, busque os itens associados ao pedido na tabela "itens_pedido"
        $itensPedido = $this->buscarItensPedidoPorId($pedidoId);

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