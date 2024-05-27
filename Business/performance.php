<?php
require_once __DIR__.'/includes/session.php';
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

// if(!isset($_SESSION['id_estabelecimento']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
//     header("Location: /Business/dashboard_home_page.php");
//     exit();
//   }

// não sei quem fez isto, mas $_GET aint it chief
$idEstabelecimento = $_GET['id_estabelecimento'];

if($idEstabelecimento != $_SESSION['id_estabelecimento']){
    exit("You cant access other people's data!");
}

function getPedidosDiarios($pdo, $estabelecimentoId, $dia)
{
    $query = "SELECT COUNT(*) AS total_pedidos FROM Pedidos WHERE id_estabelecimento = :estabelecimentoId AND EXTRACT(DAY FROM data) = :dia";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':dia', $dia, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_pedidos'];
}
function getPedidosMensais($pdo, $estabelecimentoId, $mes)
{
    $query = "SELECT COUNT(*) AS total_pedidos FROM Pedidos WHERE id_estabelecimento = :estabelecimentoId AND EXTRACT(MONTH FROM data) = :mes";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_pedidos'];
}

function getVendasDiarias($pdo, $estabelecimentoId, $dia)
{
    $query = "SELECT SUM(precoTotal) AS total_dinheiro
        FROM Pedidos
        WHERE id_estabelecimento = :estabelecimentoId AND EXTRACT(DAY FROM data) = :dia";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':dia', $dia, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_dinheiro'];
}


function getVendasMensais($pdo, $estabelecimentoId, $mes)
{
    $query = "SELECT SUM(precoTotal) AS total_dinheiro
        FROM Pedidos
        WHERE id_estabelecimento = :estabelecimentoId
          AND EXTRACT(MONTH FROM data) = :mes";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_dinheiro'];
}

//Preço médio diário

function getPrecoMedioDiario($pdo, $estabelecimentoId, $dia)
{
    $totalVendas = getVendasDiarias($pdo, $estabelecimentoId, $dia);
    $totalPedidos = getPedidosDiarios($pdo, $estabelecimentoId, $dia);

    if ($totalPedidos == 0) {
        return 0;
    }

    $media = $totalVendas / $totalPedidos;
    return number_format($media, 2);
}

//Preço médio mensal

function getPrecoMedioMensal($pdo, $estabelecimentoId, $mes)
{
    $totalVendas = getVendasMensais($pdo, $estabelecimentoId, $mes);
    $totalPedidos = getPedidosMensais($pdo, $estabelecimentoId, $mes);

    if ($totalPedidos == 0) {
        return 0;
    }

    $media = $totalVendas / $totalPedidos;
    return number_format($media, 2);
}

function getItemMaisPedidoDiario($pdo, $estabelecimentoId, $dia)
{
    $query = "SELECT 
            i.nome, 
            SUM(pi.quantidade) AS total_vendido
        FROM 
            Pedidos p
        JOIN 
            Pedido_Itens pi ON p.id_pedido = pi.id_pedido
        JOIN 
            Itens i ON pi.id_item = i.id_item
        WHERE 
            p.id_estabelecimento = :estabelecimentoId
            AND EXTRACT(DAY FROM data) = :dia
        GROUP BY 
            i.nome
        ORDER BY 
            total_vendido DESC
        LIMIT 1;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':dia', $dia, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['nome'] : null;
}

function getItemMaisPedidoMensal($pdo, $estabelecimentoId, $mes)
{
    $query = "SELECT 
            i.nome, 
            SUM(pi.quantidade) AS total_vendido
        FROM 
            Pedidos p
        JOIN 
            Pedido_Itens pi ON p.id_pedido = pi.id_pedido
        JOIN 
            Itens i ON pi.id_item = i.id_item
        WHERE 
            p.id_estabelecimento = :estabelecimentoId
            AND EXTRACT(MONTH FROM data) = :mes
        GROUP BY 
            i.nome
        ORDER BY 
            total_vendido DESC
        LIMIT 1;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['nome'] : null;
}

//Função complementar da função getAvaliacaoMediaDiaria()
function getTodasAvaliacoesDoDia($pdo, $estabelecimentoId, $dia)
{
    $query = "SELECT COUNT(*) AS total_avaliacao
        FROM Avaliacoes
        WHERE id_estabelecimento = :estabelecimentoId AND EXTRACT(DAY FROM data) = :dia";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':dia', $dia, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_avaliacao'];
}

//Função complementar da função getAvaliacaoMediaDiaria()
function getSomaAvaliacoesDoDia($pdo, $estabelecimentoId, $dia)
{
    $query = "SELECT SUM(classificacao) AS total_avaliacao
        FROM Avaliacoes
        WHERE id_estabelecimento = :estabelecimentoId AND EXTRACT(DAY FROM data) = :dia";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':dia', $dia, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_avaliacao'];
}

