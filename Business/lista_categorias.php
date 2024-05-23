<?php
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

$idEmpresa = $_GET['idEmpresa'];
$query =  
"SELECT nome,count(*) as count FROM categorias
where id_empresa = ? group by nome";

$stmt = $pdo->prepare($query);
$stmt->execute([$idEmpresa]);

$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-type: application/json');
print_r(json_encode($stmt));