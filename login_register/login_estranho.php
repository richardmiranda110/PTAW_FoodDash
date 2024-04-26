<?php
// Incluir o ficheiro de configuração
require_once("config.php");

// Iniciar Sessão
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['username'])) {
    header("Location: ../perfil_utilizador/dashboard_perfil_utilizador.php");
    exit();
}

// Verificar se o usuário está tentando fazer login com o Google
if (isset($_GET['google_login']) && $_GET['google_login'] == 1) {
    // Redirecionar para a página de autenticação do Google
    header("Location: google_login.php");
    exit();
}

// Verificar credenciais de login tradicional
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aqui você colocaria a lógica de verificação de credenciais
    // Por exemplo, verificar as credenciais no banco de dados
    // Executar uma consulta
    $query = "SELECT user, password FROM users";
    $result = executar_query($query);

    // Processar o resultado da consulta
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['user']; 
        $password = $row['username']; 
    }

    if ($_POST['username'] == $username && $_POST['password'] == $password) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: ../perfil_utilizador/dashboard_perfil_utilizador.php");
        exit();
    } else {
        $error = "Credenciais inválidas. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="submit" value="Login">
    </form>
    <p>Ou faça login com:</p>
    <a href="login.php?google_login=1">Google</a>
</body>
</html>
