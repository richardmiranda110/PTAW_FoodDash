"use strict";

const dataSource = 'http://localhost/business/lista_items.php?idEstabelecimento=2';

// Container complementos
let complementoContainer = document.querySelector("#complement-section");
// Container personalizações
let personalizacoesContainer = document.querySelector("#personalizations-section");
// Checkbox item sozinho
const itemSozinhoForm = document.querySelector("#itemsozinho-form");
// Checkbox personalizações ativas
const personalizacoesAtivasForm = document.querySelector("#personalizacoes-ativas-form");
// Container que contem produtos adicionados
const ProdutosContainer = document.querySelector("#categoria-produtos-container");
// caixa onde tem as checkboxes personalizções
const personalizacoesBox =  document.querySelector("#personalizacoes-container");
// caixa onde tem as checkboxes menu
const menuBox =  document.querySelector("#menu-container");
// Caixa modal
const modal = document.querySelector("#modal");
// Conteudo da caixa Modal
const modalContent = document.getElementById("modal-content");
// header modal
const modalText = document.getElementById("modal-text");
// + Novo Complemento
const btnAdicionarCategoria = document.querySelector("#btnNovoItemCategoria");
// Botão de fechar a caixa
const spanBotaoX = document.querySelectorAll(".close")[0];
// Input da caixa de colocar dados
const novoInput = document.querySelector("#novoItemInput");
// Input para nome de alimento
const nomeInput = document.querySelector("#nome");
// label de personalizações
const itemName = document.querySelector("#item-name-label");
// select tag ao adicionar categoria
const categoriaSelector = document.querySelector("#idcategoria");
// Tabela de bebidas
const addDrinkDableContainer = document.querySelector("#add-drink-dable-container");
// Importar bebida
const btnImportarBebida = document.querySelector("#import-drink-btn");
// Importar acompanhamento
const btnImportarAcompanhamento = document.querySelector("#import-drink-btn");
// Adicionar bebida
const btnNovaBebida = document.querySelector("#add-drink-btn");
const btnNovaOpcao = document.querySelector("#nova-personalizacao-btn");

// Associar botão com tabela usando Map
const buttonDableMap = new Map();

//array de produtos
let dableProductTables = []

// tabela de importar item
var importDable = new Dable();
var rows = [];
var itemList = [];

// Define Colunas
var listImportColumns = [ 'Nome','Categoria', 'Preço','Disponivel',''];
importDable.SetColumnNames(listImportColumns);

// Coloca estilo na tabela
importDable.style = 'CulpaDoRichard';

// tabela de personalizar item
var costumizationDable = new Dable();


itemSozinhoForm.onclick = _ => {
    // Pegar na radiobox que esteja selecionada
    const isMenu = getCheckboxValue("itemsozinho");
    // Usar valor de radiobox e aplicar na visibilidade da caixaW
    complementoContainer.style.display = isMenu.value == "true" ? 'block' : 'none';
    personalizacoesBox.style.display = isMenu.value == "true" ? 'none' : 'block';
} 

personalizacoesAtivasForm.onclick = _ =>{
    // Pegar na radiobox que esteja selecionada
    const isPersonalized = getCheckboxValue("personalizacoesativas");
    // Usar valor de radiobox e aplicar na visibilidade da caixa 
    personalizacoesContainer.style.display = isPersonalized.value == "true" ? 'block' : 'none';
    menuBox.style.display = isPersonalized.value == "true" ? 'none' : 'block';
    configureCostimizationDable();
}

btnNovaOpcao.onclick = _ => {
  showTextModal(btnNovaOpcao.textContent.substring(2));
}

btnAdicionarCategoria.onclick = _ => {
  showCategoryModal("Adicionar uma Categoria");
}
/**
 * 
 * @param {*} parent 
 * @param {*} nomeCategoria 
 */
