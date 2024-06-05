<?php
?>

<nav class="navbar navbar-expand navbar-dark bg-dark z-1" aria-label="Second navbar example">
  <div class="container-fluid">
    <?php 
    if($_SERVER['REQUEST_URI'] != '/'){
      echo 
      '<button id="toggleSidebar" class="btn btn-primary">
        <i class="bi bi-list"></i> <!-- Ícone de hambúrguer -->
      </button>';
    }
    ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02"
          aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/dashboard.php">
        <img src="assets/imgs/fooddash_logo_white.png" alt="" srcset="">
    </a>
    <div class="collapse navbar-collapse" id="navbarsExample02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <!-- <a class="nav-link active" aria-current="page" href="#">Home</a> -->
        </li>
        <li class="nav-item">
          <a class="nav-link pb-0" aria-current="page" href="../restaurantes_page.php">Restaurantes</a>
        </li>
      </ul>
      <a class="btn btn-default border border-white me-2" href="../dashboard.php">
        <img src="./assets/imgs/icon-perfil.png" width="30vw" /> <!-- remover ./. quando colocar na página -->
      </a>
      <a class="btn btn-default border border-white" href="/checkout/checkout.php" >
        <img src="./assets/imgs/carrinho-de-compras.png" width="30vw" /> <!-- remover ./. quando colocar na página -->
      </a>
    </div>
  </div>
</nav>

<script>
  // document.getElementById('home_btn').addEventListener('click', function() {
  //   window.location.href = 'index.php';
  // });
  // document.getElementById('restaurantes_btn').addEventListener('click', function() {
  //   window.location.href = 'restaurantes_page.php';
  // });
</script>