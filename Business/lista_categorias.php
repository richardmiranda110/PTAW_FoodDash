<?php
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";
require_once __DIR__."/includes/session.php";

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome'])) {
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
        header('Location: /business/dashboard_lista_categorias.php');
        exit();
    } catch(PDOException $e) {
        echo "Erro ao inserir registo: " . $e->getMessage();
    }
}

if(isset($_GET['delete'])){
    $stmt = $pdo->prepare("DELETE FROM categorias WHERE id_categoria = ? and id_empresa = ?");
    $stmt->execute([$_GET['delete'],$idEmpresa]);
    echo "Success :D";  
    exit();
}

$query =  
"SELECT nome,categorias.id_categoria as id,count(item_categorias.id_item) as count FROM categorias
full join item_categorias on categorias.id_categoria = item_categorias.id_categoria
where id_empresa = ? group by categorias.id_categoria;";

$stmt = $pdo->prepare($query);
$stmt->execute([$idEmpresa]);

$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-type: application/json');
print_r(json_encode($stmt));