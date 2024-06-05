<?php
require_once __DIR__.'/../includes/session.php';
require_once __DIR__.'/../../database/credentials.php';
require_once __DIR__.'/../../database/db_connection.php';

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
    exit('utilizador não logado');
}

$id_empresa = $_SESSION['id_empresa'];

try {
    $sql = "SELECT p.id_pedido, p.data, p.estado, p.precototal
            FROM pedidos p
            INNER JOIN estabelecimentos e ON p.id_estabelecimento = e.id_estabelecimento
            WHERE e.id_empresa = :id_empresa AND p.estado like 'EM PREPARACAO'";
            
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) == 0) {
        echo '<div class="row align-items-center border-secondary rounded-4 my-3" style="padding: 1vh; height: 10vh;">';
        echo '<h6>Nenhum pedido encontrado.</h6>';
        echo '</div>';
    } else {
        foreach ($rows as $item) {
            $query = "SELECT itens.nome
                      FROM pedido_itens
                      INNER JOIN itens ON itens.id_item = pedido_itens.id_item
                      WHERE pedido_itens.id_pedido = :id_pedido";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_pedido', $item['id_pedido'], PDO::PARAM_INT);
            $stmt->execute();
            $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $item_arr = array();
            foreach ($itens as $item_itens) {
                $item_arr[] = htmlspecialchars($item_itens['nome']);
            }
            $descricao = implode(' + ', $item_arr);

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
                    <a href="pedido.php?id_pedido=' . htmlspecialchars($item["id_pedido"]) . '">
                    <i class="bi bi-eye"></i>
                    </a>
                </div>
            </div>';
        }
    }
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>