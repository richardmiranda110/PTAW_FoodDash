<?php

function ObterEmpresaLocal()
{
    global $pdo;
    $ID = $_SESSION['id_empresa'];

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

function EditarEmpresa($DadosEmpresa)
{
    global $pdo;

    try {
        $sql = "UPDATE Empresas
        SET nome = ?, morada = ?, telemovel = ?,
        email = ?, tipo = ?, logotipo = ? WHERE id_empresa = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $DadosEmpresa['nome'], PDO::PARAM_STR);
        $stmt->bindValue(2, $DadosEmpresa['morada'], PDO::PARAM_STR);
        $stmt->bindValue(3, $DadosEmpresa['telemovel'], PDO::PARAM_STR);
        $stmt->bindValue(4, $DadosEmpresa['email'], PDO::PARAM_STR);
        $stmt->bindValue(5, $DadosEmpresa['tipo'], PDO::PARAM_STR);
        $stmt->bindValue(6, $DadosEmpresa['logotipo'], PDO::PARAM_STR);
        $stmt->bindValue(7, $_SESSION['id_empresa']);

        return $stmt->execute(); 
    } catch (Exception $e) {
        echo $e;
        exit();
    }
}

function ObterEstabelecimentosEmpresaLocal()
{
    global $pdo;

    try {
        $sql = "SELECT Estabelecimentos.* FROM Estabelecimentos
            INNER JOIN Empresas ON Estabelecimentos.id_empresa = Empresas.id_empresa
            WHERE Empresas.id_empresa = ?
            ORDER BY Estabelecimentos.id_estabelecimento";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $_SESSION['id_empresa'], PDO::PARAM_INT);
        $stmt->execute();
        $estabelecimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $estabelecimentos;
    } catch (Exception $e) {
        echo "Erro na conexão à BD: " . $e->getMessage();
        return null;
    }
}

function AdicionarEstabelecimento($dadosEstabelecimento)
{
    global $pdo;
    $id_empresa = $_SESSION['id_empresa'];

    try {
        $sql = "INSERT INTO Estabelecimentos (nome, localizacao, telemovel, taxa_entrega, tempo_medio_entrega, imagem, id_empresa) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $dadosEstabelecimento['nome'], PDO::PARAM_STR);
        $stmt->bindValue(2, $dadosEstabelecimento['localizacao'], PDO::PARAM_STR);
        $stmt->bindValue(3, $dadosEstabelecimento['telemovel'], PDO::PARAM_STR);
        $stmt->bindValue(4, $dadosEstabelecimento['taxa_entrega'], PDO::PARAM_STR);
        $stmt->bindValue(5, $dadosEstabelecimento['tempo_medio_entrega'], PDO::PARAM_STR);
        $stmt->bindValue(6, $dadosEstabelecimento['imagem'], PDO::PARAM_STR);
        $stmt->bindValue(7, $id_empresa, PDO::PARAM_INT);
        
        return $stmt->execute();

    } catch (PDOException $e) {
        echo "Erro ao adicionar estabelecimento: " . $e->getMessage();
        return false;
    }
}

function ObterEstabelecimento($id_estabelecimento)
{
    global $pdo;

    try {
        $sql = "SELECT * FROM Estabelecimentos 
        WHERE id_estabelecimento = ? AND id_empresa = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id_estabelecimento, PDO::PARAM_INT);
        $stmt->bindValue(2, $_SESSION['id_empresa'], PDO::PARAM_INT);
        $stmt->execute();

        $registo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registo;
    } catch (PDOException $e) {
        echo "Erro ao buscar o estabelecimento: " . $e->getMessage();
        return null;
    }
}

function VerificarEstabExistente($nome, $localizacao)
{
    global $pdo;
    $id_empresa = $_SESSION['id_empresa'];

    try {
        $sql = "SELECT id_estabelecimento FROM Estabelecimentos 
                WHERE nome = ? AND localizacao = ? AND id_empresa = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
        $stmt->bindValue(2, $localizacao, PDO::PARAM_STR);
        $stmt->bindValue(3, $id_empresa, PDO::PARAM_INT);
        $stmt->execute();

        $estabelecimento = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $estabelecimento ? $estabelecimento['id_estabelecimento'] : null;
    } catch (PDOException $e) {
        echo "Erro ao verificar estabelecimento: " . $e->getMessage();
        return null;
    }
}

function EditarEstabelecimento($ID, $DadosEstabelecimentos)
{
    global $pdo;

    $sql = "UPDATE Estabelecimentos SET nome = ?, localizacao = ?, telemovel = ?,
    taxa_entrega = ?, tempo_medio_entrega = ?, imagem = ?
    WHERE id_estabelecimento = ? and id_empresa = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosEstabelecimentos['nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosEstabelecimentos['localizacao'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosEstabelecimentos['telemovel'], PDO::PARAM_STR);
    $stmt->bindValue(4, $DadosEstabelecimentos['taxa_entrega'], PDO::PARAM_STR);
    $stmt->bindValue(5, $DadosEstabelecimentos['tempo_medio_entrega'], PDO::PARAM_STR);
    $stmt->bindValue(6, $DadosEstabelecimentos['imagem'], PDO::PARAM_STR);
    $stmt->bindValue(7, $ID, PDO::PARAM_INT);
    $stmt->bindValue(8, $_SESSION['id_empresa']);

    if($stmt->rowCount()){
        exit("Estabelecimento invalido, não devias mexer nas coisas dos outros.");
    }

    return $stmt->execute();
}

function ApagarEstabelecimento($id_estabelecimento)
{
    global $pdo;

    $sql = "DELETE FROM Estabelecimentos WHERE id_estabelecimento = ? AND id_empresa = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $id_estabelecimento, PDO::PARAM_INT);
    $stmt->bindValue(2, $_SESSION['id_empresa'], PDO::PARAM_INT);
    
    return $stmt->execute();
}
