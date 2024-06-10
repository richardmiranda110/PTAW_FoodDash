<?php
require_once __DIR__ .'/../session.php';
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idForm'] == 'insertPedido') {
		$idProd = isset($_POST['idProd']) ? intval($_POST['idProd']) : null;
		$totalPedido = isset($_POST['valuePedido']) ? floatval($_POST['valuePedido']) : null;
		$idCliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : null;
		$idEmpresa = isset($_POST['idEmpresa']) ? intval($_POST['idEmpresa']) : null;
		$idEntregador = isset($_POST['idEntregador']) ? intval($_POST['idEntregador']) : 1;


        // Obtém os dados do formulário e garante que não estão vazios
        $idPedido = isset($_POST['idPedido']) ? intval($_POST['idPedido']) : null;
        $idProd = isset($_POST['idProd']) ? intval($_POST['idProd']) : null;
		$itens = [];
        $itens = isset($_POST['itens']) ? $_POST['itens'] : [];
		$opcoes = [];
        $opcoes = isset($_POST['opcoes']) ? $_POST['opcoes'] : [];
		$totalPedido = isset($_POST['valuePedido']) ? floatval($_POST['valuePedido']) : null;
        $idCliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : null;
        $idEmpresa = isset($_POST['idEmpresa']) ? intval($_POST['idEmpresa']) : null;
        $idEntregador = isset($_POST['idEntregador']) ? intval($_POST['idEntregador']) : 1;

        // Atualiza os dados na base de dados
        if (empty($idPedido)) {

            $stmt = $pdo->prepare("INSERT INTO pedidos (data, estado, cancelado, precototal, id_cliente, id_entregador, id_empresa)
                                   VALUES (NOW(), 'EM CHECKOUT', false, :preco, :idCliente, :idEntregador, :idEmpresa) RETURNING id_pedido");

            $stmt->bindParam(':preco', $totalPedido);
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->bindParam(':idEntregador', $idEntregador);
            $stmt->bindParam(':idEmpresa', $idEmpresa);
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
				$idmenu = isset($_POST['idmenu_'. $id_item]) ? $_POST['idmenu_'. $id_item] : 0;
				
				if ($_POST['idmenu_'. $id_item] == 0 ) {
					$stmt = $pdo->prepare("INSERT INTO pedido_itens (id_pedido, id_item, quantidade)
									   VALUES (:idpedido, :idProd, :quantidade) RETURNING id_pedido_item");
					$stmt->bindParam(':idpedido', $idPedido);
					$stmt->bindParam(':idProd', $itemid);
					$stmt->bindParam(':quantidade', $quantidade);
				} else {
						$stmt = $pdo->prepare("INSERT INTO pedido_itens (id_pedido, id_item, quantidade, id_menu)
									   VALUES (:idpedido, :idProd, :quantidade, :idmenu) RETURNING id_pedido_item");
						$stmt->bindParam(':idpedido', $idPedido);
						$stmt->bindParam(':idProd', $itemid);
						$stmt->bindParam(':quantidade', $quantidade);
						$stmt->bindParam(':idmenu', $idmenu);
				}
				
				
				$stmt->execute();

				// Obter o ID do registro pedido_itens
				$idPedidoItem = $stmt->fetchColumn();

				//$opcoes = $_POST['opcoes'];					
				foreach ($opcoes as $id_opcao) {
					if ($itemid === $_POST['itemop_'. $id_opcao]) {
						
						$idOpcao = intval($_POST['opcao_'. $id_opcao]);
						$qtdOpcao = intval($_POST['quantidadeop_'. $id_opcao]);

						$stmt = $pdo->prepare("INSERT INTO pedido_item_opcoes (id_pedido_item, id_opcao, quantidade)
											   VALUES (:idPedidoItem, :id_opcao, :qtd)");
						$stmt->bindParam(':idPedidoItem', $idPedidoItem);
						$stmt->bindParam(':id_opcao', $idOpcao);
						$stmt->bindParam(':qtd', $qtdOpcao);
						
						$stmt->execute();		
					}					
				}
			}
            $itens = null;
			$opcoes = null;
			
            echo "<div class='alert alert-success' role='alert'> Item Adicionado ao pedido nº.".$idPedido."
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>";
        }
   
	}
} catch(PDOException $e) {
    echo "
    <div class='alert alert-danger' role='alert'> Erro ao processar o pedido: " . $e->getMessage() . "
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
}
?>
