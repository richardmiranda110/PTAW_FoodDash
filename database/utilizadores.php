<?php
function criarConta($pdo, $nome, $email, $morada, $telemovel, $password)
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Clientes (nome, apelido, email, telemovel, morada, password)
        VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $morada, $telemovel, $hash]);
}

function ObterUmUtilizador($pdo, $ID)
{
    try {
        $sql = "SELECT * FROM Clientes WHERE id = ?";
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
function EditarUtilizador($pdo, $ID, $DadosUtilizadores)
{
    $sql = "UPDATE Clientes SET nome = ?, apelido = ?, email = ?,
    telemovel = ?, morada = ?, cidade = ?, pais = ?, CodPostal = ?
    WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosUtilizadores['nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosUtilizadores['apelido'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosUtilizadores['email'], PDO::PARAM_STR);
    $stmt->bindValue(4, (int) $DadosUtilizadores['telemovel'], PDO::PARAM_INT);
    $stmt->bindValue(5, $DadosUtilizadores['morada'], PDO::PARAM_STR);
    $stmt->bindValue(6, $DadosUtilizadores['cidade'], PDO::PARAM_STR);
    $stmt->bindValue(7, $DadosUtilizadores['pais'], PDO::PARAM_STR);
    $stmt->bindValue(8, $DadosUtilizadores['CodPostal'], PDO::PARAM_STR);
    $stmt->bindValue(9, $ID, PDO::PARAM_INT);

    // Executar a query e verificar que não retornou false
    if ($stmt->execute()) {
        // A operação foi executada com sucesso
        $sucesso = True;
    } else {
        $sucesso = False;
    }

    echo $sucesso;
    return $sucesso;

}

function iniciarSessao($pdo, $email, $password)
{
    $sql = "SELECT * FROM Clientes WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    if ($usuario && password_verify($password, $usuario['password'])) {
        // Falta definir condições de sessão
        return true;
    }
    return false;
}
?>