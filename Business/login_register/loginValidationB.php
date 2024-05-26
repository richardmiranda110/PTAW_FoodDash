<?php
require_once  __DIR__."./../includes/session.php";

require_once '../../database/credentials.php';
require_once '../../database/db_connection.php';

$email = $_POST['inputEmail'];
$pass = $_POST['inputPassword'];

try {
    $stmt = $pdo->prepare("SELECT emp.id_empresa,est.id_estabelecimento, emp.nome,emp.password as password, emp.morada, emp.telemovel, emp.email as email, emp.tipo, emp.logotipo 
    FROM empresas emp 
    left join estabelecimentos est
    on emp.id_empresa = est.id_empresa WHERE emp.email = ? AND emp.password = ?;");
    $stmt->execute([$email,$pass]);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row) {
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['id_empresa'] = $row['id_empresa'];
        $_SESSION['id_estabelecimento'] = $row['id_estabelecimento'];
        $_SESSION["authenticatedB"] = true;
        $_SESSION['success_message'] = "Logado com sucesso"; // Mensagem para testar, apagar depois
        header('Location:  /Business/dashboard_home_page.php');

        // Alterar location depois
        // header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else if($pass != 'password' || $email != 'email') {
        $_SESSION['stats_fail'] = true;
        $_SESSION['error_message'] = "Email ou password errados!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} catch(PDOException $e) {
    echo "Erro ao autenticar: " . $e->getMessage();
}
