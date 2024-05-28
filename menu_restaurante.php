<?php require_once './session.php'; ?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/styles/sitecss.css">
  <link rel="stylesheet" href="/assets/styles/restaurants.css">
  <link rel="stylesheet" href="./assets/styles/rating_menu_restaurant.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<?php 
include __DIR__."/includes/insertAvaliationRestaurant.php"; 
include __DIR__."/includes/insertPedido.php"; 
?>

  <!-- NAVBAR -->
  <?php
  
  
  if (!isset($_GET['restaurante'])) {
    if (!empty($_SERVER['HTTP_REFERER'])) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
      header('Location: /restaurantes_page.php');
    }
    exit();
  }
	
  if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
    include __DIR__."/includes/header_restaurantes_selected.php";
  }else{
    include __DIR__."/includes/header_logged_in.php";
	///validar id cliente por sessiom
	$idCliente=$_SESSION['id_cliente'];
  }
  
  //$idCliente = 1;

  require_once 'database/credentials.php';
  require_once 'database/db_connection.php';

  function getImagePath($path, $default = './assets/stock_imgs/fd reduced logo.png')
  {
    return file_exists($path) ? $path : $default;
  }

  $fRestaurante = "%" . strtolower(str_replace(' ', '', $_GET['restaurante'])) . "%";

  $queryTop = "SELECT est.id_estabelecimento, est.nome, est.localizacao, est.telemovel, 
          est.taxa_entrega, est.tempo_medio_entrega, est.imagem, emp.nome AS empresa,
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
		  $idEstabelecimento = $infoRest['id_estabelecimento'] ;
          echo "<h3 class='display-6' style='font-weight: bolder;'>" . $infoRest['nome'] . "</h3>
          <h5 class='mb-0'>" . $infoRest['avaliacao'] . "★</h5>
          <p class='mb-0'>Taxa de Entrega: " . $infoRest['taxa_entrega'] . "€</p>
        </div>
        <div class='col-lg-4 text-center'>
          <img src=".$infoRest['imagem']."' alt='" . $infoRest['nome'] . "' style='max-width: 25vw;'>
        </div>
		";
          ?>
          <div class="col-lg-4 px-4">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Procurar item" id="inputPesquisarRestaurante">
              <button class="btn btn-outline-primary" type="button" id="buttonPesquisarRestaurante">Procurar</button>
            </div>

            <!-- TOAST --->
            <button type="button" class="btn btn-primary" style="<?php echo $idCliente == 0 ? 'display: none;' : ''; ?>" id="liveToastBtn">Avaliar Estabelecimento</button>
			<div class="toast-container position-fixed bottom-0 end-0 p-3">
			  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
				<div class="toast-header">
				  <img src="./assets/imgs/estrela_ilustrativa.png" class="rounded me-2" alt="star" style="width: 1.5vw;">
				  <strong class="me-auto">Avaliar Estabelecimento</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body2" style="height: auto;">
				  <form id="ratingForm" method="POST"  enctype="multipart/form-data" action="">
					
					<div class="rating-box">
					  <header>Como foi a sua experiência?</header>
					  <div class="stars">
						<i class="fa-solid fa-star" data-value="1"></i>
						<i class="fa-solid fa-star" data-value="2"></i>
						<i class="fa-solid fa-star" data-value="3"></i>
						<i class="fa-solid fa-star" data-value="4"></i>
						<i class="fa-solid fa-star" data-value="5"></i>
					  </div>
					</div>
					<input type="hidden" name="idForm" id="idForm" value="insertAvaliation">
					<input type="hidden" name="idEstabelecimento" id="idEstabelecimento" value="<?php echo $idEstabelecimento; ?>">
					<input type="hidden" name="idCliente" id="idCliente" value="<?php echo $idCliente; ?>">
					<input type="hidden" name="estrelas" id="ratingValue">
					<textarea rows="4" cols="50" maxlength="100" name="input_text_comentario" id="input_text_comentario" placeholder="Insira um comentário (opcional) ..." style="margin-bottom: 1vh; width: 80%;"></textarea>
					<input class="btn btn-primary" type="submit" id="btn_enviar_avaliacao" value="Enviar">
				  </form>
				</div>
			  </div>
			</div>

			<script>
			  document.querySelectorAll('.stars i').forEach(star => {
				star.addEventListener('click', function() {
				  let rating = this.getAttribute('data-value');
				  document.getElementById('ratingValue').value = rating;
				});
			  });

			  document.getElementById('ratingForm').addEventListener('submit', function(event) {
				let estrelas = document.getElementById('ratingValue').value;
				if (!estrelas) {
				  event.preventDefault();
				  alert('Por favor, selecione uma classificação.');
				}
			  });
			</script>

          </div>

        </div>
      </div>
    </div>

   <?php 
   
   $query = "SELECT DISTINCT categorias.nome FROM itens
   INNER JOIN estabelecimentos ON estabelecimentos.id_estabelecimento = itens.id_estabelecimento
   INNER JOIN categorias ON categorias.id_categoria = itens.id_categoria
   WHERE REPLACE(LOWER(estabelecimentos.nome), ' ', '') LIKE ? ";

       $stmt = $pdo->prepare($query);
       $stmt->execute([$fRestaurante]);
       $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
   


      if(count($categorias) != 0){
    
      echo '<div class="container d-flex justify-content-start" style="margin: 0; padding: 0">
      <!-- SIDEBAR CATEGORIAS -->
      <div class="d-flex flex-column p-3 bg-body-tertiary" style="width: 17.7vw;">
        <a class="d-flex align-items-center me-md-auto link-body-emphasis text-decoration-none">
          <span class="fs-4">Categorias</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">';

        echo "<li class='nav-item'>
			  <a href='menu_restaurante.php?restaurante=".strtolower(str_replace(' ', '', $_GET['restaurante']))."' class='nav-link link-body-emphasis' aria-current='page'>
			  </a>
			</li>";
    }


          foreach ($categorias as $row) {
			 $fcategoria = strtolower(str_replace(' ', '',$row['nome']));
            echo "<li class='nav-item'>
			  <a href='menu_restaurante.php?restaurante=".strtolower(str_replace(' ', '', $_GET['restaurante']))."&categoria=".$fcategoria."' class='nav-link link-body-emphasis' aria-current='page'>
				<text class='opcao'>" . $row['nome'] . "</text>
			  </a>
			</li>";
          }

          ?>
        </ul>
      </div>

      <div class="accordion p-3" id="listProds" style="width: 82.3vw;">
        <?php
        try {
          $dados = [];
		  
		  //filtro para aparecer só a categoria pretendido
		  if (!empty($_GET['categoria'])) {
			foreach ($categorias as $categoria) {
			  if ($_GET['categoria']==strtolower(str_replace(' ', '',$categoria['nome']))) {
				$categorias = [
					['nome' => $categoria['nome']]
				];
			  }		  
			}			 
		  }
        if(count($categorias) == 0){
          echo "Este Restaurante não pussui itens";
        }
          foreach ($categorias as $categoria) {
            $fCategoria = htmlspecialchars($categoria['nome']);

            echo "<div class='accordion-item' style='border:none;'>
				<h3 class='accordion-header' id='heading" . $fCategoria . "'>
					<button class='accordion-button bg-dark' type='button' data-bs-toggle='collapse' data-bs-target='#collapse" . $fCategoria . "' aria-expanded='true' aria-controls='collapse" . $fCategoria . "' style='color: white;'>
							" . $categoria['nome'] . "
					</button>
				</h3>";

            $queryProd = "SELECT itens.id_item, itens.nome, itens.descricao, itens.preco, itens.foto 
					FROM itens 
					INNER JOIN estabelecimentos ON estabelecimentos.id_estabelecimento = itens.id_estabelecimento 
					INNER JOIN categorias ON categorias.id_categoria = itens.id_categoria 
					WHERE REPLACE(LOWER(estabelecimentos.nome), ' ', '') LIKE ? AND REPLACE(LOWER(categorias.nome), ' ', '') LIKE ? ";

            $idCategoria = str_replace(' ', '', $fCategoria);
            $fCat = "%" . strtolower(str_replace(' ', '', $fCategoria)) . "%";

            $stmtProd = $pdo->prepare($queryProd);
            $stmtProd->execute([$fRestaurante, $fCat]);
            $produtos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

            echo "<div id='collapse" . $idCategoria . "' class='accordion-collapse collapse show' aria-labelledby='heading" . $idCategoria . "' data-bs-parent='#listProds'>
              <div class='accordion-body'>";
              

            foreach ($produtos as $rowProd) {
			 
              $imagemPath = getImagePath($rowProd['foto']);
              $idProd = str_replace(' ', '', htmlspecialchars($rowProd['nome']));
              echo "<div>
                    <div class='card shadow-sm' id='" . $idProd . "' style='width:18%; margin: 0px 0.5% 1% 0.5%; float:left;'>
                    <div class='card-body'>
                        <div class='image-overlay' style='position: relative; border-radius: 5.5px; overflow: hidden;'>
                            <img src='" . $imagemPath . "' class='card-img-top' alt='" . $idProd . "' style='border-radius: 5.5px;'>
                            <div class='icon-overlay' id='liveToastBtn_" .$idProd. "' style='position: absolute; bottom: 10px; right: 10px;'>
                                <img src='./assets/stock_imgs/mais.png' id='iconAddItem' alt='Ícone de adição' style='width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;'>
                            </div>
                        </div>
                        <div class='card-body' style='padding: 10px 0px;'>
                            <div class='d-flex justify-content-between align-items-center'>
                                <h6 class='mb-0' style='min-height: 2.5rem;'>" . htmlspecialchars($rowProd['nome']) . "</h6>
                            </div>
                            <div class='d-flex justify-content-between align-items-center'>
                                <p class='card-text mb-0' style='font-size: 12px;'>" . $rowProd['preco'] . "€</p>
                            </div>
                        </div>
                    </div>
                </div>";
                
                $dados[]  = ['id' => $rowProd['id_item'] , 'trigger' => 'liveToastBtn_'.$idProd, 'toast' => 'liveToast_'.$idProd];
                //<input type='hidden' name='idPedido' id='idPedido' value='".$idPedido."'>
				echo "
				<div class='toast-container position-fixed bottom-0 end-0 p-3'>
				<form method='POST'  enctype='multipart/form-data' action=''>
					<input type='hidden' name='idEstabelecimento' id='idEstabelecimento' value='".$idEstabelecimento."'>
					<input type='hidden' name='idCliente' id='idCliente' value='".$idCliente."'>
					<input type='hidden' name='idProd' id='idProd' value='".$rowProd['id_item']."'>

					<input type='hidden' name='preco' id='preco' value='".$rowProd['preco']."'>
					<input type='hidden' name='idForm' id='idForm' value='insertPedido'>
					
					<div id='liveToast_" .$idProd. "' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-bs-autohide='false' style='width: 40vw; max-height: 95vh; overflow-y: auto;'>
					<div class='toast-header'>
						<img src='./assets/stock_imgs/burgerKing_marca.png' class='rounded me-2' alt='logotipo' style='width: 1.5vw;'>
						<strong class='me-auto'>" . htmlspecialchars($rowProd['nome']) . "</strong>
						<button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
					</div>
					<div class='toast-body' style='height: auto; align-items: unset;'>
						<div id='txt_item_title_price_description'>
						<h3>" . htmlspecialchars($rowProd['nome']) . "</h3>
						<h5>" . $rowProd['preco'] . "€</h5>
						<p>" . htmlspecialchars($rowProd['descricao']) . "</p>
						</div>
						<hr>
						<div>
							<h5>Complemento</h5>
						";

                    $queryComp = "SELECT id_opcao, nome FROM opcoes ";
                    $stmtComp = $pdo->prepare($queryComp);
                    $stmtComp->execute();
                    $complementos = $stmtComp->fetchAll(PDO::FETCH_ASSOC); 
                 
                    foreach ($complementos as $rowComp) {
						echo "<div class='form-check form-check-reverse'>
								<input class='form-check-input' type='radio' name='complemento' id='complemento' value='".$rowComp['id_opcao']."' checked>
								<label class='form-check-label d-flex justify-content-start' for='complemento'>".$rowComp['nome']."</label>
							</div>
							";
					}
    
					echo "</div>
						<br>
						<div>
						<h5>Bebida</h5>
						";

					$queryBeb = "select id_opcao, nome from opcoes ";

					$stmtBeb= $pdo->prepare($queryBeb);
					$stmtBeb->execute();
					$bebidas = $stmtBeb->fetchAll(PDO::FETCH_ASSOC);

					foreach ($bebidas as $rowBeb) {
						echo"<div class='form-check form-check-reverse'>
							<input class='form-check-input' type='radio' name='bebida' id='bebida' value='".$rowBeb['id_opcao']."' checked>
							<label class='form-check-label d-flex justify-content-start' for='bebida'>".$rowBeb['nome']."</label>
						</div>
						";
					}
					echo "</div>
						<br>
						<div>
						<h5>Adiciona extras ao teu " . htmlspecialchars($rowProd['nome']) . "</h5>
						";

					$queryExt = "select * from opcoes ";

					$stmtExt= $pdo->prepare($queryExt);
					$stmtExt->execute();
					$extras = $stmtExt->fetchAll(PDO::FETCH_ASSOC);

					foreach ($extras as $rowExt) {
						echo"<div class='form-check form-check-reverse'>
								<input class='form-check-input' type='radio' name='extra' id='extra' value='".$rowExt['id_opcao']."' checked>
								<label class='form-check-label d-flex justify-content-start' for='extra'>".$rowExt['nome']."</label>
							</div>
							";
					}
					echo "</div>
						<div class='d-flex justify-content-center mt-2'>";
						if ($idCliente > 0) {
					echo 	"<input class='btn btn-primary btn-lg' type='submit' value='Adicionar ao carrinho • " . $rowProd['preco'] . "€'> ";
						}
					echo "</div>
					</div>
					</div>
				</div>
				";
            }

            echo "  </div>
			</form>
            </div>
        </div>";
            }

        } catch (PDOException $e) {
          echo "Erro na conexão: " . $e->getMessage();
        }
        ?>
      </div>
	  
    </div>
  </div>
  </div>
  </div>
 


  <!-- Footer -->
  <?php
  include __DIR__ . "/includes/footer_1.php";
  ?>


  <!-- SCRIPT -->
  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>

        <?php foreach ($dados as $dado): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const toastTrigger<?php echo $dado['id']; ?> = document.getElementById('<?php echo $dado['trigger']; ?>');
            const toastLiveExample<?php echo $dado['id']; ?> = document.getElementById('<?php echo $dado['toast']; ?>');
            
            if (toastTrigger<?php echo $dado['id']; ?>) {
                const toastBootstrap<?php echo $dado['id']; ?> = bootstrap.Toast.getOrCreateInstance(toastLiveExample<?php echo $dado['id']; ?>);
                toastTrigger<?php echo $dado['id']; ?>.addEventListener('click', () => {
							
					 closeOtherToasts();
                    toastBootstrap<?php echo $dado['id']; ?>.show();
					
					
                });
            }
        });
        <?php endforeach; ?>

    document.querySelector("button#buttonPesquisarRestaurante").addEventListener("click", procurarRestaurante)

	function closeOtherToasts() {
		//para simplificar fexar todos os toast antes de abrir o que se pretende
        var closeButtons = document.querySelectorAll('button.btn-close');
		closeButtons.forEach(function(button) {
		  button.click();
		});
    }
	
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



    //ISTO A PARTIR DE AGORA É DO TOAST DE AVALIAR ESTABELECIMENTO
    //SE PRECISARMOS DE COLOCAR ESTE SCRIPT NUM DOCUMENTO À PARTE TEMOS DE COLOCAR DEFER NO IMPORT DO SCRIPT PARA O HTML PARA O SCRIPT SER CORRIDO QUANDO ACABAR DE CARREGAR A PÁGINA HTML
    let avaliacao = 0;
    const stars = document.querySelectorAll(".stars i");
    stars.forEach((star, index1) => {
      star.addEventListener("click", () => {
        console.log(index1)
        avaliacao = index1 + 1;
        stars.forEach((star, index2) => {
          console.log(index2)
          index1 >= index2 ? star.classList.add("active") : star.classList.remove("active")
        })
      })
    })

    document.getElementById("btn_enviar_avaliacao").onclick = () => {
      console.log("Avaliação selecionada: " + avaliacao);
      
      const textarea = document.getElementById("input_text_comentario");
      let comentario = textarea.value;
      console.log("Comentário: " + comentario);

    }
  </script>

  <script src="./assets/js/toast.js"></script>
</body>

</html>