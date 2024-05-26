<?php

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome'])) {
    header("Location: /Business/login_register/login_business.php");
    exit();
  }

function ObterEmpresa($pdo, $ID)
{
    if($ID != $_SESSION['id_empresa']){
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

// Altera os dados do utilizador, mas não a password
function EditarEmpresa($pdo, $ID, $DadosUtilizadores)
{
    if($ID != $_SESSION['id_empresa']){
        exit("You cant Edit other people's companies!");
    }

    $sql = "UPDATE Empresas SET nome = ?, morada = ?, telemovel = ?,
    email = ?, tipo = ?, logotipo = ?, WHERE id_empresa = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosUtilizadores['nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosUtilizadores['morada'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosUtilizadores['telemovel'], PDO::PARAM_STR);
    $stmt->bindValue(4, $DadosUtilizadores['email'], PDO::PARAM_STR);
    $stmt->bindValue(5, $DadosUtilizadores['tipo'], PDO::PARAM_STR);
    $stmt->bindValue(6, $DadosUtilizadores['logotipo'], PDO::PARAM_STR);
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

function ObterEstabelecimento($pdo, $ID)
{
    if($ID != $_SESSION['id_empresa']){
        exit("You cant access other people's Establishment!");
    }
    try {
        $sql = "SELECT * FROM Estabelecimentos WHERE id_estabelecimento = ?";
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

// Altera os dados do utilizador, mas não a password
function EditarEstabelecimento($pdo, $ID, $DadosUtilizadores)
{
    if($ID != $_SESSION['id_empresa']){
        exit("You cant edit other people's Establishment!");
    }

    $sql = "UPDATE Estabelecimentos SET nome = ?, localizacao = ?, telemovel = ?,
    taxa_entrega = ?, tempo_medio_entrega = ?, imagem = ?
    WHERE id_estabelecimento = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosUtilizadores['nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosUtilizadores['localizacao'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosUtilizadores['telemovel'], PDO::PARAM_STR);
    $stmt->bindValue(4, (float) $DadosUtilizadores['taxa_entrega'], PDO::PARAM_STR); // Cast to float
    $stmt->bindValue(5, $DadosUtilizadores['tempo_medio_entrega'], PDO::PARAM_STR); // Should be a valid time string
    $stmt->bindValue(6, $DadosUtilizadores['imagem'], PDO::PARAM_STR);
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
