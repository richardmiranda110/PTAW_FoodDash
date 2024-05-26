<?php
require_once  __DIR__."/include/session.php";

if (isset($_SESSION['authenticatedB'])) {
  header("Location: /Business/dashboard_home_page.php");
  exit();
}

require_once '../../database/credentials.php';
require_once '../../database/db_connection.php';

$email = $_POST['inputEmail'];
$pass = $_POST['inputPassword'];

try {
    $stmt = $pdo->prepare("SELECT * FROM empresas WHERE email = :email AND password = :pass");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $pass);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row) {
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['id_empresa'] = $row['id_empresa'];
        $_SESSION['id_estabelecimento'] = $row['id_estabelecimento'];
        $_SESSION["authenticatedB"] = true;
        header('Location:  /Business/dashboard_home_page.php');
        // $_SESSION['success_message'] = "Logado com sucesso"; // Mensagem para testar, apagar depois
        // Alterar location depois
        // header('Location: ' . $_SERVER['HTTP_REFERER']);
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
