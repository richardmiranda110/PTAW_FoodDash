<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../assets/styles/sitecss.css">

  <title>FoodDash</title>
</head>

<body>
  <!-- Imagem no canto superior esquerdo -->
  <img src="../assets/imgs/fooddash.png" alt="FoodDash Logo" style="position: absolute; top: 8%; left: 4%; width: 15%; height: auto;">

  <!-- Formulário de registo -->
  <div class="container d-flex align-items-center justify-content-center" style="margin-top: 20vh;">
    <form action="registerValidation.php" method="POST" id="registoForm" style="width: 30%;">
      <h1 class="h1 mb-3" style="text-align: center;">Registar</h1><br>
      <div class="form-floating mb-1">
        <input type="text" class="form-control" id="inputName" name="inputName" placeholder="name@example.com" required>
        <label for="inputName">Nome</label>
      </div>
      <div class="form-floating mb-1">
        <input type="text" class="form-control" id="inputMorada" name="inputMorada" placeholder="name@example.com" required>
        <label for="inputMorada">Morada</label>
      </div>
      <div class="form-floating mb-1">
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="name@example.com" required>
        <label id="inputEmail">Email</label>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputRepetirPassword" name="inputRepetirPassword" placeholder="Password" required>
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
      <p style="text-align: center;">Já tem conta?<a type="button" class="btn btn-link" href="login.php">Login</a>
      </p>
      <div id="error-message" style="display: none; color: red; text-align: center;"></div>

      <?php
        session_start();
        if(isset($_SESSION['error_message'])) {
            echo "<div id='error-message-email' style='color: red; text-align: center;'>" . $_SESSION['error_message'] . "</div>";
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
          echo "<div id='success-message' style='color: green; text-align: center;'>" . $_SESSION['success_message'] . "</div>";
          unset($_SESSION['success_message']);
      }
      ?>

    </form>
  </div>

  <script src="loginScript.js"></script>
  <script src="../assets/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script>
    document.querySelector("input#mostrarPasswordCheckbox").addEventListener("click", mostrarPassword)
    function mostrarPassword() {
      let passwordInput = document.getElementById("inputPassword");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
      let repetirPasswordInput = document.getElementById("inputRepetirPassword");
      if (repetirPasswordInput.type === "password") {
        repetirPasswordInput.type = "text";
      } else {
        repetirPasswordInput.type = "password";
      }
    }
  </script>
</body>

</html>