<?php

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
            height: 360px;
            max-height: 360px;
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
                2
            ]);

            var options = {
                title: "Números de pedido por mês",
                width: 800,
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
                            <p class="display-5 mb-3 text-secondary fw-bold">469,70€</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Pedidos</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold">110</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mt-1 mb-3">Preço médio</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold">70,70€</p>
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
                            <p class="display-5 mb-3 text-secondary fw-bold">00:11</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Avaliação média dos clientes</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold">4.4<i class="ms-3 bi bi-star-fill"></i></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mt-1 mb-3">Item mais pedido</h4>
                            <p class="h2 mb-3 text-secondary fw-bold">Menu Burguer King</p>
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
                            <p class="display-5 mb-3 text-secondary fw-bold">469,70€</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Pedidos</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold">110</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mt-1 mb-3">Preço médio</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold">70,70€</p>
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
                            <p class="display-5 mb-3 text-secondary fw-bold">00:11</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mb-3">Avaliação média dos clientes</h4>
                            <p class="display-5 mb-3 text-secondary fw-bold">4.4<i class="ms-3 bi bi-star-fill"></i></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow border-1">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold mt-1 mb-3">Item mais pedido</h4>
                            <p class="h2 mb-3 text-secondary fw-bold">Menu Burguer King</p>
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