<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/database/credentials.php';
require_once __DIR__ . '/database/db_connection.php';

if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
    header("Location: /index.php");
    exit();
}

function ObterUmUtilizador($pdo, $ID)
{
    if ($_SESSION['id_cliente'] != $ID) {
        header("Location: /index.php");
        exit();
    }

    try {
        // query
        $stmt = $pdo->prepare('SELECT id_cliente, nome, apelido, email, telemovel, morada, cidade, pais, codpostal
        FROM clientes WHERE id_cliente = ?');
        // Executar a query e verificar que não retornou false
        if ($stmt->execute([$ID])) {
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

// Recebendo dados da BD
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Obter os dados do utilizador
    $utilizador = ObterUmUtilizador($pdo, $_SESSION['id_cliente']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Utilizador</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/styles/sitecss.css">
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <link rel="stylesheet" href="assets/styles/dashboard_beatriz.css">
	<style>
		.chart-container {
   width: 50vw;
   height:310px;
}
	</style>
</head>

<body>

    <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top/Menu da Página -->
        <?php include __DIR__ . "/includes/header_logged_in.php"; ?>
    </div>

    <!--Zona de Conteudo -->
    <div id="contentPage" class="container-xxl">
        <?php include __DIR__ . "/includes/sidebar_perfil.php"; ?>

        <!--Zona de Conteudo da Página -->
        <div id="contentDiv" class="col-md-12">
            <div class="container ps-1 py-0">
                <div class="dashboard texto_perfil">
                    <p class="h3 mb-4 fw-semibold">Olá, <?php echo htmlspecialchars($utilizador['nome']) ?></p>
                    <p>Esta é a tua página de perfil. Aqui podes ver as tuas informações pessoais, ver estatísticas,
                        sobre a tua
                        conta, ver os teus pedidos e acompanhar o estado dos teus pedidos em tempo real</p>

                    <div class="d-flex flex-column">
                        <div class="row align-items-md-stretch mb-4">
                            <div class="col-md-5">
                                <div class="p-3 bg-body-tertiary border rounded-3">
                                    <div class="d-flex mb-3 justify-content-between">
                                        <h4 style="float:left">Perfil do utilizador</h4>
                                        <a class="btn btn-warning" href="/perfil.php"> Editar </a>
                                    </div>
                                    <div>
                                        <div class="mb-2">
                                            <span class="dados fw-bold ">Nome:</span>
                                            <span class="dados_utilizador mb-4">
                                                <?php if (!empty($utilizador['nome']))
                                                    echo htmlspecialchars($utilizador['nome']); ?>
                                                <?php if (!empty($utilizador['apelido']))
                                                    echo htmlspecialchars($utilizador['apelido']); ?>
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="dados fw-bold">Email:</span>
                                            <span class="dados_utilizador">
                                                <?php if (!empty($utilizador['email']))
                                                    echo  str_repeat("*", strlen($utilizador['email'])-6) . substr($utilizador['email'], -8);$utilizador['email']; ?>
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="dados fw-bold">Nº de Telemóvel:</span>
                                            <span class="dados_utilizador">
                                                <?php echo str_repeat("*", strlen($utilizador['telemovel'])-4) . substr($utilizador['telemovel'], -4); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="direito">
                                        <div class="mb-2">
                                            <span class="dados fw-bold">Morada:</span>
                                            <span class="dados_utilizador">
                                                <?php if (!empty($utilizador['morada']))
                                                    echo htmlspecialchars($utilizador['morada']); ?>
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="dados fw-bold">Cidade:</span>
                                            <span class="dados_utilizador">
                                                <?php if (!empty($utilizador['cidade']))
                                                    echo htmlspecialchars($utilizador['cidade']); ?>
                                            </span>
                                        </div>
                                        <div class="mb-0">
                                            <span class="dados fw-bold">Código Postal:</span>
                                            <span class="dados_utilizador">
                                                <?php if (!empty($utilizador['codpostal']))
                                                    echo htmlspecialchars($utilizador['codpostal']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
								
								<div class="pedidos">
                        <div class="a">
						<div class="w-100 p-3 pb-0 bg-body-tertiary border rounded-3">
    <div class="d-flex mb-4 justify-content-between">
        <p class="h4 mb-0 mt-1">Ultimo Pedido</p>
        <a href="./dashboard_perfil_pedidos.php" class="btn btn-warning">Visualizar Pedidos</a>
    </div>
    <div>
        <div class="card mb-4">
            <div class="card-body d-flex flex-row align-items-end">
                <div class="align-self-center me-auto">
                    <p class="texto_pedido align-self-center m-0" style="text-align: center;">13:46</p>
                    <p class="texto_pedido m-0" style="">16/03/2024</p>
                </div>
                <div class="align-self-center me-auto">
                    <p class="m-0">Menu Big King<span>(Burger King)</span></>
                    <p class="texto_pedido m-0">(Big King + Batatas Médias + Ice Tea Manga)</p>
                </div>
                <div class="align-self-center me-auto">

                    <div class="mb-2 align-self-center">
                        <span class=" m-0 texto_pedido_negrito">Status:</span><br>
                        <span class="texto_pedido m-0">Entregue</span>
                    </div>
                </div>
                <div class=" m-0 align-self-center me-auto" style="">
                    <p class="h6 text-center">9,28€</p>
                </div>
            </div>
        </div>
    </div>
</div>

                        </div>
                    </div>
                            </div>
                            <div class="col-md-7">
                                <div class="p-3 pb-1 bg-body-tertiary border rounded-3">
                                    <div class="d-flex mb-3 justify-content-between">
                                        <h4 style="">Estatísticas</h4>
                                        <a class="btn btn-warning" href="./dashboard_perfil_estatisticas.php"> Visualizar </a>
                                    </div>
                                    <div class="">
                                        <div class="mb-2">
                                            <span class="dados fw-bold">Dinheiro Total Gasto:</span>
                                            <span class="dados_utilizador">489,27€</span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="dados fw-bold">Total de Pedidos Realizados:</span>
                                            <span class="dados_utilizador">71</span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="dados fw-bold">Restaurante Mais Pedido:</span>
                                            <span class="dados_utilizador">McDonald's</span>
                                        </div>
                                    </div>

                                    <div  class="chart-container">
                                        <canvas id="lineChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php include __DIR__ . "/includes/footer_2.php"; ?>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                    crossorigin="anonymous"></script>
                <script>
                    var ctx = document.getElementById('lineChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ["Dez", "Jan", "Fev", "Mar"],
                            datasets: [{
                                label: 'Total de Pedidos',
                                data: [12, 18, 24, 30],
                                backgroundColor: 'transparent',
                                borderColor: '#d1c217',
                                borderWidth: 2
                            }]
                        },
                        options: {
						    responsive: true,
							maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        suggestedMax: 30
                                    }
                                }]
                            },
                            title: {
                                display: true,
                                text: 'Total de Pedidos'
                            }
                        }
                    });
                </script>
</body>

</html>
