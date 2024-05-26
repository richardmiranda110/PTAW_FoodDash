<?php
require_once './includes/session.php';
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
$idEstabelecimento = $_GET['idEstabelecimento'];

// check if using the right one, for security reasons
if($idEstabelecimento != $_SESSION['id_estabelecimento']){
    exit("You cant access other people's Items!");
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
    return $data;
}

function listarItem($idItem){
    global $pdo;
    echo 'hi :'.$_SESSION['id_estabelecimento'];
    $query =  
    "SELECT id_item, item.nome, preco, 
    descricao, disponivel, 
    foto, itemsozinho, 
    personalizacoesativas,
    c.nome as categoria, 
    c.id_categoria
    FROM public.itens item 
    INNER JOIN categorias c 
    ON item.id_categoria = c.id_categoria
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
        "preco" => $item["preco"],
        "descricao" => $item["descricao"],
        "foto_url" => $item["foto"],
    );
    
    $data = array(
            "id_estabelecimento" => $_SESSION['id_estabelecimento'],
            "itens" => $final_item
    );
    return $data;
}