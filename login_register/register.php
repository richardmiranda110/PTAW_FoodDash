<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/styles/sitecss.css">
  <link rel="stylesheet" href="../assets/styles/login_register_styles.css">
  <title>FoodDash</title>
</head>

<body>
  <!-- Imagem no canto superior esquerdo -->
  <img src="../assets/imgs/fooddash.png" alt="FoodDash Logo" class="fooddash_logo" id="fooddash_logo">

  <!-- Formulário de registo -->
  <div class="container d-flex align-items-center justify-content-center vh-100">
    <form style="width: 25vw;">
      <h1 class="h1 mb-3" style="text-align: center;">Registar</h1><br>
      <div class="form-floating mb-1">
        <input type="text" class="form-control" id="inputName" placeholder="name@example.com" required>
        <label for="inputName">Nome</label>
      </div>
      <div class="form-floating mb-1">
        <input type="text" class="form-control" id="inputMorada" placeholder="name@example.com" required>
        <label for="inputMorada">Morada</label>
      </div>
      <div class="form-floating mb-1">
        <input type="email" class="form-control" id="inputEmail" placeholder="name@example.com" required>
        <label for="inputEmail">Email</label>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputRepetirPassword" placeholder="Password" required>
        <label for="floatingPassword">Repetir Password</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="mostrarPasswordCheckbox">
        <label class="form-check-label" for="flexCheckDefault">
          Mostrar password
        </label>
      </div>
      <div class="checkbox mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Guardar email" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Guardar email
          </label>
        </div>
      </div>
      <button id="btnLogin" class="w-100 btn btn-lg btn-primary" type="submit">Registar</button>
      <br><br>
      <p style="text-align: center;">Já tem conta?<button type="button" class="btn btn-link" id="btn_go_login_page">Login</button>
      </p>
    </form>
  </div>

  <script>
    document.getElementById('fooddash_logo').addEventListener('click', function() {
      window.location.href = './../index.php';
    });
    document.getElementById('btn_go_login_page').addEventListener('click', function() {
      window.location.href = 'login.php';
    });
  </script>
  <script src="../assets/js/register.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>