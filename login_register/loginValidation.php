<?php
session_start();

require_once '../database/db_connection.php';

$email = $_POST['inputEmail'];
$pass = $_POST['inputPassword'];

try {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = :email AND password = :pass");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $pass);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row) {
        $_SESSION["authenticated"] = true;
        $_SESSION["name"] = $row['nome'];
        $_SESSION["id_cliente"] = $row['id_cliente'];
        // $_SESSION['success_message'] = "Logado com sucesso"; // Mensagem para testar, apagar depois
        // Alterar location depois
        header('Location: /../dashboard.php');
        exit;
    } else if($pass != 'password' || $email != 'email') {
        $_SESSION['stats_fail'] = true;
        $_SESSION['error_message'] = "Email ou password errados!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
} catch(PDOException $e) {
    echo "Erro ao autenticar: " . $e->getMessage();
}