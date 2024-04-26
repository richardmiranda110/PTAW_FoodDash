<?php
function criarConta($pdo, $nome, $email, $morada, $telemovel, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Clientes (nome, email, morada, telemovel, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $morada, $telemovel, $hash]);
}

function ObterUmUtilizador($ID)
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

function iniciarSessao($pdo, $email, $password) {
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