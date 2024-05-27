<nav class="navbar navbar-expand navbar-dark bg-dark z-index-3" style="padding:0;margin:0;" aria-label="Second navbar example">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="./assets/imgs/fooddash_logo_white.png" alt="Logo FoodDash" id="logo_fooddash">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" id="home_btn" aria-current="page" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="restaurantes_btn" aria-current="page" href="restaurantes_page.php">Restaurantes</a>
        </li>
      </ul>
      <a href='login_register/login.php' id="login_btn" type="button" class="btn btn-primary me-2">Login</a>
      <a id="registar_btn" type="button" class="btn btn-secondary">Registar</a>
    </div>
  </div>
</nav>

<script>
  document.getElementById('login_btn').addEventListener('click', function() {
    window.location.href = 'login_register/login.php';
  });
  document.getElementById('registar_btn').addEventListener('click', function() {
    window.location.href = 'login_register/register.php';
  });
</script>