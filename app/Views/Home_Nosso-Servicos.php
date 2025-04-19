<?php

/*
	Nome: Pagina Acomadações & Serviços
	Copyright: 2022-2023 © Herman&Joel
	Data de Criação: 08/12/22 22:54
    Data de Ultima Revisão: 18/07/23 13:03
	Descrição: Pagina Resposavel por Apresentar nossos serviços

*/

require('../Controllers/d_con.php');
?>



<!DOCTYPE html>
<html lang="pt-ao">
    <head>
        <meta name="Copyright" content="2022-2023 © Herman&Joel">
        <meta name="description" content="#">
        <meta name="Generator" content="VSCode">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hotel Home - Acomadações & Serviços</title>
        <?php require('../Views/Links.php'); ?>
        <style>
            .pop:hover{
                border-top-color: var(--Cor-Fundo-Botao) !important;
                transform: scale(1.03);
                transition: all 0.3s;
            }
        </style>
</head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php require('../Views/Home_Header.php'); ?>
        <!-- /Cabeçario da Pagina -->

        <!-- Conteúdo da Pagina -->
        <main>
            <!-- Parte Superior da apresentação da Pagina -->
            <div class="my-5 px-4">
                <h2 class="fw-bold h-fonte text-center color_white">Acomadações & Serviços</h2>
                <div class="h-linha bg-white"></div>
                <p class="text-center mt-3 color_white">
                    Saiba mais sobre as nossas acomadações e serviços, nós dispomos varios para si.
                </p>
            </div>
            <!-- Parte Inferior que conter a caixa de serviços prestados pelo Hotel -->
            <div class="container">
                <div class="row">
                    <?php
                        $q = "SELECT * FROM acomadacao ORDER BY id DESC";
                        $datab = Selecao($Conexao,$q,$q,false);
                        $path = ACOMADACAO_IMAGE_PATH;
                        foreach ($datab as $data) {
                            echo <<<data
                                <div class="col-lg-4 col-md-6 mb-5 px-4">
                                    <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="$path$data[icone]" width="40px">
                                            <h5 class="m-8 ms-3">$data[nome]</h5>
                                    </div>
                                    <p class="text-center mt-3">$data[descricao]</p>
                                    </div>
                                </div>
                            data;
                        }
                    ?>
                </div>
            </div>
        </main>
        <!-- /Conteúdo da Pagina -->

        <!-- Rodape da Pagina -->
        <?php require('../Views/Home_Footer.php');?>
        <!-- /Rodape da Pagina -->
        <script src="/Projecto-Final/public/js/bootstrap-5.0.2/bootstrap.min.js"></script>
    </body>
</html>