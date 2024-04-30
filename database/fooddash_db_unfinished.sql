-- Tabela Cliente
CREATE TABLE IF NOT EXISTS Clientes (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100),
    apelido VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    telemovel INT,
    morada TEXT,
    cidade VARCHAR(25),
    pais VARCHAR (25), 
    CodPostal VARCHAR(25),
    password VARCHAR(100) NOT NULL
);

-- Tabela Pedido
CREATE TABLE IF NOT EXISTS Pedidos (
    id BIGSERIAL PRIMARY KEY,
    data DATE DEFAULT NOW(),
    estado VARCHAR(50) DEFAULT 'EFETUADO'
    CHECK(estado IN ('EFETUADO','EM PREPARACAO','A CAMINHO','FINALIZADO')),
    cancelado BOOLEAN DEFAULT FALSE,
    precoTotal DECIMAL(10,2) NOT NULL,
    id_cliente INTEGER REFERENCES Clientes(id) ON DELETE CASCADE NOT NULL,
    id_entregador INTEGER NOT NULL,
    id_estabelecimento INTEGER NOT NULL
);

-- Tabela Entregador
CREATE TABLE IF NOT EXISTS Entregadores (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100),
    veiculo VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS ACTION_LOGGER 
(
    id BIGSERIAL PRIMARY KEY,
    AFFECTED_ID INT NOT NULL,
    AFFECTED_NOTE INT,
    ACTION_TYPE VARCHAR(30) NOT NULL
     CHECK(ACTION_TYPE IN ('UPDATE NOTE','DELETE NOTE','DELETE USER')),
    ACTION_DATE TIMESTAMPTZ DEFAULT NOW()
);

-- Tabela AvaliacaoItem
CREATE TABLE IF NOT EXISTS AvaliacoesItens (
    id BIGSERIAL PRIMARY KEY,
    classificacao INTEGER,
    autor VARCHAR(100),
    data DATE,
    descricao TEXT,
    id_cliente INTEGER REFERENCES Clientes(id) ON DELETE CASCADE NOT NULL,
    id_item INTEGER NOT NULL
);

-- Tabela Empresa
CREATE TABLE IF NOT EXISTS Empresas (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    morada TEXT NOT NULL,
    telemovel VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    password VARCHAR(100)
);

-- Tabela Estabelecimento
CREATE TABLE IF NOT EXISTS Estabelecimentos (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    localizacao TEXT NOT NULL,
    telemovel VARCHAR(20) NOT NULL,
    id_empresa INTEGER 
    REFERENCES Empresas(id)
    ON DELETE CASCADE NOT NULL
);

-- Tabela Item
CREATE TABLE IF NOT EXISTS Itens (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    descricao TEXT,
    disponivel BOOLEAN NOT NULL,
    foto VARCHAR(255),
    itemSozinho BOOLEAN NOT NULL,
    personalizacoesAtivas BOOLEAN NOT NULL,
    categoria INTEGER NOT NULL,
    id_estabelecimento INTEGER 
    REFERENCES Estabelecimentos(id)
    ON DELETE CASCADE NOT NULL
);

-- Tabela Opcao
CREATE TABLE IF NOT EXISTS Opcoes (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100),
    quantidade INTEGER
);

-- Tabela Personalizacao
CREATE TABLE IF NOT EXISTS Personalizacoes (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100),
    id_opcao INTEGER REFERENCES Opcoes(id) 
    ON DELETE CASCADE,
    id_item INTEGER REFERENCES Itens(id)
    ON DELETE CASCADE NOT NULL
);

-- Tabela Categoria
CREATE TABLE IF NOT EXISTS Categorias (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100)
);

-- Tabela Menu
CREATE TABLE IF NOT EXISTS Menus (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100),
    horarioInicial TIME,
    horarioFinal TIME,
    id_estabelecimento INTEGER
    REFERENCES Estabelecimentos(id)
    ON DELETE CASCADE NOT NULL
);

-- Tabela Avaliacao
CREATE TABLE IF NOT EXISTS Avaliacoes (
    id BIGSERIAL PRIMARY KEY,
    classificacao INTEGER,
    autor VARCHAR(100),
    data DATE,
    descricao TEXT,
    id_cliente INTEGER
    REFERENCES Clientes(id)
    ON DELETE CASCADE NOT NULL,
    id_estabelecimento INTEGER
    REFERENCES Estabelecimentos(id)
    ON DELETE CASCADE NOT NULL
);

-- Tabelas de Associação

-- Tabela Pedido_Item
CREATE TABLE IF NOT EXISTS Pedido_Itens (
    id_pedido INTEGER 
    REFERENCES Pedidos(id) ON DELETE
    CASCADE NOT NULL,
    id_item INTEGER REFERENCES Itens(id) 
    ON DELETE CASCADE NOT NULL,
    PRIMARY KEY (id_pedido, id_item)
);

-- Tabela Item_Categoria
CREATE TABLE IF NOT EXISTS Item_Categorias (
    id_item INTEGER REFERENCES Itens(id) 
    ON DELETE CASCADE NOT NULL,
    id_categoria INTEGER REFERENCES Categorias(id) 
    ON DELETE CASCADE NOT NULL,
    PRIMARY KEY (id_item, id_categoria)
);

-- Tabela Item_Menu
CREATE TABLE IF NOT EXISTS Item_Menus (
    id_item INTEGER REFERENCES Itens(id)
    ON DELETE CASCADE NOT NULL,
    id_menu INTEGER REFERENCES Menus(id) 
    ON DELETE CASCADE NOT NULL,
    PRIMARY KEY (id_item, id_menu)
);

-- insersão de dados de teste, para testar código
INSERT INTO Clientes (id, nome, apelido, email telemovel, morada, cidade, pais, CodPostal, password) 
VALUES (1, "nome", "apelido", "email", 123456789, "morada", "cidade", "pais", "codigo-postal", "password");
