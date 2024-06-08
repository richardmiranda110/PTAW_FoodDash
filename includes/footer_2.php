<?php
?>
<footer class="d-flex flex-wrap justify-content-between align-items-center pt-1 mt-2 mb-0 pb-0 border-top" style="margin:0;padding:5px;">
  <p class="col-md-4 mb-0 text-<body>-secondary">© 2024 FoodDash</p>

  <a href="./index.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
    <img src="./assets/imgs/FoodDash.png" id="logo_fooddash_f2" class="img-fluid" alt="Responsive image">
  </a>

  <ul class="nav col-md-4 justify-content-end">
    <li class="nav-item"><a href="#" id="home_btn_f2" class="nav-link px-2 text-body-secondary">Home</a></li>
    <li class="nav-item"><a href="#" id="restaurantes_btn_f2" class="nav-link px-2 text-body-secondary">Restaurantes</a></li>
    <li class="nav-item"><a href="#" id="btn_business_f2" class="nav-link px-2 text-body-secondary">Empresarial</a></li>
  </ul>
</footer>

<script>
  document.getElementById('logo_fooddash_f2').addEventListener('click', function() {
    window.location.href = './index.php';
  });
  document.getElementById('home_btn_f2').addEventListener('click', function() {
    window.location.href = './index.php';
  });
  document.getElementById('restaurantes_btn_f2').addEventListener('click', function() {
    window.location.href = './restaurantes_page.php';
  });
  document.getElementById('btn_business_f2').addEventListener('click', function() {
    window.location.href = './Business/home_page.php';
  });
</script>