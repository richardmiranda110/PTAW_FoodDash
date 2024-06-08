<?php
require_once   "./includes/session.php";
?>

<nav class="navbar navbar-expand navbar-dark bg-dark z-1" aria-label="Second navbar example">
  <div class="justify-content-start">
    <button id="toggleSidebar" class="btn btn-primary">
      <i class="bi bi-list"></i>
    </button>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
  <div class="complement-header w-100 m-0">
    <a href="./dashboard_home_page.php" class="navbar-brand">
      <img src="Business/../assets/imgs/logo.png" alt="" srcset="" style="width: 40%;">
    </a>

  </div>
  <p class="fw-bold text-light" style="margin-right: 2vw;margin-top:1.5vh;margin-bottom:0" id="item-name-label"><?php echo $_SESSION['nome']; ?></p>
</nav>