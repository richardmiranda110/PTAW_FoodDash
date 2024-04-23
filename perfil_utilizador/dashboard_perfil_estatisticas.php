<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/styles/sitecss.css">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">

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
                width: 600,
                height: 400,
                bar: { groupWidth: "15%" },
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
    
    ?>
    <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top da Página -->
        <div class="row">
            <div class="col-md-3">
                <img src="../assets/imgs/FoodDash.png" class="img-fluid" alt="Responsive image">
            </div>
            <div class="col-md-7"></div>
            <div class="col-md-2" style="text-align: right;">
                <button type="button" class="btn butAcount">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!--Zona de Menu -->
        <div class="row">
            <div id="topMenu" class="col with gy-12 gutters">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="collapse navbar-collapse" id="menuTop">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">MENU</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">CONTATOS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">EMPRESARIAL</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!--Zona de Conteudo -->
    <div id="contentPage" class="container-xxl">
        <div id="sideBarLeft" class="col-md-2">
            <div class="d-flex flex-column">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                            <span class="bi bi-speedometer">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <span class="bi bi-person-vcard">Perfil de Utilizador</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <span class="bi bi-card-list">Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <span class="bi bi-graph-up">Estatisticas</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <span class="bi bi-credit-card-fill">Método Pagamento</span>
                        </a>
                    </li>
                </ul>
                <hr>

                <button id="butSingOutSidebarLeft" class="btn btn-dark px-3" type="button">Terminar Sessão</button>

            </div>
        </div>

        <!--Zona de Conteudo da Página -->
        <div id="contentDiv" class="col-md-10">

            <section class="section">
                <div class="container">
                    <div class="columns">
                        <div class="column is-full">
                            <h1 class="is-size-1 title">Estatísticas</h1>
                            <p>Esta é a tua página de estatísticas. Aqui podes ver as estatísticas sobre a tua conta,
                                tal como dinheiro total gasto.</p>
                        </div>
                    </div>
                    <div class="columns">
                        <!-- Primeira Coluna: 5 Cards -->
                        <div class="column is-4">
                            <!-- Card: Restaurante Mais Pedido -->
                            <div class="card">
                                <div class="card-content">
                                    <p class="title is-6 has-text-centered">
                                        Restaurante Mais Pedido
                                    </p>
                                    <div class="columns is-vcentered">
                                        <div class="column is-two-thirds">
                                            <p
                                                class="subtitle is-6 has-text-centered has-text-weight-bold has-text-grey">
                                                Burguer king
                                            </p>
                                        </div>
                                        <div class="column">
                                            <img src="../assets/imgs/burgerKing_marca.png" alt="Imagem do Restaurante"
                                                class="image is-64x64">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Card: Número de Pedidos -->
                            <div class="card">
                                <div class="card-content">
                                    <p class="title is-6 has-text-centered">
                                        Total de pedidos realizados
                                    </p>
                                    <p class="subtitle is-2 has-text-centered has-text-weight-bold has-text-grey">
                                        71
                                    </p>
                                </div>
                            </div>

                            <!-- Card: Total de Dinheiro Gasto -->
                            <div class="card">
                                <div class="card-content">
                                    <p class="title is-6 has-text-centered">
                                        Total de Dinheiro Gasto
                                    </p>
                                    <p class="subtitle is-2 has-text-centered has-text-weight-bold has-text-grey">
                                        825,73€
                                    </p>
                                </div>
                            </div>

                            <!-- Card: Média do Total de Dinheiro Gasto por Pedido -->
                            <div class="card">
                                <div class="card-content">
                                    <p class="title is-6 has-text-centered">
                                        Média de Dinheiro Gasto por Pedido
                                    </p>
                                    <p class="subtitle is-2 has-text-centered has-text-weight-bold has-text-grey">
                                        11,63€
                                    </p>
                                </div>
                            </div>

                            <!-- Card: Tempo Médio de Entrega dos Pedidos -->
                            <div class="card">
                                <div class="card-content">
                                    <p class="title is-6 has-text-centered">
                                        Tempo Médio de Entrega dos Pedidos
                                    </p>
                                    <p class="subtitle is-2 has-text-centered has-text-weight-bold has-text-grey">
                                        00:28
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Segunda Coluna: Gráficos -->
                        <div class="column is-8">
                            <!-- <img src="../assets/imgs/Frame 779.png" alt="Gráfico" class="px-2"> -->

                            <div class="card">
                                <div class="card-content">
                                    <div id="curve_chart" style="width: 900px; height: 500px"></div>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-content">
                                    <div id="columnchart_values" style="width: 900px; height: 500px"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--Limpa conteudo Float -->
            <div class="cleanFloat"></div>

            <!--Zona do Footer -->
            <div class="container">
                <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-3 border-top">
                    <p class="col-md-4 mb-0 text-body-secondary">© 2024 FoodDash</p>

                    <a href="/"
                        class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                        <img src="../assets/imgs/FoodDash.png" class="img-fluid" alt="Responsive image">
                    </a>

                    <ul class="nav col-md-4 justify-content-end">
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Menu</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Contatos</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Empresarial</a></li>
                    </ul>
                </footer>
            </div>

</body>

</html>