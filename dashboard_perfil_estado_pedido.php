<?php
session_start();

// // Verificar se o usuário está logado
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit();
// }

// // Exibir nome de usuário
// echo "Welcome, " . $_SESSION['username'];
// ?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/sitecss.css">
	<link rel="stylesheet" href="assets/styles/dashboard.css">
    
  </head>
  <body>
  <!--Zona do Header -->
  <div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include "includes/header_logged_in.php"; ?>

  </div>

  <!--Zona de Conteudo -->  
  <div id="contentPage" class="container-xxl">
  <?php include "includes/sidebar_perfil.php"; ?>

    <!--Zona de Conteudo da Página -->
    <div id="contentDiv" class="col-md-10">
      <div class="container ps-3 py-3">
        <div class="row">
        <h1 class="text title">Pedidos</h1>
            <p class="text subtitle">Esta é a tua página de pedidos. Aqui podes ver o teu histórico de pedidos feitos, ver o estado dos pedidos, etc.</p>
        </div>
        <div class="container ">
                <div class="row border my-3">
                  <div class="col-sm-1 fs-1 ">
				  <a href="dashboard_perfil_pedidos.php">
                    <i style="cursor:pointer" class="bi bi-arrow-left-short border border-2 rounded bg-light"></i>
					</a>
                  </div>
                  <div class=" rounded-left rounded-right align-self-center py-2 fs-6">
                      <p class="title display-6 fw-bold"><span>Menu Big King</span> - (<span>13:46</span>  <span>16/03/2024</span>)</p>
                      <p class="text">Big King + Batatas Médias + IceTea Manga</p>
                      <p class="text">Status do pedido: <span>💦</span></p>
                      <p class="text">Método de Pagamento: <span></span><span>Visa *****</span></p>
                      <p class="text">Preço: <span>9,28</span>€</p>
                  </div>

                  <div class="ps-3 py-3">MAP</div>

                  <div class="container mt-5 px-5 ">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="circle">1</div>
                        <div class="line flex-grow-1"></div>
                        <div class="circle">2</div>
                        <div class="line flex-grow-1"></div>
                        <div class="circle">3</div>
                        <div class="line flex-grow-1"></div>
                        <div class="circle">4</div>
                        <div class="line flex-grow-1 gradient-line"></div>
                        <div class="circle black-circle text-light">5</div>
                    </div>
                    <div class="d-flex justify-content-left align-items-left mb-4">
                      <div class="roadmap-item ten-percent-to-left align-items-top text-center"><span>Efetuação<br> do Pedido</span></div>
                      <div class="roadmap-item flex-grow-1"></div>
                      <div class="roadmap-item align-items-top text-center"><span>Recebimento<br> do Pedido</span></div>
                      <div class="roadmap-item flex-grow-1"></div>
                      <div class="roadmap-item ten-percent-to-left align-items-top text-center"><span>Em Preparação</span></div>
                      <div class="roadmap-item flex-grow-1"></div>
                      <div class="roadmap-item ten-percent-to-left align-items-top text-center"><span>Viagem Até<br> Sua Casa</span></div>
                      <div class="roadmap-item flex-grow-1"></div>
                      <div class="roadmap-item ten-percent-to-right align-items-top text-center"><span>Entregue</span></div>
                  </div>
                </div>
        </div>
    </div>
  </div>

  <!--Limpa conteudo Float -->
  <div class="cleanFloat"></div>

  <!--Zona do Footer -->
  <div class="container">
    <?php include __DIR__."/includes/footer_2.php"; ?>
  </div>

  </body>
</html>


