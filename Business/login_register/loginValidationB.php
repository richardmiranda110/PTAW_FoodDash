<?php
require_once  __DIR__."/../includes/session.php";

require_once __DIR__.'/../../database/credentials.php';
require_once __DIR__.'/../../database/db_connection.php';

$email = $_POST['inputEmail'];
$pass = $_POST['inputPassword'];

try {
    $stmt = $pdo->prepare("SELECT emp.id_empresa,est.id_estabelecimento, emp.nome,emp.password as password, emp.morada, emp.telemovel, emp.email as email, emp.tipo, emp.logotipo 
    FROM empresas emp 
    left join estabelecimentos est
    on emp.id_empresa = est.id_empresa WHERE emp.email = ?");
    $stmt->execute([$email]);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row && hash_equals($row['password'], crypt($pass, $row['password']))) {
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['id_empresa'] = $row['id_empresa'];
        $_SESSION['id_estabelecimento'] = $row['id_estabelecimento'];
        $_SESSION["authenticatedB"] = true;
        $_SESSION['success_message'] = "Logado com sucesso"; // Mensagem para testar, apagar depois

        if (isset($_POST['remember_email'])) {
            setcookie('remembered_email', $email, time() + (1 * 24 * 60 * 60), "/");
        } else {
            setcookie('remembered_email', '', time() - 3600, "/");
        }

        header('Location:  ../dashboard_home_page.php');

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
