<?php
function realizarPedido($pdo, $id_cliente, $id_entregador, $id_estabelecimento, $precoTotal) {
    $sql = "INSERT INTO Pedidos (id_cliente, id_entregador, id_estabelecimento, precoTotal) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_cliente, $id_entregador, $id_estabelecimento, $precoTotal]);
}

function visualizarPedidosCliente($pdo, $id_cliente) {
    $sql = "SELECT * FROM Pedidos WHERE id_cliente = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_cliente]);
    return $stmt->fetchAll();
}

function rastrearPedido($pdo, $id_pedido) {
    $sql = "SELECT estado FROM Pedidos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_pedido]);
    return $stmt->fetchColumn();
}

// Exemplo básico de registro de pagamento
function registrarPagamento($pdo, $id_pedido, $metodo_pagamento, $total_pago) {
    $sql = "INSERT INTO Pagamentos (id_pedido, metodo_pagamento, total_pago) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_pedido, $metodo_pagamento, $total_pago]);
}

?>