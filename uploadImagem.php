<?php
// diretorio a colocar a imagem
$target_dir = ".";
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
    exit( "O Ficheiro nao é uma imagem.");
}
// se já existe, dá o link
if (file_exists($target_file)) {
    $caminhoArquivo = basename($target_file);
} else{
    // verifica se é uma imagem demasiado grande
    if ($_FILES["imagem"]["size"] > 500000) {
        exit("Ficheiro demasiado grande.");
    }
    // verifica o tipo de ficheiro
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        exit("Apenas permitido ficheiros do tipo JPG, JPEG, PNG.");
    }
    // move o ficheiro para o lugar certo
    $moveOperationSuccess = move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);
    if ($moveOperationSuccess == false) {
        exit("Ocorreu um erro a carregar o ficheiro.");
    }
}

// coloca o link numa variavel
$caminhoArquivo = basename($target_file);
