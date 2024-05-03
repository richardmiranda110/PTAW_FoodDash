<?php
require_once './database/db_connection.php';
header('Content-Type: application/json'); 


if (!isset($_GET["id"])) {
  $restaurante = erro("NOT GIVEN ID");
  print_r ($restaurante);
  die();
} 

$restaurante = $_GET["id"];
$q = "SELECT nome, preco, disponivel, foto, categoria FROM itens;";

try {
    $statement = $pdo->prepare($q);
    $statement->execute();

    if (!$statement) {
      echo "Erro ao executar a consulta.";
    }
    
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);

    header('Content-Type: application/json');
    print_r($json);
    
  } catch (Exception $e) {
    echo "Erro na conexão à BD: " . $e->getMessage();
  }

  function erro($input){
    return json_encode(array("error"=> $input));
  }