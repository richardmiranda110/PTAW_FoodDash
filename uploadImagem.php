<?php
require_once __DIR__ . '/database/credentials.php';
require_once __DIR__ . '/database/db_connection.php';
session_start();

header('Content-type: application/json');
$status = "error";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $message = "Tipo de dados tem que ser POST";
    echo json_encode(getMsgImagem($status, $message));
    //header("Location: editar_estabelecimento.php");
    exit();
}

if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] != UPLOAD_ERR_OK) {
    $erroImagem = "Erro ao carregar o ficheiro.";
    $_SESSION['erroImagem'] = $erroImagem;
    //header("Location: editar_estabelecimento.php");
    exit();
}

// Define variáveis
$target_dir = ".";
$imageFileType = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));
$currentTimestamp = str_replace(" ", "", date("D M j G"));
$target_file = $target_dir . '/' . $currentTimestamp . '_' . basename($_FILES["imagem"]["name"]);
$checkFileSize = getimagesize($_FILES["imagem"]["tmp_name"]);

if ($checkFileSize == false) {
    $erroImagem = getMsgImagem($status, "O Ficheiro nao é uma imagem.");
    $_SESSION['erroImagem'] = $erroImagem['message'];
    //header("Location: editar_estabelecimento.php");
    exit(1);
}

if (file_exists($target_file)) {
    $erroImagem = getMsgImagem($status, "O ficheiro já existe");
    $_SESSION['erroImagem'] = $erroImagem['message'];
    //header("Location: editar_estabelecimento.php");
    exit(2);
}

if ($_FILES["imagem"]["size"] > 500000) {
    $erroImagem = getMsgImagem($status, "Ficheiro demasiado grande.");
    $_SESSION['erroImagem'] = $erroImagem['message'];
    //header("Location: editar_estabelecimento.php");
    exit(3);
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $erroImagem = getMsgImagem($status, "Apenas permitido ficheiros do tipo JPG, JPEG, PNG.");
    $_SESSION['erroImagem'] = $erroImagem['message'];
    //header("Location: editar_estabelecimento.php");
    exit(4);
}

$moveOperationSuccess = move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);
if ($moveOperationSuccess == false) {
    $erroImagem = getMsgImagem($status, "Ocorreu um erro a carregar o ficheiro.");
    $_SESSION['erroImagem'] = $erroImagem['message'];
    //header("Location: editar_estabelecimento.php");
    exit(5);
}

$status = "success";
$message = "Imagem carregada com sucesso";
echo json_encode(getMsgImagem($status, $message, basename($target_file)));

function getMsgImagem($status, $message, $extra = null) {
    if ($extra == null) {
        return ["status" => $status, "message" => $message];
    }

    return ["status" => $status, "message" => $message, "url" => $extra];
}
