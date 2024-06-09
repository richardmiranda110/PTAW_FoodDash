/* ###### SCRIPT DE CRIAÇÃO DA BASE DE DADOS FOODDASH #######
 
 Projeto Temático em Aplicações de Web
 Licenciatura em Tecnologias da Informação, 2º ano
 
 Elementos do Grupo (Grupo 2):
 Richard Miranda   | 113331
 Diogo Oliveira    | 113380
 Ricardo Fonseca   | 115776
 Ricardo Caniçais  | 48130
 Ana Vicente       | 114509
 Gustavo Guimarães | 107628

 Águeda, 10 de junho de 2024

Título: FoodDash | (tipo de aplicação)

Notas Importantes, e considerações a ter em conta:
 - antes de executar este script, tem que em primeiro lugar criar previamente a base de dados no PostgreSQL
*/  



--------------------------------------------------------------
-- Tabela 'ptaw-gr2-2024' Clientes - 1ª tabela a ser criada --
--------------------------------------------------------------
CREATE TABLE IF NOT EXISTS Clientes (
    id_cliente SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    apelido VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    telemovel VARCHAR(20),
    morada TEXT,
    cidade VARCHAR(25),
    pais VARCHAR (25),
    CodPostal VARCHAR(10),
    password VARCHAR(255) NOT NULL
);

------------------------------------------------------------------
-- Tabela 'ptaw-gr2-2024' Entregadores - 2ª tabela a ser criada --
------------------------------------------------------------------
-- Tabela Entregador
CREATE TABLE IF NOT EXISTS Entregadores (
    id_entregador SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    veiculo VARCHAR(100),
    disponivel boolean default true not null
);

