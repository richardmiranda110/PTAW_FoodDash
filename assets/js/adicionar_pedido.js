let complementosContainer = document.getElementById("complement-section");
let personalizacoesContainer = document.getElementById("personalizations-section");
const itemSozinhoForm = document.getElementById("itemsozinho-form");
const personalizacoesAtivasForm = document.getElementById("personalizacoes-ativas-form");

itemSozinhoForm.addEventListener("click", _ => hideCheckboxElement("itemsozinho",complementosContainer));
personalizacoesAtivasForm.addEventListener("click", _ => hideCheckboxElement("personalizacoesativas",personalizacoesContainer));

function hideCheckboxElement(name,elementToHide){
    const clicked = document.querySelector('input[name='+`${name}`+']:checked');
    elementToHide.style.display = clicked.value == "true" ? 'block' : 'none';
}