<?php
session_start();

// Verificar se o usuário está logado
//if (!isset($_SESSION['username'])) {
//    header("Location: login.php");
//    exit();
//}

// Exibir nome de usuário
//echo "Welcome, " . $_SESSION['username'];
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../business/styles/adicionar.css">
    <link rel="stylesheet" href="../../assets/styles/sitecss.css">
	<link rel="stylesheet" href="../../assets/styles/dashboard.css">
  <script src="../../assets/js/dable.js"></script>
  </head>
  <body>
  <!--Zona do Header -->
  <div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
   <!-- <?php //include __DIR__."../../includes/header_logged_in.php"; ?>
  </div>

  <!--Zona de Conteudo -->  
  <div id="contentPage" class="container-xxl">
    <?php include __DIR__."../../includes/sidebar_perfil.php"; ?>

    <!--Zona de Conteudo da Página -->
    <div id="contentDiv" class="col-md-12">

    <?php include __DIR__."../../includes/navbar_business.php"; ?>
    
  <div id="DefaultDable" ></div>

<script type="text/javascript">
	var dable = new Dable();
	var rows = [];
	var columns = [ 'Foto', 'Nome', 'Preço','Menus','Categorias' ];

  const response = fetch('http://localhost/business/dados.php?idEstabelecimento=31')
  .then(response => response.json())
  .then(data => {
    for(item of data){
      rows.push([ item.foto, item.nome,item["preco"],'Menu do Almoço, Menu do Jantar',' Na grelha, Carne' ]);
    }
    return rows;
  })
  .then( _ =>{
    dable.SetDataAsRows(rows)
    dable.style = 'CulpaDoRichard';
	  dable.SetColumnNames(columns);
    dable.columnData[0].CustomRendering = function(cellValue, rowNumber) {
      console.log(cellValue);
			return '<img src="../../assets/stock_imgs/icon_info.jpg" alt="'+cellValue+'" width="50" height="50" class="deleteRow" data-rownumber="' + rowNumber + '">';
		};
	dable.BuildAll("DefaultDable"); 
  }).catch((error) => console.error('Error:', error));
	

</script>
<?php
/*
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (!empty($_GET["idEmpresa"])) {
		$idestabelecimento[] = $_GET['idEmpresa'];
	};
	
	$idEmpresa = 1;
}
*/
$idEmpresa = 1;
?>	

 
<?php
require_once __DIR__."../../database/credentials.php";
require_once __DIR__."../../database/db_connection.php";

try {

	$stmt = $pdo->prepare("select id_categoria, nome from categorias where id_empresa = ? ");
	$stmt->execute([$idEmpresa]);
	$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach ($stmt as $row) {
	  echo 		'<option value="' . htmlspecialchars($row['id_categoria']) . '">' . htmlspecialchars($row['nome']) . '</option>';
	}

	echo "</select>
		</div>";


} catch(PDOException $e) {
	echo "Erro ao inserir registro: " . $e->getMessage();
}
?>

  <!--Zona do Footer -->
  <?php include __DIR__."../../includes/footer_2.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


