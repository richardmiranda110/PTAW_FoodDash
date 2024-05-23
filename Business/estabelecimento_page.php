<!DOCTYPE html>
<html>

<head>
    <title>Utilizador</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/sitecss.css">
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <link rel="stylesheet" href="assets/styles/responsive_styles.css">
</head>

<body>

    <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top/Menu da Página -->
        <?php include __DIR__ . "/includes/header_business.php"; ?>
        <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
    </div>

    <!--Zona de Conteudo -->
    <h3><strong>Loja</strong></h3>
    <!--Mapa-->
    <div>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18906.129712753736!2d6.722624160288201!3d60.12672284414915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x463e997b1b6fc09d%3A0x6ee05405ec78a692!2sJ%C4%99zyk%20trola!5e0!3m2!1spl!2spl!4v1672239918130!5m2!1spl!2spl"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <form class="centro esquerdo form_editar" method="GET">
        <h3><strong>Informações</strong></h3>

        <div class="align-items-md-stretch">
            <div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="esquerdo">Informações</h5>
                        <button id="btn_editar" class="btn btn-warning direito" style="width: auto;" type="button"
                            value="Editar">Editar</button>
                    </div>
                    <div class="card-body">
                        <!-- Informação da existência de campos obrigatórios -->
                        <div class="alert" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                            <strong> Campos marcados com <span style='color:#ff0000'>*</span> são
                                obrigatórios</strong>
                        </div>
                        <div class="esquerdo" style="padding:5px">
                            <!-- Nome -->
                            <span>Nome</span>
                            <div class="input-group flex-nowrap">
                                <input name="nome" readonly type="text" class="form-control" placeholder="Primeiro Nome"
                                    aria-label="Primeiro Nome" aria-describedby="addon-wrapping" value="">
                            </div>
                            <br>

                            <!-- Email -->
                            <span>Email<span style='color:#ff0000'> *</span></span>
                            <div class="input-group flex-nowrap">
                                <input name="email" readonly type="text" class="form-control" placeholder="Email"
                                    aria-label="Email" aria-describedby="addon-wrapping" value="">
                                <span id="erroEmail" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                        </div>
                        <div class="direito" style="padding:5px">
                            <br>
                            <!-- Telemóvel -->
                            <span>Nº de Telemóvel</span>
                            <div class="input-group flex-nowrap">
                                <input name="telemovel" readonly type="text" class="form-control"
                                    placeholder="Telemóvel" aria-label="Telemovel" aria-describedby="addon-wrapping"
                                    value="">
                                <span id="erroTelemovel" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                        </div>

                        &emsp;
                        <hr>&emsp;

                        <h5>Morada Predefinida</h5>

                        <!-- Morada -->
                        <span>Morada</span>
                        <div class="input-group flex-nowrap">
                            <input name="morada" readonly type="text" class="form-control" placeholder="Morada"
                                aria-label="Morada" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['morada']))
                                    echo $utilizador['morada']; ?>">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12 esquerdo">
                                    <!-- Cidade -->
                                    <span>Cidade</span>
                                    <div class="input-group flex-nowrap">
                                        <input name="cidade" readonly type="text" class="form-control"
                                            placeholder="Cidade" aria-label="Cidade" aria-describedby="addon-wrapping"
                                            value="<?php if (!empty($utilizador['cidade']))
                                                echo $utilizador['cidade']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <!-- País -->
                                    <span>País</span>
                                    <div class="input-group flex-nowrap">
                                        <input name="pais" readonly type="text" class="form-control" placeholder="País"
                                            aria-label="País" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['pais']))
                                                echo $utilizador['pais']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <!-- Código Postal -->
                                    <span>Código-Postal</span>
                                    <div class="input-group flex-nowrap">
                                        <input name="CodPostal" readonly type="text" class="form-control"
                                            placeholder="Código Postal" aria-label="Código Postal"
                                            aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['CodPostal']))
                                                echo $utilizador['CodPostal']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--Fim do conteúdo de página-->
    <?php
    include __DIR__ . "/includes/footer_business.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>