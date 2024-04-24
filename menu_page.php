<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/styles/sitecss.css">
</head>

<body>
  <!-- NAVBAR -->
  <?php
  //require_once __DIR__."/database/db_connection.php";
  include __DIR__."/includes/header.php";
  include __DIR__."/includes/navbar_tipos_de_comida.php";
  ?>


  <br><br>
  <!-- TÍTULO PÁGINA E PROCURAR -->
  <h1 style="text-align: center;">Restaurantes</h1><br>
  <div class="input-group container text-center mb-5" style="max-width: 40%;">
    <input type="text" class="form-control" placeholder="Procurar restaurante" id="inputPesquisarRestaurante">
    <button class="btn btn-outline-primary" type="button" id="buttonPesquisarRestaurante">Procurar</button>
  </div>

  <br>

  <!-- LISTA DE RESTAURANTES -->
  <div class="container">
    <h2>Mais Populares</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3">
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/mcdonalds_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">McDonald's</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/kfc_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">KFC</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/burgerKing_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Burger King</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/pizzaHut_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Pizza Hut</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/subenshi_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Subenshi</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
    </div><br>

    <h2>Mais Rápidos</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3">
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/mcdonalds_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">McDonald's</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/kfc_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">KFC</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/burgerKing_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Burger King</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/pizzaHut_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Pizza Hut</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/subenshi_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Subenshi</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
    </div><br>

    <h2>Mais Baratos</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3">
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/mcdonalds_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">McDonald's</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/kfc_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">KFC</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/burgerKing_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Burger King</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/pizzaHut_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Pizza Hut</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/subenshi_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Subenshi</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
    </div><br>

    <h2>Com as melhores classificações</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3">
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/mcdonalds_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">McDonald's</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/kfc_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">KFC</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/burgerKing_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Burger King</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/pizzaHut_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Pizza Hut</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/subenshi_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Subenshi</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
    </div><br><br><br><br><br>

    <h2>Todos</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3">
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/mcdonalds_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">McDonald's</h5>
              <p class="mb-0">4.7★</p>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/kfc_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">KFC</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/burgerKing_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Burger King</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/pizzaHut_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Pizza Hut</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/subenshi_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Subenshi</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/mcdonalds_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">McDonald's</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/kfc_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">KFC</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/burgerKing_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Burger King</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/pizzaHut_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Pizza Hut</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm">
          <img src="/assets/stock_imgs/subenshi_restaurantes.png" class="card-img-top" alt="Imagem do restaurante"
            style="border-radius: 5.5px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Subenshi</h5>
              <p class="mb-0">4.7★</p>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: 2,50€</p>
              <small class="text-body-secondary mb-0" style="font-size: 12px;">20-30 mins</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <!-- Paginação -->
    <nav aria-label="Page navigation example">
      <ul class="pagination" style="justify-content: right; margin-top: 20px;">
        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Próxima</a></li>
      </ul>
    </nav>
    <br>
  </div>
  <br><br>
  <!-- Footer -->
  <?php
  include __DIR__."/includes/footer_1.php";
  ?>

  <!-- SCRIPT -->
  <script>
    document.querySelector("button#buttonPesquisarRestaurante").addEventListener("click", procurarRestaurante)

    function procurarRestaurante() {
      let nomeRestaurante = document.querySelector("input#inputPesquisarRestaurante").value;
      console.log(nomeRestaurante)
      document.querySelector("input#inputPesquisarRestaurante").value = "";
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>