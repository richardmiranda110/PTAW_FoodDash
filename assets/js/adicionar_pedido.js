"use strict";

// Container complementos
let complementoContainer = document.querySelector("#complement-section");
// Container personalizações
let personalizacoesContainer = document.querySelector("#personalizations-section");
// Checkbox item sozinho
const itemSozinhoForm = document.querySelector("#itemsozinho-form");
// Checkbox personalizações ativas
const personalizacoesAtivasForm = document.querySelector("#personalizacoes-ativas-form");

// Caixa modal
const modal = document.querySelector("#modal");
// + Novo Complemento
const btnComplemento = document.querySelector("#novoComplementoBtn");
// Botão na caixa de input a dizer "Adicionar"
const adicionarDadosBtn = document.querySelector("#adicionarBtn");
// Botão de fechar a caixa
const spanBotaoX = document.querySelectorAll(".close")[0];
// Input da caixa de colocar dados
const novoItemInput = document.querySelector("#novoItemInput");

// Tabela de bebidas
const addDrinkDableContainer = document.querySelector("#add-drink-dable-container");
// Importar bebida
const btnImportarBebida = document.querySelector("#import-drink-btn");

// Adicionar acompanhamento
const btnAddAcompanhamento = document.querySelector("#add-acompanhamento-btn");
// Importar acompanhamento
const btnImportarAcompanhamento = document.querySelector("#import-drink-btn");

// Adicionar bebida
const btnNovaBebida = document.querySelector("#add-drink-btn");

// Criar tabela de bebida
const bebidaDableContainer = "add-drink-dable-container";
const acompanhamentosDableContainer = "add-personalization-dable-container";
let dableBebida = new Dable();
let dableAcompanhamento = new Dable();

const form = document.querySelector("#dataForm");

form.submit = () => console.log("hi");

// colunas das tabelas
let columns = [ 'Nome','' ];
// Bebidas, não alterem este array, usem dable.AddRow ou dable.RemoveRow para alterarem os dados
let dadosBebidas = [ ['Coca-Cola',''],['Ice Tea Manga',''],['Fanta Uva',''],['Sumol Laranja',''] ];
// Acompanhamentos, não alterem este array, usem dable.AddRow ou dable.RemoveRow para alterarem os dados
let dadosAcompanhamentos = [ ['Batatas médias',''],['Sopa de ervilhas',''],['5 nuggets',''] ];

configurarDable(dableBebida,bebidaDableContainer,dadosBebidas,columns);
configurarDable(dableAcompanhamento,acompanhamentosDableContainer,dadosAcompanhamentos,columns);

// Associar botão com tabela usando Map
const opcoesMap = new Map();
opcoesMap.set(btnNovaBebida,dableBebida);
opcoesMap.set(btnImportarBebida,"put import");

opcoesMap.set(btnAddAcompanhamento,dableAcompanhamento);
opcoesMap.set(btnImportarAcompanhamento,"put import");

// Adiciona evento aos botões de adicionar elemento
const addButtons = document.querySelectorAll(".modal_event");
addButtons.forEach(element => {
    element.onclick = event => { 
        event.preventDefault();
        console.log(element.id)
        showModal(element.textContent.substring(2),opcoesMap.get(element));
    };
});

// Esconder se o botão for não
itemSozinhoForm.onclick = _ => hideCheckboxElement("itemsozinho",complementoContainer);
personalizacoesAtivasForm.onclick = _ => hideCheckboxElement("personalizacoesativas",personalizacoesContainer);

// Adiciona funcionalidade a botão de apagar
document.addEventListener('click', event => {
  if (event.target.classList.contains('deleteRow')) {
    buttons(event.target);
  }
});


function buttons(element) {
  let dable;
  switch(element.id){
    case bebidaDableContainer:
      dable = dableBebida;
    break;
    case acompanhamentosDableContainer:
      dable = dableAcompanhamento;
    break;
  }

  var rowNumber = element.getAttribute('data-rownumber');
  dable.DeleteRow(rowNumber);
}

// Abrir interface ao clicar no botão, substring para remover o "+ "
btnAddAcompanhamento.onclick = function(event) { 
  console.log("Acompanhamento")
    event.preventDefault();
    showModal(btnComplemento.textContent.substring(2),opcoesMap.get(btnAddAcompanhamento))
  };

// Ao clicar no x do modal, esconder interface de caixa
spanBotaoX.onclick = hideModal;

// Quando o usuario clicar fora da caixa, esconder interface de caixa
window.onclick = event => {
  if (event.target == modal) {
    modal.classList.add('d-none');
  }
}

function configurarDable(dable,containerElement,rowArray,columnArray){
  // Configura tabelas Dable para bebida
  dable.SetDataAsRows(rowArray);
  dable.style = 'bootstrap';	//set the style
  dable.SetColumnNames(columnArray);
  dable.columnData[1].CustomRendering = function (_cellValue, rowNumber) {
    return '<button type="button" id="'+containerElement+'" class="deleteRow" data-rownumber="' + rowNumber + '">✕</button>';
  };
  dable.BuildAll(containerElement);
}

/**
 * 
 * @param {*} name 
 * @param {*} elementToHide 
 */
function hideCheckboxElement(name, elementToHide){
  // pegar na radiobox que esteja selecionada
  const clicked = document.querySelector('input[name='+`${name}`+']:checked');
  // usar valor de radiobox e aplicar na visibilidade da caixa
  elementToHide.style.display = clicked.value == "true" ? 'block' : 'none';
}

/**
 * 
 * @param {*} text 
 * @param {*} list 
 */
function showModal(text,dable){
    const modalText = document.querySelector("#modal-text");
    modalText.textContent = `Adicionar ${text}`;
    
    modal.classList.remove('d-none');
    modal.classList.add('d-flex');

    adicionarDadosBtn.onclick = function() {
      dable.AddRow([novoItemInput.value.toString(),'']);
      spanBotaoX.click()
      
      console.log(JSON.stringify({data:tableToJson(dable)}));
    }
}

function hideModal(){
  modal.classList.add('d-none');
  novoItemInput.value= "";
}

/**
 * 
 * @param {*} dableTable 
 * @returns 
 */
function tableToJson(dableTable) { 
  let element = document.getElementById(dableTable.id);
  var data = [];
  for (var i = 1; i < dableTable.rows.length; i++) { 
      var cells = element.querySelectorAll('tbody td');
      var rowData = []; 
      for (var j = 0; j < cells.length; j+=2) { 
          rowData.push(cells[j].innerHTML);
      } 
      data.push(rowData); 
  } 
  return data; 
}