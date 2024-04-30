<?php
function criarConta($pdo, $nome, $email, $morada, $telemovel, $password)
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Clientes (nome, apelido, email, telemovel, morada, cidade, pais, CodPostal, password)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $morada, $telemovel, $hash]);
}

function ObterUmUtilizador2($pdo, $ID)
{
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
}

function EditarUtilizador($pdo, $ID, $DadosUtilizadores)
{
    $sql = "UPDATE utilizadores SET Nome = ?, Apelido = ?, Email = ?, PMorada = ?, Telemovel = ?, 
    Password = ?, Telemovel = ?, NIF = ?, Morada = ?, CodPostal = ?, Localidade = ?, 
    Porta = ?, EstadoConta = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $DadosUtilizadores['Nome'], PDO::PARAM_STR);
    $stmt->bindValue(2, $DadosUtilizadores['Apelido'], PDO::PARAM_STR);
    $stmt->bindValue(3, $DadosUtilizadores['Email'], PDO::PARAM_STR);
    $stmt->bindValue(4, (int) $DadosUtilizadores['Telemovel'], PDO::PARAM_INT);
    $stmt->bindValue(5, $DadosUtilizadores['Morada'], PDO::PARAM_STR);
    $stmt->bindValue(6, $DadosUtilizadores['Cidade'], PDO::PARAM_STR);
    $stmt->bindValue(7, $DadosUtilizadores['Pais'], PDO::PARAM_STR);
    $stmt->bindValue(8, $DadosUtilizadores['CodPostal'], PDO::PARAM_STR);
    $stmt->bindValue(9, $DadosUtilizadores['Morada'], PDO::PARAM_STR);
    $stmt->bindValue(10, $ID, PDO::PARAM_INT);

    // Executar a query e verificar que não retornou false
    if ($stmt->execute()) {
        // A operação foi executada com sucesso
        $sucesso = True;
    }

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