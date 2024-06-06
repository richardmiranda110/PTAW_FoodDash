<?php
require_once  __DIR__ . "/includes/session.php";
require_once __DIR__ . "/../database/credentials.php";
require_once __DIR__ . "/../database/db_connection.php";

if (!isset($_SESSION['authenticatedB']) || !isset($_SESSION['id_empresa'])) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    header("Location: /Business/login_register/login_business.php");
    exit();
}

$idEmpresa = $_SESSION['id_empresa'];

function ObterEstatisticas()
{
    global $pdo;
    $query = 'SELECT (SELECT round(sum(precototal),2) from pedidos where id_estabelecimento = :id_estabelecimento) as vendas,
    (SELECT count(id_pedido) from pedidos where id_estabelecimento = :id_estabelecimento) as pedidos,
   (select avg(pedidos.precototal) from pedidos 
   inner join estabelecimentos on estabelecimentos.id_estabelecimento = pedidos.id_estabelecimento 
   where pedidos.id_estabelecimento = :id_estabelecimento) as precomedio;';
    try {
        // query
        $stmt =
            $pdo->prepare($query);

        $stmt->bindValue(":id_estabelecimento", $_SESSION['id_estabelecimento']);
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
              ON Pedidos.id_estabelecimento = Estabelecimentos.id_estabelecimento 
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
    <div id="contentPage" class="container-xxl mt-5">

        <!--Zona de Conteudo da Página -->
        <p class="ml-4 mt-4 mb-0 text-white"> a</p>
        <p class=" h3 ml-4 mt-3 mb-0"><strong>Sumário de Hoje</strong></>

        <div class="row row-cols-1 row-cols-md-3 g-4 ml-2 mt-2 mr-2 w-75">
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

        <div class="row">
            <div class="col-md-3">
                <div class="m-5">
                    <h2 class="text-xl font-semibold mb-4">Ações Rápidas</h2>
                    <div class="list-group list-group-flush">
                        <!-- Ver todo o estabelecimento -->
                        <a href="./performance.php" type="button" class="list-group-item list-group-item-action" aria-current="true">
                            Ver todo o estabelecimento
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </a>

                        <!-- Ver Itens -->
                        <a href="./dashboard_lista_items.php" type="button" class="list-group-item list-group-item-action">
                            Ver Itens
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
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Vendas</h2>
                            <div class="flex space-x-2">
                                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-3 py-1 text-sm">
                                    Month
                                </button>
                                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-3 py-1 text-sm">
                                    Week
                                </button>
                            </div>
                        </div>

                        <div class="w-full h-[300px]">
                            <div style="width:100%;height:100%">
                                <div style="position: relative;">
                                    <canvas id="vendasChart"></canvas>
                                    <!--<svg xmlns="http://www.w3.org/2000/svg" width="1050" height="300" role="application">
                                        <rect width="1050" height="300" fill="transparent"></rect>
                                        <g transform="translate(40,10)">
                                            <g>
                                                <line opacity="1" x1="0" x2="0" y1="0" y2="250" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="200" x2="200" y1="0" y2="250" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="400" x2="400" y1="0" y2="250" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="600" x2="600" y1="0" y2="250" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="800" x2="800" y1="0" y2="250" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="1000" x2="1000" y1="0" y2="250" stroke="#f3f4f6" stroke-width="1"></line>
                                            </g>
                                            <g>
                                                <line opacity="1" x1="0" x2="1000" y1="250" y2="250" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="0" x2="1000" y1="189" y2="189" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="0" x2="1000" y1="127" y2="127" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="0" x2="1000" y1="66" y2="66" stroke="#f3f4f6" stroke-width="1"></line>
                                                <line opacity="1" x1="0" x2="1000" y1="5" y2="5" stroke="#f3f4f6" stroke-width="1"></line>
                                            </g>
                                            <g transform="translate(0,250)">
                                                <g transform="translate(0,0)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="text-before-edge" text-anchor="middle" transform="translate(0,16) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        Jan
                                                    </text>
                                                </g>
                                                <g transform="translate(200,0)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="text-before-edge" text-anchor="middle" transform="translate(0,16) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        Feb
                                                    </text>
                                                </g>
                                                <g transform="translate(400,0)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="text-before-edge" text-anchor="middle" transform="translate(0,16) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        Mar
                                                    </text>
                                                </g>
                                                <g transform="translate(600,0)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="text-before-edge" text-anchor="middle" transform="translate(0,16) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        Apr
                                                    </text>
                                                </g>
                                                <g transform="translate(800,0)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="text-before-edge" text-anchor="middle" transform="translate(0,16) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        May
                                                    </text>
                                                </g>
                                                <g transform="translate(1000,0)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="text-before-edge" text-anchor="middle" transform="translate(0,16) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        Jun
                                                    </text>
                                                </g>
                                                <line x1="0" x2="1000" y1="0" y2="0" style="stroke: transparent; stroke-width: 1;"></line>
                                            </g>
                                            <g transform="translate(0,0)">
                                                <g transform="translate(0,250)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="central" text-anchor="end" transform="translate(-16,0) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        0
                                                    </text>
                                                </g>
                                                <g transform="translate(0,189)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="central" text-anchor="end" transform="translate(-16,0) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        50
                                                    </text>
                                                </g>
                                                <g transform="translate(0,127)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="central" text-anchor="end" transform="translate(-16,0) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        100
                                                    </text>
                                                </g>
                                                <g transform="translate(0,66)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="central" text-anchor="end" transform="translate(-16,0) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        150
                                                    </text>
                                                </g>
                                                <g transform="translate(0,5)" style="opacity: 1;">
                                                    <line x1="0" x2="0" y1="0" y2="0" style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                                    <text dominant-baseline="central" text-anchor="end" transform="translate(-16,0) rotate(0)" style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                        200
                                                    </text>
                                                </g>
                                                <line x1="0" x2="0" y1="0" y2="250" style="stroke: transparent; stroke-width: 1;"></line>
                                            </g>
                                            <path d="M0,176C66.66666666666667,183.5,133.33333333333331,191,200,191C266.6666666666667,191,333.3333333333333,33,400,33C466.6666666666667,33,533.3333333333334,154,600,154C666.6666666666666,154,733.3333333333334,146.66666666666666,800,132C866.6666666666666,117.33333333333333,933.3333333333334,58.66666666666667,1000,0" fill="none" stroke-width="2" stroke="#e11d48"></path>
                                            <path d="M0,197C66.66666666666667,139.5,133.33333333333331,82,200,82C266.6666666666667,82,333.3333333333333,175,400,175C466.6666666666667,175,533.3333333333334,72,600,72C666.6666666666666,72,733.3333333333334,218,800,218C866.6666666666666,218,933.3333333333334,139.5,1000,61" fill="none" stroke-width="2" stroke="#2563eb"></path>
                                            <g>
                                                <g transform="translate(1000, 0)" style="pointer-events: none;">
                                                    <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(800, 132)" style="pointer-events: none;">
                                                    <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(600, 154)" style="pointer-events: none;">
                                                    <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(400, 33)" style="pointer-events: none;">
                                                    <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(200, 191)" style="pointer-events: none;">
                                                    <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(0, 176)" style="pointer-events: none;">
                                                    <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(1000, 61)" style="pointer-events: none;">
                                                    <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(800, 218)" style="pointer-events: none;">
                                                    <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(600, 72)" style="pointer-events: none;">
                                                    <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(400, 175)" style="pointer-events: none;">
                                                    <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(200, 82)" style="pointer-events: none;">
                                                    <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                                <g transform="translate(0, 197)" style="pointer-events: none;">
                                                    <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0" style="pointer-events: none;"></circle>
                                                </g>
                                            </g>
                                            <g>
                                                <rect width="1000" height="250" fill="red" opacity="0" style="cursor: auto;">
                                                </rect>
                                            </g>
                                        </g>
                                    </svg>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <!-- Ações rápidas -->

    </div>
    <!--Fim do conteúdo de página-->
    <?php
    include __DIR__ . "/includes/footer_business.php";
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