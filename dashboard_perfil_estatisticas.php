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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles/sitecss.css">
    <link rel="stylesheet" href="/assets/styles/responsive_styles.css">
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Pedidos", { role: "style" }],
                ["Jul", 19, "gold"],
                ["Ago", 25, "gold"],
                ["Set", 17, "gold"],
                ["Out", 16, "gold"],
                ["Nov", 14, "gold"],
                ["Dez", 21, "gold"],
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2]);

            var options = {
                title: "Números de pedido por mês",
                width: 800,
                height: 390,
                bar: { groupWidth: "12%" },
                legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Dinheiro gasto'],
                ['Jul', 100],
                ['Ago', 200],
                ['Set', 140],
                ['Out', 220],
                ['Nov', 180],
                ['Dez', 300]
            ]);

            var options = {
                width: 800,
                height: 300,
                title: 'Dinheiro gasto',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>


</head>

<body>
    <?php
    include __DIR__."/includes/header.php";
    ?>

    <!--Zona de Conteudo -->
    <div id="contentPage" style="min-width:100%;" class="container-xl">
        <div id="sideBarLeft" class="col-md-2">
            <div class="d-flex flex-column" id="sidebar">
                <ul class="nav nav-pills flex-column mb-auto nav-item-container">
                    <li class="nav-item" >
                        <a href="#" class="nav-link active" aria-current="page">
                            <span class="bi bi-speedometer">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <span class = "bi-person-vcard"></span><span class="bi has-text-grey">Perfil de Utilizador</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                        <span class = "bi-card-list"></span><span class="bi has-text-grey">Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                        <span class = "bi-graph-up"></span><span class="bi has-text-grey">Estatisticas</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                        <span class = "bi-credit-card-fill"></span><span class="bi has-text-grey">Método Pagamento</span>
                        </a>
                    </li>
                </ul>
     

                <button id="butSingOutSidebarLeft" class="btn btn-dark px-3" type="button">Terminar Sessão</button>

            </div>
        </div>

        <!--Zona de Conteudo da Página -->
        <div id="contentDiv" class="col-md-10 pl-2 pt-3 pb-0">

            <section class="section p-0">
                <div class="container ml-2 mb-2">
                    <div class="columns">
                        <div class="column is-full pb-0">
                            <h2 class="is-size-3 title mt-2 mb-2">Estatísticas</h2>
                            <p>Esta é a tua página de estatísticas. Aqui podes ver as estatísticas sobre a tua conta,
                                tal como dinheiro total gasto.</p>
                        </div>
                    </div>
                    <div class="columns">
                        <!-- Primeira Coluna: 5 Cards -->
                        <div class="column pt-0 is-3 mr-6">
                            <!-- Card: Restaurante Mais Pedido -->
                            <div class="card">
                                <div class="card-content">
                                    <p class="title is-5 has-text-centered">
                                        Restaurante Mais Pedido
                                    </p>
                                    <div class="columns is-vcentered">
                                        <div class="column ">
                                            <p
                                                class="subtitle is-6 ml-2 has-text-weight-bold has-text-grey">
                                                Burguer king
                                            </p>
                                        </div>
                                        <div class="column">
                                            <img src="../assets/imgs/burgerKing_marca.png" alt="Imagem do Restaurante" class="image is-64x64">
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Card: Número de Pedidos -->
                            <div class="card">
                                <div class="card-content px-0 pb-1">
                                    <p class=" title is-5 has-text-centered mb-3" >
                                        Total de pedidos realizados
                                    </p>
                                    <p class="subtitle is-3 has-text-centered has-text-weight-bold has-text-grey">
                                        71
                                    </p>
                                </div>
                            </div>

                            <!-- Card: Total de Dinheiro Gasto -->
                            <div class="card">
                                <div class="card-content px-0 pb-1">
                                    <p class="title is-5 has-text-centered mb-3">
                                        Total de Dinheiro Gasto
                                    </p>
                                    <p class="subtitle is-3 has-text-centered has-text-weight-bold has-text-grey">
                                        825,73€
                                    </p>
                                </div>
                            </div>

                            <!-- Card: Média do Total de Dinheiro Gasto por Pedido -->
                            <div class="card">
                                <div class="card-content px-0 pb-1">
                                    <p class="title is-5 has-text-centered mb-3">
                                        Média de Dinheiro Gasto
                                    </p>
                                    <p class="subtitle is-3 has-text-centered has-text-weight-bold has-text-grey">
                                        11,63€
                                    </p>
                                </div>
                            </div>

                            <!-- Card: Tempo Médio de Entrega dos Pedidos -->
                            <div class="card">
                                <div class="card-content px-0 pb-0">
                                    <p class="title is-5 has-text-centered mb-3">
                                        Tempo Médio de Entrega
                                    </p>
                                    <p class="subtitle is-3 has-text-centered has-text-weight-bold has-text-grey">
                                        00:28
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Segunda Coluna: Gráficos -->
                        <div class="column is-8 pt-0">
                            <!-- <img src="../assets/imgs/Frame 779.png" alt="Gráfico" class="px-2"> -->

                            <div class="card">
                                <div class="card-content p-2">
                                    <div id="curve_chart" style=""></div>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-content  p-2">
                                    <div id="columnchart_values" style="width: 400px;"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--Limpa conteudo Float -->
            <div class="cleanFloat"></div>

            <!--Zona do Footer -->
            <?php
                include __DIR__."/includes/footer.php";
            ?>
 

</body>

</html>