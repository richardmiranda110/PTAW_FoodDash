<?php 
require_once __DIR__.'/includes/session.php';
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../assets/styles/checkout.css">
    <script src="../assets/js/checkout.js"></script>
    <title>Checkout</title>
</head>

<body>
    <div class="container" style="max-width: 100%;">
        <div class="flex-row" id="logo-row">
            <img src="../assets/imgs/fooddash.png" id="logo" alt="fooddash">
        </div>
        <div class="row justify-content-center">
            <h1 class="checkout-title">Checkout</h1>
        </div>
        <div class="d-flex flex-row align-items-center" style="margin-left: 15vw; margin-right: 15vw;">
            <img src="../assets/stock_imgs/burgerkingLogo.png" alt="Burger King" class="rounded-circle" style="width: 5.7vw; height: 5.7vw;">
            <h2 class="burger-king-title" style="font-size: 2vw;">Burger King</h2>
        </div>
        
        <div class="row justify-content-between" id="boxes" style="margin-left: 15vw; margin-right: 15vw;">
            <div class="col-md-5 mb-3">
                <div class="left-div">
                    <div class="ResumoPedido">
                        <h4 class="resumo-pedido" style="font-size: 1.25vw;">Resumo do pedido</h4>
                        <p style="margin-top: 1vw; margin-bottom: 0.4vw; font-size: 0.87vw;">0 artigos</p>
                    </div>
                    <div class="row">
                        <div class="col">
                            <hr class="linha">
                        </div>
                    </div>
                    <div class="DetalhesEntrega">
                        <h4 class="detalhes-entrega" style="font-size: 1.25vw;">Detalhes da Entrega</h4>
                        <div class="row align-items-center">
                            <div class="col-auto" style="margin-top: 0.65vw;">
                                <img src="../assets/stock_imgs/iconLocalizacao.png" alt="Imagem Exemplo" class="img-fluid" style="width: 1.6vw;">
                            </div>
                            <div id="morada" class="col" style="margin-top: 0.65vw;">
                                <p id="textoMorada" class="m-0" contenteditable="false" style="font-size: 0.87vw;">Rua exemplo, Nº1, Aveiro</p>
                            </div>
                            <div class="col-auto" style="margin-top: 0.65vw;">
                                <button type="button" class="btn btn-primary" id="btnMorada" onclick="editarMorada()">Editar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <hr class="linha">
                        </div>
                    </div>
                    <div class="EstimativaEntrega">
                        <h4 class="estimativa-entrega" style="font-size: 1.25vw;">Estimativa para Entrega</h4>
                        <div class="row align-items-center opcaoEntrega" style="margin: 0.75vw 0vh" onclick="toggleSelectionEntrega(this)">
                            <div class="col-auto">
                                <img src="../assets/stock_imgs/iconStandard.png" alt="Imagem Exemplo" class="img-fluid" style="width: 1.6vw;">
                            </div>
                            <div class="col">
                                <p class="m-0" style="font-size: 0.8vw;">Standard</p>
                                <p class="m-0" style="font-size: 0.6vw;">20-30min</p>
                            </div>
                        </div>
                        <div class="row align-items-center opcaoEntrega" style="margin: 0.75vw 0vh" onclick="toggleSelectionEntrega(this)">
                            <div class="col-auto">
                                <img src="../assets/stock_imgs/iconAgenda.png" alt="Imagem Exemplo" class="img-fluid" style="width: 1.6vw;">
                            </div>
                            <div class="col-auto">
                                <p class="m-0" style="font-size: 0.8vw;">Agendar</p>
                                <p class="m-0" style="font-size: 0.6vw;">Selecionar uma hora</p>
                            </div>
                        </div>
                    </div>
                    <div id="agendarHoraCampos" style="display: none;">
                        <div class="row">
                            <div class="col">
                                <input type="time" class="form-control" placeholder="Selecione a hora">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <hr class="linha" style="margin-top: 1.2vw;">
                        </div>
                    </div>
                    <div class="Pagamento">
                        <h4 class="pagamento" style="font-size: 1.25vw;">Pagamento</h4>
                        <p style="margin-top: 0.7vw; font-size: 0.87vw;">Escolher forma de pagamento:</p>
                        <div class="row align-items-center opcao" onclick="toggleSelection(this)" style="padding: 0.4vw 0vh; margin: 0.75vw 0vh;">
                            <div class="col-auto">
                                <img src="../assets/stock_imgs/iconCartao.png" alt="Imagem Exemplo" class="img-fluid" style="width: 1.6vw;">
                            </div>
                            <div class="col">
                                <p class="m-0" style="font-size: 0.82vw;">Cartão de Crédito ou Débito</p>
                            </div>
                        </div>
                        <div class="row align-items-center opcao" style="margin: 0.75vw 0vh" onclick="toggleSelection(this)">
                            <div class="col-auto">
                                <img src="../assets/stock_imgs/iconMBWAY.png" alt="Imagem Exemplo" class="img-fluid" style="width: 1.6vw;">
                            </div>
                            <div class="col">
                                <p class="m-0" style="font-size: 0.82vw;">MBWAY</p>
                            </div>
                        </div>
                        <div class="row align-items-center opcao" style="margin: 0.75vw 0vh" onclick="toggleSelection(this)">
                            <div class="col-auto">
                                <img src="../assets/stock_imgs/iconPaypal.png" alt="Imagem Exemplo" class="img-fluid" style="width: 1.6vw;">
                            </div>
                            <div class="col">
                                <p class="m-0" style="font-size: 0.82vw;">PayPal</p>
                            </div>
                        </div>
                        <div id="cartaoCampos" style="display: none;">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Nome do titular">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="Numero do cartão">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 0.7vw;">
                                <div class="col">
                                    <input type="date" class="form-control" placeholder="Data Validade">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="CVC">
                                </div>
                            </div>
                        </div>
                        <div id="MBWAYCampos" style="display: none;">
                            <div class="row">
                                <div class="col">
                                    <input type="tel" class="form-control" placeholder="Numero Telemovel">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="right-div">
                    <div class="Total Pedido">
                        <h4 class="total-pedido" style="font-size: 1.25vw;">Total do pedido</h4>
                        <div class="row align-items-center">
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <p class="m-0" style="font-size: 0.87vw;">Subtotal:</p>
                            </div>
                            <div class="col" style="margin-top: 0.6vw;">
                                <p class="m-0"></p>
                            </div>
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <p class="m-0" style="font-weight: bold; font-size: 0.87vw;">0,00€</p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <p class="m-0" style="font-size: 0.87vw;">Serviço:</p>
                            </div>
                            <div class="col" style="margin-top: 0.6vw;">
                                <p class="m-0"></p>
                            </div>
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <p class="m-0" style="font-weight: bold; font-size: 0.87vw;">0,99€</p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <p class="m-0" style="font-size: 0.87vw;">Entrega:</p>
                            </div>
                            <div class="col" style="margin-top: 0.6vw;">
                                <p class="m-0"></p>
                            </div>
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <p class="m-0" style="font-weight: bold; font-size: 0.87vw;">2,50€</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <hr class="linha">
                        </div>
                    </div>
                    <div class="TotalCodigo">
                        <div class="row align-items-center">
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <h4 class="m-0" style="font-size: 1.25vw;">Total:</h4>
                            </div>
                            <div class="col" style="margin-top: 0.6vw;">
                                <p class="m-0"></p>
                            </div>
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <h4 class="m-0" style="font-weight: bold; font-size: 1.25vw;">3,49€</h4>
                            </div>
                        </div>
                        <div class="row align-items-center" style="margin-top: 1vw;">
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <img src="../assets/stock_imgs/iconPromotion.png" alt="Imagem Exemplo" class="img-fluid" style="width: 1.6vw;">
                            </div>
                            <div class="col" style="margin-top: 0.6vw;">
                                <p class="m-0" style="font-size: 0.87vw;">Adicionar código promocional</p>
                            </div>
                            <div class="col-auto" style="margin-top: 0.6vw;">
                                <button type="button" class="btn btn-primary" id="btnCodigo" onclick="adicionarPromoCode()">Adicionar</button>
                            </div>
                        </div>
                        <div id="addPromoCode" style="display: none;">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Insira o código">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="btnConfirmPagamento">Confirmar Pagamento</button>
                    </div>
                </form>
            </div>
        </div>
        <br><br><br><br><br>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>