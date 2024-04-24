<?php
?>

<nav class="navbar navbar-expand navbar-dark bg-dark z-1" aria-label="Second navbar example">
  <div class="container-fluid">
    <button id="toggleSidebar" class="btn btn-primary">
      <i class="bi bi-list"></i> <!-- Ícone de hambúrguer -->
    </button>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02"
          aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img src="/assets/imgs/fooddash_logo_white.png" alt="" srcset="">
    </a>
    <div class="collapse navbar-collapse" id="navbarsExample02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#">Menu</a>
        </li>
      </ul>
      <button class="btn btn-default border border-white me-2">
        <img src="./assets/imgs/icon-perfil.png" width="30vw" /> <!-- remover ./. quando colocar na página -->
      </button>
      <button class="btn btn-default border border-white">
        <img src="./assets/imgs/carrinho-de-compras.png" width="30vw" /> <!-- remover ./. quando colocar na página -->
      </button>
    </div>
  </div>
</nav>