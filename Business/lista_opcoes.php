<?php
require_once __DIR__.'/includes/session.php';
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

// Check Authentication
if (!isset($_SESSION["authenticatedB"])) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    header("Location: /Business/login_register/login_business.php");
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = "Tipo de dados tem que ser POST";
    echo json_encode( getReturnMessage($status,$message));
}

// retrieve establishment id
$idEmpresa = $_SESSION['id_estabelecimento'];

if(isset($_GET['deleteoption'])){
    $stmt = $pdo->prepare("DELETE FROM opcoes WHERE id_opcao = ?");
    $stmt->execute([$_GET['deleteoption']]);
    exit();
}

if(isset($_GET['deletemenu'])){
    $stmt = $pdo->prepare(
        "DELETE 
        FROM menus 
        WHERE id_menu = ? 
        and id_menu 
        in ( select id_menu from menus where id_estabelecimento = ?)"
        );
    $stmt->execute([$_GET['deletemenu'],$idEmpresa]);

    $stmt = $pdo->prepare(
        "DELETE 
        FROM item_menus 
        WHERE id_menu = ? 
        and id_menu 
        in ( select id_menu from menus where id_estabelecimento = ?)"
        );
    $stmt->execute([$_GET['deletemenu'],$idEmpresa]);
    exit();
}

if(isset($_GET['deletemenuitem'])){
    $stmt = $pdo->prepare(
        "DELETE 
        FROM item_menus 
        WHERE id_item = ? 
        and id_menu 
        in ( select id_menu from menus where id_estabelecimento = ?)
        ");
    $stmt->execute([$_GET['deletemenuitem'],$idEmpresa]);
    exit();
}

$data = listarTodosMenus($idEmpresa);

//print result
header('Content-type: application/json');
print_r(json_encode($data));

function listarTodosMenus($idEmpresa){
    global $pdo;

    $query =  
    "SELECT menu.nome,menu.id_menu,menu.disponivel,menu.preco,menu.descricao,menu.foto, count(*) as qtd 
    from itens item 
    LEFT JOIN item_menus mi 
    on mi.id_item = item.id_item
    LEFT JOIN menus menu 
    on menu.id_menu = mi.id_menu
    where menu.id_estabelecimento = ?
    GROUP BY menu.nome,menu.id_menu,menu.disponivel,menu.preco,menu.descricao,menu.foto
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idEmpresa]);
    $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $items = array();
    
    foreach($stmt as &$menu){
        $final_item = array(
            "id" => $menu["id_menu"],
            "disponivel" => $menu["disponivel"],
            "nome" => $menu["nome"],
            "preco" => $menu["preco"],
            "quantidade" => $menu['qtd'],
            "descricao" => $menu["descricao"],
            "foto_url" => $menu["foto"],
        );
    
        $items = array_merge($items,array($final_item));
    }
    
    $data = array(
            "id_estabelecimento" => $idEmpresa,
            "itens" => $items
    );
    return $data;
}