"use strict";

const dataSource = 'http://localhost/business/lista_items.php?idEstabelecimento='+idEstabelecimento;

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
// input da caixa de preço
const inputPreco = document.querySelector("#preco");
// input da caixa de descrição
const inputDescricao = document.querySelector("#descricao");
// label de personalizações
const itemName = document.querySelector("#item-name");
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
const btnSubmit = document.querySelector("#submit-btn");

const alertContainer = document.querySelector("#alert");

const form = document.querySelector('form');
form.addEventListener('submit', handleSubmit);

const imageInput = document.querySelector("#foto");

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

nomeInput.onchange = () => {
  itemName.innerHTML = String(nomeInput.value);
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

btnSubmit.onclick = () => generateItemData();

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
var costumizationColumns = [ 'Nome', ''];
var costumizationRows = [[]];
function configureCostimizationDable(){
  // Configura tabelas
  costumizationDable.SetDataAsRows(costumizationRows);
  costumizationDable.style = 'fooddash';
  costumizationDable.SetColumnNames(costumizationColumns);


  costumizationDable.columnData[1].CustomRendering = function (_cellValue, rowNumber) {
    return ' <div class="col-xs-2 w-25 mx-3s float-end "><input class="w-25 text-center float-end border option-price-amount" type="number" value="1" min="0" step="any" class="form-control form-control-sm input-group-text" "><span class=" mx-2 float-end mr-2" data-rownumber="' + rowNumber + '" dable-id='+costumizationDable.id+' >Preço:</span><input step="any" class="w-25 text-center float-end border option-amount" type="number" value="1" min="0" class="form-control form-control-sm input-group-text" "><span class=" mx-2 float-end mr-2" data-rownumber="' + rowNumber + '" dable-id='+costumizationDable.id+' >Max.:</span><button type="button" data-rownumber="' + rowNumber + '" dable-id='+costumizationDable.id+' class="btn btn-light float-end btn-sm deleteOption">✕</button></div>';
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

    if(selected.value == "null"){
      displayErrorMessage("Por favor adicionar uma categoria para continuar");
      spanBotaoX.click();
      return;
    }
    
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

function generateItemData(foto_url){
  let itemType = getCheckboxValue("itemsozinho").value == "false" ? "item" : "menu";
  let isPersonalized = getCheckboxValue("personalizacoesativas").value;
  itemType += isPersonalized == "true" ? "-personalizado" : "";

  const itemFactory = new ItemFactory();
  try{
    const item = itemFactory.createItem(itemType,isPersonalized,foto_url);
 
    let result = { 
      "idEstabelecimento": idEstabelecimento,
      tipo:itemType,
      dados: item
    }
    return result;
   }catch(error){
     displayErrorMessage(error);
   }
  return undefined;
}

function getItems(){
  let resultado = {};
  dableProductTables.forEach(element => {
    const elementos = element.rows.slice(1);

    if(elementos.length == 0){
      return;
    }
    resultado = {
        categoria: elementos[0][1].categoria,
        items: []
    }

    elementos.forEach(item => {
        resultado.items.push(item[1])
    })
  });
  return [resultado];
}

function getOptions(){
  const json = []
  costumizationDable.rows.slice(1).forEach((element,i) => {
    const options = document.querySelectorAll(".option-amount");
    const optionsprice = document.querySelectorAll(".option-price-amount");
    json.push({nome:element[0],max_quantidade: parseInt(options[i].value),preco: parseFloat(optionsprice[i].value) });
  })
  return json;
}

class ItemFactory{
    dados = {
      nome: nomeInput.value,
      preco: parseFloat(inputPreco.value),
      descricao: inputDescricao.value,
      disponivel: getCheckboxValue("disponivel").value == "true" ? true:false,
      categoria:  parseInt(categoriaSelector.options[categoriaSelector.selectedIndex].value),
      itens : getItems(),
      opcoes: getOptions()
    }
  
  createItem(tipo,isPersonalized,foto_url){
    
     if(this.isDataValid(tipo,isPersonalized) == false)
       throw new Error("Por favor verifique um dos campos");

    switch(tipo){
      case "item":
        return new MenuItem(
          this.dados.nome,this.dados.preco,
          this.dados.descricao,this.dados.disponivel,
          foto_url,this.dados.categoria)
      case "item-personalizado":
          return new MenuItemWithOptions(
            this.dados.nome,this.dados.preco,
            this.dados.descricao,this.dados.disponivel,
            foto_url,this.dados.categoria,
            this.dados.opcoes)
      case "menu":
        return new ItemBundle(
          this.dados.nome,this.dados.preco,
          this.dados.descricao,this.dados.disponivel,
          foto_url['url'],this.dados.categoria,this.dados.itens)
      default:
          throw new Error("Item invalido");
    }
    
  }

  isDataValid(tipo,isPersonalized){
    if(this.dados.nome === ''){
      throw new Error("Nome do item não pode estar vazio");
    }else if(this.dados.preco === NaN){
      throw new Error("Preço invalido");
    }else if(this.dados.preco <= 0){
      throw new Error("Preço não pode ser negativo");
    }else if(imageInput.files.length == 0){
      throw new Error("Por favor coloque uma imagem");
    }else if(costumizationDable.rows.length-1 == 0 && isPersonalized == "true"){
      throw new Error("Opções não podem estar vazias");
    }
    return true;
  }
}

class MenuItem{
  constructor(nome,preco,descricao,disponivel,foto,categoria) {
    this.nome = nome;
    this.preco = preco;
    this.descricao = descricao;
    this.disponivel = disponivel;
    this.foto = foto;
    this.categoria = categoria;
  }

  toJson(){
    return JSON.stringify(this);
  }
}

class ItemBundle extends MenuItem {
  constructor(nome,preco,descricao,disponivel,foto,categoria,items){
    super(nome,preco,descricao,disponivel,foto,categoria)
    this.items = items;
  }
}

class SingleMenuItem extends MenuItem{
  constructor(nome,preco,descricao,disponivel,foto,categoria){
    super(nome,preco,descricao,disponivel,foto,categoria)
  }
}

class MenuItemWithOptions extends MenuItem{
  constructor(nome,preco,descricao,disponivel,foto,categoria,opcoes){
    super(nome,preco,descricao,disponivel,foto,categoria)
    this.opcoes = opcoes;
  }
}

/** @param {Event} event */
async function handleSubmit(event) {
event.preventDefault();

  const files = imageInput.files;
  if(files.length == 0){
      alert("Por favor man, imagem :bruh:");
  }

  let formdata = new FormData();
  formdata.append("foto",files[0]);

  const uploadImageTask = await fetch("../uploadFile.php", {
    body: formdata,
    method: "post",
  })
  .then(answer => answer.json())
  .then(data => {
    if(data.status == "error" && data.message != "O ficheiro ja existe"){
      displayErrorMessage(data.message);
      return;
    }

    displaySuccessMessage(data.message);
    return generateItemData(data.url);
  });

  // returns object with image already attached
  const data = uploadImageTask;

  const createItemTask = await postJSON("./inserir_item.php",data);
  
  if(createItemTask['status'] == "error"){
    displayErrorMessage(createItemTask.message);
  }else{
    displaySuccessMessage(createItemTask.message);
  }
}

function displayErrorMessage(message){
  alertContainer.classList.remove("d-none");

  if(alertContainer.classList.contains("alert-success")){
    alertContainer.classList.remove("alert-success");
  }
  
  alertContainer.classList.add("alert-danger")
  alertContainer.innerHTML = message
}

function displaySuccessMessage(message){
  alertContainer.classList.remove("d-none");

  if(alertContainer.classList.contains("alert-danger")){
    alertContainer.classList.remove("alert-danger")
  }
  alertContainer.classList.add("alert-success");
  alertContainer.innerHTML = message
}

function hideAlertMessage(){
  alertContainer.classList.add("d-none");
}

async function postJSON(url,data) {
  try {
    const response = await fetch(url, {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });

    const result = await response.json();
    return result;
  } catch (error) {
    console.error("Error:", error);
  }
}