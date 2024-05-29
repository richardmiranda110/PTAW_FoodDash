<?php
require_once  __DIR__."/includes/session.php";

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome'])) {
  header("Location: /Business/login_register/login_business.php");
  exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/styles/adicionar.css">
    <link rel="stylesheet" href="../../assets/styles/sitecss.css">
    <link rel="stylesheet" href="../../assets/styles/dashboard.css">
    <script src="../../assets/js/dable.js"></script>
    <?php echo '<script>var idEmpresa="'.$_SESSION['id_empresa'].'"</script>' ?>
  </head>
  <body class="d-flex flex-column min-vh-100">

    <header id="topHeader" class="container-xxl">
      <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
    </header>
    <main id="contentPage" class="container-xxl flex-grow-1">
      <?php include __DIR__."/includes/sidebar_business.php"; ?>
      <div id="contentDiv" class="col-md-12">
        <nav style="font-size:1.4rem; z-index: 1; text-align: center;" class="navbar navbar-expand-lg gray-navbar navbar-light fw-bold">
          <div class="collapse navbar-collapse" style="width: 15vw;" id="navbarNav">
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a class="nav-link nav" href="http://localhost/business/dashboard_lista_menus.php#">Menus</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link nav" style="border-bottom: 1vh solid black;" href="http://localhost/business/dashboard_lista_categorias.php#">Categorias</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link nav" href="http://localhost/business/dashboard_lista_items.php#">Itens</a>
                  </li>
              </ul>
          </div>
        </nav>
      
        <span class="float:left fw-bold h2 m-3 mb-2 mt-3 text-left">Categorias</span> 
        <button class="float-end btn btn-custom fw-bold mt-1" style="margin-right:4.5vw" id="btnNovoItemCategoria">+ Nova Categoria</button>
        <div id="DefaultDable"></div>
      </div>
    </main>

    <div id="modal" class="modal d-none">
      <div class="modal-content" id="modal-content">
      <p class="fw-bold mt-1 mb-2" id="modal-text"></p>
        <form id="category-input"  action='./lista_categorias.php?idEmpresa=<?php echo $_SESSION['id_empresa']?>' method="post">
          <input type="text" name ="category-input" class="mb-2 form-control" id="category-input">
        </form>
        <span class="close">&times;</span>
      </div>
    </div>

    <!--Zona do Footer -->
    <footer class="container">
      <?php include __DIR__."../../business/includes/footer_business.php"; ?>
    </footer>

    <script src="./assets/js/lista_categorias.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
