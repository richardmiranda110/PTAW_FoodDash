<?php
require_once __DIR__ .'/../session.php';
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idForm'] != 'checkoutForm') {
		$idPedido = isset($_POST['id_toDelete']) ? intval($_POST['id_toDelete']) : null;
				
        // Atualiza os dados na base de dados
        if (!empty($idPedido)) {
          
            $stmt = $pdo->prepare("delete from pedidos WHERE id_pedido = :idpedido");
            $stmt->bindParam(':idpedido', $idPedido);
            
            $stmt->execute();
			
			echo "<div class='alert alert-success' role='alert'> Pedido nº ".$idPedido." removido do Carrinho
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>";
        }
	}
} catch(PDOException $e) {
    echo "<br>
    <div class='alert alert-danger' role='alert'> Erro ao processar o pedido: " . $e->getMessage() . "
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
}
?>
