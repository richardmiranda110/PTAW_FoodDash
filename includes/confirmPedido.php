<?php
require_once __DIR__ .'/../session.php';
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idForm'] == 'checkoutForm') {
	
        // Obtém os dados do formulário e garante que não estão vazios
		$pedidos = isset($_POST['pedidos']) ? $_POST['pedidos'] : [];
		$restaurantes = isset($_POST['restaurantes']) ? $_POST['restaurantes'] : [];
		$restPedidos = isset($_POST['restPedidos']) ? $_POST['restPedidos'] : [];

		$errors = [];

		if (empty($pedidos)) {
			$errors[] = 'Não tem pedidos para concluir.';
		}


		if (empty($restaurantes)) {
			$errors[] = 'Não tem o(s) restaurante(s) selecionado(s).';
		}
		
		foreach ($restaurantes as $rest) {
			$isRest = $_POST['estabelecimento_'. $rest];
			
			if ($isRest == 0) {
				$errors[] = 'Não tem o(s) restaurante(s) selecionado(s).';
				break;
			}
				
		}

		if (!empty($errors)) {
			echo "
			<div class='alert alert-danger' role='alert'>" . implode('\n', $errors) . "
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			  </button>
			</div>";
		}
		else {	
        // Atualiza os dados na base de dados
		foreach ($pedidos as $pedido) {
			$idPedido = intval($_POST['id_pedido_'. $pedido]);
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
	
		foreach ($restaurantes as $rest) {
			//$isRest = $_POST['estabelecimento_'. $rest];
			$isRest = $_POST['idRestaurante_'. $rest];
			$idPedidos = $_POST['pedidosRestaurante_'. $rest];
			$array = explode('||', $idPedidos);
			
			foreach ($array as $idpedido) {
				$stmt = $pdo->prepare("UPDATE pedidos SET id_empresa = :idEmpresa WHERE id_pedido = :idpedido");
				$stmt->bindParam(':idpedido', $idPedido); 
				$stmt->bindParam(':idEmpresa', $isRest); 				
				$stmt->execute();
			}
			
		}
	}
} catch(PDOException $e) {
    echo "
    <div class='alert alert-danger' role='alert'> Erro ao processar pedidos: " . $e->getMessage() . "
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
}
?>
