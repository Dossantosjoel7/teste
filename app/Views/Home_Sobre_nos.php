<?php

/*
	Nome: Pagina Sobre-nos
	Copyright: 2022-2023 © Herman&Joel
	Data de Criação: 11/12/22 00:43
    Data de Revisao: 18/07/23 10:43
	Descrição: Pagina Resposavel por Apresentar Sobre-nos

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
        <title>Hotel Home - Sobre-nos</title>
        <?php require('../Views/Links.php');?>
        <style>
            .caixa{
                border-top-color: var(--Cor-Fundo-Botao) !important;
            }
        </style>
</head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php require('../Views/Home_Header.php'); ?>
        <!-- /Cabeçario da Pagina -->

        <!-- Conteúdo da Pagina -->
        <main>
            <?php 

                $cm = $Conexao->prepare("SELECT SUM(quant) as total_quartos_disponiveis FROM quartos where removido=0;");
                $cm -> execute();
                $d2= $cm ->fetchAll(PDO::FETCH_ASSOC);


                $cm = $Conexao->prepare("SELECT COUNT(id_funcionario) as total_funcionarios FROM funcionario");
                $cm -> execute();
                $d3= $cm ->fetchAll(PDO::FETCH_ASSOC);
            
            ?>
            <!-- Parte Superior da apresentação da Pagina -->
            <div class="my-5 px-4">
                    <h2 class="fw-bold h-fonte text-center color_white">Sobre-nós</h2>
                    <div class="h-linha bg-white"></div>
                    <p class="text-center mt-3 color_white">Saiba mais sobre nós.
                    </p>
            </div>
            <!-- Parte central que conter mais acerca do Hotel -->
            <div class="container color_white">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                        <h3 class="mb-3">Com 2 anos, nós somos uma equipe dedicada e apaixonada que busca atender às necessidades dos nossos clientes. </h3>
                        <p>Nossa missão é proporcionar excelência em tudo o que fazemos, desde a qualidade dos nossos produtos até o atendimento ao cliente.
                           Valorizamos relacionamentos duradouros com nossos clientes e buscamos construir parcerias sólidas com base na confiança e no respeito mútuo.</p>
                    </div>
                <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                        <img src="/Projecto-Final/public/media/information.png" alt="free" class="w-100">
                    </div>
                </div>
            </div>
            <!-- Parte inferior que conter as caixas de informações gerais do Hotel -->
            <!--<div class="container mt-5">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 ">
                        <div class="bg-white rounded shadow p-4 border-top border-4 text-center caixa">
                            <img src="/Projecto-Final/public/media/icons8-hotel-64.png" width="78px">
                            <h4 class="mt-3">30 Quartos</h4>
                        </div>
                    </div>
                 
                    <div class="col-lg-3 col-md-6 mb-4 px-4">
                        <div class="bg-white rounded shadow p-4 border-top border-4 text-center caixa">
                            <img src="/Projecto-Final/public/media/icons8-employees-64.png" width="78px">
                            <h4 class="mt-3">20 funcionários</h4>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="container text-center">
            <div class="row">
                <div class="col mb-4 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 text-center caixa">
                        <img src="/Projecto-Final/public/media/icons8-hotel-64.png" width="78px">
                        <h4 class="mt-3"><?php 
                        
                            if($d2[0]["total_quartos_disponiveis"] == 0){echo 0;}else {
                                echo $d2[0]["total_quartos_disponiveis"];
                            }?> Quartos</h4>
                    </div>
                </div>
                <div class="col order-5 mb-4 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 text-center caixa">
                        <img src="/Projecto-Final/public/media/icons8-employees-64.png" width="78px">
                        <h4 class="mt-3"><?php 
                            if($d3[0]["total_funcionarios"] == 0){
                                echo 0;
                            }else {echo $d3[0]["total_funcionarios"];}?> funcionários</h4>
                    </div>
                </div>
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