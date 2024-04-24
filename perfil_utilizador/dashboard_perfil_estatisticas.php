<?php
session_start();

// Verificar se o usuário está logado
//if (!isset($_SESSION['username'])) {
//    header("Location: login.php");
//    exit();
//}

// Exibir nome de usuário
//echo "Welcome, " . $_SESSION['username'];
?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
  
  <!--Zona do Header -->
	<div id="topHeader" class="container-xxl">
		<!-- Top/Menu da Página -->
		<?php include "../includes/header.php"; ?>
	</div>

	<!--Zona de Conteudo -->
  <div id="contentPage" style="min-width:100%;" class="container-xl">
      <?php include "../includes/sidebarMenu.php"; ?>

        <!--Zona de Conteudo da Página -->
        <div id="contentDiv" class="col-md-12">

          <!-- <section class="section p-0"> -->
		   <div class="container">
				<div class="row">
					<h1 class="title">Estatísticas</h1>
					<p>Esta é a tua página de estatísticas. Aqui podes ver as estatísticas sobre a tua conta, tal como dinheiro total gasto</p>
				</div>
				
				<div class="row">
					<div id="infoEstatisticas" class="col-md-4">
						<!-- Card: Restaurante Mais Pedido -->
						<div class="card"> 
						  <img class="card-img-top" style="width:10%; margin-left:45%; margin-right:45%" src="../assets/imgs/burgerKing_marca.png" alt="Imagem do Restaurante" alt="Card image cap">
						  <div class="card-body">
							<h5 class="card-title">Restaurante Mais Pedido</h5>
							<p class="card-text">Burguer king</p>
						  </div>
						</div>
						<!-- Card: Total de Dinheiro Gasto -->
						<div class="card"> 
						  <div class="card-body">
							<h5 class="card-title">Total de Dinheiro Gasto</h5>
							<p class="card-text">825,73€</p>
						  </div>
						</div>
						<!-- Card: Média do Total de Dinheiro Gasto por Pedido -->
						<div class="card"> 
						  <div class="card-body">
							<h5 class="card-title">Média de Dinheiro Gasto</h5>
							<p class="card-text">11,63€</p>
						  </div>
						</div>
						<!-- Card: Tempo Médio de Entrega dos Pedidos -->
						<div class="card"> 
						  <div class="card-body">
							<h5 class="card-title">Tempo Médio de Entrega</h5>
							<p class="card-text">00:28</p>
						  </div>
						</div>					
					</div>
					<!-- Segunda Coluna: Gráficos -->
					<div id="grafEstatisticas" class="col-md-8">
						<div class="card"> 
						  <div class="card-body">
							<div id="curve_chart"></div>
						  </div>
						</div>	
						<div class="card"> 
						  <div class="card-body">
							<div id="columnchart_values"></div>
						  </div>
						</div>	
					</div>
				</div>
			</div>

		</div>	
	</div>

  <!--Limpa conteudo Float -->
  <div class="cleanFloat"></div>

  <!--Zona do Footer -->
  <div class="container">
    <?php include "../includes/footer.php"; ?>
  </div>

  </body>
</html>


