<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "/home/ptaw-2024-gr2/public_html/assets/stock_imgs/";
    $imageFileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
    $timestamp = time();
    $target_file = $target_dir . $timestamp . '_' . basename($_FILES["file"]["name"]);
    $uploadOk = 1;

    // Verificar se o arquivo é uma imagem real
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<br><div class='alert alert-danger' role='alert'> O Ficheiro não é uma imagem.</div>";
        $uploadOk = 0;
    }

    // Verificar se o arquivo já existe
    if (file_exists($target_file)) {
        echo "<br><div class='alert alert-danger' role='alert'> O ficheiro já existe.</div>";
        $uploadOk = 0;
    }

    // Verificar tamanho do arquivo
    if ($_FILES["file"]["size"] > 500000) {
        echo "<br><div class='alert alert-danger' role='alert'> Ficheiro demasiado grande.</div>";
        $uploadOk = 0;
    }

    // Permitir certos formatos de arquivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "<br><div class='alert alert-danger' role='alert'> Apenas é permitido ficheiros do tipo JPG, JPEG, PNG.".strtolower($imageFileType)."</div>";
        $uploadOk = 0;
    }

    // Verificar se $uploadOk está definido como 0 por um erro
    if ($uploadOk == 0) {
        echo "<br><div class='alert alert-danger' role='alert'> Ocorreram erros a validar o ficheiro.</div>";
    // Se tudo estiver ok, tentar fazer o upload do arquivo
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "<br><div class='alert alert-success' role='alert'> O ficheiro " . htmlspecialchars(basename($_FILES["file"]["name"])) . " foi carregado.</div>";
        } else {
            echo "<br><div class='alert alert-danger' role='alert'> Ocorreu um erro a carregar o ficheiro.</div>";
        }
    }
}
?>