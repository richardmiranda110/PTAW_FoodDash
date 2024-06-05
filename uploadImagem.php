<?php
require_once __DIR__.'/database/credentials.php';
require_once __DIR__.'/database/db_connection.php';

header('Content-type: application/json');
$status = "error";
$erroImagem = "";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $message = "Tipo de dados tem que ser POST";
    echo json_encode( getReturnMessage($status,$message));
    header("Location: editar_estabelecimento.php");
    exit();
}


if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] != UPLOAD_ERR_OK) {
    $erroImagem = "Erro ao carregar o ficheiro.";
    $_SESSION['erroImagem'] = $erroImagem;
    header("Location: editar_estabelecimento.php");
    exit();
}

// define variaveis 
$target_dir = ".";
// coloca o nome do ficheiro em minusculas
$imageFileType = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));
$currentTimestamp = str_replace(" ", "",date("D M j G")); 
// obtem nome e diretorio do ficheiro
$target_file = $target_dir . '/' . $currentTimestamp . '_' . basename($_FILES["imagem"]["name"]);
// obtem tamanho do ficheiro
$checkFileSize = getimagesize($_FILES["imagem"]["tmp_name"]);

// se não for possivel obter tamanho de ficheiro
if ($checkFileSize == false) {
    //$message = "O Ficheiro nao é uma imagem.";
    //echo json_encode(getReturnMessage($status,$message));
    $erroImagem = "O Ficheiro nao é uma imagem.";
    $_SESSION['erroImagem'] = $erroImagem;
    exit(1);
} 

if (file_exists($target_file)) {
    //$message = "O ficheiro já existe";
    //echo json_encode(getReturnMessage($status,$message,basename($target_file)));
    $erroImagem = "O ficheiro já existe";
    $_SESSION['erroImagem'] = $erroImagem;
    exit(2);
}

// tamanho limite de ficheiro -> 500 mb 
if ($_FILES["imagem"]["size"] > 500000) {
    //$message = "Ficheiro demasiado grande.";
    //echo json_encode(getReturnMessage($status,$message));
    $erroImagem = "Ficheiro demasiado grande.";
    $_SESSION['erroImagem'] = $erroImagem;
    exit(3);
}

// verifica tipo de imagem
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    //$message = "Apenas permitido ficheiros do tipo JPG, JPEG, PNG.";
    //echo json_encode(getReturnMessage($status,$message));
    $erroImagem = "Apenas permitido ficheiros do tipo JPG, JPEG, PNG.";
    $_SESSION['erroImagem'] = $erroImagem;
    exit(4);
}

// move ficheiro para diretorio correto
$moveOperationSuccess = move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);
// se não foi possivel mover o ficheiro
if ($moveOperationSuccess == false) {
    //$message = "Ocorreu um erro a carregar o ficheiro.";
    //echo json_encode(getReturnMessage($status,$message));
    $erroImagem = "Ocorreu um erro a carregar o ficheiro.";
    $_SESSION['erroImagem'] = $erroImagem;
    exit(5);
}

$status = "success";
$message = "Imagem carregada com sucesso";
echo json_encode(getReturnMessage($status,$message,basename($target_file)));

function getReturnMessage($status,$message,$extra = null){
    if($extra == null){
        return ["status" => $status, "message" => $message];
    }

    return ["status" => $status, "message" => $message, "url" => $extra];
}