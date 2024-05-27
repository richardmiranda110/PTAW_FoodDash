<?php
require_once __DIR__.'/../session.php'; 
require_once __DIR__.'/../database/db_connection.php';

$email = $_POST['inputEmail'];
$pass = $_POST['inputPassword'];

try {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row && hash_equals($row['password'], crypt($pass, $row['password']))) {
        $_SESSION["authenticated"] = true;
        $_SESSION["name"] = $row['nome'];
        $_SESSION["id_cliente"] = $row['id_cliente'];
        // $_SESSION['success_message'] = "Logado com sucesso"; // Mensagem para testar, apagar depois
        // Alterar location depois
        header('Location: ../dashboard.php');
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