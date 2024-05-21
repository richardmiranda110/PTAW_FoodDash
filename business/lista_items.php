<?php
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

$idEmpresa = $_GET['idEstabelecimento'];

$stmt = $pdo->prepare(
    "SELECT id_item, item.nome, preco, 
    descricao, disponivel, 
    foto, itemsozinho, 
    personalizacoesativas,
    c.nome as categoria, 
    c.id_categoria, id_estabelecimento
	FROM public.itens item 
    INNER JOIN categorias c 
    ON item.id_categoria = c.id_categoria
    where id_estabelecimento = ? ");
    
$stmt->execute([$idEmpresa]);
$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-type: application/json');
print_r(json_encode($stmt));