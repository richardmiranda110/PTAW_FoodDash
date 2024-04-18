<?php
function avaliarItem($pdo, $classificacao, $autor, $descricao, $id_cliente, $id_item) {
    $sql = "INSERT INTO AvaliacoesItens (classificacao, autor, data, descricao, id_cliente, id_item) VALUES (?, ?, NOW(), ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$classificacao, $autor, $descricao, $id_cliente, $id_item]);
}

function visualizarAvaliacoesItem($pdo, $id_item) {
    $sql = "SELECT * FROM AvaliacoesItens WHERE id_item = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_item]);
    return $stmt->fetchAll();
}
?>