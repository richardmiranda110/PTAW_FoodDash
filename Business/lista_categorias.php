<?php
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";
require_once __DIR__."/includes/session.php";

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome'])) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    header("Location: /Business/login_register/login_business.php");
    exit();
  }

$idEmpresa = $_SESSION['id_empresa'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categorias WHERE nome = ? and id_empresa = ?");
        $stmt->execute([$_POST["category-input"],$idEmpresa]);
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            exit("A categoria já existe!");
        }
    
        $stmt = $pdo->prepare("INSERT INTO categorias(nome, id_empresa) VALUES (?, ?);");
        $stmt->execute([$_POST["category-input"],$idEmpresa]);
        header('Location: ./dashboard_lista_categorias.php');
        exit();
    } catch(PDOException $e) {
        echo "Erro ao inserir registo: " . $e->getMessage();
    }
}

if(isset($_GET['delete'])){
    echo $_GET['delete'].' HI';
    $stmt = $pdo->prepare("DELETE FROM categorias WHERE id_categoria = ? and id_empresa = ?");
    $stmt->execute([$_GET['delete'],$idEmpresa]);
    echo "Success :D";  
    exit();
}

$query =  
"SELECT categorias.nome, categorias.id_categoria,
COUNT(itens.id_item) AS count FROM  categorias
LEFT JOIN itens ON categorias.id_categoria = itens.id_categoria
where categorias.id_empresa = ? 
GROUP BY categorias.id_categoria, categorias.nome
ORDER BY categorias.id_categoria;";

$stmt = $pdo->prepare($query);
$stmt->execute([$idEmpresa]);

$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-type: application/json');
print_r(json_encode($stmt));