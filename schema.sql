CREATE TABLE produtos (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255),
    valor_venda DECIMAL(10, 2),
    estoque INT(11)
);


CREATE TABLE imagens_produto (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    produtoID INT,
    imagem MEDIUMBLOB,
    FOREIGN KEY (produtoID) REFERENCES produtos(ID)
);


CREATE TABLE pedidos (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    data_pedido DATE,
    valor_total DECIMAL(10, 2),
    cliente VARCHAR(255)
);


CREATE TABLE itens_pedido (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    pedidoID INT,
    produtoID INT,
    quantidade INT(11),
    FOREIGN KEY (pedidoID) REFERENCES pedidos(ID),
    FOREIGN KEY (produtoID) REFERENCES produtos(ID)
);



