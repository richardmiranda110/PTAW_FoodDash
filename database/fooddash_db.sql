-- Tabela Cliente
CREATE TABLE IF NOT EXISTS Clientes (
    id_cliente SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    apelido VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    telemovel INT,
    morada TEXT,
    cidade VARCHAR(25),
    pais VARCHAR (25), 
    CodPostal VARCHAR(10),
    password VARCHAR(255) NOT NULL
);

-- Tabela Entregador
CREATE TABLE IF NOT EXISTS Entregadores (
    id_entregador SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    veiculo VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS ACTION_LOGGER 
(
    id SERIAL PRIMARY KEY,
    AFFECTED_ID INT NOT NULL,
    AFFECTED_NOTE INT,
    ACTION_TYPE VARCHAR(30) NOT NULL CHECK(ACTION_TYPE IN ('UPDATE NOTE','DELETE NOTE','DELETE USER')),
    ACTION_DATE TIMESTAMPTZ DEFAULT NOW()
);

-- Tabela AvaliacaoItem
CREATE TABLE IF NOT EXISTS AvaliacoesItens (
    id_avaliacaoItem SERIAL PRIMARY KEY,
    classificacao INTEGER,
    autor VARCHAR(100) DEFAULT 'anonymous',
    data DATE DEFAULT NOW(),
    descricao TEXT,
    id_cliente INTEGER REFERENCES Clientes(id_cliente) ON DELETE CASCADE NOT NULL,
    id_item INTEGER NOT NULL
);

-- Tabela Empresa
CREATE TABLE IF NOT EXISTS Empresas (
    id_empresa SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    morada TEXT NOT NULL,
    telemovel VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    password VARCHAR(255)
);

-- Tabela Estabelecimento
CREATE TABLE IF NOT EXISTS Estabelecimentos (
    id_estabelecimento SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    localizacao TEXT NOT NULL,
    telemovel VARCHAR(20) NOT NULL,
    taxa_entrega DECIMAL NOT NULL,
    tempo_medio_entrega TIME NOT NULL,
    id_empresa INTEGER REFERENCES Empresas(id_empresa) ON DELETE CASCADE NOT NULL
);

-- Tabela Pedido
CREATE TABLE IF NOT EXISTS Pedidos (
    id_pedido SERIAL PRIMARY KEY,
    data DATE DEFAULT NOW(),
    estado VARCHAR(50) DEFAULT 'EFETUADO'
    CHECK(estado IN ('EFETUADO','EM PREPARACAO','A CAMINHO','FINALIZADO')),
    cancelado BOOLEAN DEFAULT FALSE,
    precoTotal DECIMAL(10,2) NOT NULL,
    id_cliente INTEGER REFERENCES Clientes(id_cliente) ON DELETE CASCADE NOT NULL,
    id_entregador INTEGER REFERENCES Entregadores(id_entregador) ON DELETE CASCADE NOT NULL,
    id_estabelecimento INTEGER REFERENCES Estabelecimentos(id_estabelecimento) ON DELETE CASCADE NOT NULL
);

-- Tabela Categoria
CREATE TABLE IF NOT EXISTS Categorias (
    id_categoria SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    id_empresa INTEGER REFERENCES Empresas(id_empresa) ON DELETE CASCADE NOT NULL
);

-- Tabela Item
CREATE TABLE IF NOT EXISTS Itens (
    id_item SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    descricao TEXT,
    disponivel BOOLEAN NOT NULL,
    foto VARCHAR(255),
    itemSozinho BOOLEAN DEFAULT FALSE,
    personalizacoesAtivas BOOLEAN DEFAULT FALSE,
    id_categoria INTEGER NOT NULL REFERENCES Categorias(id_categoria) ON DELETE CASCADE NOT NULL,
    id_estabelecimento INTEGER REFERENCES Estabelecimentos(id_estabelecimento) ON DELETE CASCADE NOT NULL
);

-- Tabela Opcao
CREATE TABLE IF NOT EXISTS Opcoes (
    id_opcao SERIAL PRIMARY KEY,
    nome VARCHAR(255),
    max_quantidade INTEGER,
    preco real,
    pid_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL
);

/* -- Tabela Menu
CREATE TABLE IF NOT EXISTS Menus (
    id_menu SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    horarioInicial TIME,
    horarioFinal TIME,
    id_estabelecimento INTEGER
    REFERENCES Estabelecimentos(id)
    ON DELETE CASCADE NOT NULL
); */

-- Tabela Avaliacao
CREATE TABLE IF NOT EXISTS Avaliacoes (
    id_avaliacao SERIAL PRIMARY KEY,
    classificacao INTEGER,
    autor VARCHAR(100),
    data DATE,
    descricao TEXT,
    id_cliente INTEGER REFERENCES Clientes(id_cliente) ON DELETE CASCADE NOT NULL,
    id_estabelecimento INTEGER REFERENCES Estabelecimentos(id_estabelecimento) ON DELETE CASCADE NOT NULL
);

-- Tabelas de Associação

CREATE TABLE IF NOT EXISTS Pedido_Item_Opcoes (
    id_pedido_item_opcao SERIAL PRIMARY KEY,
    pid_pedido_item INTEGER REFERENCES Pedido_Itens(id_pedido_item) ON DELETE CASCADE NOT NULL,
    pid_opcao INTEGER REFERENCES Opcoes(id_opcao) ON DELETE CASCADE NOT NULL,
    quantidade INTEGER
);

-- Tabela Pedido_Item
CREATE TABLE IF NOT EXISTS Pedido_Itens (
    id_pedido_item SERIAL PRIMARY KEY,
    id_pedido INTEGER REFERENCES Pedidos(id_pedido) ON DELETE CASCADE NOT NULL,
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL
	quantidade INTEGER
);
--cria um índice na tabela Pedido_Itens para facilitar as consultas
CREATE INDEX idx_pedido_itens_id_pedido_id_item ON Pedido_Itens (id_pedido, id_item);


-- Tabela Item_Categoria
CREATE TABLE IF NOT EXISTS Item_Categorias (
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL,
    id_categoria INTEGER REFERENCES Categorias(id_categoria) ON DELETE CASCADE NOT NULL,
    PRIMARY KEY (id_item, id_categoria)
);

/* -- Tabela Item_Menu
CREATE TABLE IF NOT EXISTS Item_Menus (
    id_item INTEGER REFERENCES Itens(id_item)
    ON DELETE CASCADE NOT NULL,
    id_menu INTEGER REFERENCES Menus(id_menu) 
    ON DELETE CASCADE NOT NULL,
    PRIMARY KEY (id_item, id_menu)
); */


-- TRIGGERS
CREATE OR REPLACE FUNCTION verificaPersonalizacoesAtivas() RETURNS TRIGGER AS $$
BEGIN
    --verifica se o item tem personalizacoesAtivas igual a TRUE
    IF EXISTS (
        SELECT 1 FROM Itens i WHERE NEW.id_item = i.id_item AND i.personalizacoesAtivas = TRUE
    ) THEN
        --se sim, não faz nada
        RETURN NEW;
    ELSE
        --se não, lança um erro
        RAISE EXCEPTION 'O item não tem personalizações ativas';
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_verifica_personalizacoes
BEFORE INSERT ON Personalizacoes
FOR EACH ROW
EXECUTE FUNCTION verificaPersonalizacoesAtivas();