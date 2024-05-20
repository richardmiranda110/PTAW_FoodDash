<?php
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

$idEmpresa = $_GET['idEstabelecimento'];

$stmt = $pdo->prepare(
    "SELECT nome, foto, 
    preco from itens 
    where id_estabelecimento = ? ");
    
$stmt->execute([$idEmpresa]);
$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-type: application/json');
print_r(json_encode($stmt));