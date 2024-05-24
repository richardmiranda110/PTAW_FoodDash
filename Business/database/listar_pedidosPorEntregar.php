<?php
require_once '../database/db_connection.php';

try {
    $sql = "SELECT * FROM pedidos WHERE estado!='FINALIZADO'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="row border border-2 border-secondary rounded-4 my-3" style="padding: 1vh; height: 10vh;">';
            echo '    <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">';
            echo '        <strong style="font-size: 1.5vw;">' . htmlspecialchars($row["id_pedido"]) . '</strong>';
            echo '    </div>';
            echo '    <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">';
            echo '        <span style="font-size: 0.8vw;">' . date("d/m/y", strtotime($row["data"])) . '</span>';
            echo '    </div>';
            echo '    <div class="col-sm-5 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">';
            echo '        <span style="font-weight: bold; font-size: 0.8vw;">' . htmlspecialchars($row["descricao"]) . '</span>';
            echo '    </div>';
            echo '    <div class="col-sm-3 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">';
            echo '        <span style="font-weight: bold; font-size: 0.8vw;">Estado do pedido:<br>';
            echo '        <span style="font-weight: normal; font-size: 0.8vw;">' . htmlspecialchars($row["estado"]) . '</span></span>';
            echo '    </div>';
            echo '    <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">';
            echo '        <strong style="font-size: 1.3vw;">' . number_format($row["precototal"], 2, ',', '') . '€</strong>';
            echo '    </div>';
            echo '    <div class="col-sm-1 align-self-center text-center">';
            echo '        <a href="pedido.php">';
            echo '        <i class="bi bi-eye"></i>';
            echo '        </a>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo '<div class="row align-items-center border border-2 border-secondary rounded-4 my-3" style="padding: 1vh; height: 10vh;">';
        echo '<h1>Nenhum pedido encontrado.</h1>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>