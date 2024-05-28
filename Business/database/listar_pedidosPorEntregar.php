<?php
require_once __DIR__.'/../../database/credentials.php';
require_once __DIR__.'/../includes/session.php';
require_once __DIR__.'/../../database/db_connection.php';

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticatedB'])) {
    header("Location: /index.php");
    exit();
  }

try {
    $sql = "SELECT * FROM pedidos WHERE estado!='FINALIZADO'";      
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) == 0) {
        echo '<div class="row align-items-center border border-2 border-secondary rounded-4 my-3" style="padding: 1vh; height: 10vh;">';
        echo '<h1>Nenhum pedido encontrado.</h1>';
        echo '</div>';
    }

    $query = "SELECT itens.nome
	FROM public.pedido_itens
	inner join itens on itens.id_item=pedido_itens.id_item
	inner join pedidos on pedidos.id_pedido=pedido_itens.id_pedido
	where pedidos.id_pedido = 1;";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $itens = $stmt->fetchAll();

    $item_arr = array();

    foreach($itens as &$item){
    array_push($item_arr,$item['nome']);
    }

    $descricao = implode(' + ',$item_arr);

    foreach($rows as &$item){
        echo '<div class="border border-2 border-secondary rounded-4 my-3 d-flex justify-content-between" style="padding: 1vh; height: 10vh;">
            <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                <strong style="font-size: 1.5vw;">' . htmlspecialchars($item["id_pedido"]) . '</strong>
            </div>
            <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                <span style="font-size: 0.8vw;">' . date("d/m/y", strtotime($item["data"])) . '</span>
            </div>
            <div class="col-sm-5 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                <span style="font-weight: bold; font-size: 0.8vw;">' . htmlspecialchars($descricao) . '</span>
            </div>
            <div class="col-sm-3 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                <span style="font-weight: bold; font-size: 0.8vw;">Estado do pedido:<br>
                <span style="font-weight: normal; font-size: 0.8vw;">' . htmlspecialchars($item["estado"]) . '</span></span>
            </div>
            <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                <strong style="font-size: 1.3vw;">' . number_format($item["precototal"], 2, ',', '') . '€</strong>
            </div>
            <div class="col-sm-1 align-self-center text-center">
                <a href="pedido.php">
                <i class="bi bi-eye"></i>
                </a>
            </div>
        </div>';
    }
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}