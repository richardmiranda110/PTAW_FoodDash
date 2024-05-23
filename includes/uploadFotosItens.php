<?php
require_once 'database/credentials.php';
require_once 'database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = ".";
    $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $timestamp = time();
    $target_file = $target_dir . $timestamp . '_' . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;

    // Verificar se o arquivo é uma imagem real
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
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
    if ($_FILES["foto"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                try {

                    $stmt = $pdo->prepare("INSERT INTO itens (nome, preco, descricao, disponivel, foto, itemsozinho, personalizacoesativas, id_categoria, id_estabelecimento) 
                    VALUES (:nome, :preco, :descricao, :disponivel, :foto, :itemsozinho, :personalizacoesativas, :idcategoria, :idestabelecimento)");
                    $stmt->bindParam(':nome', $_POST['nome']);
                    $stmt->bindParam(':preco', $_POST['preco']);
                    $stmt->bindParam(':descricao', $_POST['descricao']);
                    $stmt->bindParam(':disponivel', $_POST['disponivel']);
                    $stmt->bindParam(':foto', htmlspecialchars(basename($target_file)));
                    $stmt->bindParam(':itemsozinho', $_POST['itemsozinho']);
                    $stmt->bindParam(':personalizacoesativas', $_POST['inputName']);
                    $stmt->bindParam(':idcategoria', $_POST['idcategoria']);
                    $stmt->bindParam(':idestabelecimento', $_POST['idestabelecimento']);
                    $stmt->execute();

                } catch(PDOException $e) {
                    echo "Erro ao inserir registro: " . $e->getMessage();
                }

            echo "<br><div class='alert alert-success' role='alert'> O item " . htmlspecialchars(basename($_FILES["foto"]["name"])) . " foi carregado.</div>";
            echo "<script>submitJsonData(".$target_file.")</script>";   
        } else {
            echo "<br><div class='alert alert-danger' role='alert'> Ocorreu um erro a carregar o ficheiro.</div>";
        }
    }
}
?>