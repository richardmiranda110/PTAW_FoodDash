<?php
//PESQUISAR RESTAURANTE
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $restaurante = $_POST["input_pesquisar_restaurante"];

  try {
    if (!empty($restaurante)) {
      $q = "SELECT nome, imagem, avaliacao, taxa_entrega, tempo_medio_entrega FROM restaurantes WHERE nome LIKE ?";
      $statement = $pdo->prepare($q);
      $statement->execute(array("%$restaurante%"));

      if ($statement) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
          foreach ($result as $row) {
            echo '<div class="col">
                  <div class="card shadow-sm">
                    <img src="' . $row["imagem"] . '" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">' . $row["nome"] . '</h5>
                        <p class="mb-0">' . $row["avaliacao"] . '★</p>
                      </div>

                      <div class="d-flex justify-content-between align-items-center">
                        <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: ' . $row["taxa_entrega"] . '€</p>
                        <small class="text-body-secondary mb-0" style="font-size: 12px;">' . $row["tempo_medio_entrega"] . ' mins</small>
                      </div>
                    </div>
                  </div>
                </div>';
          }
        } else {
          echo "Restaurante não encontrado :(";
        }
      } else {
        echo "Erro ao executar a consulta.";
      }
    }
  } catch (Exception $e) {
    echo "Erro na conexão à BD: " . $e->getMessage();
  }
}*/
?>

<?php
//POPULAR PÁGINA COM OS RESTAURANTES DA BASE DE DADOS
/*
try {

  $q = "SELECT nome, imagem, avaliacao, taxa_entrega, tempo_medio_entrega FROM restaurantes;";
  $statement = $pdo->prepare($q);
  $statement->execute();

  if ($statement) {
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
      foreach ($result as $row) {
        echo '<div class="col">
                <div class="card shadow-sm">
                  <img src="' . $row["imagem"] . '" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">' . $row["nome"] . '</h5>
                      <p class="mb-0">' . $row["avaliacao"] . '★</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: ' . $row["taxa_entrega"] . '€</p>
                      <small class="text-body-secondary mb-0" style="font-size: 12px;">' . $row["tempo_medio_entrega"] . ' mins</small>
                    </div>
                  </div>
                </div>
              </div>';
      }
    }
  } else {
    echo "Nenhum restaurante encontrado :(";
  }
} catch (Exception $e) {
  echo "Erro na conexão à BD: " . $e->getMessage();
}*/
?>



<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .card {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <?php
  //require_once __DIR__."/database/db_connection.php";
  include __DIR__ . "/includes/header_restaurantes_selected.php";
  include __DIR__ . "/includes/navbar_tipos_de_comida.php";
  ?>


  <br><br>
  <!-- TÍTULO PÁGINA E PROCURAR -->
  <h1 style="text-align: center;">Restaurantes</h1><br>
  <form class="input-group container text-center mb-5" style="max-width: 40%;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" class="form-control" placeholder="Procurar restaurante" name="input_pesquisar_restaurante" id="inputPesquisarRestaurante">
    <button class="btn btn-outline-primary" type="button" id="buttonPesquisarRestaurante">Procurar</button>
  </form>

  <br>

  <!-- LISTA DE RESTAURANTES -->
  <div class="container">
    <h2 id="txt_categoria">Todos</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3">
      <div class="col">
        <div class="card shadow-sm">
          <img src="./assets/stock_imgs/mcdonalds_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/kfc_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/burgerKing_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/pizzaHut_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/subenshi_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/mcdonalds_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/kfc_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/burgerKing_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/pizzaHut_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
          <img src="./assets/stock_imgs/subenshi_restaurantes.png" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
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
  include __DIR__ . "/includes/footer_1.php";
  ?>

  <!-- SCRIPT -->
  <script>
    document.getElementById('card_restaurante').addEventListener('click', function() {
      window.location.href = 'menu_restaurante_page.php';
    });

    //PESQUISAR RESTAURANTE (acho que este código não vai servir pra nada)
    document.querySelector("button#buttonPesquisarRestaurante").addEventListener("click", function() {
      let nomeRestaurante = document.querySelector("input#inputPesquisarRestaurante").value;
      document.querySelector("input#inputPesquisarRestaurante").value = "";
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>