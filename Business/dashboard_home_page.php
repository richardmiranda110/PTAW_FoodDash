<?php
require_once  __DIR__ . "/includes/session.php";
require_once __DIR__ . "/../database/credentials.php";
require_once __DIR__ . "/../database/db_connection.php";

if (!isset($_SESSION['authenticatedB']) || !isset($_SESSION['id_empresa'])) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ./login_register/login_business.php");
    exit();
}

$idEmpresa = $_SESSION['id_empresa'];

function ObterEstatisticas()
{
    global $pdo;
    $query = 'SELECT (SELECT round(sum(precototal),2) from pedidos where id_empresa = :id_empresa) as vendas,
    (SELECT count(id_pedido) from pedidos where id_empresa = :id_empresa) as pedidos,
   (select round(avg(pedidos.precototal),2) from pedidos 
   inner join estabelecimentos on estabelecimentos.id_empresa = pedidos.id_empresa 
   where pedidos.id_empresa= :id_empresa) as precomedio;';
    try {
        // query
        $stmt =
            $pdo->prepare($query);

        $stmt->bindValue(":id_empresa", $_SESSION['id_empresa']);
        // Executar a query e verificar que não retornou false
        if ($stmt->execute()) {
            // Fetch retorna um único resultado, então usamos fetch() e não fetchAll()
            $registo = $stmt->fetch();
            // Retornar os dados
            return $registo;
        } else {
            // Se a consulta falhar, retornar null
            return null;
        }
    } catch (Exception $e) {
        echo "Erro na conexão à BD: " . $e->getMessage();
        // Se ocorrer um erro, retornar null
        return null;
    }
}

$estatisticas = ObterEstatisticas();

function getVendasMensais($pdo, $idEmpresa, $mes)
{
    $query = "SELECT SUM(precoTotal) AS total_dinheiro
        FROM Pedidos
        JOIN Estabelecimentos 
              ON Pedidos.id_empresa = Estabelecimentos.id_empresa 
              WHERE Estabelecimentos.id_empresa = :empresaId
          AND EXTRACT(MONTH FROM data) = :mes";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':empresaId', $idEmpresa, PDO::PARAM_INT);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['total_dinheiro'];
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Utilizador</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./assets/imgs/t_fd_logo_tab_icon.png">
    <link rel="stylesheet" href="../assets/styles/sitecss.css">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link rel="stylesheet" href="../assets/styles/responsive_styles.css">
</head>

<body>

    <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top/Menu da Página -->
        <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
        <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
    </div>

    <!--Zona de Conteudo -->
    <div id="contentPage" class="container-xxl mt-5" style="margin: auto !important; width: 80vw;">

        <!--Zona de Conteudo da Página -->
        <p class="ml-4 mt-4 mb-0 text-white"> a</p>
        <p class=" h3 ml-4 mt-3 mb-0"><strong>Sumário de Hoje</strong></>

        <div class="row row-cols-1 row-cols-md-3 g-4 ml-2 mt-2 mr-2 w-100">
            <!-- Vendas -->
            <div class="col ">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Vendas</h5>
                        <p class="card-text"><?php echo ($estatisticas['vendas'] ? $estatisticas['vendas'] : 0) ?> €</p>
                    </div>
                </div>
            </div>

            <!-- Pedidos -->
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Pedidos</h5>
                        <p class="card-text"><?php echo $estatisticas['pedidos']  ?></p>
                    </div>
                </div>
            </div>

            <!-- Preço Médio de Pedidos-->
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Preço Médio de Pedidos</h5>
                        <p class="card-text"><?php echo ($estatisticas['precomedio'] ? $estatisticas['precomedio'] : 0) ?> €</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Ações rápidas -->
        <div class="row" style="margin: auto !important">
            <div class="col-md-3">
                <div class="m-5 ml-1">
                    <h2 class="text-xl font-semibold mb-4" style="width: 15vw">Ações Rápidas</h2>
                    <div class="list-group list-group-flush" style="width: 15vw">
                        <!-- Ver todo o estabelecimento -->
                        <a href="./empresa_page.php" type="button" class="list-group-item list-group-item-action" aria-current="true">
                            Ver info empresa
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </a>

                        <!-- Ver Itens -->
                        <a href="./dashboard_lista_items.php" type="button" class="list-group-item list-group-item-action">
                            Ver itens
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </a>

                        <!-- Ver pedidos -->
                        <a href="./listapedidos.php" type="button" class="list-group-item list-group-item-action">
                            Ver pedidos
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </a>

                        <!-- Ver avalições -->
                        <a href="./avaliacoes.php" type="button" class="list-group-item list-group-item-action">
                            Ver avaliações
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col space-y-6">
                    <!-- Gráfico -->
                    <div class="m-5">
                        <div class="flex justify-between items-center mb-0">
                            <h2 class="text-xl font-semibold">Vendas</h2>
                        </div>
                        <style>
                            .chart {
                                max-width:100%; 
                                min-height: 400px;
                            }
                            .row {
                                margin:0 !important;
                            }
                        </style>

                        <div class="w-full h-[300px]">
                            <div style="width:100%;height:100%">
                                <div style="position: relative;">
                                    <canvas id="vendasChart" class="chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Fim do conteúdo de página-->

    <?php
    include "./includes/footer_business_2.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const vendasChart = document.getElementById('vendasChart').getContext('2d');

        new Chart(vendasChart, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Vendas',
                    data: [
                        <?= (getVendasMensais($pdo, $idEmpresa, 1)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 1)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 2)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 2)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 3)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 3)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 4)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 4)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 5)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 5)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 6)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 6)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 7)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 7)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 8)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 8)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 9)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 9)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 10)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 10)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 11)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 11)) ?>,
                        <?= (getVendasMensais($pdo, $idEmpresa, 12)) == 0 ? 0 : (getVendasMensais($pdo, $idEmpresa, 12)) ?>
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