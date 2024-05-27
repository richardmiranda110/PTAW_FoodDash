<?php
require_once './session.php';

if(!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
  header("Location: /index.php");
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
	<link rel="stylesheet" href="assets/styles/sitecss.css">
	<link rel="stylesheet" href="assets/styles/dashboard.css">
  </head>
  <body>
  <!--Zona do Header -->
  <div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include __DIR__."/includes/header_logged_in.php"; ?>

    
  </div>

  <!--Zona de Conteudo -->  
  <div id="contentPage" class="container-xxl">
    <?php include __DIR__."/includes/sidebar_perfil.php"; ?>

    <!--Zona de Conteudo da Página -->
    <div id="contentDiv" class="col-md-12">
      <div class="container ps-3 py-3">
        <div class="row">
        <h1 class="title">Pedidos</h1>
            <p>Esta é a tua página de pedidos. Aqui podes ver o teu histórico de pedidos feitos, ver o estado dos pedidos, etc.</p>
        </div>
        <div class="container ">
              <!-- START OF SLIDE-->
                <div id="ticket-info" class="row border border-2 border-secondary rounded my-3">
                  <div class="col-sm-1 text-center align-self-center py-2 fs-6 "><span>13:46</span><br><span>16/03/24</span></div>
                  <div class="col-sm-5 rounded-left rounded-right align-self-center py-2 px-5 fs-6">
                      <strong>Menu Big King </strong> (Burger King)<br>
                      <small>(Big King + Batatas Médias + IceTea Manga)</small>
                  </div>
                  <div class="col-sm-4 align-self-center py-2">
                         <strong>Método de Pagamento:</strong> Visa ****1002<br>
                         <span><strong>Status do pedido:</strong> Pedido em Processamento</span></small>
                  </div>
                  <div class="col-sm-1 text-center align-self-center fs-4 py-4 "><strong>9,28€</strong></div>
                  <div class="col-sm-1 align-self-center text-center h-60"><strong><img class="img-fluid p-3" src="/assets/imgs/icon_info.jpg" alt="" srcset=""></strong></div>
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


