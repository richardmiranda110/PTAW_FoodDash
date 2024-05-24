<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../assets/styles/sitecss.css">
	<link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link rel="stylesheet" href="../Business/assets/styles/adicionar.css">
  </head>
  <style>
    .body {
        position: fixed;
    }
  </style>
  <body>

    <!-- Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
    </div>

    <!-- LISTA DE PEDIDOS -->  
    <div id="contentPage" class="container-xxl">
        <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
        <div id="contentDiv" class="col-md-12">
            <div class="container ps-3 py-3">
                <div class="row">
                    <h1 class="title" style="font-size: 2.1vw; font-weight: bold;">Pedidos</h1>
                </div>
                <nav style="font-size:1.4rem; z-index: 1; text-align: center;" class="navbar navbar-expand-lg navbar-light gray-navbar">
                    <div class="collapse navbar-collapse" style="width: 15vw;" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link nav" style="font-size: 1.2vw;" href="listapedidos.php">Todos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav" href="listapedidosPorEntregar.php" style="font-size: 1.2vw;  border-bottom: 1vh solid black;">Por Entregar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav " href="listapedidosEntregues.php" style="font-size: 1.2vw;">Entregues</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="container ps-3 py-3">
                <div class="container" style="margin-top: 2vh;">
                    <div id="ticket-info" class="row" style="padding: 1vh 1vw;">
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw;">Número</span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                        <span style="font-size: 1.3vw; margin-left: 1vh;">Data</span>
                        </div>
                        <div class="col-sm-5 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw; margin-right: 3vh;">Detalhes</span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw; margin-right: 4vh;">Estado</span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw; margin-right: 5vh;">Preço</span>
                        </div>
                        <div class="col-sm-1 align-self-center text-center">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOX LISTA DE PEDIDOS -->
            <div class="" id="listaPedidos" style="overflow-y: scroll; padding: 0vh 1vw; height: 57vh;">
                <?php include 'database/listar_pedidosPorEntregar.php'; ?>
            </div>
        </div>
    </div>

  <!--FOOTER -->
  <footer class="d-flex flex-wrap justify-content-end" style="margin-bottom: 0vh;">
  <p style="margin-bottom: 0vh; font-size: 0.9vw;">© 2024<p style="margin-bottom: 0vh; margin-left: 0.2vw; color: #FEBB41; font-size: 0.9vw;">Food</p><p style="margin-bottom: 0vh; font-size: 0.9vw;">Dash</p></p>
  </footer>

  </body>
</html>

