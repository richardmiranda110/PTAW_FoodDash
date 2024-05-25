<?php
require_once  __DIR__."./session.php";
?>

<nav class="navbar navbar-expand navbar-dark bg-dark z-1" aria-label="Second navbar example">
  <div class=" justify-content-start">
    <button id="toggleSidebar" class="btn btn-primary">
      <i class="bi bi-list"></i>
    </button>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02"
          aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
    </button>
  </div>
  <div class="complement-header w-100 m-0">
      <a class="navbar-brand">
        <img src="./Business/assets/imgs/logo.png" alt="" srcset="" style="width: 50%;">
      </a>
    <p class="fw-bold text-light" style="margin-right: 1vw;margin-top:1.5vh;margin-bottom:0" id="item-name-label"><?php echo "Bem vindo de volta, " . $_SESSION['nome']; ?></p>
    </div>
</nav>

