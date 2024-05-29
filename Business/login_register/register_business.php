<?php 
require_once  __DIR__."/../includes/session.php";

if (isset($_SESSION['authenticatedB'])) {
  header("Location: ../dashboard_home_page.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/styles/loginregisto.css">
  <title>FoodDash</title>
  <style>
    #mostrarPasswordCheckbox, #mostrarPasswordCheckbox:focus{
      border-color: white;
      box-shadow: none;
    }

    #flexCheckDefault, #flexCheckDefault:focus{
      border-color: white;
      box-shadow: none;
    }
  </style>
</head>

<body>
  <!-- Imagem no canto superior esquerdo -->
  <img src="../assets/imgs/logo.png" id="logoB" alt="FoodDash Logo" style="position: absolute; top: 8%; left: 4%; width: 22%; height: auto; cursor: pointer;">

  <!-- Formulário de registo -->
  <div class="container d-flex align-items-center justify-content-center" style="margin-top: 10vh;">
    <form action="registerValidationB.php" method="POST" id="registoForm" style="width: 30%;">
      <h1 class="h1 mb-3" style="text-align: center; color: white;">Registar</h1><br>
      <div class="form-floating mb-1">
        <input type="text" class="form-control" id="inputNomeEstab" name="inputNomeEstab" placeholder="name@example.com" required>
        <label for="inputName">Nome do Estabelecimento</label>
      </div>
      <div class="form-floating mb-1">
        <input type="text" class="form-control" id="inputEndereco" name="inputEndereco" placeholder="name@example.com" required>
        <label for="inputMorada">Morada do Estabelecimento</label>
      </div>
      <div class="form-floating mb-1">
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="name@example.com" required>
        <label for="inputEmail">Email</label>
      </div>
      <div class="form-floating mb-1">
        <input type="tel" class="form-control" id="inputTel" name="inputTel" placeholder="XXXXXXXXX" maxlength="9" required>
        <label class="form-label" for="inputTel">Telemovel</label>
      </div>
      <div class="form-floating mb-1">
        <select id="tipo" name="tipo" class="form-select" style="padding-top: 1.1vh;" required>
          <option value="" selected>Tipo</option>
          <option value="pizza">Pizza</option>
          <option value="fastfood">Fast Food</option>
          <option value="hamburger">Hamburger</option>
          <option value="sushi">Sushi</option>
          <option value="churrasco">Churrasco</option>
          <option value="vegan">Vegan</option>
          <option value="portuguesa">Portuguesa</option>
          <option value="italiana">Italiana</option>
          <option value="sobremesas">Sobremesas</option>
          <option value="bebidas">Bedidas</option>
        </select>
      </div>
      <div class="d-flex">
        <div class="form-floating mb-1">
          <input type="number" class="form-control" id="inputTaxa" name="inputTaxa" placeholder="name@example.com" min="0" step=".01" required>
          <label for="inputTaxa">Taxa de entrega (€)</label>
        </div>
        <div class="form-floating mb-1" style="margin-left: 0.3vw;">
          <input type="text" class="form-control" id="inputTempo" name="inputTempo" placeholder="name@example.com" required>
          <label for="inputTempo" style="font-size: 0.8vw;">Tempo médio de entrega</label>
        </div>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" required>
        <label for="inputPassword">Password</label>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputRepetirPassword" name="inputRepetirPassword" placeholder="Password" required>
        <label for="inputRepetirPassword">Repetir Password</label>
      </div>
      <div class="form-check mb-3" style="color: grey;">
        <input class="form-check-input" type="checkbox" value="" id="mostrarPasswordCheckbox" style="background-color: black;">
        <label class="form-check-label" for="flexCheckDefault" style="color: grey;">
          Mostrar password
        </label>
      </div>
      <button id="btnLogin" class="w-100 btn btn-lg btn-primary" type="submit">Registar</button>
      <br><br>
      <p style="text-align: center; color: grey;">Já tem conta?<a type="button" class="btn btn-link" href="login_business.php" style="color: white;">Login</a>
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
        if(isset($_SESSION['error_message'])) {
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

        if(isset($_SESSION['success_message'])) {
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

  <script src="loginScriptB.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var inputTempo = document.getElementById('inputTempo');

      inputTempo.value = "hh:mm:ss";

      inputTempo.addEventListener('focus', function () {
        if (inputTempo.value === "hh:mm:ss") {
            inputTempo.setSelectionRange(0, 8);
        }
      });
    });

    document.getElementById('registoForm').addEventListener('submit', function(event) {
      var value_time = document.getElementById("inputTempo").value;
      var regex_time = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;

      if (regex_time.test(value_time)) {
        console.log("Valid! " + value_time);
      } else {
        console.error("Invalid!");
        alert("Formato inválido. Use hh:mm:ss. hh(00 a 23) / mm e ss(00 a 59");
        document.getElementById("inputTempo").value = "hh:mm:ss";
        event.preventDefault(); // Impede o envio do formulário
      }
    });

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

    document.getElementById('logoB').addEventListener('click', function() {
      window.location.href = '../home_page.php';
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