USE nanosistema;

INSERT INTO grupo (descricao) VALUES
('Sala de Estar'),
('Sala de Jantar'),
('Quarto'),
('Escritório');

INSERT INTO modelo (descricao) VALUES
('Rústico'),
('Moderno'),
('Minimalista'),
('Clássico');

INSERT INTO cliente (codigo, nome_completo, cpf, rg, ie, data_nascimento, email, celular) VALUES
(1, 'Carlos Alberto Nunes', '12345678901', 'MG1234567', '', '1985-04-15', 'carlos.nunes@email.com', '31987654321'),
(2, 'Fernanda Souza Lima', '98765432100', 'SP9876543', '', '1992-09-22', 'fernanda.lima@email.com', '11996547890'),
(3, 'Ricardo Mendes Silva', '', '', '456789123', '1988-12-01', 'ricardo.silva@email.com', '21987451236'),
(4, 'Juliana Pereira Santos', '', '', '321654987', '1995-06-10', 'juliana.santos@email.com', '71996547812');

INSERT INTO empresa (codigo, cnpj, razao_social, nome_fantasia, cep, logradouro, numero, complemento, bairro, municipio, uf, celular, email, logo) VALUES
(1, '09376309000155', 'Expresso', 'Expresso', '05047000', 'Rua Coriolano', 864, 'Prédio', 'Vila Romana', 'São Paulo', 'SP', '1127784510', 'expresso@email.com', 'assets/img/logo-empresa.png');

INSERT INTO fornecedor (codigo, descricao) VALUES
(1, 'Criativa Estofados'),
(2, 'Casa 7'),
(3, 'Decora'),
(4, 'Agile');

INSERT INTO produto (codigo, descricao, altura, largura, profundidade, preco_unitario, estoque, fornecedor_id, modelo_id, grupo_id) VALUES
(1, 'Sofá 3 lugares Veludo Azul', 90, 210, 90, 2899.90, 999, 1, 2, 1),
(2, 'Poltrona Giratória Couro Marrom', 100, 80, 85, 1599.00, 999, 1, 4, 1),
(3, 'Mesa de Centro Madeira Maciça', 45, 110, 60, 749.50, 999, 2, 1, 1),
(4, 'Estante para TV até 60 Polegadas', 180, 200, 40, 1299.00, 999, 2, 3, 1),
(5, 'Mesa de Jantar 6 Lugares Vidro Temperado', 78, 180, 90, 2599.00, 999, 3, 2, 2),
(6, 'Cadeira Estofada Bege', 95, 50, 55, 399.90, 999, 3, 2, 2),
(7, 'Cama Queen Madeira Rústica', 120, 160, 210, 3499.00, 999, 4, 1, 3),
(8, 'Guarda-Roupa 6 Portas Branco Fosco', 240, 220, 60, 4299.00, 999, 4, 3, 3),
(9, 'Armário 2 Gavetas Amêndoa', 60, 45, 40, 499.90, 999, 2, 1, 3),
(10, 'Escrivaninha Compacta Carvalho', 75, 120, 55, 899.00, 999, 1, 3, 4),
(11, 'Cadeira de Escritório Ergonômica', 110, 70, 70, 1299.00, 999, 2, 2, 4),
(12, 'Estante para Livros Modular', 190, 100, 35, 999.50, 999, 3, 3, 4);

INSERT INTO forma_pagamento (descricao, tipo) VALUES
('Cartão de Crédito', 'credito'),
('Cartão de Débito', 'debito'),
('Transferência Bancária', 'debito'),
('PIX', 'debito');

INSERT INTO instituicao (descricao, numero_parcelas, forma_pagamento_id) VALUES
('Stone', 1, 1),
('Stone', 2, 1),
('Stone', 3, 1),
('Stone', 4, 1),
('Stone', 5, 1),
('Stone', 6, 1),
('PagBank', 1, 1),
('PagBank', 2, 1),
('PagBank', 3, 1),
('Mastercard', 1, 2),
('Visa Electron', 1, 2),
('Mercado Pago', 1, 3),
('CPF: 651.533.660-81', 1, 4); 

INSERT INTO pedido_status (descricao) VALUES
('Em Andamento'),
('Finalizado'),
('Cancelado');

INSERT INTO pedido (data_cadastro, valor_total, pedido_status_id, empresa_id, cliente_id) VALUES
('2025-08-07 10:30:00', 5698.80, 1, 1, 1), 
('2025-08-08 14:15:00', 5298.00, 1, 1, 2), 
('2025-09-08 09:50:00', 4798.90, 1, 1, 3), 
('2025-10-08 16:05:00', 2998.00, 1, 1, 4); 

INSERT INTO pedido_item (data_cadastro, quantidade, preco_unitario, pedido_id, produto_id) VALUES
('2025-08-07 10:30:00', 1, 2899.90, 1, 1), 
('2025-08-07 10:30:00', 2, 1399.45, 1, 3); 

INSERT INTO pedido_item (data_cadastro, quantidade, preco_unitario, pedido_id, produto_id) VALUES
('2025-08-08 14:15:00', 1, 2599.00, 2, 5), 
('2025-08-08 14:15:00', 4, 399.90, 2, 6); 

INSERT INTO pedido_item (data_cadastro, quantidade, preco_unitario, pedido_id, produto_id) VALUES
('2025-09-08 09:50:00', 1, 3499.00, 3, 7), 
('2025-09-08 09:50:00', 1, 1299.90, 3, 9); 

INSERT INTO pedido_item (data_cadastro, quantidade, preco_unitario, pedido_id, produto_id) VALUES
('2025-10-08 16:05:00', 1, 899.00, 4, 10), 
('2025-10-08 16:05:00', 2, 549.50, 4, 12); 

INSERT INTO pedido_pagamento (data_cadastro, pedido_id, valor, instituicao_id) VALUES
('2025-12-08 10:30:00', 1, 2899.40, 1),
('2025-12-08 10:30:00', 1, 2799.40, 7); 

INSERT INTO pedido_pagamento (data_cadastro, pedido_id, valor, instituicao_id) VALUES
('2025-21-09 14:15:00', 2, 2649.00, 7), 
('2025-21-09 14:15:00', 2, 2649.00, 2); 

INSERT INTO pedido_pagamento (data_cadastro, pedido_id, valor, instituicao_id) VALUES
('2025-29-09 09:50:00', 3, 4798.90, 13); 

INSERT INTO pedido_pagamento (data_cadastro, pedido_id, valor, instituicao_id) VALUES
('2025-06-10 16:05:00', 4, 2998.00, 12);