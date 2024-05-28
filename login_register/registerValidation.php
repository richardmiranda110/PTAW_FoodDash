<?php
require_once __DIR__.'/../session.php';

if (isset($_SESSION['authenticated'])) {
  header("Location: /dashboard.php");
  exit();
}

require_once __DIR__.'/../database/db_connection.php';

$name = $_POST['inputName'];
$apelido = $_POST['inputApelido'];
$morada = $_POST['inputMorada'];
$cp = $_POST['inputCP'];
$cidade = $_POST['inputCidade'];
$tele = $_POST['inputTele'];
$email = $_POST['inputEmail'];
$pass = $_POST['inputPassword'];
$repetirpass = $_POST['inputRepetirPassword'];

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    $salt = '$2y$10$' . bin2hex(random_bytes(22));
    $hashedPass = crypt($pass, $salt);

    if ($count > 0) {
        $_SESSION['error_message'] = "O e-mail já existe!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO clientes (nome, apelido, email, telemovel, morada, cidade, codpostal, password) VALUES (:nome, :apelido, :email, :telemovel, :morada, :cidade, :codpostal, :palavrachave)");
    $stmt->bindParam(':nome', $name);
    $stmt->bindParam(':apelido', $apelido);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telemovel', $tele);
    $stmt->bindParam(':morada', $morada);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':codpostal', $cp);
    $stmt->bindParam(':palavrachave', $hashedPass);
    $stmt->execute();

    $_SESSION['success_message'] = "Registado com sucesso!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch(PDOException $e) {
    echo "Erro ao inserir registo: " . $e->getMessage();
}
?>