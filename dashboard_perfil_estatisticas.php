<?php
require_once __DIR__.'/session.php';
require_once __DIR__.'/database/credentials.php';
require_once __DIR__.'/database/db_connection.php';

if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
    header("Location: /index.php");
    exit();
  }

function getTotalPedidos($conn, $clienteId)
{
    if ($_SESSION['id_cliente'] != $clienteId){
        header("Location: /index.php");
        exit();
    }

    $query = "SELECT COUNT(*) AS total_pedidos FROM Pedidos WHERE id_cliente = :clienteId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();  // Obtemos um único resultado, que é a contagem
    return $result['total_pedidos'];  // Retorna o total de pedidos
}
// Função para contar pedidos por mês para um cliente específico
function getMesPedidos($pdo, $clienteId, $mes)
{
    if ($_SESSION['id_cliente'] != $clienteId){
        header("Location: /index.php");
        exit();
    }

    $query = "
        SELECT COUNT(*) AS total_pedidos
        FROM Pedidos
        WHERE id_cliente = :clienteId
          AND EXTRACT(MONTH FROM data) = :mes
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_pedidos'];
}
// Função para calcular o total de dinheiro gasto por um cliente
function getTotalDinheiro($pdo, $clienteId)
{
    if ($_SESSION['id_cliente'] != $clienteId){
        header("Location: /index.php");
        exit();
    }

    $query = "
        SELECT SUM(precoTotal) AS total_dinheiro
        FROM Pedidos
        WHERE id_cliente = :clienteId
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    
    return $result['total_dinheiro'] == NULL ? 0 : $result['total_dinheiro'];
}

function getRestauranteMaisPedido($clienteId)
{
    global $pdo;
    if ($_SESSION['id_cliente'] != $clienteId){
        header("Location: /index.php");
        exit();
    }

    $query = "
    SELECT estabelecimento,nome, count
    FROM (
        SELECT estabelecimentos.id_estabelecimento as estabelecimento,estabelecimentos.nome AS nome, COUNT(estabelecimentos.id_estabelecimento) AS count
        FROM pedidos
        INNER JOIN estabelecimentos ON estabelecimentos.id_estabelecimento = pedidos.id_estabelecimento
        where pedidos.id_cliente = ?
        GROUP BY estabelecimentos.nome,estabelecimento
    ) AS counts
    ORDER BY count DESC
    LIMIT 1;
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$clienteId]);
    $result = $stmt->fetch();
    
    if($result == false){
        return 'N/A';
    }
    return $result['nome'];
}

// Função para calcular o total de dinheiro gasto por um cliente em um mês específico
function getMesDinheiro($pdo, $clienteId, $mes)
{
    if ($_SESSION['id_cliente'] != $clienteId){
        header("Location: /index.php");
        exit();
    }

    $query = "
        SELECT SUM(precoTotal) AS total_dinheiro
        FROM Pedidos
        WHERE id_cliente = :clienteId
          AND EXTRACT(MONTH FROM data) = :mes
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_dinheiro'];
}

// Função para calcular a média de custo por pedido
function getMediaCustoPedidos($pdo, $clienteId)
{
    if ($_SESSION['id_cliente'] != $clienteId){
        header("Location: /index.php");
        exit();
    }

    $totalDinheiro = getTotalDinheiro($pdo, $clienteId);
    $totalPedidos = getTotalPedidos($pdo, $clienteId);

    if ($totalPedidos == 0) {
        return 0;  // Para evitar divisão por zero
    }

    $media = $totalDinheiro / $totalPedidos;
    return number_format($media, 2);
}

// Exemplo de uso
$clienteId = $_SESSION['id_cliente'];  // ID do cliente para o qual queremos contar os pedidos
$totalPedidos = getTotalPedidos($pdo, $clienteId);

$totalDinheiro = getTotalDinheiro($pdo, $clienteId);

$mediaCustoPedidos = getMediaCustoPedidos($pdo, $clienteId);

$totalPedidosJulho = getMesPedidos($pdo, $clienteId, 7);
$totalPedidosAgosto = getMesPedidos($pdo, $clienteId, 8);
$totalPedidosSetembro = getMesPedidos($pdo, $clienteId, 9);
$totalPedidosOutubro = getMesPedidos($pdo, $clienteId, 10);
$totalPedidosNovembro = getMesPedidos($pdo, $clienteId, 11);
$totalPedidosDezembro = getMesPedidos($pdo, $clienteId, 12);

