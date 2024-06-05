<?php 

require_once __DIR__.'/includes/session.php';
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

// retrieve establishment id
$idEmpresa = $_SESSION['id_estabelecimento'];

if(isset($_GET['id']) && isset($_GET['stage'])){
    echo $_GET['id'].' '.$_GET['stage'];
    switch($_GET['stage']){
        case 1:
            $stage = 'EFETUADO';
            break;
        case 2:
            $stage = 'EM PREPARACAO';
            break;
        case 3:
            $stage = 'A CAMINHO';
            break;
        case 4:
            $stage = 'ENTREGUE';
            break;
        default:
         $stage = NULL;
    }
    if($stage == null){
       $data = "Error: invalid data";
    }else{
        $stmt = $pdo->prepare("UPDATE pedidos SET estado = ? WHERE id_pedido = ? and id_estabelecimento = ?");
        $stmt->execute([$stage,$_GET['id'],$_SESSION['$id_estabelecimento']]);
        $data = "Success!";
    }
}

//print result
header('Content-type: application/json');
print_r(json_encode($data));