function getAvaliacaoMediaDiaria($pdo, $estabelecimentoId, $dia)
{
    $somaAvaliacoes = getSomaAvaliacoesDoDia($pdo, $estabelecimentoId, $dia);
    $totalAvaliacoes = getTodasAvaliacoesDoDia($pdo, $estabelecimentoId, $dia);

    if ($totalAvaliacoes == 0) {
        return 0;
    }

    $media = $somaAvaliacoes / $totalAvaliacoes;
    return number_format($media, 2);
}

//Função complementar da função getAvaliacaoMediaMensal()
function getTodasAvaliacoesDoMes($pdo, $estabelecimentoId, $mes)
{
    $query = "SELECT COUNT(*) AS total_avaliacao
        FROM Avaliacoes
        WHERE id_estabelecimento = :estabelecimentoId AND EXTRACT(MONTH FROM data) = :mes";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_avaliacao'];
}

//Função complementar da função getAvaliacaoMediaMensal()
function getSomaAvaliacoesDoMes($pdo, $estabelecimentoId, $mes)
{
    $query = "SELECT SUM(classificacao) AS total_avaliacao
        FROM Avaliacoes
        WHERE id_estabelecimento = :estabelecimentoId AND EXTRACT(MONTH FROM data) = :mes";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_avaliacao'];
}

function getAvaliacaoMediaMensal($pdo, $estabelecimentoId, $mes)
{
    $somaAvaliacoes = getSomaAvaliacoesDoMes($pdo, $estabelecimentoId, $mes);
    $totalAvaliacoes = getTodasAvaliacoesDoMes($pdo, $estabelecimentoId, $mes);

    if ($totalAvaliacoes == 0) {
        return 0;
    }

    $media = $somaAvaliacoes / $totalAvaliacoes;
    return number_format($media, 2);
}

function getTempoMedio($pdo, $estabelecimentoId)
{
    $query = "SELECT tempo_medio_entrega AS tempo_medio
        FROM Estabelecimentos
        WHERE id_estabelecimento = :estabelecimentoId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':estabelecimentoId', $estabelecimentoId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['tempo_medio'];
}

$diaAtual = date("j");
$mesAtual = date("n");

$itemMaisPedidoDia = getItemMaisPedidoDiario($pdo, $idEstabelecimento, $diaAtual);

$itemMaisPedidoMes = getItemMaisPedidoMensal($pdo, $idEstabelecimento, $mesAtual);

$avaliacaoMediaDiaria = getAvaliacaoMediaDiaria($pdo, $idEstabelecimento, $diaAtual);

$avaliacaoMediaMensal = getAvaliacaoMediaMensal($pdo, $idEstabelecimento, $mesAtual);

$vendasDiarias = getVendasDiarias($pdo, $idEstabelecimento, $diaAtual);

$vendasMensais = getVendasMensais($pdo, $idEstabelecimento, $mesAtual);

$pedidosDiarios = getPedidosDiarios($pdo, $idEstabelecimento, $diaAtual);

$pedidosMensais = getPedidosMensais($pdo, $idEstabelecimento, $mesAtual);

$precoMedioDiario = getPrecoMedioDiario($pdo, $idEstabelecimento, $diaAtual);

$precoMedioMensal = getPrecoMedioMensal($pdo, $idEstabelecimento, $mesAtual);

