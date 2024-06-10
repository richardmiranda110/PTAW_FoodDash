<?php 

require_once __DIR__.'/includes/session.php';
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

// retrieve establishment id
$idEmpresa = $_SESSION['id_empresa'];
$query = "UPDATE pedidos SET estado = ? WHERE id_pedido = ? and id_empresa = ?";

if(isset($_GET['id']) && isset($_GET['stage'])){
    switch($_GET['stage']){
        case 1:
            $stage = 'EFETUADO';
            $arguments = [$stage,$_GET['id'],$idEmpresa];
            break;
        case 2:
            $stage = 'EM PREPARACAO';
            $arguments = [$stage,$_GET['id'],$idEmpresa];
            break;
        case 3:
            $stage = 'A CAMINHO';
            $query = "UPDATE pedidos SET estado = ?,id_entregador=? WHERE id_pedido = ? and id_empresa = ?";
            
            if(empty($_GET['deliveryman']))
                exit('delivery man cannot be null');

            $arguments = [$stage,$_GET['deliveryman'],$_GET['id'],$idEmpresa];
            break;
        case 4:
            $stage = 'ENTREGUE';
            $arguments = [$stage,$_GET['id'],$idEmpresa];
            break;
        default:
         $stage = NULL;
    }
    if($stage == null){
       $data = "Error: invalid data";
    }else{
        $stmt = $pdo->prepare($query);
        $stmt->execute($arguments);

        $data = "Success!";
    }
}

//print result
header('Content-type: application/json');
print_r(json_encode($data));