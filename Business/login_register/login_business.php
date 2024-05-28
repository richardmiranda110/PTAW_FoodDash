<?php 
require_once __DIR__.'/../includes/session.php';

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
  <img src="../assets/imgs/logo.png" id="logoB" alt="FoodDash Logo" style="position: absolute; top: 8%; left: 4%; width: 22%; height: auto;">

  <!-- Formulário de login -->
  <div class="container d-flex align-items-center justify-content-center" style="margin-top: 25vh;">
    <form action="loginValidationB.php" method="POST" style="width: 30%;">
      <h1 class="h1 mb-3" style="text-align: center; color: white;">Login</h1><br>
      <div class="form-floating mb-1">
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="name@example.com" required>
        <label for="inputEmail">Email</label>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" required>
        <label for="inputPassword">Password</label>

        <div class="form-check" style="margin-top: 1vh;">
          <input class="form-check-input" type="checkbox" value="" id="mostrarPasswordCheckbox" style="background-color: black;">
          <label class="form-check-label" for="flexCheckDefault" style="color: grey;">
            Mostrar password
          </label>
        </div>
      </div>
      <div class="checkbox mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Guardar email" id="flexCheckDefault" style="background-color: black;">
          <label class="form-check-label" for="flexCheckDefault" style="color: grey;">
            Guardar email
          </label>
        </div>
      </div>
      <button id="btnLogin" class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
      <br><br>
      <p style="text-align: center; color: grey;">Ainda não tem conta?<a type="button" class="btn btn-link" href="register_business.php" style="color: white;">Registe-se</a>
      </p>

      <?php
        if(isset($_SESSION['error_message'])) {
            echo "<div id='error-message-email' style='color: red; text-align: center;'>" . $_SESSION['error_message'] . "</div>";
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
          echo "<div id='success-message' style='color: green; text-align: center;'>" . $_SESSION['success_message'] . "</div>";
          unset($_SESSION['success_message']);
        }

        if(empty($_SESSION["authenticatedB"]) || $_SESSION["authenticatedB"] != 'true') {

        } else {
          echo "<div class='form-floating mb-1'>";
          echo "<a id='btnLogout' class='w-100 btn btn-lg btn-primary' type='submit' href='logoutB.php'>Logout</a>";
          echo "</div>";
        }
      ?>
      
    </form>
  </div>


  <script>
    document.querySelector("input#mostrarPasswordCheckbox").addEventListener("click", mostrarPassword)
    function mostrarPassword() {
      let passwordInput = document.getElementById("inputPassword");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }

    document.querySelector("button#btnLogin").addEventListener("click", validarlogin)

    function validarlogin() {
      let nome = document.querySelector("input#inputName").value;
      let email = document.querySelector("input#inputEmail").value;
      let password = document.querySelector("input#inputPassword").value;
      let repetirPassword = document.querySelector("input#inputRepetirPassword").value;

      console.log(`Email: ${email} | Password: ${password}`);

      if (!validateEmail(email)) {
        document.querySelector("input#inputEmail").classList.add("form-control is-invalid");
        alert("Por favor, insira um email válido.");
        return;
      } else if (password.length < 6) {
        document.querySelector("input#inputPassword").classList.add("form-control is-invalid");
        alert("A palavra-passe deve ter pelo menos 6 caracteres.");
        return;
      }

      //document.querySelector("input#inputEmail").classList.add("form-control is-valid");
      //document.querySelector("input#inputPassword").classList.add("form-control is-invalid");
    }

    function validateEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }

    document.getElementById('logoB').addEventListener('click', function() {
      window.location.href = '../home_page.php';
    });
  </script>

  <script src="loginScript.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>