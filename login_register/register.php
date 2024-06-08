<!DOCTYPE html>
<?php
require_once __DIR__.'/../session.php';

if (isset($_SESSION['authenticated'])) {
  header("Location: /dashboard.php");
  exit();
}

?>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/styles/sitecss.css">

  <title>FoodDash</title>
</head>

<body>
  <!-- Imagem no canto superior esquerdo -->
  <img src="../assets/imgs/FoodDash.png" alt="FoodDash Logo" id="logo_fooddash" style="position: absolute; top: 8%; left: 4%; width: 15%; height: auto; cursor: pointer;">

  <!-- Formulário de registo -->
  <div class="container d-flex align-items-center justify-content-center" style="margin-top: 10vh;">
    <form action="registerValidation.php" method="POST" id="registoForm" style="width: 30%;">
      <h1 class="h1 mb-3" style="text-align: center;">Registar</h1><br>
      <div class="d-flex">
        <div class="form-floating mb-1">
          <input type="text" class="form-control" id="inputName" name="inputName" placeholder="name@example.com" required>
          <label for="inputName">Nome</label>
        </div>
        <div class="form-floating mb-1" style="margin-left: 0.3vw;">
          <input type="text" class="form-control" id="inputApelido" name="inputApelido" placeholder="name@example.com" required>
          <label for="inputName">Apelido</label>
        </div>
      </div>
      <div class="form-floating mb-1">
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="name@example.com" required>
        <label id="inputEmail">Email</label>
      </div>
      <div class="form-floating mb-1">
        <input type="tel" class="form-control" id="inputTele" name="inputTele" placeholder="XXXXXXXXX" maxlength="9" required>
        <label for="inputTele">Telemóvel</label>
      </div>
      <div class="form-floating mb-1">
        <input type="text" class="form-control" id="inputMorada" name="inputMorada" placeholder="name@example.com" required>
        <label for="inputMorada">Morada</label>
      </div>
      <div class="d-flex">
        <div class="form-floating mb-1">
          <input type="text" class="form-control" id="inputCP" name="inputCP" placeholder="XXXX-YYY" required>
          <label for="inputName">Código Postal</label>
        </div>
        <div class="form-floating mb-1" style="margin-left: 0.3vw;">
          <input type="text" class="form-control" id="inputCidade" name="inputCidade" placeholder="name@example.com" required>
          <label for="inputName">Cidade</label>
        </div>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputRepetirPassword" name="inputRepetirPassword" placeholder="Password" required>
        <label for="floatingPassword">Repetir Password</label>
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="" id="mostrarPasswordCheckbox">
        <label class="form-check-label" for="flexCheckDefault">
          Mostrar password
        </label>
      </div>
      <button id="btnLogin" class="w-100 btn btn-lg btn-primary" type="submit">Registar</button>
      <br><br>
      <p style="text-align: center;">Já tem conta?<a type="button" class="btn btn-link" href="login.php">Login</a>
      </p>
      

      <div class='toast-container position-fixed bottom-0 end-0 p-3'>
        <div class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-autohide='false' id='error-message'>
          <div class='toast-header'>
            <strong class='mr-auto'>Erro</strong>
            <button type='button' class='btn-close' data-dismiss='toast' aria-label='Close'>
            </button>
          </div>
          <div class='toast-body' style='color: red; text-align: center;' id='error-messagee'>
            As senhas não coincidem!
          </div>
        </div>
      </div>

      <?php
      if (isset($_SESSION['error_message'])) {
        echo "<div class='toast-container position-fixed bottom-0 end-0 p-3'>
                <div class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-autohide='false' id='error-message-email'>
                  <div class='toast-header'>
                    <strong class='mr-auto'>Erro</strong>
                    <button type='button' class='btn-close' data-dismiss='toast' aria-label='Close'>
                    </button>
                  </div>
                  <div class='toast-body' style='color: red; text-align: center;'>
                  ". $_SESSION['error_message'] ."
                  </div>
                </div>
              </div>";
                
        unset($_SESSION['error_message']);
      }

      if (isset($_SESSION['success_message'])) {
        echo "<div class='toast-container position-fixed bottom-0 end-0 p-3'>
                <div class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-autohide='false' id='success-message'>
                  <div class='toast-header'>
                    <strong class='mr-auto'>Sucesso</strong>
                    <button type='button' class='btn-close' data-dismiss='toast' aria-label='Close'>
                    </button>
                  </div>
                  <div class='toast-body' style='color: green; text-align: center;'>
                  ". $_SESSION['success_message'] ."
                  </div>
                </div>
              </div>";

        unset($_SESSION['success_message']);
      }
      ?>

    </form>
  </div>

  <script src="loginScript.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

    document.getElementById('logo_fooddash').addEventListener('click', function() {
      window.location.href = '../index.php';
    });

    $('#error-message-email').toast('show');
    const toastTrigger = document.getElementById('btnLogin');
    const toastLiveExample = document.getElementById('error-message-email');

    if (toastTrigger) {
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
      toastTrigger.addEventListener('click', () => {
      toastBootstrap.show();
      });
    };

    $('#success-message').toast('show');
    const toastTriggerSuccess = document.getElementById('btnLogin');
    const toastLiveSuccess = document.getElementById('success-message');

    if (toastTrigger) {
      const toastBootstrapSuccess = bootstrap.Toast.getOrCreateInstance(toastLiveSuccess);
      toastTriggerSuccess.addEventListener('click', () => {
      toastBootstrapSuccess.show();
      });
    };
  </script>
</body>

</html>