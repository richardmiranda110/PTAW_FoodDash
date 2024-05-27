var dable = new Dable();
var rows = [];
var list_columns = [ 'Foto', 'Nome', 'Preço','Menus','Categorias','','' ];
var items = [];
const response = fetch('http://localhost/business/lista_items.php?idEstabelecimento='+idEmpresa+'')
  .then(response => response.json())
  .then(data => {
    for(item of data.itens){
      console.log(item);
      items.push(item);
      rows.push([ item.foto_url, item.nome,item.preco+'€',item.menus,item.categoria,item.id,item.id ]);
    }
    return rows;
  })
  .then( _ =>{
    dable.SetDataAsRows(rows)
    dable.style = 'CulpaDoRichard';
	  dable.SetColumnNames(list_columns);
    dable.columnData[0].CustomRendering = function(cellValue, rowNumber) {
			return '<img src="../'+cellValue+'" alt="'+cellValue+'" width="60" height="60"  data-rownumber="' + rowNumber + '">';
		};
    dable.columnData[5].CustomRendering = function (_cellValue, rowNumber) {
    return '<button> <img width="30" class="bg-white editRow" src="./assets/imgs/edit.png" data-rownumber="' + rowNumber + '" /></button>';
  };
    dable.columnData[6].CustomRendering = function (_cellValue, rowNumber) {
    return '<button type="button"> <img width="30" class="bg-white deleteRow" cellValue="'+_cellValue+'" src="./assets/imgs/delete.png" data-rownumber="' + rowNumber + '" /></button>';
  };
	dable.BuildAll("DefaultDable"); 
  }).catch((error) => console.error('Error:', error));
	
  
  document.addEventListener('click', handleDeleteButtonClick);



function handleDeleteButtonClick(event) {
    if (event.target.classList.contains('editRow')) {
        editItem(event.target);

    }   
    if (event.target.classList.contains('deleteRow')) {
      performDelete(event.target);
    }
}

function performDelete(element){
  const cellValue =  element.getAttribute("cellValue");
  console.log(cellValue);
  const rownumber =  element.getAttribute("data-rownumber");
  const request = fetch("/Business/lista_items.php?idEstabelecimento="+idEmpresa+"&delete="+cellValue);
  request.then(reply => {
    console.log(reply);
    dable.DeleteRow(rownumber);
  });
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
  window.open(`/Business/dashboard_inserir_item.php?id=${item.id}`);

}
