<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/styles/sitecss.css">
  <link rel="stylesheet" href="/assets/styles/restaurants.css">
</head>

<body>
  <!-- NAVBAR -->
 <?php
 if (!isset($_GET['restaurante'])) {
    if (!empty($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: /~ptaw-2024-gr2/restaurantes_page.php');
    }
    exit();
}
 
 
include __DIR__.'/includes/header_restaurantes_selected.php';
  
require_once 'database/credentials.php';
require_once 'database/db_connection.php';

function getImagePath($path, $default = './assets/stock_imgs/fd reduced logo.png') {
    return file_exists($path) ? $path : $default;
}

$fRestaurante = "%" . strtolower(str_replace(' ', '', $_GET['restaurante'])) . "%";

$queryTop = "SELECT est.id_estabelecimento, est.nome, est.localizacao, est.telemovel, 
          est.taxa_entrega, est.tempo_medio_entrega, est.logotipo, emp.nome AS empresa,
          COALESCE ((select sum(classificacao)/count(classificacao) from avaliacoes where avaliacoes.id_estabelecimento=est.id_estabelecimento),0) as avaliacao
          FROM estabelecimentos AS est
          INNER JOIN empresas AS emp ON emp.id_empresa = est.id_empresa
		  WHERE REPLACE(LOWER(est.nome), ' ', '') LIKE ?";
		  
try {		
	$stmtTop = $pdo->prepare($queryTop);
	$stmtTop->execute([$fRestaurante]);
	$infoRest = $stmtTop->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "Erro na conexão: " . $e->getMessage();
}
?>

  <!-- IDENTIFICAÇÃO DO RESTAURANTE -->
  <div class="p-4 p-md-5" style="background-color: #ffffff; border-bottom: 1vw ridge #febc41; border-radius: 15px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 px-0">
<?php		
    echo "<h1 class='display-4' style='font-weight: bolder;'>".$infoRest['nome']."</h1>
          <h5 class='mb-0'>".$infoRest['avaliacao']."★</h5>
          <p class='mb-0'>Taxa de Entrega: ".$infoRest['taxa_entrega']."€</p>
        </div>
        <div class='col-lg-4 text-center'>
          <img src='./assets/stock_imgs/".$infoRest['logotipo']."' alt='".$infoRest['nome']."' style='max-width: 300px;'>
        </div>
		";
?>		
        <div class="col-lg-4 px-4">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Procurar item" id="inputPesquisarRestaurante">
            <button class="btn btn-outline-primary" type="button" id="buttonPesquisarRestaurante">Procurar</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container d-flex justify-content-start" style="margin: 0; padding: 0">
    <!-- SIDEBAR CATEGORIAS -->
    <div class="d-flex flex-column p-3 bg-body-tertiary" style="width: 17.7vw;">
      <a class="d-flex align-items-center me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-4">Categorias</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
<?php

	
    $query = "SELECT DISTINCT categorias.nome FROM itens
			INNER JOIN estabelecimentos ON estabelecimentos.id_estabelecimento = itens.id_estabelecimento
			INNER JOIN categorias ON categorias.id_categoria = itens.id_categoria
			WHERE REPLACE(LOWER(estabelecimentos.nome), ' ', '') LIKE ?";
			
	$stmt = $pdo->prepare($query);
	$stmt->execute([$fRestaurante]);
	$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($categorias as $row) {
		echo "<li class='nav-item'>
			  <a href='#' class='nav-link link-body-emphasis' aria-current='page'>
				<text class='opcao'>".$row['nome']."</text>
			  </a>
			</li>";
	}
	  
?>
    </ul>
    </div>
    <div class="">
    <!-- CARROSSEL DE ITENS -->

<?php	  
	try {
        foreach ($categorias as $categoria) {
			$fCategoria = htmlspecialchars($categoria['nome']);
			echo "<h3>".$fCategoria."</h3>";
			
			$queryProd = "select itens.id_item, itens.nome, itens.descricao, itens.preco, itens.foto 
						from itens 
						inner join estabelecimentos on estabelecimentos.id_estabelecimento = itens.id_estabelecimento 
						inner join categorias on categorias.id_categoria = itens.id_categoria 
						WHERE REPLACE(LOWER(estabelecimentos.nome), ' ', '') LIKE ? AND REPLACE(LOWER(categorias.nome), ' ', '') like ? ";
			
			$fCat = "%" . strtolower(str_replace(' ', '', $fCategoria)) . "%";			
			$stmtProd = $pdo->prepare($queryProd);
			$stmtProd->execute([$fRestaurante, $fCat]);
			$produtos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);


			echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3'> ";
			foreach ($stmt as $row) {
				echo "
				<div class='col'>
				<div class='card shadow-sm' id='" . $row['nome'] . "'>
					<img src='./assets/stock_imgs/" . $row['logotipo'] . "' class='card-img-top' alt='" . $row['nome'] . "' style='border-radius: 5.5px;'>
					<div class='card-body'>
						<div class='image-overlay' style='position: relative; border-radius: 5.5px; overflow: hidden;'>
							<img src='".$imagemPath."' class='card-img-top' alt='".$rowProd['nome']."'
							  style='border-radius: 5.5px;'>
							<div class='icon-overlay' style='position: absolute; bottom: 10px; right: 10px;'>
							  <img src='./assets/stock_imgs/mais.png' id='iconAddItem' alt='Ícone de adição'
								style='width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;'>
							</div>
						  </div>
						  <div class='card-body'>
							<div class='d-flex justify-content-between align-items-center'>
							  <h6 class='mb-0'>".$rowProd['nome']."</h6>
							</div>
							<div class='d-flex justify-content-between align-items-center'>
							  <p class='card-text mb-0' style='font-size: 12px;'>".$rowProd['preco']."'</p>
							</div>
						  </div>
					</div>
				</div>
				</div>
				";
			}
			echo "</div>";
        }
    } catch (PDOException $e) {
        echo "Erro na conexão: " . $e->getMessage();
    }
 ?>
  </div>
    </div>
  </div>


  <!-- Footer -->
  <?php
  include __DIR__."/includes/footer_1.php";
  ?>

  <!-- SCRIPT -->
  <script>
    document.querySelector("button#buttonPesquisarRestaurante").addEventListener("click", procurarRestaurante)

    function procurarRestaurante() {
      let nomeRestaurante = document.querySelector("input#inputPesquisarRestaurante").value;
      console.log(nomeRestaurante)
      document.querySelector("input#inputPesquisarRestaurante").value = "";
    }


    let opcaoSelecionadaAnteriormente = null;

    function selecionarOpcao(event) {
      // Remove o sublinhado de todas as opções
      const links = document.querySelectorAll('.opcao');
      links.forEach(link => {
        link.style.textDecoration = 'none';
      });

      // Remove o negrito da opção anteriormente selecionada
      if (opcaoSelecionadaAnteriormente !== null) {
        opcaoSelecionadaAnteriormente.style.fontWeight = 'normal';
      }

      // Adiciona bold à opção selecionada e atualiza a referência para a opção selecionada anteriormente
      event.target.style.fontWeight = 'bold';
      opcaoSelecionadaAnteriormente = event.target;
    }


    // Adiciona o evento de clique a todas as opções
    const links = document.querySelectorAll('.opcao');
    links.forEach(link => {
      link.addEventListener('click', selecionarOpcao);
    });

    // Adiciona evento de clique a todas as opções do sidebar
    const sidebarOptions = document.querySelectorAll('.opcao');
    sidebarOptions.forEach(option => {
      option.addEventListener('click', selecionarOpcao);
    });

    const initSlider = () => {
      const imageList = document.querySelector(".slider-wrapper .image-list");
      const slideButtons = document.querySelectorAll(".slider-wrapper .slide-button");
      const sliderScrollbar = document.querySelector(".container .slider-scrollbar");
      const scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
      let maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;

      scrollbarThumb.addEventListener("mousedown", (e) => {
        const startX = e.clientX;
        const thumbPosition = scrollbarThumb.offsetLeft;
        const maxThumbPosition = sliderScrollbar.getBoundingClientRect().width - scrollbarThumb.offsetWidth;

        const handleMouseMove = (e) => {
          const deltaX = e.clientX - startX;
          const newThumbPosition = thumbPosition + deltaX;

          const boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
          const scrollPosition = (boundedPosition / maxThumbPosition) * (imageList.scrollWidth - imageList.clientWidth);

          scrollbarThumb.style.left = `${boundedPosition}px`;
          imageList.scrollLeft = scrollPosition;
        }

        const handleMouseUp = () => {
          document.removeEventListener("mousemove", handleMouseMove);
          document.removeEventListener("mouseup", handleMouseUp);
        }

        document.addEventListener("mousemove", handleMouseMove);
        document.addEventListener("mouseup", handleMouseUp);
      });

      // Slide images according to the slide button clicks
      slideButtons.forEach(button => {
        button.addEventListener("click", () => {
          const direction = button.id === "prev-slide" ? -1 : 1;
          const scrollAmount = imageList.clientWidth * direction;
          imageList.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });
      });

      // Show or hide slide buttons based on scroll position
      const handleSlideButtons = () => {
        maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
        slideButtons[0].style.display = imageList.scrollLeft <= 0 ? "none" : "flex";
        slideButtons[1].style.display = imageList.scrollLeft >= maxScrollLeft ? "none" : "flex";
      }

      // Update scrollbar thumb position based on image scroll
      const updateScrollThumbPosition = () => {
        maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
        const scrollPosition = imageList.scrollLeft;
        const thumbPosition = (scrollPosition / maxScrollLeft) * (sliderScrollbar.clientWidth - scrollbarThumb.offsetWidth);
        scrollbarThumb.style.left = `${thumbPosition}px`;
      }

      // Call these two functions when image list scrolls
      imageList.addEventListener("scroll", () => {
        updateScrollThumbPosition();
        handleSlideButtons();
      });
    }

    window.addEventListener("resize", initSlider);
    window.addEventListener("load", initSlider);
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>