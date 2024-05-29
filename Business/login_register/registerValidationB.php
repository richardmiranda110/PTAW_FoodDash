<?php
require_once  __DIR__."/../includes/session.php";


if (isset($_SESSION['id_empresa']) || isset($_SESSION['nome'])) {
  header("Location: /Business/dashboard_home_page.php");
  exit();
}

require_once __DIR__.'/../../database/db_connection.php';

$name = $_POST['inputNomeEstab'];
$morada = $_POST['inputEndereco'];
$email = $_POST['inputEmail'];
$telemovel = $_POST['inputTel'];
$tipo = $_POST['tipo'];
$taxa = $_POST['inputTaxa'];
$tempo = $_POST['inputTempo'];
$pass = $_POST['inputPassword'];
$repetirpass = $_POST['inputRepetirPassword'];


try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM empresas WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    $salt = '$2y$10$' . bin2hex(random_bytes(22));
    $hashedPass = crypt($pass, $salt);

    if ($count > 0) {
        $_SESSION['error_message'] = "O e-mail já existe!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO empresas (nome, morada, email, telemovel, tipo, password) VALUES (:nome, :morada, :email, :telemovel, :tipo, :palavrachave)");
    $stmt->bindParam(':nome', $name);
    $stmt->bindParam(':morada', $morada);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telemovel', $telemovel);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':palavrachave', $hashedPass);
    $stmt->execute();

    $id_empresa = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO estabelecimentos (nome, localizacao, telemovel, taxa_entrega, tempo_medio_entrega, id_empresa) VALUES (:nome, :localizacao, :telemovel, :taxa_entrega, :tempo_medio_entrega, :id_empresa)");
    $stmt->bindParam(':nome', $name);
    $stmt->bindParam(':localizacao', $morada);
    $stmt->bindParam(':telemovel', $telemovel);
    $stmt->bindParam(':taxa_entrega', $taxa);
    $stmt->bindParam(':tempo_medio_entrega', $tempo);
    $stmt->bindParam(':id_empresa', $id_empresa);
    $stmt->execute();

    $pdo->commit();

    $_SESSION['success_message'] = "Registado com sucesso!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch(PDOException $e) {
    $pdo->rollBack();
    echo "Erro ao inserir registo: " . $e->getMessage();
}
