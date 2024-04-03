<?php
// *** ADICONAR SDK GOOGLE / COMPOSER *****
require_once 'vendor/autoload.php'; // Caminho para o arquivo autoload.php fornecido pelo SDK do Google

session_start();

// Configurações do Google
$client = new Google_Client();
$client->setClientId('SEU_CLIENT_ID');
$client->setClientSecret('SEU_CLIENT_SECRET');
$client->setRedirectUri('../perfil_utilizador/dashboard_perfil_utilizador.php'); // URL para redirecionar após a autenticação
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL); // Escopo para obter o email do usuário

// Processo de autenticação
if (!isset($_GET['code'])) {
    // Se não houver código de autorização, redirecione para a página de login do Google
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    // Se o código de autorização estiver presente, troque-o pelo token de acesso
    $client->authenticate($_GET['code']);
    $token = $client->getAccessToken();

    // Armazenar o token de acesso na sessão ou em algum lugar seguro
    $_SESSION['access_token'] = $token;

    // Redirecionar para a página de perfil do usuário
    header('Location: ../perfil_utilizador/dashboard_perfil_utilizador.php');
}
?>
