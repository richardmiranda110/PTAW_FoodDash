document.getElementById('registoForm').addEventListener('submit', function(event) {
    var password = document.getElementById('inputPassword').value;
    var confirmPassword = document.getElementById('inputRepetirPassword').value;
    var errorMessage = document.getElementById('error-message');
    let codigo_postal_inserido = document.getElementById("inputCP").value;
    console.log(codigo_postal_inserido);
    let regex_codigo_postal = /^[0-9]{4}-[0-9]{3}$/;
    let tele_inserido = document.getElementById("inputTele").value;
    console.log(tele_inserido);
    let regex_tele = /^[0-9]{9}$/;

    if (password !== confirmPassword) {
        errorMessage.textContent = 'As senhas não coincidem!';
        errorMessage.style.display = 'block';
        event.preventDefault(); // Impede o envio do formulário
    } else {
        errorMessage.style.display = 'none';
    }

    if (regex_codigo_postal.test(codigo_postal_inserido)) {
        console.log("Valid! " + codigo_postal_inserido);
    } else {
        console.error("Invalid!");
        alert("Código-postal inserido inválido! Insira novamente!");
        document.getElementById("inputCP").value = "";
        event.preventDefault(); // Impede o envio do formulário
    }

    if (regex_tele.test(tele_inserido)) {
        console.log("Valid! " + tele_inserido);
    } else {
        console.error("Invalid!");
        alert("Número de telemóvel inválido! Insira novamente!");
        document.getElementById("inputTele").value = "";
        event.preventDefault(); // Impede o envio do formulário
    }
});