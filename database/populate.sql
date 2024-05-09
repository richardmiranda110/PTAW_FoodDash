INSERT INTO Clientes (nome, email, morada, telemovel, password) VALUES
('João Silva', 'joao@ua.com', 'Rua A, Lisboa', '912345678', 'senha123'),
('Maria Santos', 'maria@ua.com', 'Avenida B, Porto', '987654321', 'abcde123'),
('Richard Miranda', 'richard@ua.com', 'Rua ABCS, Aveiro', '916713732', 'richardfood');

INSERT INTO Pedidos (estado, precoTotal, id_cliente, id_entregador, id_estabelecimento) VALUES 
("EFETUADO", 5.59, 1, 1, 1),  -- MCDonalds
("EFETUADO", 5.99, 1, 2, 2),  -- Burger King
("EFETUADO", 14.99, 2, 3, 3),  -- Subenshi
("EFETUADO", 19.99, 2, 4, 4),  -- Pizza Hut
("EFETUADO", 19.99, 3, 4, 4),  -- Pizza Hut
("EFETUADO", 10.00, 3, 5, 5),  -- KFC
("EFETUADO", 1.59, 2, 6, 1);  -- MCDonalds

INSERT INTO Categorias (nome, id_empresa) VALUES
('Carne', 2),
('Frango', 2),
('Sobremesas', 1),
('Carne 100% Bovina', 1),
('Pizzas Simples', 4),
("Acompanhamentos", 2),
("Sushi", 3),
("Wings", 5);

INSERT INTO Itens (nome, preco, descricao, disponivel, foto, itemSozinho, personalizacoesAtivas, id_categoria, id_estabelecimento) VALUES 
('Menu Whopper', 5.99, 'Delicioso menu de hambúrguer com queijo, alface, tomate, cebola, picles e maionese.', TRUE, 'whopper.jpg', FALSE, TRUE, 1, 2),
('Batata Frita Supreme', 2.49, 'Batatas fritas crocantes e deliciosas.', TRUE, 'fries.jpg', TRUE, FALSE, 6, 2),
('Sundae de Caramelo', 1.99, 'Sorvete de baunilha coberto com calda de caramelo e chantilly.', TRUE, 'sundae.jpg', TRUE, FALSE, 3, 1),
('Menu Big Mac', 5.59, 'Um hambúrguer clássico com alface, tomate e molho especial.', TRUE, 'big_mac.jpg', FALSE, TRUE, 4, 1),
('Pizza Margherita', 19.99, 'Uma deliciosa pizza Margherita com molho de tomate e mozzarela.', TRUE, 'pizza_margherita.jpg', TRUE, TRUE, 5, 4),
("Sushis de Todos os Tipos", 14.99, "Uma embalagem de sushis aleatórios." TRUE, "random_sushi.jpg", TRUE, FALSE, 7, 3),
("Bucket of Hot Chicken Wings", 10.00, "Balde de asas de frango picantes HOT HOT HOT", TRUE, "wings_bucket.jpg", TRUE, FALSE, 8, 5);

INSERT INTO Entregadores (nome, veiculo) VALUES
('Entregador Zé 1', 'Moto'),
('Entregador Zé 2', 'Bicicleta'),
('Entregador Zé 3', 'Moto'),
('Entregador Zé 4', 'Bicicleta'),
('Entregador Zé 5', 'Carro'),
('Entregador Zé 6', 'Carro');

INSERT INTO Empresas (nome, morada, telemovel, email, tipo, password) VALUES
("McDonald's", 'Rua X, Lisboa', '123456789', 'mcdonaldsgmail.com', 'Fast Food', 'mac1277'),
('Burger King', 'Avenida Y, Porto', '987654321', 'burgerking@gmail.com', 'Fast Food', 'poiuer456'),
('Subenshi', 'Praça Aundff, Porto', '917988321', 'subenshi@gmail.com', 'Sushi', 'sushi44201'),
('Pizza Hut', 'Fórum Aveiro, Aveiro', '997374851', 'pizzahut@gmail.com', 'Pizza', 'jkjdf342'),
('KFC', 'Glicinias, Porto', '935672132', 'kfc@gmail.com', 'Fast Food', 'omga2sd456');

INSERT INTO Estabelecimentos (nome, localizacao, telemovel, tempo_medio_entrega, id_empresa) VALUES
("McDonald's Aveiro Pingo Doce", 'Pingo Doce Aveiro', '111111111', "00:20:00", 1),
("McDonald's Aveiro Glicinias Plaza", 'Glicinias Plaza', '222222222', "00:10:00", 1),
("McDonald's Aveiro Universidade", 'Rua da Universidade de Aveiro', '333333333', "00:15:00", 1),
("McDonald's Porto Norte Shopping", 'Norte Shopping', '444444444', "00:10:00", 1),
('Burger King Aveiro Verdemilho', 'Avenida Verde, Verdemilho, Aveiro', '777333555', "00:25:00", 2),
('Burger King Aveiro Center', 'Aveiro Center, Rua da AAAA, Aveiro', '777444555', "00:30:00", 2),
('Subenshi Aveiro', 'R. Carlos Aleluia 4 17, 3810-077 Aveiro', '888333555', "00:40:00", 3),
("Pizza Hut Forum Aveiro", "R. do Batalhão de Caçadores 10 2.07, 3810-064 Aveiro", "936689709", "00:35:00", 4),
("Pizza Hut Cais Gaia", "Empreendimento Douro Cais, Lj 320, Av. de Ramos Pinto, 4400-161 Vila Nova de Gaia", "222444333", "00:20:00", 4),
("KFC Arrábida Shopping", "Centro Comercial Arrábida Shopping, PCT de Henrique Moreira 244 piso 2 loja 450, 4400-346 Vila Nova de Gaia", "932110887", "00:10:00", 5),
("KFC Aveiro", "Centro Glicínias Plaza, R. Dom Manuel Barbuda e Vasconcelos 2 10, 3810-498 Aveiro", "932016660", "00:20:00", 5);

INSERT INTO Personalizacoes (nome, id_item) VALUES 
("Bebida", 1),
("Acompanhamento", 1),
("Bebida", 2),
("Acompanhamento", 2),
("Extras", 5);

INSERT INTO Opcoes (nome, quantidade, id_personalizacao) VALUES 
("Gelo", 0, 1), 
("Sal", 1, 2),
("Gelo", 1, 3),
("Sal", 0, 4),
("Extra Queijo", 0, 5);

INSERT INTO Item_Categorias (id_item, id_categoria) VALUES 
(1, 1),
(2, 6),
(3, 3),
(4, 4),
(5, 5),
(6, 7),
(7, 8);

INSERT INTO Pedido_Itens (id_pedido, id_item) VALUES 
(1, 4), 
(1, 4), --dois big macs no mesmo pedido
(2, 1),
(2, 2),
(3, 6),
(4, 5),
(5, 5),
(6, 7),
(7, 3);