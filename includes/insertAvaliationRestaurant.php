<?php
require_once __DIR__.'../database/credentials.php';
require_once __DIR__.'../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idForm'] == 'insertAvaliation') {
    // Obtém os dados do formulário e garante que não estão vazios
    $estrelas = isset($_POST['estrelas']) ? intval($_POST['estrelas']) : null;
    $comentario = isset($_POST['input_text_comentario']) ? $_POST['input_text_comentario'] : '';
    $id_cliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : null;
    $id_estabelecimento = isset($_POST['idEstabelecimento']) ? intval($_POST['idEstabelecimento']) : null;

    if ($estrelas === null || $id_cliente === null || $id_estabelecimento === null) {
        echo "<div class='alert alert-danger' role='alert'> Erro: Todos os campos obrigatórios devem ser preenchidos.
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			  </button>
			</div>";

        exit;
    }

    try {
        // Verificar se o cliente já avaliou o estabelecimento
        $stmt = $pdo->prepare("SELECT * FROM avaliacoes WHERE id_cliente = :id_cliente AND id_estabelecimento = :id_estabelecimento");
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_estabelecimento', $id_estabelecimento);
        $stmt->execute();
        $avaliacao_existente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($avaliacao_existente) {
			echo "<div class='alert alert-danger' role='alert'> Já avaliou este Restaurante!
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				  </button>
				</div>";
        } else {
            // Insere os dados na base de dados
            $stmt = $pdo->prepare("INSERT INTO avaliacoes (classificacao, data, descricao, id_cliente, id_estabelecimento) 
            VALUES (:classificacao, now(), :descricao, :id_cliente, :id_estabelecimento)");
            $stmt->bindParam(':classificacao', $estrelas);
            $stmt->bindParam(':descricao', $comentario);
            $stmt->bindParam(':id_cliente', $id_cliente);
            $stmt->bindParam(':id_estabelecimento', $id_estabelecimento);
            $stmt->execute();

            echo "<div class='alert alert-success' role='alert'> Avaliação Enviada.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			  </button>
			</div>";
        }

    } catch(PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'> Erro a enviar Avaliação.". $e->getMessage()."
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			  </button>
			</div>";
    }
}
?>