function gerarTabelaCategoria(nomeCategoria){
/**
          <div class="complement-header mb-0">
            <p class="fw-bold m-0">Bebida</p>
            <button class="btn btn-custom modal_event" id="add-drink-btn">Importar Existente</button>
          </div>
          <hr class="mt-0">
          <div id="add-drink-dable-container"></div>
 */

  const parent = ProdutosContainer;
  const container = document.createElement("div");

  // cria container para conteudo
  const header = document.createElement("div")
  header.classList.add("complement-header")
  header.classList.add("mb-0")

  // cria header
  const title = document.createElement("p")
  title.classList.add("fw-bold")
  title.classList.add("mb-0")
  title.innerText = nomeCategoria

  // cria botão de import
  const btnDelete = document.createElement("button")

  // Adiciona classes
  btnDelete.classList.add("btn")
  btnDelete.classList.add("btn-custom")
  btnDelete.classList.add("modal_event")
  btnDelete.classList.add("bg-danger")
  btnDelete.classList.add("float-end")
  btnDelete.innerText = "X"

  // cria botão de import
  const btnImport = document.createElement("button")

  // Adiciona classes
  btnImport.classList.add("btn")
  btnImport.classList.add("btn-custom")
  btnImport.classList.add("bg-bg-danger")
  btnImport.classList.add("modal_event")
  btnImport.innerText = "Importar Existente"
  btnImport.id = "add-drink-btn"

  btnDelete.onclick = event => {
    event.preventDefault();

    // Obtem index da Dable no array
    const index = dableProductTables.indexOf(dableTable);

    // Remove o conteudo da pagina e array
    container.remove();
    delete dableProductTables[index];

    // remove o "null" deixado ao remover
    dableProductTables = dableProductTables.filter(function(e){return e}); 
  }

  // cria linha horizontal
  const line = document.createElement("hr")
  line.classList.add("mt-0")

  // cria container para libraria Dable
  const dableContainer = document.createElement("div")
  dableContainer.id = `dable-${nomeCategoria.replaceAll(/[\s.;,?%0-9]/g, '').replaceAll(' ','')}`
  // verifica se categoria já existe
  if(checkIfDableExists(dableContainer)){
    spanBotaoX.click();
    return;
  }

  // criar associação entre botão e tabela
  const dable = generateDableProductTable(dableContainer);

  buttonDableMap.set(dableContainer.id,dable);

    // objeto DableTable relacionado ao conteudo
    const dableTable = buttonDableMap.get(dableContainer.id);
    // Adiciona evento de clicar 
    btnImport.onclick = event => { 
      event.preventDefault();
  
      showImportModal(`Importar ${nomeCategoria}`,nomeCategoria, dableTable);  
    };

  // colocar botão e titulo
  header.append(title,btnImport)
  container.append(btnDelete)
  container.append(header,line,dableContainer);

  parent.appendChild(container);

  // popular tabela
  dable.BuildAll(dableContainer.id);
}

function deleteOption(element){
 const dable = costumizationDable;

 const rownumber = element.getAttribute("data-rownumber");
 dable.DeleteRow(rownumber);
}

function addItem(element){
  const dableId =  element.getAttribute("dable-id")
  const dable = buttonDableMap.get(dableId);
 
  const rownumber =  element.getAttribute("data-rownumber");
  const item = itemList[rownumber];
  dable.AddRow([item.nome,item]);
 }
 

function performDelete(element){
  const dableId =  element.getAttribute("dable-id")
  const dable = buttonDableMap.get(dableId);
 
  const rownumber =  element.getAttribute("data-rownumber");
  dable.DeleteRow(rownumber);
}

// Adiciona funcionalidade a botão de apagar
document.addEventListener('click', event => {
  if (event.target.classList.contains('deleteOption')) {
    deleteOption(event.target);
  }

  if (event.target.classList.contains('addRow')) {
    addItem(event.target);
  }

  if (event.target.classList.contains('deleteRow')) {
    performDelete(event.target);
  }
});

// Ao clicar no x do modal, esconder interface de caixa
spanBotaoX.onclick = hideModal;

// Quando o usuario clicar fora da caixa, esconder interface de caixa
window.onclick = event => {
  if (event.target == modal) {
   hideModal();
  }
}

function generateDableProductTable(container){
  let table = new Dable();
  let columns = [ 'Nome','' ];
  let rows = [''];

  // configura a tabela para receber conteudo
  configureProductDable(table,rows,columns);
  // adiciona a tabela á lista e retorna
  dableProductTables.push(table);
  return table;
}

function configureProductDable(dable,rowArray,columnArray){
  // Configura tabelas
  dable.SetDataAsRows(rowArray);
  dable.style = 'CulpaDoRichard';
  dable.SetColumnNames(columnArray);

  dable.columnData[1].CustomRendering = function (_cellValue, rowNumber) {
    return '<button> <img width="30" class="bg-white deleteRow" dable-id='+dable.id+' src="../business/assets/imgs/delete.png" data-rownumber="' + rowNumber + '" /></button>';
  };
}
var costumizationColumns = [ 'Nome', 'Qtd'];
var costumizationRows = [[]];
function configureCostimizationDable(){
  // Configura tabelas
  costumizationDable.SetDataAsRows(costumizationRows);
  costumizationDable.style = 'fooddash';
  costumizationDable.SetColumnNames(costumizationColumns);


  costumizationDable.columnData[1].CustomRendering = function (_cellValue, rowNumber) {
    return ' <div class="col-xs-2 w-25 mx-3s float-end "><button type="button" data-rownumber="' + rowNumber + '" dable-id='+costumizationDable.id+' class="btn btn-light btn-sm deleteOption">✕</button><input id="personalization-input" class="w-25 text-center float-end border" type="number" min="0" class="form-control form-control-sm input-group-text" "><span class=" mx-2 float-end mr-2" data-rownumber="' + rowNumber + '" dable-id='+costumizationDable.id+' >Max.:</span></div';
  };

  costumizationDable.BuildAll("costumization-dable");
}

