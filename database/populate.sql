INSERT INTO Clientes (nome, apelido, email, telemovel, morada, cidade, pais, codpostal, password) VALUES
('João', 'Silva', 'joao@ua.com', '912345678', 'Av. Gen. José Estevão de Morais Sarmento, 33', 'Sintra', 'Portugal', '2710-583', crypt('senha123', gen_salt('bf'))),
('Maria', 'Santos', 'maria@ua.com', '987654321', 'R. de Antero de Quental 557', 'Porto', 'Portugal', '4200-065', crypt('abcde123', gen_salt('bf'))),
('Richard', 'Miranda', 'richard@ua.com', '916713732', 'R. de Dr. Manuel das Neves 5', 'Aveiro', 'Portugal', '3810-164', crypt('richard123', gen_salt('bf')));

INSERT INTO Empresas (nome, morada, telemovel, email, tipo, logotipo, password) VALUES
('McDonalds', 'Rua X, Lisboa', '123456789', 'mcdonaldsgmail.com', 'Fast Food', 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/McDonald%27s_Golden_Arches.svg/1200px-McDonald%27s_Golden_Arches.svg.png', crypt('mac1277', gen_salt('bf')) ),
('Burger King', 'Avenida Y, Porto', '987654321', 'burgerking@gmail.com', 'Fast Food', 'https://logodownload.org/wp-content/uploads/2021/01/burguer-king-logo-0.png', crypt('poiuer456', gen_salt('bf'))),
('Subenshi', 'Praça Aundff, Porto', '917988321', 'subenshi@gmail.com', 'Sushi', 'https://www.subenshi.pt/img/logos/LOGO_SUBENSHI-1-300x277.png', crypt('sushi44201', gen_salt('bf'))),
('Pizza Hut', 'Fórum Aveiro, Aveiro', '997374851', 'pizzahut@gmail.com', 'Pizza', 'https://upload.wikimedia.org/wikipedia/sco/thumb/d/d2/Pizza_Hut_logo.svg/1200px-Pizza_Hut_logo.svg.png', crypt('jkjdf342', gen_salt('bf'))),
('KFC', 'Glicinias, Porto', '935672132', 'kfc@gmail.com', 'Fast Food', 'https://media-cdn.tripadvisor.com/media/photo-s/26/c8/30/69/kfc-logo.jpg', crypt('omga2sd456', gen_salt('bf')));

INSERT INTO Estabelecimentos (nome, localizacao, telemovel, taxa_entrega, tempo_medio_entrega, imagem, id_empresa) VALUES
('McDonalds Aveiro Pingo Doce', 'Pingo Doce Aveiro', '111111111', 5.50, '00:20:00', 'https://lh3.googleusercontent.com/p/AF1QipM6gay0MMm-yE3Y2XVF7VftLPm8Oz_ART2jnH83=s1360-w1360-h1020', 1),
('McDonalds Aveiro Glicinias Plaza', 'Glicinias Plaza', '222222222', 3.00, '00:10:00', 'https://lh3.googleusercontent.com/p/AF1QipMxa7xgD2YoIMvbEeQIqDGijI2jo-XCba2VDcR2=s1360-w1360-h1020', 1),
('McDonalds Aveiro Universidade', 'Rua da Universidade de Aveiro', '333333333', 2.50, '00:15:00', 'https://lh3.googleusercontent.com/p/AF1QipPAFsHbJO3gfu71n59ljjhWNoQBJqc9ykikc8Ke=s1360-w1360-h1020', 1),
('McDonalds Porto NorteShopping', 'Norte Shopping', '444444444', 4.49, '00:10:00', 'https://www.mcdonalds.pt/media/5196/norteshopping-5.png?center=0.4911242603550296,0.033222591362126248&mode=crop&width=1920&height=1080&rnd=132412012040000000', 1),
('Burger King Aveiro Verdemilho', 'Avenida Verde, Verdemilho, Aveiro', '777333555', 2.00, '00:25:00', 'https://lh3.googleusercontent.com/p/AF1QipNL3G6RC8tOkN5Px17o2Pz_IGm7SJiZxG6vNnew=s1360-w1360-h1020', 2),
('Burger King Aveiro Center', 'Aveiro Center, Rua da AAAA, Aveiro', '777444555', 3.00, '00:30:00', 'https://lh3.googleusercontent.com/p/AF1QipMb6hv1vqOzAdjm3ZnhfZzQhgbeUaS6SDEbPCkL=s1360-w1360-h1020', 2),
('Subenshi Aveiro', 'R. Carlos Aleluia 4 17, 3810-077 Aveiro', '888333555', 5.00, '00:40:00', 'https://lh3.googleusercontent.com/p/AF1QipPM7YkY9ge6DtQoCkDe847pW6UvLLkyrASxdkob=s1360-w1360-h1020', 3),
('Pizza Hut Forum Aveiro', 'R. do Batalhão de Caçadores 10 2.07, 3810-064 Aveiro', '936689709', 4.50, '00:35:00', 'https://lh3.googleusercontent.com/p/AF1QipO2qLIZOyo22woZyeUjF82Riq-JSZO6JQssrx7Y=s1360-w1360-h1020', 4),
('Pizza Hut Cais Gaia', 'Empreendimento Douro Cais, Lj 320, Av. de Ramos Pinto, 4400-161 Vila Nova de Gaia', '222444333', 6.00, '00:20:00', 'https://lh3.googleusercontent.com/p/AF1QipPonG2HoqZP_-8EVWCGqgxvoXRWmd-qJr4a98t5=s1360-w1360-h1020', 4),
('KFC Arrábida Shopping', 'Centro Comercial Arrábida Shopping, PCT de Henrique Moreira 244 piso 2 loja 450, 4400-346 Vila Nova de Gaia', '932110887', 3.00, '00:10:00', 'https://lh3.googleusercontent.com/p/AF1QipOYQ-3yW21KUUYLCAW4nVz7JaA_o1ntqVoQJLQU=s1360-w1360-h1020', 5),
('KFC Aveiro', 'Centro Glicínias Plaza, R. Dom Manuel Barbuda e Vasconcelos 2 10, 3810-498 Aveiro', '932016660', 1.50, '00:20:00', 'https://lh3.googleusercontent.com/p/AF1QipO7mSiByNi0nExQnIU-a27DnmmNepwLGcc0C9N7=s1360-w1360-h1020', 5);

INSERT INTO Entregadores (nome, veiculo) VALUES
('Entregador Zé 1', 'Moto'),
('Entregador Zé 2', 'Bicicleta'),
('Entregador Zé 3', 'Moto'),
('Entregador Zé 4', 'Bicicleta'),
('Entregador Zé 5', 'Carro'),
('Entregador Zé 6', 'Carro');

INSERT INTO Categorias (nome, id_empresa) VALUES
('Carne', 2),
('Frango', 2),
('Sobremesas', 1),
('Carne 100% Bovina', 1),
('Pizzas Simples', 4),
('Acompanhamentos', 2),
('Sushi', 3),
('Wings', 5);

INSERT INTO Itens (nome, preco, descricao, disponivel, foto, itemSozinho, personalizacoesAtivas, id_categoria, id_estabelecimento) VALUES 
('Menu Whopper', 5.99, 'Delicioso menu de hambúrguer com queijo, alface, tomate, cebola, picles e maionese.', TRUE, 'whopper.jpg', FALSE, TRUE, 1, 2),
('Batata Frita Supreme', 2.49, 'Batatas fritas crocantes e deliciosas.', TRUE, 'fries.jpg', TRUE, FALSE, 6, 2),
('Sundae de Caramelo', 1.99, 'Sorvete de baunilha coberto com calda de caramelo e chantilly.', TRUE, 'sundae.jpg', TRUE, FALSE, 3, 1),
('Menu Big Mac', 5.59, 'Um hambúrguer clássico com alface, tomate e molho especial.', TRUE, 'big_mac.jpg', FALSE, TRUE, 4, 1),
('Pizza Margherita', 19.99, 'Uma deliciosa pizza Margherita com molho de tomate e mozzarela.', TRUE, 'pizza_margherita.jpg', TRUE, TRUE, 5, 4),
('Sushis de Todos os Tipos', 14.99, 'Uma embalagem de sushis aleatórios.', TRUE, 'random_sushi.jpg', TRUE, FALSE, 7, 3),
('Bucket of Hot Chicken Wings', 10.00, 'Balde de asas de frango picantes HOT HOT HOT', TRUE, 'wings_bucket.jpg', TRUE, FALSE, 8, 5);

/* INSERT INTO Personalizacoes (nome, id_item) VALUES 
('Bebida', 1),
('Acompanhamento', 1),
('Bebida', 4),
('Acompanhamento', 4),
('Extras', 5); */

INSERT INTO Opcoes (nome, preco, id_item) VALUES 
('Gelo', 0, 1), 
('Sal', 0, 2),
('Gelo', 0, 4),
('Sal', 0, 4),
('Extra Queijo', 0.60, 5),
('Extra Molho Shoyu', 0.20, 6),
('Extra Picante', 0.30, 7);

INSERT INTO Item_Categorias (id_item, id_categoria) VALUES 
(1, 1),
(2, 6),
(3, 3),
(4, 4),
(5, 5),
(6, 7),
(7, 8);

INSERT INTO Pedidos (estado, precoTotal, id_cliente, id_entregador, id_estabelecimento) VALUES 
('EFETUADO', 5.59, 1, 1, 1),  -- MCDonalds
('EFETUADO', 5.99, 1, 2, 2),  -- Burger King
('EFETUADO', 14.99, 2, 3, 3),  -- Subenshi
('EFETUADO', 19.99, 2, 4, 4),  -- Pizza Hut
('EFETUADO', 19.99, 3, 4, 4),  -- Pizza Hut
('EFETUADO', 20.00, 3, 5, 5),  -- KFC
('EFETUADO', 1.59, 2, 6, 1);  -- MCDonalds

INSERT INTO Pedido_Itens (id_pedido, id_item, quantidade) VALUES 
(1, 4, 2),
(2, 1, 1),
(2, 2, 1),
(3, 6, 1),
(4, 5, 1),
(5, 5, 1),
(6, 7, 2),
(7, 3, 1);

INSERT INTO Pedido_Item_Opcoes (id_pedido_item, id_opcao, quantidade) VALUES 
(1, 3, 0),
(2, 1, 1),
(3, 2, 1),
(4, 6, 1),
(5, 5, 1),
(6, 5, 1),
(7, 7, 0),
(7, 7, 1);

INSERT INTO Avaliacoes (classificacao, descricao, id_cliente, id_estabelecimento) VALUES 
(5, 'Excelente serviço e comida deliciosa.', 1, 1),
(4, 'Ambiente agradável e atendimento bom.', 2, 1),
(3, 'Comida boa, mas o atendimento pode melhorar.', 3, 1),
(4, 'O local é bonito. A comida estava fria.', 1, 2),
(1, 'Experiência decepcionante, não recomendo.', 2, 2),
(5, 'Gostei do lugar, voltarei com certeza!', 3, 2),
(5, 'Bom custo-benefício e atendimento rápido.', 1, 3),
(3, 'Comida ok, nada de especial.', 2, 3),
(3, 'Esperava mais pelo preço cobrado.', 3, 3),
(2, 'Não gostei.', 1, 4),
(5, 'Uma experiência incrível! A comida estava divina e o serviço impecável. Recomendo a todos!', 2, 4),
(5, 'Ambiente aconchegante e atendimento muito bom. Uma noite para lembrar!', 3, 4),
(3, 'A comida era boa, mas o atendimento deixou a desejar. Pode melhorar.', 1, 5),
(3, 'O lugar é lindo, mas a comida estava fria. Fiquei desapontada.', 2, 5),
(1, 'Que decepção! O serviço foi péssimo e a comida não estava boa. Não recomendo.', 3, 5),
(5, 'Simplesmente maravilhoso! Adorei cada detalhe e com certeza voltarei!', 1, 1),
(4, 'A comida estava decente.', 2, 1),
(5, 'Ótimo custo-benefício e o atendimento foi rápido e eficiente. Vale a pena!', 3, 1),
(2, 'Esperava mais pelo preço que paguei. Foi um pouco decepcionante.', 1, 2),
(1, 'Mau serviço e comida abaixo do esperado.', 2, 2),
(4, 'Ótimo custo-benefício.', 3, 2),
(5, 'Uma experiência fantástica! A comida estava sublime e o serviço foi impecável.', 1, 3),
(5, 'Ambiente acolhedor e atendimento excelente. Uma noite inesquecível!', 2, 3),
(5, 'Simplesmente maravilhoso! Amei cada pormenor e vou voltar com certeza!', 3, 3),
(5, 'Ótima relação qualidade-preço e o atendimento foi rápido e eficiente.', 1, 4),
(4, 'A comida estava aceitável, nada de especial, mas o ambiente era agradável.', 2, 4),
(5, 'Uma noite perfeita, desde a entrada até à sobremesa. Parabéns ao chef!', 3, 4),
(5, 'O atendimento foi impecável e a comida deliciosa.', 1, 5),
(3, 'O ambiente é ótimo, mas a comida não me impressionou. Há opções melhores.', 2, 5),
(4, 'Fiquei satisfeito com a comida.', 3, 5),
(4, 'A comida estava excelente, mas o serviço foi um pouco lento. Precisa de melhorias.', 1, 2),
(5, 'Gostei do ambiente e a comida estava deliciosa. Vou recomendar aos meus amigos!', 2, 2),
(4, 'Serviço amigável e comida saborosa. Uma boa escolha para um jantar descontraído.', 3, 2);





/*
DROP TABLE IF EXISTS action_logger,
avaliacoes,
avaliacoesitens,
categorias,
clientes,
empresas,
entregadores,
estabelecimentos,
item_categorias,
itens,
opcoes,
pedido_itens,
pedido_item_opcoes,
pedidos,
personalizacoes CASCADE;*/