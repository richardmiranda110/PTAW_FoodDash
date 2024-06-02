<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/database/credentials.php';
require_once __DIR__ . '/database/db_connection.php';

if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
    header("Location: /index.php");
    exit();
}

function getTotalPedidos($conn, $clienteId)
{
    if ($_SESSION['id_cliente'] != $clienteId) {
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
    if ($_SESSION['id_cliente'] != $clienteId) {
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
    if ($_SESSION['id_cliente'] != $clienteId) {
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
    if ($_SESSION['id_cliente'] != $clienteId) {
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

    if ($result == false) {
        return 'N/A';
    }
    return $result['nome'];
}

// Função para calcular o total de dinheiro gasto por um cliente em um mês específico
function getMesDinheiro($pdo, $clienteId, $mes)
{
    if ($_SESSION['id_cliente'] != $clienteId) {
        header("Location: /index.php");
        exit();
    }

    $query = "SELECT COALESCE(SUM(precoTotal), 0) AS total_dinheiro
        FROM Pedidos
        WHERE id_cliente = :clienteId
          AND EXTRACT(MONTH FROM data) = :mes";
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
    if ($_SESSION['id_cliente'] != $clienteId) {
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

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grid com Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/sitecss.css">
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <style>
        section {
            padding: 7px;
        }

        .row {
            padding: 5px;
        }

        .col {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .row.bg-light {
            flex-grow: 1;
            display: flex;
        }

        .row.bg-light .col {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: auto;
            height: 160px;
            max-height: 160px;
            max-width: 900px;
        }

        .card-body {
            flex-grow: 1;
        }

        .grafico {
            height: 1000px;
            /* Altura mínima dos gráficos */
            max-height: 1000px;
            /* Altura máxima dos gráficos */
        }

        .grafico canvas {
            max-width: 100%;
            height: 100%;
            /* Faz o canvas ocupar toda a altura do contêiner pai */
        }
    </style>
</head>

<body>
    <?php include __DIR__ . "/includes/header_logged_in.php"; ?>
    <?php include __DIR__."/includes/sidebar_perfil.php"; ?>
    <section id="pricing" class="bg-light pt-2 pb-2">
        <div class="container">
            <div class="text-start mt-1">
                <h2 class="fw-bold">Estatísticas</h2>
                <p class="lead text-muted fw-bold">Esta é a tua página de estatísticas. Aqui podes ver estatísticas sobre a tua conta, tal como dinheiro total gasto.</p>
            </div>
            <div class="row">

                <!-- Coluna 1 com 5 linhas -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="row bg-light">
                        <div class="col">
                            <div class="card shadow border-1">
                                <div class="card-body text-center">
                                    <h4 class="card-title fw-bold mb-3">Restaurante mais pedido</h4>
                                    <p class="h2 mb-3 text-secondary fw-bold"><?php echo getRestauranteMaisPedido($_SESSION['id_cliente']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-light">
                        <div class="col">
                            <div class="card shadow border-1">
                                <div class="card-body text-center">
                                    <h4 class="card-title fw-bold mb-3">Total de pedidos realizados</h4>
                                    <p class="display-5 mb-3 text-secondary fw-bold"><?php echo getTotalPedidos($pdo, $_SESSION['id_cliente']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-light">
                        <div class="col">
                            <div class="card shadow border-1">
                                <div class="card-body text-center">
                                    <h4 class="card-title fw-bold mb-3">Total de dinheiro gasto</h4>
                                    <p class="display-5 mb-3 text-secondary fw-bold"><?php echo getTotalDinheiro($pdo, $_SESSION['id_cliente']) . "€"; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-light">
                        <div class="col">
                            <div class="card shadow border-1">
                                <div class="card-body text-center">
                                    <h4 class="card-title fw-bold mb-3">Média de dinheiro gasto por pedido</h4>
                                    <p class="display-5 mb-3 text-secondary fw-bold"><?php echo getMediaCustoPedidos($pdo, $_SESSION['id_cliente']) . "€"; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-light">
                        <div class="col">
                            <div class="card shadow border-1">
                                <div class="card-body text-center">
                                    <h4 class="card-title fw-bold mb-3">Tempo médio de entrega</h4>
                                    <p class="display-5 mb-3 text-secondary fw-bold">10:15</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Coluna 2 com 2 linhas -->
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="row bg-light ">
                        <div class="col-12 col-md-7 col-lg-8">
                            <div class="card grafico shadow border-1" style="height: 419px; max-height: 419px; width: 1000px">
                                <div class="card-body">
                                    <canvas id="vendasChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-light">
                        <div class="col-12 col-md-7 col-lg-8">
                            <div class="card grafico shadow border-1" style="height: 419px; max-height: 419px; width: 1000px">
                                <div class="card-body">
                                    <canvas id="pedidosChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include __DIR__."/includes/footer_2.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pedidosChart = document.getElementById('pedidosChart').getContext('2d');
        const vendasChart = document.getElementById('vendasChart').getContext('2d');

        new Chart(pedidosChart, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Pedidos',
                    data: [
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 1); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 2); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 3); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 4); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 5); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 6); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 7); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 8); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 9); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 10); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 11); ?>,
                        <?php echo getMesPedidos($pdo, $_SESSION['id_cliente'], 12); ?>

                    ],
                    borderWidth: 1,
                    borderColor: 'rgb(0,0,0)',
                    backgroundColor: 'rgb(255,215,0)',
                    tension: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(vendasChart, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Vendas',
                    data: [
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 1); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 2); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 3); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 4); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 5); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 6); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 7); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 8); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 9); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 10); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 11); ?>,
                        <?php echo getMesDinheiro($pdo, $_SESSION['id_cliente'], 12); ?>
                    ],
                    borderWidth: 5,
                    borderColor: 'rgb(255,215,0)',
                    backgroundColor: 'rgb(255,215,0)',
                    tension: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>

</html>