// complemento
let complementosContainer = document.getElementById("complement-section");
let personalizacoesContainer = document.getElementById("personalizations-section");
const itemSozinhoForm = document.getElementById("itemsozinho-form");
const personalizacoesAtivasForm = document.getElementById("personalizacoes-ativas-form");

//modal
let modal = document.getElementById("modal");
var btnComplemento = document.getElementById("novoComplementoBtn");
var btnOpcao = document.getElementById("novaOpcaoBtn");
var spanBotaoX = document.getElementsByClassName("close")[0];

//esconder se o botão for não
itemSozinhoForm.onclick = _ => hideCheckboxElement("itemsozinho",complementosContainer);
personalizacoesAtivasForm.onclick = _ => hideCheckboxElement("personalizacoesativas",personalizacoesContainer);

function hideCheckboxElement(name, elementToHide){
    // pegar na radiobox que esteja selecionada
    const clicked = document.querySelector('input[name='+`${name}`+']:checked');
    // usar valor de radiobox e aplicar na visibilidade da caixa
    elementToHide.style.display = clicked.value == "true" ? 'block' : 'none';
}

// abrir interface ao clicar no botão, substring para remover o "+ "
btnComplemento.onclick = event => { 
    event.preventDefault();
    showModal(btnComplemento.textContent.substring(2))};

const addButtons = document.querySelectorAll(".modal_event");
addButtons.forEach(element => {
    element.onclick = event => { 
        event.preventDefault();
        showModal(element.textContent.substring(2))
    };
});

function showModal(text){
    const modalText = document.querySelector("#modal-text");
    modalText.textContent = `Adicionar ${text}`;
    modal.style.display = "flex";
}

// ao clicar no x do modal, esconder interface de caixa
spanBotaoX.onclick = _ => {
  modal.style.display = "none";
}

// quando o usuario clicar fora da caixa, esconder interface de caixa
window.onclick = event => {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}