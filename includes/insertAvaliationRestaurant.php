<?php
require_once 'database/credentials.php';
require_once 'database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    sdasawfafefef
    // Obtém os dados do formulário
    $estrelas = intval($_POST['estrelas']);
    $comentario = $conn->real_escape_string($_POST['comentario']);

    try {
    $stmt = $pdo->prepare("INSERT INTO avaliacoes (classificacao, data, descricao, id_cliente, id_estabelecimento) 
    VALUES (:classificacao, :data, :descricao, :id_cliente, :id_estabelecimento)");
    $stmt->bindParam(':classificacao', $_POST['classificacao']);
    $stmt->bindParam(':data', date('Y-m-d H:i:s'));
    $stmt->bindParam(':descricao', $_POST['input_text_comentario']);
    $stmt->bindParam(':id_cliente', $_POST['idCliente']);
    $stmt->bindParam(':id_estabelecimento', $_POST['idEstabelecimento']);
    $stmt->execute();

    echo "<br><div class='alert alert-success' role='alert'> Avaliaçáo Enviada.</div>";

    } catch(PDOException $e) {
        echo "Erro ao inserir registro: " . $e->getMessage();
        echo "<br><div class='alert alert-success' role='alert'> Avaliaçáo Enviada.</div>";
    }


    $conn->close();
}
?>
