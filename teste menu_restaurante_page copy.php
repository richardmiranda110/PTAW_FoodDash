<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/styles/sitecss.css">
  <link rel="stylesheet" href="/assets/styles/restaurants.css">
</head>

<body>
  <!-- NAVBAR -->
  <?php
  include __DIR__ . "/includes/header_restaurantes_selected.php";
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

  <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

  <div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="width: 30vw;">
        <div class="toast-header">
          <img src="./assets/stock_imgs/burgerKing_marca.png" class="rounded me-2" alt="logotipo" style="width: 1.5vw;">
          <strong class="me-auto">Menu Big King</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          <div id="txt_item_title_price_description">
            <h2>Menu Big King</h2>
            <h4>5,79€</h4>
            <p>Duplo contraste e duplo sabor, queijo derretido, alface, picles e cebola regados com o delicioso molho Big King entre dois pães de sésamo crocante. Será possível pedir mais?</p>
          </div>
          <hr>
          <div>
            <h4>Complemento</h4>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault1">
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault1">Batatas Fritas Clássicas</label>
            </div>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault1">
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault1">Batatas Supreme</label>
            </div>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault1">
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault1">King Aros de Cebola</label>
            </div>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault1">
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault1">King Fries (+ Cheddar + Bacon + Cebola)</label>
            </div>
          </div>
          <br>
          <div>
            <h4>Bebida</h4>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault2">
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault2">Coca-Cola</label>
            </div>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault2" checked>
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault2">Coca-Cola Zero</label>
            </div>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault2" checked>
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault2">Fanta Laranja</label>
            </div>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault2" checked>
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault2">Nestea Manga</label>
            </div>
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault2" checked>
              <label class="form-check-label d-flex justify-content-start" for="flexRadioDefault2">Água Mineral</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->

  <!-- SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')

    if (toastTrigger) {
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
      toastTrigger.addEventListener('click', () => {
        toastBootstrap.show()
      })
    }
  </script>

</body>

</html>