-----------------------------------------------------------------------
-- Tabela 'ptaw-gr2-2024' ACTION_LOGGER - XXXXXª tabela a ser criada --
-----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS ACTION_LOGGER (
    id SERIAL PRIMARY KEY,
    AFFECTED_ID INT NOT NULL,
    AFFECTED_COMPANY INT,
    ACTION_TYPE VARCHAR(30) NOT NULL CHECK(
        ACTION_TYPE IN (
            'ADDED ITEM',
            'DELETED ITEM',
            'DELETED MENU',
            'ADDED MENU',
            'ADDED CATEGORY',
            'DELETED CATEGORY',
            'ADDED MENU ITEM',
            'DELETED MENU ITEM'
        )
    ),
    ACTION_DATE TIMESTAMPTZ DEFAULT NOW()
);
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
    data TIMESTAMPTZ DEFAULT NOW(),
    estado VARCHAR(50) DEFAULT 'EFETUADO' CHECK(
        estado IN (
            'EFETUADO',
            'EM PREPARACAO',
            'A CAMINHO',
            'FINALIZADO'
        )
    ),
    cancelado BOOLEAN DEFAULT FALSE,
    precoTotal DECIMAL(10, 2) NOT NULL,
    id_cliente INTEGER REFERENCES Clientes(id_cliente) ON DELETE CASCADE NOT NULL,
    id_entregador INTEGER REFERENCES Entregadores(id_entregador) ON DELETE CASCADE NOT NULL,
    id_empresa INTEGER REFERENCES Empresas(id_empresa) ON DELETE CASCADE NOT NULL
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
    preco DECIMAL(10, 2) NOT NULL,
    descricao TEXT,
    disponivel BOOLEAN NOT NULL DEFAULT TRUE,
    foto VARCHAR(255),
    itemSozinho BOOLEAN DEFAULT FALSE,
    personalizacoesAtivas BOOLEAN DEFAULT FALSE,
    id_categoria INTEGER NOT NULL REFERENCES Categorias(id_categoria) ON DELETE CASCADE NOT NULL,
    id_empresa INTEGER REFERENCES Empresas(id_empresa) ON DELETE CASCADE NOT NULL
);
-- Tabela Menu
CREATE TABLE IF NOT EXISTS Menus (
    id_menu SERIAL PRIMARY KEY,
    nome VARCHAR(40) NOT NULL,
    preco REAL NOT NULL,
    descricao VARCHAR(100) DEFAULT 'Nenhuma descrição.',
    disponivel boolean DEFAULT TRUE,
    foto VARCHAR(255),
    id_empresa INTEGER REFERENCES Empresas(id_empresa) ON DELETE CASCADE NOT NULL
);
-- Tabela Opcao
CREATE TABLE IF NOT EXISTS Opcoes (
    id_opcao SERIAL PRIMARY KEY,
    nome VARCHAR(255),
    max_quantidade INTEGER DEFAULT 1,
    preco REAL,
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL
);
-- Tabela Avaliacao
CREATE TABLE IF NOT EXISTS Avaliacoes (
    id_avaliacao SERIAL PRIMARY KEY,
    classificacao INTEGER CHECK (
        classificacao BETWEEN 1 AND 5
    ),
    data DATE DEFAULT NOW(),
    descricao TEXT,
    id_cliente INTEGER REFERENCES Clientes(id_cliente) ON DELETE CASCADE NOT NULL,
    id_empresa INTEGER REFERENCES Empresas(id_empresa) ON DELETE CASCADE NOT NULL
);
-- Tabelas de Associação
-- Tabela Pedido_Item
CREATE TABLE IF NOT EXISTS Pedido_Itens (
    id_pedido_item SERIAL PRIMARY KEY,
    id_pedido INTEGER REFERENCES Pedidos(id_pedido) ON DELETE CASCADE NOT NULL,
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL,
    id_menu INTEGER REFERENCES menus(id_menu) ON DELETE CASCADE,
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
-- Tabela Item_Menu
CREATE TABLE IF NOT EXISTS Item_Menus (
    id_item_menu SERIAL PRIMARY KEY,
    id_item INTEGER REFERENCES Itens(id_item) ON DELETE CASCADE NOT NULL,
    id_menu INTEGER REFERENCES Menus(id_menu) ON DELETE CASCADE NOT NULL
);

ALTER TABLE Pedidos
ADD CONSTRAINT check_estado_valido CHECK (
        estado IN (
            'EM CHECKOUT',
            'EFETUADO',
            'EM PREPARACAO',
            'A CAMINHO',
            'FINALIZADO'
        )
    );
/* ###### TRIGGERS ###### */
-- trigger para verificar se já existe uma avaliação do mesmo cliente para o mesmo estabelecimento, porque um cliente só pode avaliar um estabelecimento uma vez
CREATE OR REPLACE FUNCTION verificar_avaliacao_duplicada() RETURNS TRIGGER AS $$ BEGIN IF EXISTS (
        SELECT 1
        FROM Avaliacoes
        WHERE id_cliente = NEW.id_cliente
            AND id_empresa = NEW.id_empresa
    ) THEN RAISE EXCEPTION 'Cliente já avaliou esta empresa.';
END IF;
RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER trigger_verificar_avaliacao_duplicada BEFORE
INSERT ON Avaliacoes FOR EACH ROW EXECUTE FUNCTION verificar_avaliacao_duplicada();
CREATE OR REPLACE FUNCTION inserir_pedido(
        p_id_pedido INTEGER,
        p_id_prod INTEGER,
        p_value_pedido INTEGER,
        p_id_cliente INTEGER,
        p_id_empresa INTEGER,
        p_id_entregador INTEGER,
        p_opcoes JSONB
    ) RETURNS INTEGER AS $$
DECLARE v_id_pedido INTEGER;
v_id_pedido_item INTEGER;
v_opcao JSONB;
BEGIN -- Insere ou atualiza o pedido
IF p_id_pedido IS NULL THEN
INSERT INTO pedidos (
        data,
        estado,
        cancelado,
        precototal,
        id_cliente,
        id_entregador,
        id_empresa
    )
VALUES (
        NOW(),
        'EM CHECKOUT',
        false,
        p_value_pedido,
        p_id_cliente,
        p_id_entregador,
        p_id_empresa
    )
RETURNING id_pedido INTO v_id_pedido;
ELSE
UPDATE pedidos
SET precototal = p_value_pedido
WHERE id_pedido = p_id_pedido;
v_id_pedido := p_id_pedido;
END IF;
-- Insere o item no pedido
INSERT INTO pedido_itens (id_pedido, id_item, quantidade)
VALUES (v_id_pedido, p_id_prod, 1)
RETURNING id_pedido_item INTO v_id_pedido_item;
-- Insere as opções do item
FOR v_opcao IN
SELECT *
FROM jsonb_array_elements(p_opcoes) LOOP
INSERT INTO pedido_item_opcoes (id_pedido_item, id_opcao, quantidade)
VALUES (
        v_id_pedido_item,
        (v_opcao->>'id_opcao')::INTEGER,
        (v_opcao->>'quantidade')::INTEGER
    );
END LOOP;
-- Mensagem de sucesso
RETURN v_id_pedido;
END;
$$ LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION ADICIONAR_MENU() RETURNS TRIGGER LANGUAGE PLPGSQL AS $$ BEGIN
INSERT INTO ACTION_LOGGER(AFFECTED_ID, AFFECTED_COMPANY, ACTION_TYPE)
VALUES (NEW.id_menu, NEW.id_empresa, 'ADDED MENU');
RETURN NEW;
END;
$$;
CREATE OR REPLACE FUNCTION REMOVER_MENU() RETURNS TRIGGER LANGUAGE PLPGSQL AS $$ BEGIN
INSERT INTO ACTION_LOGGER(AFFECTED_ID, AFFECTED_COMPANY, ACTION_TYPE)
VALUES (
        OLD.id_menu,
        OLD.id_empresa,
        'DELETED MENU'
    );
RETURN OLD;
END;
$$;
CREATE OR REPLACE FUNCTION ADICIONAR_ITEM() RETURNS TRIGGER LANGUAGE PLPGSQL AS $$ BEGIN
INSERT INTO ACTION_LOGGER(AFFECTED_ID, AFFECTED_COMPANY, ACTION_TYPE)
VALUES (NEW.id_item, NEW.id_empresa, 'ADDED ITEM');
RETURN NEW;
END;
$$;
CREATE OR REPLACE FUNCTION REMOVER_ITEM() RETURNS TRIGGER LANGUAGE PLPGSQL AS $$ BEGIN
INSERT INTO ACTION_LOGGER(AFFECTED_ID, AFFECTED_COMPANY, ACTION_TYPE)
VALUES (
        OLD.id_item,
        OLD.id_empresa,
        'DELETED ITEM'
    );
RETURN OLD;
END;
$$;
CREATE OR REPLACE FUNCTION ADICIONAR_CATEGORIA() RETURNS TRIGGER LANGUAGE PLPGSQL AS $$ BEGIN
INSERT INTO ACTION_LOGGER(AFFECTED_ID, AFFECTED_COMPANY, ACTION_TYPE)
VALUES (NEW.id_categoria, NEW.id_empresa, 'ADDED CATEGORY');
RETURN NEW;
END;
$$;
CREATE OR REPLACE FUNCTION REMOVER_CATEGORIA() RETURNS TRIGGER LANGUAGE PLPGSQL AS $$ BEGIN
INSERT INTO ACTION_LOGGER(AFFECTED_ID, AFFECTED_COMPANY, ACTION_TYPE)
VALUES (
        OLD.id_categoria,
        OLD.id_empresa,
        'DELETED CATEGORY'
    );
RETURN OLD;
END;
$$;
CREATE OR REPLACE FUNCTION ADICIONAR_MENU_ITENS() RETURNS TRIGGER LANGUAGE PLPGSQL AS $$ BEGIN
INSERT INTO ACTION_LOGGER(AFFECTED_ID, AFFECTED_COMPANY, ACTION_TYPE)
VALUES (NEW.id_item, NEW.id_menu, 'ADDED MENU ITEM');
RETURN NEW;
END;
$$;
CREATE OR REPLACE FUNCTION REMOVER_MENU_ITENS() RETURNS TRIGGER LANGUAGE PLPGSQL AS $$ BEGIN
INSERT INTO ACTION_LOGGER(AFFECTED_ID, AFFECTED_COMPANY, ACTION_TYPE)
VALUES (OLD.id_item, OLD.id_menu, 'DELETED MENU ITEM');
RETURN OLD;
END;
$$;
-- TRIGGERS
CREATE TRIGGER ADICIONAR_MENU AFTER INSERT ON Menus FOR EACH ROW EXECUTE FUNCTION ADICIONAR_MENU();
CREATE TRIGGER REMOVER_MENU BEFORE DELETE ON Menus FOR EACH ROW EXECUTE FUNCTION REMOVER_MENU();

CREATE TRIGGER ADICIONAR_ITEM AFTER INSERT ON Itens FOR EACH ROW EXECUTE FUNCTION ADICIONAR_ITEM();
CREATE TRIGGER REMOVER_ITEM BEFORE DELETE ON Itens FOR EACH ROW EXECUTE FUNCTION REMOVER_ITEM();

CREATE TRIGGER ADICIONAR_CATEGORIA AFTER INSERT ON Categorias FOR EACH ROW EXECUTE FUNCTION ADICIONAR_CATEGORIA();
CREATE TRIGGER REMOVER_CATEGORIA BEFORE DELETE ON Categorias FOR EACH ROW EXECUTE FUNCTION REMOVER_CATEGORIA();

CREATE TRIGGER ADICIONAR_MENU_ITENS AFTER INSERT ON Item_Menus FOR EACH ROW EXECUTE FUNCTION ADICIONAR_MENU_ITENS();
CREATE TRIGGER REMOVER_MENU_ITENS BEFORE DELETE ON Item_Menus FOR EACH ROW EXECUTE FUNCTION REMOVER_MENU_ITENS();