function checkIfDableExists(dableContainer){
  for(let table of dableProductTables){
    if(table.id == dableContainer.id)
        return true;
  }
  return false;
}

function getCheckboxValue(checkboxName){
  // pegar na radiobox que esteja selecionada
  return document.querySelector('input[name='+`${checkboxName}`+']:checked');
}

async function populateImportDable(nomeCategoria = null){
  rows = [];
  itemList = [];
  let request;
  // se não houver categoria, pega todos os dados
  if(nomeCategoria == null){
    request = fetchData();
  }else{
    request = fetchData(nomeCategoria);
  }

  const response = await request;
  if(response == null){
    console.log("Erro ao popular tabela!");
    return response;
  }

  // popula array para mostrar
  for(let item of response.itens){
    itemList.push(item);
    rows.push([item.nome,item.categoria,item.preco+'€',item.disponivel? 'Sim': 'Não',item.id]);
  }
  importDable.SetDataAsRows(rows)
}

/**
 * 
 * @param {*} text 
 * @param {*} list 
 */
function showImportModal(text,categoria,dable){
  // prepara Modal
  setupModal(text);

  // cria container para a nova tabela
  const defaultDable = document.createElement("div");
  // adiciona ID para ser usado pela libraria
  defaultDable.id = "DefaultDable";
  modalContent.appendChild(defaultDable);

  importDable.columnData[4].CustomRendering = function (_cellValue, rowNumber) {
    return '<button> <img width="30" class="bg-white addRow" dable-id='+dable.id+' src="../business/assets/imgs/add.png" data-rownumber="' + rowNumber + '" /></button>';
  };

  // espera o resultado do servidor e popula tabela
  populateImportDable(categoria).then(_ => {

    // mostra tabela
    importDable.BuildAll("DefaultDable"); 
  })
}

let selectContainer = 0;
/**
 * 
 * @param {*} text 
 * @param {*} list 
 */
function showCategoryModal(text){
  const container = document.createElement("div");
  container.id = "import-select-container";
  // cria elemento de opção
  const selectTag = document.createElement("select");

  selectTag.innerHTML = categoriaSelector.innerHTML;
  selectTag.classList.add("mb-2");
  selectTag.classList.add("form-select");

  // Colocar elemento na pagina
  container.appendChild(selectTag);

  // criar botão de adicionar
  const btnAdd = document.createElement("button");
  btnAdd.id = "adicionarBtn";
  btnAdd.classList.add("w-100");
  btnAdd.innerHTML = "Adicionar";

  // Colocar elemento na pagina
  container.appendChild(btnAdd);
  modalContent.appendChild(container);
  selectContainer = document.getElementById("import-select-container");

  // Prepara Modal
  setupModal(text);

  // Coloca Funcionalidade no botão
  btnAdd.onclick = function() {
    const selected = selectTag.options[selectTag.selectedIndex];
    gerarTabelaCategoria(selected.text);
    spanBotaoX.click();
  }
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
  selectContainer = document.getElementById("import-select-container");

  // Prepara Modal
  setupModal(text);

  // Coloca Funcionalidade no botão
  btnAdd.onclick = function() {
    costumizationDable.AddRow([String(modalInput.value),''])
    spanBotaoX.click();
  }
}


function setupModal(headerText){
  // <p class="fw-bold mt-1 mb-2"></p>
  modalText.textContent = `${headerText}`;
  
  modal.classList.remove('d-none');
  modal.classList.add('d-flex');
}

function hideModal(){
  modal.classList.add('d-none');
  try{
    document.querySelector("#DefaultDable").remove();
  }catch(err){}
    selectContainer.remove();

}

async function fetchData(categoria = null){
  let url = dataSource;
  
  if(categoria !== null){
    url += `&categoria=${categoria}`;
  }

  const response = await fetch(url);
  
  if(!response.ok){
    alert("Could no connect to database :o");
    return null;
  }

  return response.json();
}