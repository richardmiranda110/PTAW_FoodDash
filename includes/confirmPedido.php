<?php
require_once __DIR__ .'/../session.php';
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idForm'] == 'checkoutForm') {
	
        // Obtém os dados do formulário e garante que não estão vazios
		$pedidos = [];
        $pedidos = isset($_POST['pedidos']) ? $_POST['pedidos'] : [];
		$restaurantes = [];
        $restaurantes = isset($_POST['restaurantes']) ? $_POST['restaurantes'] : [];

        // Atualiza os dados na base de dados
		foreach ($pedidos as $pedido) {
			$idPedido = intval($_POST['id_pedido_'. $pedido]);
			echo($idPedido);
            $stmt = $pdo->prepare("UPDATE pedidos SET estado = 'EFETUADO' WHERE id_pedido = :idpedido");
            $stmt->bindParam(':idpedido', $idPedido);           
            $stmt->execute();
        } 
			
		echo "<div class='alert alert-success' role='alert'> Pedido(s) confirmado(s)
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
		  </button>
		</div>";
        }
  /* echo"passou";
   print_r($restaurantes);
		foreach ($restaurantes as $rest) {
			print_r($_POST['pedidosEmpresa_'.$rest]);
			$pedidosRest = $_POST['pedidosRestaurante_'. $id_item];
			print_r($pedidosRest);
		}
	}*/
} catch(PDOException $e) {
    echo "<br>
    <div class='alert alert-danger' role='alert'> Erro ao processar pedidos: " . $e->getMessage() . "
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
}
?>
