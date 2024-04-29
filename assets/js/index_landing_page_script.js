document.getElementById("btn_procurar_codigo_postal").addEventListener("click", function () {
    let codigo_postal_inserido = document.getElementById("input_codigo_postal").value;
    console.log(codigo_postal_inserido);
    let regex_codigo_postal = /^[0-9]{4}-[0-9]{3}$/;

    if (regex_codigo_postal.test(codigo_postal_inserido)) {
        console.log("Valid! " + codigo_postal_inserido);
    } else {
        console.error("Invalid!");
        alert("Código-postal inserido inválido! Insira novamente!");
        document.getElementById("input_codigo_postal").value = "";
    }
});