$tempoMedioEntrega = getTempoMedio($pdo, $idEstabelecimento);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>Performance</title>
    <style>
        .card {
            overflow: auto;
            height: 160px;
            max-height: 160px;
            /* Defina a altura fixa desejada */
        }

        .grafico {
            overflow: auto;
            height: 380px;
            max-height: 380px;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Pedidos", {
                    role: "style"
                }],
                ["Jan", <?= getPedidosMensais($pdo, $estabelecimentoId, 1) ?>, "gold"],
                ["Fev", <?= getPedidosMensais($pdo, $estabelecimentoId, 2) ?>, "gold"],
                ["Mar", <?= getPedidosMensais($pdo, $estabelecimentoId, 3) ?>, "gold"],
                ["Abr", <?= getPedidosMensais($pdo, $estabelecimentoId, 4) ?>, "gold"],
                ["Mai", <?= getPedidosMensais($pdo, $estabelecimentoId, 5) ?>, "gold"],
                ["Jun", <?= getPedidosMensais($pdo, $estabelecimentoId, 6) ?>, "gold"],
                ["Jul", <?= getPedidosMensais($pdo, $estabelecimentoId, 7) ?>, "gold"],
                ["Ago", <?= getPedidosMensais($pdo, $estabelecimentoId, 8) ?>, "gold"],
                ["Set", <?= getPedidosMensais($pdo, $estabelecimentoId, 9) ?>, "gold"],
                ["Out", <?= getPedidosMensais($pdo, $estabelecimentoId, 10) ?>, "gold"],
                ["Nov", <?= getPedidosMensais($pdo, $estabelecimentoId, 11) ?>, "gold"],
                ["Dez", <?= getPedidosMensais($pdo, $estabelecimentoId, 12) ?>, "gold"],
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
                width: 820,
                height: 340,
                bar: {
                    groupWidth: "35%"
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
                ['Jan', <?= getPedidosMensais($pdo, $estabelecimentoId, 1) ?>],
                ['Fev', <?= getPedidosMensais($pdo, $estabelecimentoId, 2) ?>],
                ['Mar', <?= getPedidosMensais($pdo, $estabelecimentoId, 3) ?>],
                ['Abr', <?= getPedidosMensais($pdo, $estabelecimentoId, 4) ?>],
                ['Mai', <?= getPedidosMensais($pdo, $estabelecimentoId, 5) ?>],
                ['Jun', <?= getPedidosMensais($pdo, $estabelecimentoId, 6) ?>],
                ['Jul', <?= getPedidosMensais($pdo, $estabelecimentoId, 7) ?>],
                ['Ago', <?= getPedidosMensais($pdo, $estabelecimentoId, 8) ?>],
                ['Set', <?= getPedidosMensais($pdo, $estabelecimentoId, 9) ?>],
                ['Out', <?= getPedidosMensais($pdo, $estabelecimentoId, 10) ?>],
                ['Nov', <?= getPedidosMensais($pdo, $estabelecimentoId, 11) ?>],
                ['Dez', <?= getPedidosMensais($pdo, $estabelecimentoId, 12) ?>]
            ]);

            var options = {
                width: 820,
                height: 340,
                title: 'Vendas',
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

    <!-- NAVBAR -->
    <?php
    include __DIR__ . "/includes/header_business.php";
    ?>
    <!-- SIDEBAR -->
    <?php
    include __DIR__ . "/includes/sidebar_business.php";
    ?>
    <!-- Sumário diário -->
    <section id="pricing" class="bg-light pt-2 pb-2">
        <div class="container-lg">
            <div class="text-start mt-1">
                <h2 class="fw-bold">Performance</h2>
                <p class="lead text-muted fw-bold">Sumário diário.</p>
            </div>

            <!--1ª linha-->

            <div class="row my-4 gx-5 gy-3 align-items-center justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Vendas</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $vendasDiarias . "€" ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Pedidos</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $pedidosDiarios ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mt-1 mb-3">Preço médio</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $precoMedioDiario . "€" ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!--2ª linha-->
            <div class="row my-4 gx-5 gy-3 align-items-center justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Tempo médio de preparação</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $tempoMedioEntrega ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Avaliação média dos clientes</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $avaliacaoMediaDiaria ?><i class="ms-3 bi bi-star-fill"></i></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mt-1 mb-3">Item mais pedido</h4>
                            <p class="h2 mb-3 text-secondary fw-bold"><?php echo $itemMaisPedidoDia ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- end container -->
    </section>

    <!-- Sumário mensal -->

    <section id="pricing" class="bg-light pt-2 pb-2">
        <div class="container-lg">
            <div class="text-start mt-1">
                <p class="lead text-muted fw-bold">Sumário mensal.</p>
            </div>

            <!--1ª linha-->

            <div class="row my-4 gx-5 gy-3 align-items-center justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Vendas</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $vendasMensais . "€" ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Pedidos</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $pedidosMensais ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mt-1 mb-3">Preço médio</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $precoMedioMensal . "€" ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!--2ª linha-->
            <div class="row my-4 gx-5 gy-3 align-items-center justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Tempo médio de preparação</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $tempoMedioEntrega ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Avaliação média dos clientes</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold"><?php echo $avaliacaoMediaMensal ?><i class="ms-3 bi bi-star-fill"></i></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mt-1 mb-3">Item mais pedido</h4>
                            <p class="h2 mb-3 text-secondary fw-bold"><?php echo $itemMaisPedidoMes ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <!-- end container -->
    </section>

    <!-- Gráficos -->
    <section class="bg-light pt-2 pb-2">
        <div class="container-lg">
            <!-- Primeiro gráfico -->
            <div class="row my-4 gx-5 gy-3 align-items-center justify-content-start">
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="card grafico shadow border-1">
                        <div class="card-body text-center">
                            <div id="curve_chart" style=""></div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Segundo gráfico -->
            <div class="row my-4 gx-5 gy-3 align-items-center justify-content-start">
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="card grafico shadow border-1">
                        <div class="card-body text-center">
                            <div id="columnchart_values" style=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php
    include __DIR__ . "/includes/footer_business.php";
    ?>
</body>

</html>