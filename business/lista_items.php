<?php
require_once __DIR__.'/includes/session.php';
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

// Check Authentication
if (!isset($_SESSION["authenticatedB"])) {
    header("Location: /Business/login_register/login_business.php");
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = "Tipo de dados tem que ser POST";
    echo json_encode( getReturnMessage($status,$message));
}

// retrieve establishment id
$idEstabelecimento = $_SESSION['id_estabelecimento'];

if(isset($_GET['delete'])){
    $stmt = $pdo->prepare("DELETE FROM itens WHERE id_item = ? and id_estabelecimento = ?");
    $stmt->execute([$_GET['delete'],$idEstabelecimento]);
    exit();
}

// if the user wants an item, retrieve item
if(isset($_GET['itemId'])){
 $data = listarItem($_GET['itemId']);
}else{ // else retrieve all items
 $data = listarTodosItems($idEstabelecimento);
}

//print result
header('Content-type: application/json');
print_r(json_encode($data));

// Functions
function listarTodosItems($idEmpresa){
    global $pdo;

    $query =  
    "SELECT id_item, item.nome, preco, 
    descricao, disponivel, 
    foto, itemsozinho, 
    personalizacoesativas,
    c.nome as categoria, 
    c.id_categoria as categoria_id, id_estabelecimento
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
            "menus" => implode(',',getMenus($item["id_item"])),
            "categoria" => $item["categoria"],
            "categoria_id" => $item["categoria_id"],
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
    return $data;
}

function getMenus($id_item){
    global $pdo;

    $query = "SELECT distinct menu.nome from itens item INNER JOIN item_menus mi on mi.id_item = item.id_item
    INNER JOIN menus menu on menu.id_menu = mi.id_menu where item.id_item = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_item]);

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function listarItem($idItem){
    global $pdo;
    echo 'hi :'.$_SESSION['id_estabelecimento'];
    $query =  
    "SELECT id_item, item.nome, preco, 
    descricao, disponivel, 
    foto, itemsozinho, 
    personalizacoesativas,
    menu.nome as menu
    c.nome as categoria, 
    c.id_categoria as categoria_id
    FROM public.itens item 
    INNER JOIN categorias c 
    ON item.id_categoria = c.id_categoria
    INNER JOIN menu_items mi on mi.id_item = item.id_item
    INNER JOIN menus on menu.id_menu = mi.id_menu
    where item.id_item = ? and item.id_estabelecimento = ".$_SESSION['id_estabelecimento']."";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idItem]);

    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $final_item = array(
        "id" => $item["id_item"],
        "tem_personalizacoes" => $item["personalizacoesativas"],
        "bundle" => $item["itemsozinho"],
        "disponivel" => $item["disponivel"],
        "nome" => $item["nome"],
        "categoria" => $item["categoria"],
        "categoria_id" => $item["categoria_id"],
        "preco" => $item["preco"],
        "descricao" => $item["descricao"],
        "foto_url" => $item["foto"],
        "menu" => $item["menu"],
    );
    
    $data = array(
            "id_estabelecimento" => $_SESSION['id_estabelecimento'],
            "itens" => $final_item
    );
    return $data;
}