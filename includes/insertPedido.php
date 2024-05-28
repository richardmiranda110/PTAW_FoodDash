<?php
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idForm'] == 'insertPedido') {

        // Obtém os dados do formulário e garante que não estão vazios
        $idPedido = isset($_POST['idPedido']) ? intval($_POST['idPedido']) : null;
        $idProd = isset($_POST['idProd']) ? intval($_POST['idProd']) : null;
        $complemento = isset($_POST['complemento']) ? intval($_POST['complemento']) : null;
        $bebida = isset($_POST['bebida']) ? intval($_POST['bebida']) : null;
        $extra = isset($_POST['extra']) ? intval($_POST['extra']) : null;
        $preco = isset($_POST['preco']) ? floatval($_POST['preco']) : 0.0;
        $idCliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : null;
        $idEstabelecimento = isset($_POST['idEstabelecimento']) ? intval($_POST['idEstabelecimento']) : null;
        $idEntregador = isset($_POST['idEntregador']) ? intval($_POST['idEntregador']) : 1;

        // Atualiza os dados na base de dados
        if (empty($idPedido)) {

            $stmt = $pdo->prepare("INSERT INTO pedidos (data, estado, cancelado, precototal, id_cliente, id_entregador, id_estabelecimento)
                                   VALUES (NOW(), 'EFETUADO', false, :preco, :idCliente, :idEntregador, :idEstabelecimento) RETURNING id_pedido");
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->bindParam(':idEntregador', $idEntregador);
            $stmt->bindParam(':idEstabelecimento', $idEstabelecimento);

            $stmt->execute();

            // Obter o ID do registro inserido
            $idPedido = $stmt->fetchColumn();

        } else {
            $stmt = $pdo->prepare("UPDATE pedidos SET precototal = :preco WHERE id_pedido = :idpedido");
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':idpedido', $idPedido);
            
            $stmt->execute();
        }

        if (!empty($idPedido)){

            // Preenche tabela pedido_itens
            $stmt = $pdo->prepare("INSERT INTO pedido_itens (id_pedido, id_item, quantidade)
                                   VALUES (:idpedido, :idProd, 1) RETURNING id_pedido_item");
            $stmt->bindParam(':idpedido', $idPedido);
            $stmt->bindParam(':idProd', $idProd);
            
            $stmt->execute();

            // Obter o ID do registro pedido_itens
            $idPedidoItem = $stmt->fetchColumn();


            // Preenche tabela pedido_item_opcoes - complemento
            if (!empty($complemento)) {
                $stmt = $pdo->prepare("INSERT INTO pedido_item_opcoes (id_pedido_item, id_opcao, quantidade)
                                       VALUES (:idPedidoItem, :id_opcao, :qtd)");
                $stmt->bindParam(':idPedidoItem', $idPedidoItem);
                $stmt->bindParam(':id_opcao', $complemento);
                $qtd = 1;
                $stmt->bindParam(':qtd', $qtd, PDO::PARAM_INT);
                
                $stmt->execute();
            }

            // Preenche tabela pedido_item_opcoes - bebida
            if (!empty($bebida)) {
                $stmt = $pdo->prepare("INSERT INTO pedido_item_opcoes (id_pedido_item, id_opcao, quantidade)
                                       VALUES (:idPedidoItem, :id_opcao, :qtd)");
                $stmt->bindParam(':idPedidoItem', $idPedidoItem);
                $stmt->bindParam(':id_opcao', $bebida);
                $stmt->bindParam(':qtd', $qtd, PDO::PARAM_INT);
                
                $stmt->execute();
            }

            // Preenche tabela pedido_item_opcoes - extras
            if (!empty($extra)) {
                $stmt = $pdo->prepare("INSERT INTO pedido_item_opcoes (id_pedido_item, id_opcao, quantidade)
                                       VALUES (:idPedidoItem, :id_opcao, :qtd)");
                $stmt->bindParam(':idPedidoItem', $idPedidoItem);
                $stmt->bindParam(':id_opcao', $extra);
                $stmt->bindParam(':qtd', $qtd, PDO::PARAM_INT);
                
                $stmt->execute();
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
