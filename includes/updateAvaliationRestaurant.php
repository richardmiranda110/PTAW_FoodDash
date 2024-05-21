<?php
require_once 'database/credentials.php';
require_once 'database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtém os dados do formulário e garante que não estão vazios
    $id_avaliacao = isset($_POST['id_avaliacao']) ? intval($_POST['id_avaliacao']) : null;
    $estrelas = isset($_POST['estrelas']) ? intval($_POST['estrelas']) : null;
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';

    if ($id_avaliacao === null || $estrelas === null) {
        echo "<br><div class='alert alert-danger' role='alert'> Erro: Todos os campos obrigatórios devem ser preenchidos.</div>";
        exit;
    }

    try {
        // Atualiza os dados na base de dados
        $stmt = $pdo->prepare("UPDATE avaliacoes SET classificacao = :classificacao, descricao = :descricao, data = now() WHERE id = :id_avaliacao");
        $stmt->bindParam(':classificacao', $estrelas);
        $stmt->bindParam(':descricao', $comentario);
        $stmt->bindParam(':id_avaliacao', $id_avaliacao);
        $stmt->execute();

        echo "<br><div class='alert alert-success' role='alert'> Avaliação Atualizada.</div>";

    } catch(PDOException $e) {
        echo "<br>
        <div class='alert alert-danger' role='alert'> Erro ao atualizar Avaliação.". $e->getMessage()."
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
    }
}
?>
