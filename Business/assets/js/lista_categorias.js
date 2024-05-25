"use strict";

// Caixa modal
const modal = document.querySelector("#modal");
// Conteudo da caixa Modal
const modalContent = document.getElementById("modal-content");
// header modal
const modalText = document.getElementById("modal-text");

const btnNovaOpcao = document.querySelector("#btnNovoItemCategoria");

// Botão de fechar a caixa
const spanBotaoX = document.querySelectorAll(".close")[0];

// Ao clicar no x do modal, esconder interface de caixa
spanBotaoX.onclick = hideModal;

window.onclick = event => {
  if (event.target == modal) {
   hideModal();
  }
}

function hideModal(){
  modal.classList.toggle('d-none');
}

var dable = new Dable();
var rows = [];
var list_columns = [ 'Nome', 'Itens'];
var items = [];
const response = fetch('http://localhost/business/lista_categorias.php?idEmpresa='+idEmpresa+'')
  .then(response => response.json())
  .then(data => {
    for(item of data){
      items.push(item);
      rows.push([ item.nome,item.count+" item"]);
    }
    return rows;
  })
  .then( _ =>{
    dable.SetDataAsRows(rows)
    dable.style = 'fooddash_categorias';
	  dable.SetColumnNames(list_columns);

	dable.BuildAll("DefaultDable"); 
  }).catch((error) => console.error('Error:', error));
	
  
  document.addEventListener('click', handleDeleteButtonClick);

function handleDeleteButtonClick(event) {
    if (event.target.classList.contains('editRow')) {
        editItem(event.target);

    }   
    if (event.target.classList.contains('deleteRow')) {
        removeItem(event.target);
    }
}

btnNovaOpcao.onclick = _ => {
  showTextModal(btnNovaOpcao.textContent.substring(2));
}

function removeItem(element) {
  // mandar para base de dados
  var rowNumber = element.getAttribute('data-rownumber');
  dable.DeleteRow(rowNumber);
}

function editItem(element) {
  // mandar para base de dados
  var rowNumber = element.getAttribute('data-rownumber');

  const item = items[rowNumber];
  window.open(`../dashboard_adicionar_pedido.php?id=${item.id_item}         `);

}


function showTextModal(text){
  const container = document.createElement("div");
  container.id = "import-select-container";
  // cria elemento de opção
  const modalInput = document.createElement("input");
  modalInput.type = "text";

  modalInput.classList.add("mb-2");
  modalInput.classList.add("form-control");

  // Colocar elemento na pagina
  container.appendChild(modalInput);

  // criar botão de adicionar
  const btnAdd = document.createElement("button");
  btnAdd.id = "adicionarBtn";
  btnAdd.classList.add("w-100");
  btnAdd.innerHTML = "Adicionar";

  // Colocar elemento na pagina
  container.appendChild(btnAdd);
  modalContent.appendChild(container);

  // Prepara Modal
  setupModal(text);

  // Coloca Funcionalidade no botão
  btnAdd.onclick = function() {
    dable.AddRow([String(modalInput.value),0])
    spanBotaoX.click();
  }
}

function setupModal(headerText){
  // <p class="fw-bold mt-1 mb-2"></p>
  modalText.textContent = `${headerText}`;
  
  modal.classList.remove('d-none');
  modal.classList.add('d-flex');
}