document.querySelector("input#mostrarPasswordCheckbox").addEventListener("click", mostrarPassword)
    function mostrarPassword() {
      let passwordInput = document.getElementById("inputPassword");
      let repetirPasswordInput = document.getElementById("inputRepetirPassword");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        repetirPasswordInput.type = "text"
      } else {
        passwordInput.type = "password";
        repetirPasswordInput.type = "password"
      }
    }

    document.querySelector("button#btnLogin").addEventListener("click", validarlogin)
    function validarlogin() {
      let nome = document.querySelector("input#inputName").value;
      let email = document.querySelector("input#inputEmail").value;
      let password = document.querySelector("input#inputPassword").value;
      let repetirPassword = document.querySelector("input#inputRepetirPassword").value;

      console.log(`Nome: ${nome} | Email: ${email} | Password: ${password} | Repetir Password: ${repetirPassword}`);

      if (!validateEmail(email)) {
        document.querySelector("input#inputEmail").classList.add("form-control is-invalid");
        alert("Por favor, insira um email válido.");
        return;
      } else if (password.length < 6) {
        document.querySelector("input#inputPassword").classList.add("form-control is-invalid");
        alert("A palavra-passe deve ter pelo menos 6 caracteres.");
        return;
      } else if (password !== repetirPassword) {
        document.querySelector("input#inputPassword").classList.add("form-control is-invalid");
        document.querySelector("input#inputRepetirPassword").classList.add("form-control is-invalid");
        alert("As palavras-passes não são iguais.")
        return
      }

      //document.querySelector("input#inputEmail").classList.add("form-control is.valid");
      //document.querySelector("input#inputPassword").classList.add("form-control is.valid");
    }

    function validateEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }