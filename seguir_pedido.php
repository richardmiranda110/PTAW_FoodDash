<?php
declare(strict_types=1);
require_once './database/credentials.php';
require_once './database/db_connection.php';
require_once './session.php';

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

if(!isset($_GET['id'])){
    exit('no id!');
}
 
$id_cliente = $_SESSION['id_cliente'];
session_write_close(); 

$query = "SELECT pedido.estado as estado
FROM pedidos pedido 
FULL JOIN pedido_itens pi on pedido.id_pedido = pi.id_pedido 
INNER JOIN CLIENTES ON pedido.ID_CLIENTE = CLIENTES.ID_CLIENTE
WHERE pedido.id_pedido = ? and pedido.id_cliente = ?";

$updateQuery = "UPDATE pedidos
SET pedidos.estado = 'FINALIZADO'
WHERE pedido.id_pedido = ? and pedido.id_cliente = ?";

$stmt = $pdo->prepare($query);

while(1){
    $stmt->execute([$_GET['id'],$id_cliente]);
    $estado = $stmt->fetchColumn();

    echo 'data: '. $estado;
    echo "\n\n";

    if($estado == 'A CAMINHO'){
        sleep(5);
        $updstmt = $pdo->prepare($updateQuery);
        $updstmt->execute([$_GET['id'],$id_cliente]);
    }else if($estado == 'FINALIZADO'){
        break;
    }

    sleep(1);

    // shout out ciro, ganda codigo

    // flush the output buffer and send echoed messages to the browser
    while (ob_get_level() > 0) {
        ob_end_flush();
    }

    flush();

    // break the loop if the client aborted the connection (closed the page)
    if (connection_aborted())
        break;
}