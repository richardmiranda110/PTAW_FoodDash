<?php
require_once __DIR__ .'/../session.php';
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idForm'] == 'insertPedido') {
		$idProd = isset($_POST['idProd']) ? intval($_POST['idProd']) : null;
		$totalPedido = isset($_POST['valuePedido']) ? floatval($_POST['valuePedido']) : null;
		$idCliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : null;
		$idEstabelecimento = isset($_POST['idEstabelecimento']) ? intval($_POST['idEstabelecimento']) : null;
		$idEntregador = isset($_POST['idEntregador']) ? intval($_POST['idEntregador']) : 1;
//		$opcoes = isset($_POST['opcoes']) ? json_encode($_POST['opcoes']) : '[]';
//		$itens = isset($_POST['itens']) ? json_encode($_POST['itens']) : '[]';
/*
		$stmt = $pdo->prepare("SELECT inserir_pedido(:idPedido, :idProd, :totalPedido, :idCliente, :idEstabelecimento, :idEntregador, :opcoes, :itens)");
		$stmt->bindParam(':idPedido', $_SESSION['idPedido']);
		$stmt->bindParam(':idProd', $idProd);
		$stmt->bindParam(':totalPedido', $totalPedido);
		$stmt->bindParam(':idCliente', $idCliente);
		$stmt->bindParam(':idEstabelecimento', $idEstabelecimento);
		$stmt->bindParam(':idEntregador', $idEntregador);
		$stmt->bindParam(':opcoes', $opcoes);
		$stmt->bindParam(':itens', $itens);
		

		
		$stmt->execute();
		$idPedido = $stmt->fetchColumn();
		$_SESSION['idPedido'] = $idPedido;

		echo "<div class='alert alert-success' role='alert'> Item Adicionado ao pedido nº.".$_SESSION['idPedido']."
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>";

 */

        // Obtém os dados do formulário e garante que não estão vazios
        $idPedido = isset($_POST['idPedido']) ? intval($_POST['idPedido']) : null;
        $idProd = isset($_POST['idProd']) ? intval($_POST['idProd']) : null;
		$itens = [];
        $itens = isset($_POST['itens']) ? $_POST['itens'] : [];
		$opcoes = [];
        $opcoes = isset($_POST['opcoes']) ? $_POST['opcoes'] : [];
		$totalPedido = isset($_POST['valuePedido']) ? floatval($_POST['valuePedido']) : null;
        $idCliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : null;
        $idEstabelecimento = isset($_POST['idEstabelecimento']) ? intval($_POST['idEstabelecimento']) : null;
        $idEntregador = isset($_POST['idEntregador']) ? intval($_POST['idEntregador']) : 1;

		
        // Atualiza os dados na base de dados
        if (empty($idPedido)) {

            $stmt = $pdo->prepare("INSERT INTO pedidos (data, estado, cancelado, precototal, id_cliente, id_entregador, id_estabelecimento)
                                   VALUES (NOW(), 'EM CHECKOUT', false, :preco, :idCliente, :idEntregador, :idEstabelecimento) RETURNING id_pedido");

            $stmt->bindParam(':preco', $totalPedido);
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->bindParam(':idEntregador', $idEntregador);
            $stmt->bindParam(':idEstabelecimento', $idEstabelecimento);

            $stmt->execute();

            // Obter o ID do registro inserido
            $idPedido = $stmt->fetchColumn();

        } else {
            $stmt = $pdo->prepare("UPDATE pedidos SET precototal = :preco WHERE id_pedido = :idpedido");
            $stmt->bindParam(':preco', $totalPedido);
            $stmt->bindParam(':idpedido', $idPedido);
            
            $stmt->execute();
        }

        if (!empty($idPedido)){
			foreach ($itens as $id_item) {
				// Preenche tabela pedido_itens
				$itemid = $_POST['itemid_'. $id_item];
				$quantidade = $_POST['quantidade_'. $id_item];
				$preco = $_POST['preco_'. $id_item];
				$idmenu = $_POST['idmenu_'. $id_item];
				
				$stmt = $pdo->prepare("INSERT INTO pedido_itens (id_pedido, id_item, quantidade, id_menu)
									   VALUES (:idpedido, :idProd, :quantidade, :idmenu) RETURNING id_pedido_item");
				$stmt->bindParam(':idpedido', $idPedido);
				$stmt->bindParam(':idProd', $itemid);
				$stmt->bindParam(':quantidade', $quantidade);
				$stmt->bindParam(':idmenu', $idmenu);
				
				$stmt->execute();

				// Obter o ID do registro pedido_itens
				$idPedidoItem = $stmt->fetchColumn();

				//$opcoes = $_POST['opcoes'];						
				foreach ($opcoes as $id_opcao) {
					if ($itemid == $_POST['itemop_'. $id_opcao]) {
						
						$quant = 0;
						if (!isset($_POST['opcao_'. $id_opcao])){
							$quant = 1;
						}

						$stmt = $pdo->prepare("INSERT INTO pedido_item_opcoes (id_pedido_item, id_opcao, quantidade)
											   VALUES (:idPedidoItem, :id_opcao, :qtd)");
						$stmt->bindParam(':idPedidoItem', $idPedidoItem);
						$stmt->bindParam(':id_opcao', $id_opcao);
						$stmt->bindParam(':qtd', $quant);
						
						$stmt->execute();		
					}					
				}
			}
            
            echo "<div class='alert alert-success' role='alert'> Item Adicionado ao pedido nº.".$idPedido."
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
