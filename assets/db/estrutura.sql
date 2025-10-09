SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE nanosistema;

USE nanosistema;

Create Table empresa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    codigo INT NOT NULL,
    cnpj VARCHAR (14) NOT NULL,
    razao_social VARCHAR (100) NOT NULL, 
    nome_fantasia VARCHAR (100),
    cep CHAR (8),
    logradouro VARCHAR (60),
    numero INT,
    complemento VARCHAR (20),
    bairro VARCHAR (60),
    municipio VARCHAR (60),
    uf CHAR (2),
    celular VARCHAR (11),
    email VARCHAR (120),
    logo VARCHAR (150)
);

Create Table cliente(
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    codigo INT NOT NULL,
    nome_completo VARCHAR (100) NOT NULL,
    cpf char (11),
    rg VARCHAR (10),
    ie CHAR (9),
    data_nascimento DATE,
    email VARCHAR (130) NOT NULL,
    celular CHAR (11) NOT NULL
);

Create Table forma_pagamento(
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    descricao VARCHAR (100) NOT NULL,
    tipo VARCHAR (7) NOT NULL
);

Create Table instituicao(
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    descricao VARCHAR (100) NOT NULL,
    numero_parcelas INT,
    forma_pagamento_id INT,
    FOREIGN KEY (forma_pagamento_id) REFERENCES forma_pagamento(id)
);

Create Table fornecedor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    codigo INT NOT NULL,
    descricao VARCHAR (100) NOT NULL
);

Create Table grupo(
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    descricao VARCHAR (30) NOT NULL
);

Create Table modelo(
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    descricao VARCHAR (50) NOT NULL
);

Create Table produto(
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    codigo INT NOT NULL,
    descricao VARCHAR (150) NOT NULL,
    altura INT,
    largura INT,
    profundidade int (11),
    preco_unitario DECIMAL (9, 2),
    estoque INT,
    fornecedor_id INT,
    modelo_id INT,
    grupo_id INT,
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedor(id),
    FOREIGN KEY (modelo_id) REFERENCES modelo(id),
    FOREIGN KEY (grupo_id) REFERENCES grupo(id)
);

CREATE TABLE pedido_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    descricao VARCHAR(30) NOT NULL
);

CREATE TABLE pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    valor_total DECIMAL(10,2) NOT NULL,
    pedido_status_id INT,
    empresa_id INT,
    cliente_id INT,
    FOREIGN KEY (pedido_status_id) REFERENCES pedido_status(id),
    FOREIGN KEY (empresa_id) REFERENCES empresa(id),
    FOREIGN KEY (cliente_id) REFERENCES cliente(id)
);

CREATE TABLE pedido_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    pedido_id INT,
    produto_id INT,
    FOREIGN KEY (pedido_id) REFERENCES pedido(id),
    FOREIGN KEY (produto_id) REFERENCES produto(id)
);

CREATE TABLE pedido_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    pedido_id INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    instituicao_id INT,
    FOREIGN KEY (pedido_id) REFERENCES pedido(id),
    FOREIGN KEY (instituicao_id) REFERENCES instituicao(id)
);

ALTER TABLE empresa AUTO_INCREMENT = 1;
ALTER TABLE cliente AUTO_INCREMENT = 1;
ALTER TABLE forma_pagamento AUTO_INCREMENT = 1;
ALTER TABLE fornecedor AUTO_INCREMENT = 1;
ALTER TABLE grupo AUTO_INCREMENT = 1;
ALTER TABLE instituicao AUTO_INCREMENT = 1;
ALTER TABLE modelo AUTO_INCREMENT = 1;
ALTER TABLE produto AUTO_INCREMENT = 1;
ALTER TABLE pedido_status AUTO_INCREMENT = 1;
ALTER TABLE pedido AUTO_INCREMENT = 1;
ALTER TABLE pedido_item AUTO_INCREMENT = 1;
ALTER TABLE pedido_pagamento AUTO_INCREMENT = 1;