<?php
header('Content-Type: application/json');

require_once './database/credentials.php';
require_once './database/db_connection.php';
require_once './session.php';

if (!isset($_GET['id'])) {
    exit('no id!');
}

$query = "SELECT pedidos.estado as estado
FROM pedidos
FULL JOIN pedido_itens pi on pedidos.id_pedido = pi.id_pedido 
INNER JOIN CLIENTES ON pedidos.ID_CLIENTE = CLIENTES.ID_CLIENTE
WHERE pedidos.id_pedido = ?";

$updateQuery = "UPDATE pedidos
SET estado = 'FINALIZADO'
WHERE id_pedido = ?";
try {
    $stmt = $pdo->prepare($query);
    $updstmt = $pdo->prepare($updateQuery);


    $stmt->execute([$_GET['id']]);
    $estado = $stmt->fetchColumn();
} catch (PDOException $e) {
    $status ="error";
    $message = 'Error executing query';
    echo json_encode(getReturnMessage($status,$message,$time_passed));
    exit();
}

$status = "success";
$time_passed = null;

switch($estado){
    case 'EFETUADO':
    case 'EM PREPARACAO':
    case 'FINALIZADO':
    case 'ENTREGUE':
        $message = $estado;
        break;
    case 'A CAMINHO':
        if(!isset($_SESSION['last_update']))
            $SESSION['last_update'] = time();

        $message = $estado;
        $time_passed = time() - $_SESSION['last_update'];

        if($time_passed >= 60){
            $updstmt->execute([$_GET['id']]);
        }
        $message = $estado;
        break;
    default:
    $status ="error";
    $message = "algo inesperado aconteceu!";
}

echo json_encode(getReturnMessage($status,$message,$time_passed));

function getReturnMessage($status,$message,$extra = null){
    if($extra == null){
        return ["status" => $status, "message" => $message];
    }

    return ["status" => $status, "message" => $message, "time_passed" => $extra];
}