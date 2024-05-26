<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/styles/sitecss.css">
  <title>FoodDash</title>
  <style>
    .content_our_story {
      width: 80vw;
      position: relative;
      top: 4vw;
      left: 10vw;
    }

    .fooddash_logo {
      position: absolute;
      right: 0;
      width: 17.5vw;
      height: auto;
    }
  </style>
</head>

<body>
  <!-- HEADER -->
  <?php
  if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticated'])) {
    include __DIR__ . "/includes/header.php";
  }else{
    include __DIR__."/includes/header_logged_in.php";
  }
  ?>

  <div class="content_our_story">
    <img src="./assets/imgs/fooddash.png" alt="FoodDash Logo" class="fooddash_logo">
    <h1>História</h1>
    <div class="datas">
      <h5>Data de Começo do Projeto:</h5>
      <p>03-03-2024</p>
      <h5>Data de Deploy do Projeto:</h5>
      <p>DD-MM-YYYY</p>
    </div>
    <div class="texto">
      <h5>História:</h5>
      <p>Bem-vindos à história por trás da nossa aplicação de entrega de comida! Tudo começou com a inspiração e a vontade de proporcionar uma solução inovadora e conveniente para os amantes de comida em todo o mundo. Como um grupo de seis alunos entusiasmados do curso de Tecnologias da Informação da Universidade de Aveiro, fomos impulsionados pela paixão pela tecnologia e pela vontade de fazer a diferença no mundo da gastronomia.</p>
      <p>
        Desde o primeiro dia, mergulhámos de cabeça no trabalho árduo e na colaboração intensiva, dedicando horas a fio para transformar a nossa visão em realidade. Através de uma combinação de criatividade, conhecimento técnico e trabalho em equipa, desenvolvemos uma aplicação web de entrega de comida que oferece uma experiência sem igual aos nossos utilizadores.
      </p>
      <p>
        O nosso compromisso com a excelência e a inovação impulsionou-nos a ultrapassar obstáculos e desafios ao longo do caminho, desde a conceção da ideia até à implementação final. Cada linha de código, cada teste realizado e cada feedback recebido contribuiu para moldar a aplicação que agora orgulhosamente apresentamos ao mundo.
      </p>
      <p>
        Estamos entusiasmados por partilhar esta jornada convosco e convidamo-vos a explorar a nossa aplicação, desfrutar das delícias gastronómicas que temos para oferecer e fazer parte da nossa história em constante evolução. Obrigado por fazerem parte desta jornada connosco.
      </p>
    </div>
  </div>

  <br><br><br><br><br>
  <!-- FOOTER -->
  <?php
  include __DIR__ . "/includes/footer_1.php";
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>