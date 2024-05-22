<!DOCTYPE html>
<html>

<head>
    <title>Utilizador</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/styles/sitecss.css">
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <link rel="stylesheet" href="assets/styles/dashboard_beatriz.css">
</head>

<body>

    <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top/Menu da Página -->
        <?php //include __DIR__ . "/includes/header_logged_in.php"; ?>
    </div>

    <!--Zona de Conteudo -->
    <div id="contentPage" class="container-xxl">
        <?php //include __DIR__ . "/includes/sidebar_perfil.php"; ?>

        <!--Zona de Conteudo da Página -->
        <!--
// v0 by Vercel.
// https://v0.dev/t/AvTz6p9cvzC
-->

        <div class="bg-white p-6 rounded-lg shadow-md flex flex-col space-y-6">
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col items-center justify-center py-4 px-6 bg-[#F9FAFB] rounded-lg">
                    <span class="text-sm text-gray-500">Vendas</span>
                    <span class="text-2xl font-semibold">469,70€</span>
                </div>
                <div class="flex flex-col items-center justify-center py-4 px-6 bg-[#F9FAFB] rounded-lg">
                    <span class="text-sm text-gray-500">Pedidos</span>
                    <span class="text-2xl font-semibold">40</span>
                </div>
                <div class="flex flex-col items-center justify-center py-4 px-6 bg-[#F9FAFB] rounded-lg">
                    <span class="text-sm text-gray-500">Preço Médio dos Pedidos</span>
                    <span class="text-2xl font-semibold">11,74€</span>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Vendas</h2>
                    <div class="flex space-x-2">
                        <button
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-3 py-1 text-sm">
                            Month
                        </button>
                        <button
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-3 py-1 text-sm">
                            Week
                        </button>
                    </div>
                </div>
                <div class="w-full h-[300px]">
                    <div style="width:100%;height:100%">
                        <div style="position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1050" height="300" role="application">
                                <rect width="1050" height="300" fill="transparent"></rect>
                                <g transform="translate(40,10)">
                                    <g>
                                        <line opacity="1" x1="0" x2="0" y1="0" y2="250" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="200" x2="200" y1="0" y2="250" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="400" x2="400" y1="0" y2="250" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="600" x2="600" y1="0" y2="250" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="800" x2="800" y1="0" y2="250" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="1000" x2="1000" y1="0" y2="250" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                    </g>
                                    <g>
                                        <line opacity="1" x1="0" x2="1000" y1="250" y2="250" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="0" x2="1000" y1="189" y2="189" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="0" x2="1000" y1="127" y2="127" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="0" x2="1000" y1="66" y2="66" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                        <line opacity="1" x1="0" x2="1000" y1="5" y2="5" stroke="#f3f4f6"
                                            stroke-width="1"></line>
                                    </g>
                                    <g transform="translate(0,250)">
                                        <g transform="translate(0,0)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="text-before-edge" text-anchor="middle"
                                                transform="translate(0,16) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                Jan
                                            </text>
                                        </g>
                                        <g transform="translate(200,0)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="text-before-edge" text-anchor="middle"
                                                transform="translate(0,16) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                Feb
                                            </text>
                                        </g>
                                        <g transform="translate(400,0)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="text-before-edge" text-anchor="middle"
                                                transform="translate(0,16) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                Mar
                                            </text>
                                        </g>
                                        <g transform="translate(600,0)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="text-before-edge" text-anchor="middle"
                                                transform="translate(0,16) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                Apr
                                            </text>
                                        </g>
                                        <g transform="translate(800,0)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="text-before-edge" text-anchor="middle"
                                                transform="translate(0,16) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                May
                                            </text>
                                        </g>
                                        <g transform="translate(1000,0)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="text-before-edge" text-anchor="middle"
                                                transform="translate(0,16) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                Jun
                                            </text>
                                        </g>
                                        <line x1="0" x2="1000" y1="0" y2="0"
                                            style="stroke: transparent; stroke-width: 1;"></line>
                                    </g>
                                    <g transform="translate(0,0)">
                                        <g transform="translate(0,250)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="central" text-anchor="end"
                                                transform="translate(-16,0) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                0
                                            </text>
                                        </g>
                                        <g transform="translate(0,189)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="central" text-anchor="end"
                                                transform="translate(-16,0) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                50
                                            </text>
                                        </g>
                                        <g transform="translate(0,127)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="central" text-anchor="end"
                                                transform="translate(-16,0) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                100
                                            </text>
                                        </g>
                                        <g transform="translate(0,66)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="central" text-anchor="end"
                                                transform="translate(-16,0) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                150
                                            </text>
                                        </g>
                                        <g transform="translate(0,5)" style="opacity: 1;">
                                            <line x1="0" x2="0" y1="0" y2="0"
                                                style="stroke: rgb(119, 119, 119); stroke-width: 1;"></line>
                                            <text dominant-baseline="central" text-anchor="end"
                                                transform="translate(-16,0) rotate(0)"
                                                style="font-family: sans-serif; font-size: 11px; fill: rgb(51, 51, 51); outline-width: 0px; outline-color: transparent;">
                                                200
                                            </text>
                                        </g>
                                        <line x1="0" x2="0" y1="0" y2="250"
                                            style="stroke: transparent; stroke-width: 1;"></line>
                                    </g>
                                    <path
                                        d="M0,176C66.66666666666667,183.5,133.33333333333331,191,200,191C266.6666666666667,191,333.3333333333333,33,400,33C466.6666666666667,33,533.3333333333334,154,600,154C666.6666666666666,154,733.3333333333334,146.66666666666666,800,132C866.6666666666666,117.33333333333333,933.3333333333334,58.66666666666667,1000,0"
                                        fill="none" stroke-width="2" stroke="#e11d48"></path>
                                    <path
                                        d="M0,197C66.66666666666667,139.5,133.33333333333331,82,200,82C266.6666666666667,82,333.3333333333333,175,400,175C466.6666666666667,175,533.3333333333334,72,600,72C666.6666666666666,72,733.3333333333334,218,800,218C866.6666666666666,218,933.3333333333334,139.5,1000,61"
                                        fill="none" stroke-width="2" stroke="#2563eb"></path>
                                    <g>
                                        <g transform="translate(1000, 0)" style="pointer-events: none;">
                                            <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(800, 132)" style="pointer-events: none;">
                                            <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(600, 154)" style="pointer-events: none;">
                                            <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(400, 33)" style="pointer-events: none;">
                                            <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(200, 191)" style="pointer-events: none;">
                                            <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(0, 176)" style="pointer-events: none;">
                                            <circle r="3" fill="#e11d48" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(1000, 61)" style="pointer-events: none;">
                                            <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(800, 218)" style="pointer-events: none;">
                                            <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(600, 72)" style="pointer-events: none;">
                                            <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(400, 175)" style="pointer-events: none;">
                                            <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(200, 82)" style="pointer-events: none;">
                                            <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                        <g transform="translate(0, 197)" style="pointer-events: none;">
                                            <circle r="3" fill="#2563eb" stroke="transparent" stroke-width="0"
                                                style="pointer-events: none;"></circle>
                                        </g>
                                    </g>
                                    <g>
                                        <rect width="1000" height="250" fill="red" opacity="0" style="cursor: auto;">
                                        </rect>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-4">Ações Rápidas</h2>
                <div class="space-y-2">
                    <a class="flex items-center justify-between text-sm font-medium text-gray-600 hover:text-gray-800"
                        href="#" rel="ugc">
                        Ver informações{" "}
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </a>
                    <a class="flex items-center justify-between text-sm font-medium text-gray-600 hover:text-gray-800"
                        href="#" rel="ugc">
                        Ver pedidos{" "}
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </a>
                    <a class="flex items-center justify-between text-sm font-medium text-gray-600 hover:text-gray-800"
                        href="#" rel="ugc">
                        Ver avaliações{" "}
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <!--Fim do conteúdo de página-->
        <?php
        //include __DIR__ . "/includes/footer_2.php";
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>

</html>