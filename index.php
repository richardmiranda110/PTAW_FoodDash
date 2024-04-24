<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/styles/sitecss.css">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

</head>

<body>
  <!-- NAVBAR -->
  <?php
  include __DIR__."/includes/header.php";
  ?>
  <!-- CONTAINER DE INSERIR MORADA -->
  <div class="bg-custom px-4 py-4 text-left">
    <h1 class="display-6 fw-bold text-body-primary" style="color: white;">Peça uma entrega perto de si</h1>
    <br>
    <div class="row justify-content-left align-items-center mb-3">
      <div class="col-md-3">
        <div class="form-floating">
          <input type="text" class="form-control form-control-sm" id="floatingInput" placeholder="XXXX-YY">
          <label for="floatingInput">Introduza um codigo postal</label>
        </div>
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-lg px-4">Procurar</button>
      </div>
    </div>
  </div>

  <!-- CONTAINER COMO TRABALHAMOS -->
  <div class="container px-4 pt-4" id="featured-3">
    <h1 class="pb-2 border-bottom" style="text-align: center; font-weight: bolder;">Como Trabalhamos</h1>
    <div class="row g-4 pt-5 row-cols-1 row-cols-lg-4">
      <div class="feature col" style="text-align: center;">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
          <img src="./assets/imgs/location.png" alt="Ícone de localização" width="160" height="160">
        </div>
        <h3 class="fs-2 text-body-emphasis">Escolha localização</h3>
        <p>Escolha a localização onde a sua comida será entregue.</p>
      </div>
      <div class="feature col" style="text-align: center;">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
          <img src="./assets/imgs/escolha_comida_burger_drink.png" alt="Ícone de localização" width="160" height="160">
        </div>
        <h3 class="fs-2 text-body-emphasis">Escolha comida</h3>
        <p>Escolha entre diversos tipos de restaurantes e comidas deliciosas disponíveis.</p>
      </div>
      <div class="feature col" style="text-align: center;">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
          <img src="./assetsimgs/pague_online_money_euro.png" alt="Ícone de localização" width="160" height="160">
        </div>
        <h3 class="fs-2 text-body-emphasis">Pague online</h3>
        <p>Pague de maneira rápida, simples e segura. Escolha entre diversos meios de pagamento.</p>
      </div>
      <div class="feature col" style="text-align: center;">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
          <img src="./assetsimgs/desfrute_smileFace.png" alt="Ícone de localização" width="160" height="160">
        </div>
        <h3 class="fs-2 text-body-emphasis">Desfrute</h3>
        <p>A comida é feita e entregue diretamente onde estás.</p>
      </div>
    </div>
  </div>

  <!-- CONTAINER FUNCIONALIDADES E INFORMAÇÕES EXTRAS -->
  <div class="container px-4 py-4" id="custom-cards">
    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg"
          style="background-image: url('imgs/descontos_20.jpg'); background-size: cover;">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Descontos nos melhores restaurantes</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="./assetsimgs/fd reduced logo.png" alt="Bootstrap" width="32" height="20">
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg"
          style="background-image: url('imgs/live_tracking.jpg'); background-size: cover;">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Acompanhamento em tempo real</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="./assets/imgs/fd reduced logo.png" alt="Bootstrap" width="32" height="20">
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg"
          style="background-image: url('imgs/fast_delivery.jpg'); background-size: cover;">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Entregas rápidas</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="./assets/imgs/fd reduced logo.png" alt="Bootstrap" width="32" height="20">
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- PUBLICIDADE BUSINESS EMPRESARIAL -->
  <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active"
        aria-current="true"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item">
        <img src="./assets/imgs/restaurant_img1_car_business.png" class="d-block w-100" alt="Imagem de um restaurante"
          style="height: 600px;">
        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Registe o seu estabelecimento</h1>
            <p class="opacity-90">Ainda não realiza entregas no seu restaurante? Registe o seu estabelecimento ou rede
              de restaurantes e comece já a efetuar entregas online.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Registar</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item active">
        <img src="./assets/imgs/kitchen_img2_car_business.png" class="d-block w-100" alt="Imagem de uma cozinha"
          style="height: 600px;">
        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Receba estatísticas</h1>
            <p>Receba estatísticas detalhadas sobre as suas vendas.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Registar</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="./assets/imgs/deliveryGuy_img3_car_business.png" class="d-block w-100" alt="Imagem de dois homens"
          style="height: 600px;">
        <div class="container">
          <div class="carousel-caption">
            <h1>Não espere pelo futuro, comece a moldá-lo hoje mesmo!</h1>
            <p><a class="btn btn-lg btn-primary" href="#">Registar</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <br><br>
  <div style="text-align: center;">
    <button type="button" class="btn btn-dark btn-lg">Criar conta empresarial</button>
  </div><br><br>

  <!-- FOOTER -->
  <?php
  include __DIR__."/includes/footer_1.php";
  ?>

  <!-- SCRIPT -->
  <script>
    document.getElementById('loginBtn').addEventListener('click', function () {
      window.location.href = 'login_register/login.html';
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>