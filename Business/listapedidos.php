<?php
require_once './includes/session.php';

if(!isset($_SESSION['id_estabelecimento']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
    header("Location: /Business/dashboard_home_page.php");
    exit();
}
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
    <link rel="stylesheet" href="../Business/assets/styles/listapedidos.css">
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
    <div id="contentPage" class="container">
        <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
        <div id="contentDiv" class="col">
            <div class="container ps-3 py-3">
                <div class="row">
                    <h1 class="title" style="font-size: 2.1vw; font-weight: bold;">Pedidos</h1>
                </div>
                <div class="row">
                    <nav style="font-size:1.4rem; z-index: 1; text-align: center;" class="navbar navbar-expand navbar-light">
                        <div class="collapse navbar-collapse" style="width: 15vw; margin-left: 1vw;" id="navbarNav">
                            <ul class="navbar-nav" style="margin-left: 1vw;">
                                <li class="nav-item">
                                    <a class="nav-link nav" style="font-size: 1.2vw; border-bottom: 1vh solid black; width: 12vw; display: inline-block;" href="listapedidos.php">Todos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nav" href="listapedidosPorEntregar.php" style="font-size: 1.2vw; width: 12vw; display: inline-block;">Por Entregar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nav " href="listapedidosEntregues.php" style="font-size: 1.2vw; width: 12vw; display: inline-block;">Entregues</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="container">
                <div class="" style="margin-top: 2vh;">
                    <div id="ticket-info" class="d-flex justify-content-between" style="padding: 1vh 1vw; display: inline-block;">
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw; display: inline-block;">Número</span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw; margin-left: 1vh; display: inline-block;">Data</span>
                        </div>
                        <div class="col-sm-5 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw; margin-right: 3vh; display: inline-block;">Detalhes</span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw; margin-right: 4vh; display: inline-block;">Estado</span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw; margin-right: 5vh; display: inline-block;">Preço</span>
                        </div>
                        <div class="col-sm-1 align-self-center text-center">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOX LISTA DE PEDIDOS -->
            <div class="" id="listaPedidos" style="overflow-y: scroll; padding: 0vh 1vw; height: 57vh;">
                <?php include 'database/listar_pedidos.php'; ?>
            </div>
        </div>
    </div>

  <!--FOOTER -->
  <footer class="d-flex flex-wrap justify-content-end" style="margin-bottom: 0vh;">
  <p style="margin-bottom: 0vh; font-size: 0.9vw;">© 2024<p style="margin-bottom: 0vh; margin-left: 0.2vw; color: #FEBB41; font-size: 0.9vw;">Food</p><p style="margin-bottom: 0vh; font-size: 0.9vw;">Dash</p></p>
  </footer>

  </body>
</html>

