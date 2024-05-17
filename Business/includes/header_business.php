<nav class="navbar navbar-expand navbar-dark bg-dark z-index-3" style="padding:0;margin:0;" aria-label="Second navbar example">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="./imagens/logo.png" alt="Logo FoodDash" id="logo_fooddash" style="width: 23vw;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample02">
      <ul class="navbar-nav me-auto">
      </ul>
      <button id="login_btn" type="button" class="btn btn-primary me-2">Login</button>
      <button id="registar_btn" type="button" class="btn btn-secondary">Registar</button>
    </div>
  </div>
</nav>

<script>
  document.getElementById('login_btn').addEventListener('click', function() {
    window.location.href = 'login_register/login_business.php';
  });
  document.getElementById('registar_btn').addEventListener('click', function() {
    window.location.href = 'login_register/register_business.php';
  });
</script>