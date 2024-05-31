-- Tabela Cliente
CREATE TABLE IF NOT EXISTS Clientes (
    id_cliente SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    apelido VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    telemovel INTEGER,
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

/* -- Tabela AvaliacaoItem
CREATE TABLE IF NOT EXISTS AvaliacoesItens (
    id_avaliacaoItem SERIAL PRIMARY KEY,
    classificacao INTEGER CHECK (classificacao BETWEEN 1 AND 5),
    autor VARCHAR(100) DEFAULT 'anonymous',
    data DATE DEFAULT NOW(),
    descricao TEXT,
    id_cliente INTEGER REFERENCES Clientes(id_cliente) ON DELETE CASCADE NOT NULL,
    id_item INTEGER NOT NULL
); */

-- Tabela Empresa
CREATE TABLE IF NOT EXISTS Empresas (
    id_empresa SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    morada TEXT NOT NULL,
    telemovel VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    logotipo VARCHAR(255),
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
    imagem VARCHAR(255),
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
    nome VARCHAR(40) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    descricao TEXT,
    disponivel BOOLEAN NOT NULL DEFAULT TRUE,
    foto VARCHAR(255),
    itemSozinho BOOLEAN DEFAULT FALSE,
    personalizacoesAtivas BOOLEAN DEFAULT FALSE,
    id_categoria INTEGER NOT NULL REFERENCES Categorias(id_categoria) ON DELETE CASCADE NOT NULL,
    id_estabelecimento INTEGER REFERENCES Estabelecimentos(id_estabelecimento) ON DELETE CASCADE NOT NULL
);

 -- Tabela Menu
CREATE TABLE IF NOT EXISTS Menus (
    id_menu SERIAL PRIMARY KEY,
    nome VARCHAR(40) NOT NULL,
    preco REAL NOT NULL,
    descricao VARCHAR(100) DEFAULT 'Nenhuma descrição.',
    disponivel boolean DEFAULT TRUE,
    foto VARCHAR(255),
    id_estabelecimento INTEGER
    REFERENCES Estabelecimentos(id_estabelecimento)
    ON DELETE CASCADE NOT NULL
); 

-- Tabela Item Menus
CREATE TABLE IF NOT EXISTS Item_Menus (
    id_item INTEGER REFERENCES Itens(id_item)
    ON DELETE CASCADE NOT NULL,
    id_menu INTEGER REFERENCES Menus(id_menu) 
    ON DELETE CASCADE NOT NULL,
    PRIMARY KEY (id_item, id_menu)
);

/*-- Tabela Personalizacao
CREATE TABLE IF NOT EXISTS Personalizacoes (
    id_personalizacao SERIAL PRIMARY KEY,
    nome VARCHAR(255),
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL
);
*/

-- Tabela Opcao
CREATE TABLE IF NOT EXISTS Opcoes (
    id_opcao SERIAL PRIMARY KEY,
    nome VARCHAR(255),
    max_quantidade INTEGER DEFAULT 1,
    preco REAL,
    /*id_personalizacao INTEGER REFERENCES Personalizacoes(id_personalizacao) ON DELETE CASCADE NOT NULL,*/
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL
);

/* -- Tabela HoraCardápio
CREATE TABLE IF NOT EXISTS HoraCardapio (
    id_hora_cardapio SERIAL PRIMARY KEY,
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
    classificacao INTEGER CHECK (classificacao BETWEEN 1 AND 5),
    /* autor VARCHAR(100), */
    data DATE DEFAULT NOW(),
    descricao TEXT,
    id_cliente INTEGER REFERENCES Clientes(id_cliente) ON DELETE CASCADE NOT NULL,
    id_estabelecimento INTEGER REFERENCES Estabelecimentos(id_estabelecimento) ON DELETE CASCADE NOT NULL
);

-- Tabelas de Associação

-- Tabela Pedido_Item
CREATE TABLE IF NOT EXISTS Pedido_Itens (
    id_pedido_item SERIAL PRIMARY KEY,
    id_pedido INTEGER REFERENCES Pedidos(id_pedido) ON DELETE CASCADE NOT NULL,
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL,
    quantidade INTEGER DEFAULT 1
);

