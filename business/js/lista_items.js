var dable = new Dable();
var rows = [];
var list_columns = [ 'Foto', 'Nome', 'Preço','Menus','Categorias','','' ];
var items = [];
const response = fetch('http://localhost/business/lista_items.php?idEstabelecimento=31')
  .then(response => response.json())
  .then(data => {
    for(item of data){
      items.push(item);
      rows.push([ item.foto, item.nome,item.preco+'€','Menu do Almoço, Menu do Jantar',' Na grelha, Carne','','' ]);
    }
    return rows;
  })
  .then( _ =>{
    dable.SetDataAsRows(rows)
    dable.style = 'CulpaDoRichard';
	  dable.SetColumnNames(list_columns);
    dable.columnData[0].CustomRendering = function(cellValue, rowNumber) {
			return '<img src="../../assets/stock_imgs/icon_info.jpg" alt="'+cellValue+'" width="60" height="60"  data-rownumber="' + rowNumber + '">';
		};
    dable.columnData[5].CustomRendering = function (_cellValue, rowNumber) {
    return '<button> <img width="30" class="bg-white editRow" src="./imagens/edit.png" data-rownumber="' + rowNumber + '" /></button>';
  };
    dable.columnData[6].CustomRendering = function (_cellValue, rowNumber) {
    return '<button type="button"> <img width="30" class="bg-white deleteRow" src="./imagens/delete.png" data-rownumber="' + rowNumber + '" /></button>';
  };
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
