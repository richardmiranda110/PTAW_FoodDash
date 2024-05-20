<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="../assets/styles/sitecss.css"> -->
  <link rel="stylesheet" href="./assets/styles/team_page.css">
  <title>FoodDash</title>

</head>

<body>
  <!-- HEADER -->
  <?php
  include __DIR__ . "/includes/header.php";
  ?>

  <div class="content_our_story">
    <img src="./assets/imgs/fooddash.png" alt="FoodDash Logo" class="fooddash_logo">

    <h1>Equipa</h1>
    <div class="conteudo">
      <div class="texto">
        <h5>Elementos da equipa:</h5>
        <table class="table_content">
          <tr>
            <th>Nome</th>
            <th>Número</th>
            <th>Email</th>
          </tr>
          <tr>
            <td>Richard Miranda</td>
            <td>113331</td>
            <td>richardmiranda@ua.pt</td>
          </tr>
          <tr>
            <td>Diogo Oliveira</td>
            <td>113380</td>
            <td>dsimao@ua.pt</td>
          </tr>
          <tr>
            <td>Ricardo Fonseca</td>
            <td>115776</td>
            <td>ric.fon@ua.pt</td>
          </tr>
          <tr>
            <td>Ricardo Caniçais</td>
            <td>48130</td>
            <td>ricardo.canicais@ua.pt</td>
          </tr>
          <tr>
            <td>Ana Vicente</td>
            <td>114509</td>
            <td>vicente.anab@ua.pt</td>
          </tr>
          <tr>
            <td>Gustavo Guimarães</td>
            <td>107628</td>
            <td>gustavovitorino@ua.pt</td>
          </tr>
        </table>

      </div>
      <img src="./assets/stock_imgs/ai_team_constitution.jpg" alt="foto da equipa" class="team_photo">
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