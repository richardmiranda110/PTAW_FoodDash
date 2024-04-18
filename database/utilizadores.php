<?php
function criarConta($pdo, $nome, $email, $morada, $telemovel, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Clientes (nome, email, morada, telemovel, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $morada, $telemovel, $hash]);
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