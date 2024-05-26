<?php
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome'])) {
    header("Location: /Business/login_register/login_business.php");
    exit();
  }

if($_GET['$idEmpresa'] != $_SESSION['id_empresa']){
    exit("You cant access other people's list!");
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $idEmpresa = $_GET['idEmpresa'];
    $query =  
    "SELECT nome,count(*) as count FROM categorias
    where id_empresa = ? group by nome";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$idEmpresa]);

    $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-type: application/json');
    print_r(json_encode($stmt));
}


