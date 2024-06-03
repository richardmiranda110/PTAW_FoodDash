<?php

function ObterEmpresa($pdo, $ID)
{
    if ($ID != $_SESSION['id_empresa']) {
        exit("You cant access data of other companies!");
    }

    try {
        $sql = "SELECT * FROM Empresas WHERE id_empresa = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        // Executar a query e verificar que não retornou false
        if ($stmt->execute()) {
            // Fetch retorna um único resultado, então usamos fetch() e não fetchAll()
            $registo = $stmt->fetch();
            // Retornar os dados
            return $registo;
        } else {
            // Se a consulta falhar, retornar null
            return null;
        }

    } catch (Exception $e) {
        echo "Erro na conexão à BD: " . $e->getMessage();
        // Se ocorrer um erro, retornar null
        return null;
    }
}

// Altera os dados do empresa, mas não a password
function EditarEmpresa($pdo, $ID, $DadosEmpresa)
{
    if ($ID != $_SESSION['id_empresa']) {
        exit("You cant Edit other people's companies!");
    }

    $sql = "UPDATE Empresas SET nome = ?, morada = ?, telemovel = ?,
    email = ?, tipo = ?, logotipo = ?, WHERE id_empresa = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosEmpresa['nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosEmpresa['morada'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosEmpresa['telemovel'], PDO::PARAM_STR);
    $stmt->bindValue(4, $DadosEmpresa['email'], PDO::PARAM_STR);
    $stmt->bindValue(5, $DadosEmpresa['tipo'], PDO::PARAM_STR);
    $stmt->bindValue(6, $DadosEmpresa['logotipo'], PDO::PARAM_STR);
    $stmt->bindValue(7, $ID, PDO::PARAM_INT);

    // Executar a query e verificar que não retornou false
    if ($stmt->execute()) {
        // A operação foi executada com sucesso
        $sucesso = True;
    } else {
        // A operação foi executada sem sucesso
        $sucesso = False;
    }
    return $sucesso;
}

function AdicionarEstabelecimento($pdo, $id_empresa,$dadosEstabelecimento) {
    try {
        // Preparar a consulta SQL para inserir um novo estabelecimento
        $sql = "INSERT INTO Estabelecimentos (nome, localizacao, telemovel, taxa_entrega, tempo_medio_entrega, imagem, id_empresa) VALUES (:nome, :localizacao, :telemovel, :taxa_entrega, :tempo_medio_entrega, :imagem, :id_empresa)";
        
        // Preparar a declaração PDO
        $stmt = $pdo->prepare($sql);
        
        // Vincular parâmetros
        $stmt->bindParam(':nome', $dadosEstabelecimento['nome']);
        $stmt->bindParam(':localizacao', $dadosEstabelecimento['localizacao']);
        $stmt->bindParam(':telemovel', $dadosEstabelecimento['telemovel']);
        $stmt->bindParam(':taxa_entrega', $dadosEstabelecimento['taxa_entrega']);
        $stmt->bindParam(':tempo_medio_entrega', $dadosEstabelecimento['tempo_medio_entrega']);
        $stmt->bindParam(':imagem', $dadosEstabelecimento['imagem']);
        $stmt->bindParam(':id_empresa', $id_empresa);
        
        // Executar a consulta
        $stmt->execute();
        
        // Retornar verdadeiro se a inserção for bem-sucedida
        return true;
    } catch (PDOException $e) {
        // Se houver algum erro, lançar uma exceção ou lidar de outra forma
        return false;
    }
}
function ObterEstabelecimentosPorEmpresa($pdo, $ID)
{
    if ($ID != $_SESSION['id_empresa']) {
        throw new Exception("You can't access other people's Establishment!");
    }
    try {
        $id = $_SESSION['id_empresa'];

        $sql = "SELECT Estabelecimentos.* FROM Estabelecimentos
            INNER JOIN Empresas ON Estabelecimentos.id_empresa = Empresas.id_empresa
            WHERE Empresas.id_empresa = $id";

        $stmt = $pdo->prepare($sql);
        //$stmt->bindParam($id, $_SESSION['id_empresa'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Fetch retorna vários resultados, então usamos fetch() e não fetchAll()
            $estabelecimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Retornar os dados
            return $estabelecimentos;
        } else {
            // Se a consulta falhar, retornar null
            return null;
        }

    } catch (Exception $e) {
        echo "Erro na conexão à BD: " . $e->getMessage();
        // Se ocorrer um erro, retornar null
        return null;
    }
}

function ObterEstabelecimento($pdo, $id_estabelecimento)
{
    try {
        $sql = "SELECT * FROM Estabelecimentos WHERE id_estabelecimento = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id_estabelecimento, PDO::PARAM_INT);
        //$registo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->execute()) {
            // Fetch retorna um único resultado, então usamos fetch() e não fetchAll()
            //$registo = $stmt->fetch();
            $registo = $stmt->fetch(PDO::FETCH_ASSOC);
            return $registo;
        } else {
            // Se a consulta falhar, retornar null
            return null;
        }
    } catch (PDOException $e) {
        echo "Erro ao buscar o estabelecimento: " . $e->getMessage();
        return null;
    }
}


// Altera os dados do estabelecimento, mas não a password
function EditarEstabelecimento($pdo, $ID, $DadosEstabelecimentos)
{
    if ($ID != $_SESSION['id_estabelecimento']) {
        exit("You cant edit other people's Establishment!");
    }

    $sql = "UPDATE Estabelecimentos SET nome = ?, localizacao = ?, telemovel = ?,
    taxa_entrega = ?, tempo_medio_entrega = ?, imagem = ?
    WHERE id_estabelecimento = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosEstabelecimentos['nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosEstabelecimentos['localizacao'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosEstabelecimentos['telemovel'], PDO::PARAM_STR);
    $stmt->bindValue(4, (float) $DadosEstabelecimentos['taxa_entrega'], PDO::PARAM_STR); // Cast to float
    $stmt->bindValue(5, $DadosEstabelecimentos['tempo_medio_entrega'], PDO::PARAM_STR); // Should be a valid time string
    $stmt->bindValue(6, $DadosEstabelecimentos['imagem'], PDO::PARAM_STR);
    $stmt->bindValue(7, (int) $ID, PDO::PARAM_INT);

    // Executar a query e verificar que não retornou false
    if ($stmt->execute()) {
        // A operação foi executada com sucesso
        $sucesso = True;
    } else {
        // A operação foi executada sem sucesso
        $sucesso = False;
    }

    return $sucesso;
}

function ApagarEstabelecimento($pdo, $id_estabelecimento)
{
    try {
        // Prepare a query para excluir o estabelecimento
        $stmt = $pdo->prepare("DELETE FROM Estabelecimentos WHERE id_estabelecimento = ?");

        // Executa a query, passando o ID do estabelecimento como parâmetro
        $stmt->execute([$id_estabelecimento]);

        // Retorna verdadeiro se a exclusão foi bem-sucedida
        return true;
    } catch (PDOException $e) {
        echo "Erro ao buscar o estabelecimento: " . $e->getMessage();
        return false;
    }
}