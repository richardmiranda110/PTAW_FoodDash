<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/homepage.css">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<body>
  <!-- NAVBAR -->
  <?php
    include __DIR__ . "/includes/header_business.php";
  ?>

  <!-- IMAGEM COM BTN LOGIN E REGISTO -->
  <div class="d-flex" style="max-width: 100%; padding: 0vw 0vh; height: 85vh;">
    <img id="imgEmpresas" src="./imagens/empresas.png" class="w-100">
    <div class="col-12 overlay">
      <h1 style="margin-top: 5vh; margin-left: 5vw; font-size: 2.1vw;">Faça crescer o seu negócio com a FoodDash</h1>
      <div class="text-center" style="margin-top: 17vh;">
        <div class="flex-row">
          <button class="btn btn-lg" id="btnLogin" type="button">Iniciar Sessão</button>
        </div>
        <div class="flex-row">
          <button class="btn btn-lg" id="btnRegisto" type="button" style="margin-top: 10vh;">Registe-se</button>
        </div>
      </div>
    </div>
  </div>

  <!-- DIV DE FUNDO DOURADO -->
  <div class="d-flex align-items-center justify-content-center" style="max-width: 100%; padding: 0vw 0vh; height: 40vh; background-color: rgb(255, 184, 0);">
    <div class="d-flex align-items-center justify-content-center" style="width: 35%;">
      <h1 style="text-align: center; font-weight: bold; font-size: 2.1vw;">Expanda o seu negócio com o poder da plataforma FoodDash</h1>
    </div>
  </div>

  <!-- DIV INFORMAÇÕES ADICIONAIS -->
  <div class="container align-items-center justify-content-center" style="max-width: 100%; padding: 0vw 0vh; margin: 0vw 0vh; height: 70vh; background-color: black;">
    <div class="row" style="padding: 0vw 0vh; margin: 0vw 0vh;">
      <h1 style="text-align: center; font-weight: bold; font-size: 2.1vw; color: white; margin-top: 5vh;">As refeições do seu restaurante entregues ao domicílio</h1>
    </div>
    <div class="row row-cols-6 justify-content-center" style="padding: 0vw 0vh; margin: 0vw 0vh; margin-top: 7vh;">
      <div class="col">
        <div class="card card-cover overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-size: cover;">
          <img src="./imagens/exemplo1.png" alt="Bootstrap">
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-auto w-auto overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-size: cover;">
          <img src="./imagens/exemplo2.png" alt="Bootstrap">
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-auto overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-size: cover;">
          <img src="./imagens/exemplo3.png" alt="Bootstrap">
        </div>
      </div>
    </div>
    <div class="row align-items-center justify-content-center" style="padding: 0vw 0vh; margin: 0vw; margin-top: 2vh;">
      <div class="" style="max-width: 70%;">
        <h1 style="text-align: center; font-size: 1.2vw; color: white; margin-top: 5vh;">Ainda não realiza entregas no seu restaurante? 
        Registe o seu estabelecimento ou rede de restaurantes e comece já a efetuar entregas online, enquanto recebe estatísticas detalhadas sobre as suas vendas.</h1>
        <h1 style="text-align: center; font-size: 1.2vw; color: white;">Não espere pelo futuro, comece a moldá-lo hoje mesmo!</h1>
      </div>
    </div>
  </div>

  <!-- DIV PRONTO PARA COMEÇAR -->
  <div class="d-flex align-items-center justify-content-center" style="max-width: 100%; padding: 0vw 0vh; height: 25vh; background-color: white;">
    <div class="col-md-12 text-center">
      <h1 style="text-align: center; font-weight: bold; font-size: 2.1vw;">Tudo pronto para começar?</h1>
      <button class="btn" id="btnRegisto2" type="button" style="padding: 0.5vh 1vw; margin-top: 2vh;">Registe-se</button>
    </div>
  </div>

  
  <!-- FOOTER -->
  <?php
    include __DIR__ . "/includes/footer_business.php";
  ?>

  <script>
    document.getElementById('btnLogin').addEventListener('click', function() {
      window.location.href = 'login_register/login_business.php';
    });
    document.getElementById('btnRegisto').addEventListener('click', function() {
      window.location.href = 'login_register/register_business.php';
    });
    document.getElementById('btnRegisto2').addEventListener('click', function() {
      window.location.href = 'login_register/register_business.php';
    });
  </script>
</body>
</html>