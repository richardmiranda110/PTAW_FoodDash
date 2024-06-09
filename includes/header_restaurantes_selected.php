<nav class="navbar navbar-expand navbar-dark bg-dark z-index-3" style="padding:0;margin:0;" aria-label="Second navbar example">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="./assets/stock_imgs/fooddash_logo_white.png" alt="Logo FoodDash" id="logo_fooddash">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" id="home_btn" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" id="restaurantes_btn" aria-current="page" href="#">Restaurantes</a>
        </li>
      </ul>
      <button id="login_btn" type="button" class="btn btn-primary me-2">Login</button>
      <button id="registar_btn" type="button" class="btn btn-secondary">Registar</button>
    </div>
  </div>
</nav>

<script>
  document.getElementById('logo_fooddash').addEventListener('click', function() {
    window.location.href = 'index.php';
  });
  document.getElementById('home_btn').addEventListener('click', function() {
    window.location.href = 'index.php';
  });
  document.getElementById('restaurantes_btn').addEventListener('click', function() {
    window.location.href = 'restaurantes_page.php';
  });
  document.getElementById('login_btn').addEventListener('click', function() {
    window.location.href = 'login_register/login.php';
  });
  document.getElementById('registar_btn').addEventListener('click', function() {
    window.location.href = 'login_register/register.html';
  });
</script>