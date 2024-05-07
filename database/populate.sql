-- Inserir dados de teste para a tabela Clientes
INSERT INTO Clientes (nome, email, morada, telemovel, password) VALUES
    ('João Silva', 'joao@ua.com', 'Rua A, Lisboa', '912345678', 'senha123'),
    ('Maria Santos', 'maria@ua.com', 'Avenida B, Porto', '987654321', 'abcde123'),
    ('Richard Miranda', 'richard@ua.com', 'Rua ABCS, Aveiro', '916713732', 'richardfood');

-- Inserir dados de teste para a tabela Empresas
INSERT INTO Empresas (nome, morada, telemovel, email, tipo, password) VALUES
    ('McDonalds', 'Rua X, Lisboa', '123456789', 'mcdonaldsgmail.com', 'Fast Food', 'mac1277'),
    ('Burger King', 'Avenida Y, Porto', '987654321', 'burgerking@gmail.com', 'Fast Food', 'poiuer456'),
    ('Subenshi', 'Praça Aundff, Porto', '917988321', 'subenshi@gmail.com', 'Sushi', 'sushi44201'),
    ('Pizza Hut', 'Fórum Aveiro, Aveiro', '997374851', 'pizzahut@gmail.com', 'Pizza', 'jkjdf342'),
    ('KFC', 'Glicinias, Porto', '935672132', 'kfc@gmail.com', 'Fast Food', 'omga2sd456');

-- Inserir dados de teste para a tabela Estabelecimentos
INSERT INTO Estabelecimentos (nome, localizacao, telemovel, id_empresa) VALUES
    ('McDonalds Aveiro Pingo Doce', 'Pingo Doce Aveiro', '111111111', 46),
    ('McDonalds Aveiro Glicinias Plazaz', 'Glicinias Plaza', '222222222', 46),
    ('McDonalds Aveiro Universidade', 'Rua da Universidade de Aveiro', '333333333', 46),
    ('McDonalds Porto Norte Shopping', 'Norte Shopping', '444444444', 46),
    ('Burger King Aveiro Verdemilho', 'Avenida Verde, Verdemilho, Aveiro', '777333555', 47),
    ('Burger King Aveiro Center', 'Aveiro Center, Rua da AAAA, Aveiro', '777444555', 47),
    ('Subenshi Aveiro', 'R. Carlos Aleluia 4 17, 3810-077 Aveiro', '888333555', 48),
    ('Pizza Hut Forum Aveiro', 'R. do Batalhão de Caçadores 10 2.07, 3810-064 Aveiro', '936689709', 49),
    ('Pizza Hut Cais Gaia', 'Empreendimento Douro Cais, Lj 320, Av. de Ramos Pinto, 4400-161 Vila Nova de Gaia', '222444333', 50),
    ('KFC Arrábida Shopping', 'Centro Comercial Arrábida Shopping, PCT de Henrique Moreira 244 piso 2 loja 450, 4400-346 Vila Nova de Gaia', '932110887', 50),
    ('KFC Aveiro', 'Centro Glicínias Plaza, R. Dom Manuel Barbuda e Vasconcelos 2 10, 3810-498 Aveiro', '932016660', 50);

-- Inserir dados de teste para a tabela Itens
INSERT INTO Itens (nome, preco, descricao, disponivel, foto, itemSozinho,categoria,personalizacoesAtivas,id_estabelecimento) VALUES
    ('Menu Whopper', 5.99, 'Delicioso menu de hambúrguer com queijo, alface, tomate, cebola, picles e maionese.', FALSE, 'whopper.jpg', TRUE,1, TRUE,63),
    ('Batata Frita Supreme', 2.49, 'Batatas fritas crocantes e deliciosas.', TRUE, 'fries.jpg', TRUE,2, FALSE,63),
    ('Sundae de Caramelo', 1.99, 'Sorvete de baunilha coberto com calda de caramelo e chantilly.', TRUE, 'sundae.jpg', TRUE,3, FALSE,63);

-- Inserir dados de teste para a tabela Categorias
INSERT INTO Categorias (nome) VALUES
    ('Carne'),
    ('Frango'),
    ('Sobremesas');

-- Inserir dados de teste para a tabela Menus
INSERT INTO Menus (nome, horarioInicial, horarioFinal, id_estabelecimento) VALUES
    ('Menu 1', '12:00', '15:00', 59),
    ('Menu 2', '18:00', '22:00', 59)

-- Inserir dados de teste para a tabela Pedidos
INSERT INTO Pedidos (id_cliente, id_entregador, id_estabelecimento, precoTotal) VALUES
    (31, 1, 1, 25.00),
    (32, 2, 2, 30.00);

-- Inserir dados de teste para a tabela Entregadores
INSERT INTO Entregadores (nome, veiculo) VALUES
    ('Entregador 1', 'Motocicleta'),
    ('Entregador 2', 'Bicicleta');
