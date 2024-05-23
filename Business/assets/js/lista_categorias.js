var dable = new Dable();
var rows = [];
var list_columns = [ 'Nome', 'Itens'];
var items = [];
const response = fetch('http://localhost/business/lista_categorias.php?idEmpresa=1')
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
