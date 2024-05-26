<?php
require_once './includes/session.php';
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

$idEmpresa = $_GET['idEstabelecimento'];

if (!isset($_SESSION['id_estabelecimento']) || !isset($_SESSION['nome'])) {
    header("Location: /Business/login_register/login_business.php");
    exit();
  }

if($idEmpresa != $_SESSION['id_empresa']){
    exit("You cant access other people's list!");
}

$query =  
"SELECT id_item, item.nome, preco, 
descricao, disponivel, 
foto, itemsozinho, 
personalizacoesativas,
c.nome as categoria, 
c.id_categoria, id_estabelecimento
FROM public.itens item 
INNER JOIN categorias c 
ON item.id_categoria = c.id_categoria
where id_estabelecimento = ? and itemsozinho = true ";

if(isset($_GET['categoria'])){
    $query = $query."and c.nome like ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idEmpresa,$_GET['categoria']]);
}else{
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idEmpresa]);
}

$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
$items = array();

foreach($stmt as &$item){
    $final_item = array(
        "id" => $item["id_item"],
        "tem_personalizacoes" => $item["personalizacoesativas"],
        "bundle" => $item["itemsozinho"],
        "disponivel" => $item["disponivel"],
        "nome" => $item["nome"],
        "categoria" => $item["categoria"],
        "preco" => $item["preco"],
        "descricao" => $item["descricao"],
        "foto_url" => $item["foto"],
    );

    $items = array_merge($items,array($final_item));
}

$data = array(
        "id_estabelecimento" => $idEmpresa,
        "itens" => $items
);

header('Content-type: application/json');
print_r(json_encode($data));