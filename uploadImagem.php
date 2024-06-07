<?php
// diretorio a colocar a imagem
$target_dir = '/home/ptaw-2024-gr2/public_html';
// colocar em letras pequenas
$imageFileType = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));
// colocar data á frente
$currentTimestamp = str_replace(" ", "", date("D M j G"));
// obter link para a imagem
$target_file = $target_dir . '/' . $currentTimestamp . '_' . basename($_FILES["imagem"]["name"]);
// obtem tamanho de imagem
$checkFileSize = getimagesize($_FILES["imagem"]["tmp_name"]);
// se o tamanho da imagem não for valido para o tamanho do ficheiro
if ($checkFileSize == false) {
    $_SESSION['erroImagem'] = "O Ficheiro nao é uma imagem.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
// se já existe, dá o link
if (file_exists($target_file)) {
    $caminhoArquivo = basename($target_file);
} else{
    // verifica se é uma imagem demasiado grande
    if ($_FILES["imagem"]["size"] > 500000) {
        $_SESSION['erroImagem'] = "Ficheiro demasiado grande.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    // verifica o tipo de ficheiro
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION['erroImagem'] = "Apenas permitido ficheiros do tipo JPG, JPEG, PNG.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    ini_set("display_errors", "1");
    error_reporting(E_ALL);
    // move o ficheiro para o lugar certo
    $moveOperationSuccess = move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);

    if ($moveOperationSuccess == false) {
        $_SESSION['erroImagem'] = "Ocorreu um erro a carregar o ficheiro.  ".  $_FILES["imagem"]["tmp_name"];
        ini_set("display_errors", "1");
        error_reporting(E_ALL);
        exit();
    }
    // coloca o link numa variavel
    $caminhoArquivo = basename($target_file);
}
