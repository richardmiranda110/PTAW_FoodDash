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

  <!-- Formulário de login -->
  <div class="container d-flex align-items-center justify-content-center vh-100">
    <form style="width: 25vw;">
      <h1 class="h1 mb-3" style="text-align: center;">Login</h1><br>
      <div class="form-floating mb-1">
        <input type="email" class="form-control" id="inputEmail" placeholder="name@example.com" required>
        <label for="inputEmail">Email</label>
      </div>
      <div class="form-floating mb-1">
        <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
        <label for="inputPassword">Password</label>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="mostrarPasswordCheckbox">
          <label class="form-check-label" for="flexCheckDefault">
            Mostrar password
          </label>
        </div>
      </div>
      <div class="checkbox mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Guardar email" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Guardar email
          </label>
        </div>
      </div>
      <button id="btnLogin" class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
      <br><br>
      <p style="text-align: center;">Ainda não tem conta?<button type="button" class="btn btn-link" id="btn_go_registar_page">Registe-se</button>
      </p>
    </form>
  </div>


  <script>
    document.getElementById('fooddash_logo').addEventListener('click', function() {
      window.location.href = './../index.php';
    });
    document.getElementById('btn_go_registar_page').addEventListener('click', function() {
      window.location.href = 'register.php';
    });


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
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>