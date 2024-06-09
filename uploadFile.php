<?php
require_once __DIR__.'/database/credentials.php';
require_once __DIR__.'/database/db_connection.php';

header('Content-type: application/json');
$status = "error";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $message = "Tipo de dados tem que ser POST";
    echo json_encode( getReturnMessage($status,$message));
}

// define variaveis 
$target_dir = "/home/ptaw-2024-gr2/public_html/assets/stock_imgs";
// coloca o nome do ficheiro em minusculas
$imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
$currentTimestamp = str_replace(" ", "",date("D M j G")); 
// obtem nome e diretorio do ficheiro
$target_file = $target_dir . '/' . $currentTimestamp . '_' . basename($_FILES["foto"]["name"]);
// obtem tamanho do ficheiro
$checkFileSize = getimagesize($_FILES["foto"]["tmp_name"]);

// se não for possivel obter tamanho de ficheiro
if ($checkFileSize == false) {
    $message = "O Ficheiro nao e uma imagem.";
    echo json_encode(getReturnMessage($status,$message));
    exit(1);
} 

if (file_exists($target_file)) {
    $message = "O ficheiro ja existe";
    echo json_encode(getReturnMessage($status,$message,basename($target_file)));
    exit(2);
}

// tamanho limite de ficheiro -> 500 mb 
if ($_FILES["foto"]["size"] > 500000) {
    $message =  "Ficheiro demasiado grande.";
    echo json_encode(getReturnMessage($status,$message));
    exit(3);
}

// verifica tipo de imagem
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $message = "Apenas permitido ficheiros do tipo JPG, JPEG, PNG.";
    echo json_encode(getReturnMessage($status,$message));
    exit(4);
}

// move ficheiro para diretorio correto
$moveOperationSuccess = move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
// se não foi possivel mover o ficheiro
if ($moveOperationSuccess == false) {
    ini_set("display_errors", "1");
    error_reporting(E_ALL);
    // $message = "Ocorreu um erro a carregar o ficheiro.";
    // echo json_encode(getReturnMessage($status,$message));
    // exit(5);
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