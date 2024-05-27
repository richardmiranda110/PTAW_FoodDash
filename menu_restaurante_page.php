<!DOCTYPE html>
<?php require_once './session.php' 



?>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/styles/sitecss.css">
  <link rel="stylesheet" href="/assets/styles/restaurants.css">
</head>

<body>
  <!-- NAVBAR -->
  <?php
  if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
    include __DIR__."/includes/header_restaurantes_selected.php";
  }else{
    include __DIR__."/includes/header_logged_in.php";
  }
  ?>

  <!-- IDENTIFICAÇÃO DO RESTAURANTE -->
  <div class="p-4 p-md-5" style="background-color: #ffffff; border-bottom: 1vw ridge #febc41; border-radius: 15px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 px-0">
          <h1 class="display-4" style="font-weight: bolder;">Burger King</h1>
          <h5 class="mb-0">4.7★</h5>
          <p class="mb-0">Taxa de Entrega: 2,50€</p>
        </div>
        <div class="col-lg-4 text-center">
          <img src="./assets/stock_imgs/burgerKing_marca.png" alt="Imagem do restaurante" style="max-width: 300px;">
        </div>
        <div class="col-lg-4 px-4">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Procurar item" id="inputPesquisarRestaurante">
            <button class="btn btn-outline-primary" type="button" id="buttonPesquisarRestaurante">Procurar</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container d-flex justify-content-start" style="margin: 0; padding: 0">
    <!-- SIDEBAR CATEGORIAS -->
    <div class="d-flex flex-column p-3 bg-body-tertiary" style="width: 17.7vw;">
      <a class="d-flex align-items-center me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-4">Categorias</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="#" class="nav-link link-body-emphasis" aria-current="page">
            <text class="opcao">Novidades</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Na grelha</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Frango</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Vaca</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">King Jr</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Sem Gluten</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Gourmet</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Hamburgueres</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Sobremesas</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Entradas</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Molhos</text>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-body-emphasis">
            <text class="opcao">Bebidas</text>
          </a>
        </li>

      </ul>
    </div>

    <div class="">
      <!-- CARROSSEL DE ITENS -->
      <h1 style="margin-top: 10px; margin-left: 50px;">Novidades</h1>
      <div class="container" style="margin-bottom: 40px;">
        <div class="slider-wrapper carousel1">
          <button id="prev-slide" class="slide-button material-symbols-rounded">
            «
          </button>
          <ul class="image-list">
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
          <button id="next-slide" class="slide-button material-symbols-rounded">
            »
          </button>
        </div>
        <div class="slider-scrollbar">
          <div class="scrollbar-track">
            <div class="scrollbar-thumb"></div>
          </div>
        </div>
      </div>
      <h1 style="margin-top: 10px; margin-left: 50px;">Na grelha</h1>
      <div class="container" style="margin-bottom: 40px;">
        <div class="slider-wrapper carousel2">
          <button id="prev-slide" class="slide-button material-symbols-rounded">
            «
          </button>
          <ul class="image-list">
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
          <button id="next-slide" class="slide-button material-symbols-rounded">
            »
          </button>
        </div>
        <div class="slider-scrollbar">
          <div class="scrollbar-track">
            <div class="scrollbar-thumb"></div>
          </div>
        </div>
      </div>
      <h1 style="margin-top: 10px; margin-left: 50px;">Frango</h1>
      <div class="container" style="margin-bottom: 40px;">
        <div class="slider-wrapper carousel3">
          <button id="prev-slide" class="slide-button material-symbols-rounded">
            «
          </button>
          <ul class="image-list">
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/whopper_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Whopper</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/menu_bigKing_bk.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Menu Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">6,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="col" style="width: 13vw;">
                <div class="card shadow-sm">
                  <div class="image-overlay" style="position: relative; border-radius: 5.5px; overflow: hidden;">
                    <img src="./assets/stock_imgs/bigKing_bk_burger.png" class="card-img-top" alt="Imagem do restaurante"
                      style="border-radius: 5.5px;">
                    <div class="icon-overlay" style="position: absolute; bottom: 10px; right: 10px;">
                      <img src="./assets/stock_imgs/mais.png" id="iconAddItem" alt="Ícone de adição"
                        style="width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Big King</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">4,50€</p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
          <button id="next-slide" class="slide-button material-symbols-rounded">
            »
          </button>
        </div>
        <div class="slider-scrollbar">
          <div class="scrollbar-track">
            <div class="scrollbar-thumb"></div>
          </div>
        </div>
      </div>
    </div>
  </div>


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


    let opcaoSelecionadaAnteriormente = null;

    function selecionarOpcao(event) {
      // Remove o sublinhado de todas as opções
      const links = document.querySelectorAll('.opcao');
      links.forEach(link => {
        link.style.textDecoration = 'none';
      });

      // Remove o negrito da opção anteriormente selecionada
      if (opcaoSelecionadaAnteriormente !== null) {
        opcaoSelecionadaAnteriormente.style.fontWeight = 'normal';
      }

      // Adiciona bold à opção selecionada e atualiza a referência para a opção selecionada anteriormente
      event.target.style.fontWeight = 'bold';
      opcaoSelecionadaAnteriormente = event.target;
    }


    // Adiciona o evento de clique a todas as opções
    const links = document.querySelectorAll('.opcao');
    links.forEach(link => {
      link.addEventListener('click', selecionarOpcao);
    });

    // Adiciona evento de clique a todas as opções do sidebar
    const sidebarOptions = document.querySelectorAll('.opcao');
    sidebarOptions.forEach(option => {
      option.addEventListener('click', selecionarOpcao);
    });

    const initSlider = () => {
      const imageList = document.querySelector(".slider-wrapper .image-list");
      const slideButtons = document.querySelectorAll(".slider-wrapper .slide-button");
      const sliderScrollbar = document.querySelector(".container .slider-scrollbar");
      const scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
      let maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;

      scrollbarThumb.addEventListener("mousedown", (e) => {
        const startX = e.clientX;
        const thumbPosition = scrollbarThumb.offsetLeft;
        const maxThumbPosition = sliderScrollbar.getBoundingClientRect().width - scrollbarThumb.offsetWidth;

        const handleMouseMove = (e) => {
          const deltaX = e.clientX - startX;
          const newThumbPosition = thumbPosition + deltaX;

          const boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
          const scrollPosition = (boundedPosition / maxThumbPosition) * (imageList.scrollWidth - imageList.clientWidth);

          scrollbarThumb.style.left = `${boundedPosition}px`;
          imageList.scrollLeft = scrollPosition;
        }

        const handleMouseUp = () => {
          document.removeEventListener("mousemove", handleMouseMove);
          document.removeEventListener("mouseup", handleMouseUp);
        }

        document.addEventListener("mousemove", handleMouseMove);
        document.addEventListener("mouseup", handleMouseUp);
      });

      // Slide images according to the slide button clicks
      slideButtons.forEach(button => {
        button.addEventListener("click", () => {
          const direction = button.id === "prev-slide" ? -1 : 1;
          const scrollAmount = imageList.clientWidth * direction;
          imageList.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });
      });

      // Show or hide slide buttons based on scroll position
      const handleSlideButtons = () => {
        maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
        slideButtons[0].style.display = imageList.scrollLeft <= 0 ? "none" : "flex";
        slideButtons[1].style.display = imageList.scrollLeft >= maxScrollLeft ? "none" : "flex";
      }

      // Update scrollbar thumb position based on image scroll
      const updateScrollThumbPosition = () => {
        maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
        const scrollPosition = imageList.scrollLeft;
        const thumbPosition = (scrollPosition / maxScrollLeft) * (sliderScrollbar.clientWidth - scrollbarThumb.offsetWidth);
        scrollbarThumb.style.left = `${thumbPosition}px`;
      }

      // Call these two functions when image list scrolls
      imageList.addEventListener("scroll", () => {
        updateScrollThumbPosition();
        handleSlideButtons();
      });
    }

    window.addEventListener("resize", initSlider);
    window.addEventListener("load", initSlider);
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>