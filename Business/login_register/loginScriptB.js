document.getElementById('registoForm').addEventListener('submit', function(event) {
    var password = document.getElementById('inputPassword').value;
    var confirmPassword = document.getElementById('inputRepetirPassword').value;
    let tele_inserido = document.getElementById("inputTel").value;
    console.log(tele_inserido);
    let regex_tele = /^[0-9]{9}$/;

    $('#error-message').toast('show');
    const toastTriggerPass = document.getElementById('btnLogin');
    const toastLivePass = document.getElementById('error-message');

    if (password !== confirmPassword) {
        if (toastTriggerPass) {
            const toastBootstrapPass = bootstrap.Toast.getOrCreateInstance(toastLivePass);
            toastTriggerPass.addEventListener('click', () => {
            toastBootstrapPass.show();
            });
        };
        event.preventDefault(); // Impede o envio do formulário
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