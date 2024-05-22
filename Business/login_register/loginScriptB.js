document.getElementById('registoForm').addEventListener('submit', function(event) {
    var password = document.getElementById('inputPassword').value;
    var confirmPassword = document.getElementById('inputRepetirPassword').value;
    var errorMessage = document.getElementById('error-message');

    if (password !== confirmPassword) {
        errorMessage.textContent = 'As senhas não coincidem!';
        errorMessage.style.display = 'block';
        event.preventDefault(); // Impede o envio do formulário
    } else {
        errorMessage.style.display = 'none';
    }
});