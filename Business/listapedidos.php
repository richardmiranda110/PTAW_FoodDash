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
                <nav style="font-size:1.4rem; z-index: 1; text-align: center;" class="navbar navbar-expand-lg gray-navbar navbar-light fw-bold ">
                    <div class="collapse navbar-collapse" style="width: 15vw;" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link nav" style="border-bottom: 1vh solid black;" href="#">Todos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav" href="#">Por Entregar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav " href="#">Entregues</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- BOX LISTA DE PEDIDOS -->
                <div class="container" style="margin-top: 2vh;">
                    <div id="ticket-info" class="row" style="padding: 1vh;">
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw;">Número</span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                        <span style="font-size: 1.3vw;">Data</span>
                        </div>
                        <div class="col-sm-5 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw;">Detalhes</span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw;">Estado</span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center">
                            <span style="font-size: 1.3vw;">Preço</span>
                        </div>
                        <div class="col-sm-1 align-self-center text-center">
                        </div>
                    </div>
                </div>
                <div class="container" style="margin-top: 0vh;">
                    <div id="ticket-info" class="row border border-2 border-secondary rounded-4" style="padding: 1vh; height: 10vh;">
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.5vw;">1</strong>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-size: 0.8vw;">13:46<br>16/03/24</span>
                        </div>
                        <div class="col-sm-5 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Menu Big King (Burger King)<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">(Big King + Batatas Médias + IceTea Manga)</span></span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Estado do pedido:<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">Pedido em Processamento</span></span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.3vw;">9,28€</strong>
                        </div>
                        <div class="col-sm-1 align-self-center text-center">
                            <a href="pedido.php">
                            <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="container" style="margin-top: 2vh;">
                    <div id="ticket-info" class="row border border-2 border-secondary rounded-4" style="padding: 1vh; height: 10vh;">
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.5vw;">2</strong>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-size: 0.8vw;">13:46<br>16/03/24</span>
                        </div>
                        <div class="col-sm-5 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Menu Big King (Burger King)<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">(Big King + Batatas Médias + IceTea Manga)</span></span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Estado do pedido:<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">Pedido em Processamento</span></span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.3vw;">9,28€</strong>
                        </div>
                        <div class="col-sm-1 align-self-center text-center">
                            <a href="dashboard_perfil_estado_pedido.php">
                            <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="container" style="margin-top: 2vh;">
                    <div id="ticket-info" class="row border border-2 border-secondary rounded-4" style="padding: 1vh; height: 10vh;">
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.5vw;">3</strong>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-size: 0.8vw;">13:46<br>16/03/24</span>
                        </div>
                        <div class="col-sm-5 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Menu Big King (Burger King)<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">(Big King + Batatas Médias + IceTea Manga)</span></span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Estado do pedido:<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">Pedido em Processamento</span></span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.3vw;">9,28€</strong>
                        </div>
                        <div class="col-sm-1 align-self-center text-center">
                            <a href="dashboard_perfil_estado_pedido.php">
                            <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="container" style="margin-top: 2vh;">
                    <div id="ticket-info" class="row border border-2 border-secondary rounded-4" style="padding: 1vh; height: 10vh;">
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.5vw;">4</strong>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-size: 0.8vw;">13:46<br>16/03/24</span>
                        </div>
                        <div class="col-sm-5 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Menu Big King (Burger King)<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">(Big King + Batatas Médias + IceTea Manga)</span></span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Estado do pedido:<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">Pedido em Processamento</span></span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.3vw;">9,28€</strong>
                        </div>
                        <div class="col-sm-1 align-self-center text-center">
                            <a href="dashboard_perfil_estado_pedido.php">
                            <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="container" style="margin-top: 2vh;">
                    <div id="ticket-info" class="row border border-2 border-secondary rounded-4" style="padding: 1vh; height: 10vh;">
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.5vw;">5</strong>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-size: 0.8vw;">13:46<br>16/03/24</span>
                        </div>
                        <div class="col-sm-5 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Menu Big King (Burger King)<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">(Big King + Batatas Médias + IceTea Manga)</span></span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <span style="font-weight: bold; font-size: 0.8vw;">Estado do pedido:<br>
                            <span style="font-weight: normal; font-size: 0.8vw;">Pedido em Processamento</span></span>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center text-center align-self-center" style="border-right: solid 0.2vw lightgrey; height: 100%; align-items: center;">
                            <strong style="font-size: 1.3vw;">9,28€</strong>
                        </div>
                        <div class="col-sm-1 align-self-center text-center">
                            <a href="dashboard_perfil_estado_pedido.php">
                            <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!--FOOTER -->
  <footer class="d-flex flex-wrap justify-content-end" style="margin-bottom: 0vh;">
  <p style="margin-bottom: 0vh; font-size: 0.9vw;">© 2024<p style="margin-bottom: 0vh; margin-left: 0.2vw; color: #FEBB41; font-size: 0.9vw;">Food</p><p style="margin-bottom: 0vh; font-size: 0.9vw;">Dash</p></p>
  </footer>

  </body>
</html>

