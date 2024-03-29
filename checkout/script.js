function toggleSelectionEntrega(element) {
    // Remove a classe "selected" de todos os elementos com a classe "opcao"
    document.querySelectorAll('.opcaoEntrega').forEach(function(el) {
        el.classList.remove('selected');
    });

    // Adiciona a classe "selected" apenas ao elemento clicado
    element.classList.add('selected');

    var MBWAYCampos = document.getElementById("agendarHoraCampos");
    if (element.querySelector("p").textContent.trim() === "Agendar") {
        agendarHoraCampos.style.display = "block";
        agendarHoraCampos.style.marginTop = "20px";
    } else {
        agendarHoraCampos.style.display = "none";
    }
}


function toggleSelection(element) {
    // Remove a classe "selected" de todos os elementos com a classe "opcao"
    document.querySelectorAll('.opcao').forEach(function(el) {
        el.classList.remove('selected');
    });

    // Adiciona a classe "selected" apenas ao elemento clicado
    element.classList.add('selected');

    var cartaoCampos = document.getElementById("cartaoCampos");
    // Verifica se a opção "Cartão de Crédito ou Débito" está selecionada
    if (element.querySelector("p").textContent.trim() === "Cartão de Crédito ou Débito") {
        // Se estiver selecionada, mostra os campos de preenchimento
        cartaoCampos.style.display = "block";
        cartaoCampos.style.marginTop = "20px";
    } else {
        // Caso contrário, oculta os campos de preenchimento
        cartaoCampos.style.display = "none";
    }

    var MBWAYCampos = document.getElementById("MBWAYCampos");
    if (element.querySelector("p").textContent.trim() === "MBWAY") {
        MBWAYCampos.style.display = "block";
        MBWAYCampos.style.marginTop = "20px";
    } else {
        MBWAYCampos.style.display = "none";
    }
}


function editarMorada() {
    var textoMorada = document.getElementById("textoMorada");

    // Ativa a edição do texto apenas se estiver desativada
    if (textoMorada.contentEditable === "false") {
        textoMorada.contentEditable = true;
        textoMorada.focus();

        // Adiciona evento para guardar ao pressionar Enter
        textoMorada.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Impede a quebra de linha
                guardarMorada();
            }
        });
    }
}

function guardarMorada() {
    var textoMorada = document.getElementById("textoMorada");

    // Desativa a edição do texto
    textoMorada.contentEditable = false;

    // Guarda o texto editado
    var novoEndereco = textoMorada.textContent;
    console.log("Novo endereço salvo: " + novoEndereco);
}


function adicionarPromoCode() {
    var addPromoCode = document.getElementById("addPromoCode");

    if (addPromoCode.style.display === "none" || addPromoCode.style.display === "") {
        addPromoCode.style.display = "block";
        addPromoCode.style.marginTop = "20px";
    }
}
