<?php
session_start();

require_once '../database/db_connection.php';

$name = $_POST['inputName'];
$morada = $_POST['inputMorada'];
$email = $_POST['inputEmail'];
$pass = $_POST['inputPassword'];
$repetirpass = $_POST['inputRepetirPassword'];

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $_SESSION['error_message'] = "O e-mail já existe!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, morada, password) VALUES (:nome, :email, :morada, :palavrachave)");
    $stmt->bindParam(':nome', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':morada', $morada);
    $stmt->bindParam(':palavrachave', $pass);
    $stmt->execute();

    $_SESSION['success_message'] = "Registado com sucesso!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch(PDOException $e) {
    echo "Erro ao inserir registo: " . $e->getMessage();
}
?>