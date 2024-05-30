<?php
   require_once __DIR__.'/includes/session.php';
   
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
      <title>FoodDash Business</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <link rel="stylesheet" href="../../business/styles/adicionar.css">
      <link rel="stylesheet" href="../../assets/styles/sitecss.css">
      <link rel="stylesheet" href="../../assets/styles/dashboard.css">
      <link rel="stylesheet" href="./assets/styles/pedido_page.css">
      <script src="../../assets/js/dable.js"></script>
      <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .card {
            max-width: 50vw;
            border-radius: 15px;
            padding: 20px;
        }
      
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow-sm" style="margin:0 auto">
            <div class="card-body">
                <h3 class="card-title fw-bold">Menu Big King</h3>
                <p><strong>Data e Hora:</strong> 13:46 16/03/2024</p>
                <p><strong>Status do Pedido:</strong> Entregue</p>
                <p><strong>Preço:</strong> 9,28€</p>
                <p><strong>Método de Pagamento:</strong> Visa 1002 ************</p>

                <div class="col-md-3 mb-4">
                            <div class="card rounded-3 shadow-sm">
                                <div class="card-header py-3">
                                    <h4 class="my-0">Sundae da Morango</h4>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title pricing-card-title">1,49€</h6>
                                    <h6>Sundae de Morango</h6>
                                </div>
                            </div>
                        </div>



                <div class="customer-info mb-4">
                    <h5>Dados do Cliente</h5>
                    <p><strong>Nome:</strong> Maria Letria</p>
                    <p><strong>Telemóvel:</strong> 917 620 293</p>
                    <p><strong>Email:</strong> marialetria@gmail.com</p>
                    <p><strong>Morada:</strong> Avenida 25 de Abril 38, 3ºESQ, 3810-164, Aveiro</p>
                </div>

                  <div class="process-wrapper">
                     <div id="progress-bar-container">
                        <ul>
                           <li class="step step01 active">
                              <div class="step-inner">PEDIDO EFETUADO</div>
                           </li>
                           <li class="step step02 ">
                              <div class="step-inner">PREPARAÇÃO</div>
                           </li>
                           <li class="step step03">
                              <div class="step-inner">VIAGEM ATÉ DESTINO</div>
                           </li>
                           <li class="step step04">
                              <div class="step-inner">ENTREGUE</div>
                           </li>
                        </ul>
                        <div id="line">
                           <div id="line-progress"></div>
                        </div>
                     </div>
                     <div id="progress-content-section">
                        <div class="section-content efetuacao-pedido active">
                           <h2>Efetuação do Pedido</h2>
                           <p>O pedido foi efetuado.</p>
                           <div class="d-flex justify-content-center mt-4 mb-4">
                              <button class="btn btn-outline-warning btn-block" id="btn_comecar_preparar" style="color: #343a40;">Começar a Preparar</button>
                           </div>
                        </div>
                        <div class="section-content preparacao">
                           <h2>Preparação</h2>
                           <p>O pedido está em fase de preparação. Assim que o pedido estiver pronto para entrega dê-o ao seu entregador e carregue no botão abaixo para iniciar a fase entrega.</p>
                           <div class="d-flex justify-content-center mt-4 mb-4">
                              <button class="btn btn-outline-warning btn-block" id="btn_pedido_pronto" style="color: #343a40;">Pedido Pronto</button>
                           </div>
                        </div>
                        <div class="section-content viagem">
                           <h2>Viagem até ao Destino</h2>
                           <p>O pedido está a caminho do seu cliente.</p>
                        </div>
                        <div class="section-content entregue">
                           <h2>Entregue</h2>
                           <p>O pedido foi entregue com sucesso. Parabéns. Muito obrigado.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--Zona do Footer -->
      <?php include __DIR__ . "../../includes/footer_2.php"; ?>
      <script src="./assets/js/adicionar_pedido.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script>
         $(".step").click(function() {
             $(this).addClass("active").prevAll().addClass("active");
             $(this).nextAll().removeClass("active");
         });
         
         $(".step01").click(function() {
             $("#line-progress").css("width", "3%");
             $(".efetuacao-pedido").addClass("active").siblings().removeClass("active");
         });
         
         $(".step02, #btn_comecar_preparar").click(function() {
             $("#line-progress").css("width", "33%");
             $(".preparacao").addClass("active").siblings().removeClass("active");
             $(".step02").addClass("active");
         });
         
         $(".step03, #btn_pedido_pronto").click(function() {
             $("#line-progress").css("width", "66%");
             $(".viagem").addClass("active").siblings().removeClass("active");
             $(".step03").addClass("active");
         });
         
         $(".step04").click(function() {
             $("#line-progress").css("width", "100%");
             $(".entregue").addClass("active").siblings().removeClass("active");
         });
      </script>
   </body>
</html>