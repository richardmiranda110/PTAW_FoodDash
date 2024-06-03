<?php

function ObterEmpresa($pdo, $ID)
{
    if ($ID != $_SESSION['id_empresa']) {
        exit("You can't access data of other companies!");
    }

    try {
        $sql = "SELECT * FROM Empresas WHERE id_empresa = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        $stmt->execute();
        $registo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registo;
    } catch (Exception $e) {
        echo "Erro na conexão à BD: " . $e->getMessage();
        return null;
    }
}

function EditarEmpresa($pdo, $ID, $DadosEmpresa)
{
    if ($ID != $_SESSION['id_empresa']) {
        exit("You can't edit other people's companies!");
    }

    $sql = "UPDATE Empresas SET nome = ?, morada = ?, telemovel = ?,
    email = ?, tipo = ?, logotipo = ? WHERE id_empresa = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosEmpresa['nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosEmpresa['morada'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosEmpresa['telemovel'], PDO::PARAM_STR);
    $stmt->bindValue(4, $DadosEmpresa['email'], PDO::PARAM_STR);
    $stmt->bindValue(5, $DadosEmpresa['tipo'], PDO::PARAM_STR);
    $stmt->bindValue(6, $DadosEmpresa['logotipo'], PDO::PARAM_STR);
    $stmt->bindValue(7, $ID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function AdicionarEstabelecimento($pdo, $id_empresa, $dadosEstabelecimento)
{
    try {
        $sql = "INSERT INTO Estabelecimentos (nome, localizacao, telemovel, taxa_entrega, tempo_medio_entrega, imagem, id_empresa) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $dadosEstabelecimento['nome'], PDO::PARAM_STR);
        $stmt->bindValue(2, $dadosEstabelecimento['localizacao'], PDO::PARAM_STR);
        $stmt->bindValue(3, $dadosEstabelecimento['telemovel'], PDO::PARAM_STR);
        $stmt->bindValue(4, $dadosEstabelecimento['taxa_entrega'], PDO::PARAM_STR);
        $stmt->bindValue(5, $dadosEstabelecimento['tempo_medio_entrega'], PDO::PARAM_STR);
        $stmt->bindValue(6, $dadosEstabelecimento['imagem'], PDO::PARAM_STR);
        $stmt->bindValue(7, $id_empresa, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erro ao adicionar estabelecimento: " . $e->getMessage();
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
            WHERE Empresas.id_empresa = ?
            ORDER BY Estabelecimentos.id_estabelecimento";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $estabelecimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $estabelecimentos;
    } catch (Exception $e) {
        echo "Erro na conexão à BD: " . $e->getMessage();
        return null;
    }
}

function ObterEstabelecimento($pdo, $id_estabelecimento)
{
    try {
        $sql = "SELECT Estabelecimentos.* FROM Estabelecimentos WHERE id_estabelecimento = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id_estabelecimento, PDO::PARAM_INT);
        $stmt->execute();
        $registo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registo;
    } catch (PDOException $e) {
        echo "Erro ao buscar o estabelecimento: " . $e->getMessage();
        return null;
    }
}


function EditarEstabelecimento($pdo, $ID, $DadosEstabelecimentos)
{
    $id_estabelecimento = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($ID != $id_estabelecimento) {
        exit("You can't edit other people's Establishment!");
    }

    $sql = "UPDATE Estabelecimentos SET nome = ?, localizacao = ?, telemovel = ?,
    taxa_entrega = ?, tempo_medio_entrega = ?, imagem = ?
    WHERE id_estabelecimento = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosEstabelecimentos['nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosEstabelecimentos['localizacao'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosEstabelecimentos['telemovel'], PDO::PARAM_STR);
    $stmt->bindValue(4, $DadosEstabelecimentos['taxa_entrega'], PDO::PARAM_STR);
    $stmt->bindValue(5, $DadosEstabelecimentos['tempo_medio_entrega'], PDO::PARAM_STR);
    $stmt->bindValue(6, $DadosEstabelecimentos['imagem'], PDO::PARAM_STR);
    $stmt->bindValue(7, $ID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function ApagarEstabelecimento($pdo, $id_estabelecimento)
{
    $id_estabelecimento = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    try {
        $stmt = $pdo->prepare("DELETE FROM Estabelecimentos WHERE id_estabelecimento = ?");
        $stmt->bindValue(1, $id_estabelecimento, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Erro ao apagar o estabelecimento: " . $e->getMessage();
        return false;
    }
}