$totalDinheiroJulho = getMesDinheiro($pdo, $clienteId, 7);
$totalDinheiroAgosto = getMesDinheiro($pdo, $clienteId, 8);
$totalDinheiroSetembro = getMesDinheiro($pdo, $clienteId, 9);
$totalDinheiroOutubro = getMesDinheiro($pdo, $clienteId, 10);
$totalDinheiroNovembro = getMesDinheiro($pdo, $clienteId, 11);
$totalDinheiroDezembro = getMesDinheiro($pdo, $clienteId, 12);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles/sitecss.css">
    <link rel="stylesheet" href="/assets/styles/responsive_styles.css">
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        google.charts.load("current", {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Pedidos", { role: "style" }],
                ["Jul", <?= $totalPedidosJulho ?>, "gold"],
                ["Ago", <?= $totalPedidosAgosto ?>, "gold"],
                ["Set", <?= $totalPedidosSetembro ?>, "gold"],
                ["Out", <?= $totalPedidosOutubro ?>, "gold"],
                ["Nov", <?= $totalPedidosNovembro ?>, "gold"],
                ["Dez", <?= $totalPedidosDezembro ?>, "gold"],
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                title: "Números de pedido por mês",
                width: 1100,
                responsive: true,
                width_units: 'vw',
                height: 390,
                bar: {
                    groupWidth: "12%"
                },
                legend: {
                    position: "none"
                },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Dinheiro gasto'],
                ['Jul', <?=$totalDinheiroJulho?>],
                ['Ago', <?=$totalDinheiroAgosto?>],
                ['Set', <?=$totalDinheiroSetembro?>],
                ['Out', <?=$totalDinheiroOutubro?>],
                ['Nov', <?=$totalDinheiroNovembro?>],
                ['Dez', <?=$totalDinheiroDezembro?>]
            ]);

            var options = {
                width: 80,
                height: 300,
                title: 'Dinheiro gasto',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>


</head>

<body>

    <?php
    include __DIR__ . "/includes/header_logged_in.php";
    ?>
        <?php
        include __DIR__ . "/includes/sidebar_perfil.php";
        ?>
    <!--Zona de Conteudo -->
    <div id="contentPage" style="min-width:100%;" class="container-xxl">

        <!--Zona de Conteudo da Página -->
        <div id="contentDiv" class="col-md-10 pl-2 pt-3 pb-0">
            <div class="container-md" style="padding: 10px;">
                <div class="row mb-4">
                    <div class="col-12">
                        <h1 class="display-4">Estatísticas</h1>
                        <p>Esta é a tua página de estatísticas. Aqui podes ver as estatísticas sobre a tua conta, tal como dinheiro total gasto.</p>
                    </div>
                </div>

                <div class="row d-flex align-items-stretch">
                    <!-- Primeira Coluna: 5 Cartões -->
                    <div class="col-md-4 d-flex flex-column justify-content-between">
                        <!-- Defina altura fixa para cada card -->
                        <div class="card flex-grow-1" style=" overflow: auto;">
                            <div class="card-body text-center">
                                <p class="card-title">Restaurante Mais Pedido</p>
                                <div class="row align-items-center">
                                    <div class="col-12 text-center">
                                        <p class="fw-bold text-secondary" style="max-height: 70px;"><?php echo getRestauranteMaisPedido($_SESSION['id_cliente']); ?></p>
                                    </div>
                                    <!-- <div class="col-4" style="max-height: 70px;">
                                        <img src="../assets/imgs/burgerKing_marca.png" alt="Imagem do Restaurante" class="img-fluid">
                                    </div> -->
                                </div>
                            </div>
                        </div>

                        <!-- Outros Cartões -->
                        <div class="card flex-grow-1" style=" overflow: auto;">
                            <div class="card-body text-center">
                                <p class="card-title">Total de pedidos realizados</p>
                                <p class="display-4 text-secondary" style="max-height: 70px;"><?php echo getTotalPedidos($pdo,$_SESSION['id_cliente']); ?></p>
                            </div>
                        </div>

                        <div class="card flex-grow-1" style=" overflow: auto;">
                            <div class="card-body text-center">
                                <p class="card-title">Total de Dinheiro Gasto</p>
                                <!-- Adicionar altura máxima para evitar conteúdo excessivo -->
                                <p class="display-4 text-secondary" style="max-height: 70px; overflow: auto;">
                                <?php echo getTotalDinheiro($pdo,$_SESSION['id_cliente']) . "€"; ?>
                                </p>
                            </div>
                        </div>

                        <div class="card flex-grow-1" style="overflow: auto;">
                            <div class="card-body text-center">
                                <p class="card-title">Média de Dinheiro Gasto por Pedido</p>
                                <p class="display-4 text-secondary" style="max-height: 70px;"><?php echo $mediaCustoPedidos . "€"; ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda Coluna: Gráficos -->
                    <div class="col-md-8 d-flex flex-column justify-content-between">

                            <div class="card-body text-center pt-5 pb-5">
                                <div id="curve_chart" style=""></div>
                            </div>
                    

                        <div class="card flex-grow-1" style=" overflow: auto;">
                            <div class="card-body text-center pt-5 pb-5">
                                <div id="columnchart_values" style=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Limpa conteudo Float -->
        <div class="cleanFloat"></div>

        <!--Zona do Footer -->
        <?php
        include __DIR__ . "/includes/footer_2.php";
        ?>
    </div>

</body>

</html>