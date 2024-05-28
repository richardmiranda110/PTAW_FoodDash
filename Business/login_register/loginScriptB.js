document.getElementById('registoForm').addEventListener('submit', function(event) {
    var password = document.getElementById('inputPassword').value;
    var confirmPassword = document.getElementById('inputRepetirPassword').value;
    var errorMessage = document.getElementById('error-message');
    let tele_inserido = document.getElementById("inputTel").value;
    console.log(tele_inserido);
    let regex_tele = /^[0-9]{9}$/;

    if (password !== confirmPassword) {
        errorMessage.textContent = 'As senhas não coincidem!';
        errorMessage.style.display = 'block';
        event.preventDefault(); // Impede o envio do formulário
    } else {
        errorMessage.style.display = 'none';
    }

    if (regex_tele.test(tele_inserido)) {
        console.log("Valid! " + tele_inserido);
    } else {
        console.error("Invalid!");
        alert("Número de telemóvel inválido! Insira novamente!");
        document.getElementById("inputTel").value = "";
        event.preventDefault(); // Impede o envio do formulário
    }
});