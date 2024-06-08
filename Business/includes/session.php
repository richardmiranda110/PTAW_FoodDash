<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
ini_set('session.use_cookies', '1');
if (!isset($_SESSION))
  {
    session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'httponly' => true,
    'samesite' => 'Strict' // Helps mitigate CSRF attacks
    ]);
    session_start();
}

// // Verificar se o usuário está logado
// if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
//     header("Location: /Business/login_register/login_business.php");
//     exit();
//   }

if (!isset($_SESSION['user_ip']) && !isset($_SESSION['user_agent']) || !isset($_SESSION['authenticated'])) {
    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
} else {
    if ($_SESSION['user_ip'] !== $_SERVER['REMOTE_ADDR'] ||
        $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_unset();     // potential session hijack
        session_destroy();
    }
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable
    session_destroy();   // destroy session data
}
$_SESSION['last_activity'] = time(); // update last activity time stamp