CREATE TABLE IF NOT EXISTS Pedido_Item_Opcoes (
    id_pedido_item_opcao SERIAL PRIMARY KEY,
    id_pedido_item INTEGER REFERENCES Pedido_Itens(id_pedido_item) ON DELETE CASCADE NOT NULL,
    id_opcao INTEGER REFERENCES Opcoes(id_opcao) ON DELETE CASCADE,
    quantidade INTEGER DEFAULT 1
);

-- Tabela Item_Categoria
CREATE TABLE IF NOT EXISTS Item_Categorias (
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL,
    id_categoria INTEGER REFERENCES Categorias(id_categoria) ON DELETE CASCADE NOT NULL,
    PRIMARY KEY (id_item, id_categoria)
);

-- Tabela Item Menus Opções
CREATE TABLE IF NOT EXISTS Item_Menus_Opcoes (
    id_opcao_menu SERIAL PRIMARY KEY,
    id_menu_item INTEGER REFERENCES Item_Menus(id_item_menu) ON DELETE CASCADE NOT NULL,
    id_opcao INTEGER REFERENCES Opcoes(id_opcao) ON DELETE CASCADE,
    quantidade INTEGER DEFAULT 1
);

 -- Tabela Item_Menu
CREATE TABLE IF NOT EXISTS Item_Menus (
    id_item_menu SERIAL PRIMARY KEY,
    id_item INTEGER REFERENCES Itens(id_item)
    ON DELETE CASCADE NOT NULL,
    id_menu INTEGER REFERENCES Menus(id_menu) 
    ON DELETE CASCADE NOT NULL,
);

ALTER TABLE Pedidos ADD CONSTRAINT check_estado_valido
CHECK (estado IN ('EM CHECKOUT','EFETUADO', 'EM PREPARACAO', 'A CAMINHO', 'FINALIZADO'));

-- trigger para verificar se já existe uma avaliação do mesmo cliente para o mesmo estabelecimento, porque um cliente só pode avaliar um estabelecimento uma vez
CREATE OR REPLACE FUNCTION verificar_avaliacao_duplicada()
RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (
        SELECT 1 
        FROM Avaliacoes 
        WHERE id_cliente = NEW.id_cliente 
          AND id_estabelecimento = NEW.id_estabelecimento
    ) THEN
        RAISE EXCEPTION 'Cliente já avaliou este estabelecimento.';
    END IF;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_verificar_avaliacao_duplicada
BEFORE INSERT ON Avaliacoes
FOR EACH ROW
EXECUTE FUNCTION verificar_avaliacao_duplicada();


/* -- TRIGGERS
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
EXECUTE FUNCTION verificaPersonalizacoesAtivas(); */


CREATE OR REPLACE FUNCTION inserir_pedido(
    p_id_pedido INTEGER,
    p_id_prod INTEGER,
    p_value_pedido INTEGER,
    p_id_cliente INTEGER,
    p_id_estabelecimento INTEGER,
    p_id_entregador INTEGER,
    p_opcoes JSONB
) RETURNS INTEGER AS $$
DECLARE
    v_id_pedido INTEGER;
    v_id_pedido_item INTEGER;
    v_opcao JSONB;
BEGIN
    -- Insere ou atualiza o pedido
    IF p_id_pedido IS NULL THEN
        INSERT INTO pedidos (data, estado, cancelado, precototal, id_cliente, id_entregador, id_estabelecimento)
        VALUES (NOW(), 'EM CHECKOUT', false, p_value_pedido, p_id_cliente, p_id_entregador, p_id_estabelecimento)
        RETURNING id_pedido INTO v_id_pedido;
    ELSE
        UPDATE pedidos SET precototal = p_value_pedido WHERE id_pedido = p_id_pedido;
        v_id_pedido := p_id_pedido;
    END IF;

    -- Insere o item no pedido
    INSERT INTO pedido_itens (id_pedido, id_item, quantidade)
    VALUES (v_id_pedido, p_id_prod, 1)
    RETURNING id_pedido_item INTO v_id_pedido_item;

    -- Insere as opções do item
    FOR v_opcao IN SELECT * FROM jsonb_array_elements(p_opcoes) LOOP
        INSERT INTO pedido_item_opcoes (id_pedido_item, id_opcao, quantidade)
        VALUES (v_id_pedido_item, (v_opcao->>'id_opcao')::INTEGER, (v_opcao->>'quantidade')::INTEGER);
    END LOOP;

    -- Mensagem de sucesso
    RETURN v_id_pedido;
END;
$$ LANGUAGE plpgsql;
