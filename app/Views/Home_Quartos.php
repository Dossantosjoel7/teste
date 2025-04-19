<?php

/*
	Nome: Pagina Quartos
	Copyright: 2022-2023 © Herman&Joel
	Descrição: Pagina Resposavel por Apresentar os quartos 

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
        <title>Hotel Home - Quartos</title>
        <?php require('../Views/Links.php'); ?>
</head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php 
        
        require('../Views/Home_Header.php');


        $checkin_default = "";
        $checkout_default = "";
        $adulto_default ="";
        $crianca_default ="";

        if (isset($_GET['check_verificacao'])) {
            $data = filtracao($_GET);
            $checkin_default = $data['checkin'] ;
            $checkout_default = $data['checkout'] ;
            $adulto_default =$data['adulto'] ;
            $crianca_default =$data['crianca'] ;
        }

        ?>
        <!-- /Cabeçario da Pagina -->

        <!-- Conteúdo da Pagina -->
        <main>
            <!-- -->
            <div class="my-5 px-4">
                <h2 class="fw-bold h-fonte text-center color_white">Nossos Quartos</h2>
                <div class="h-linha bg-white"></div>
            </div>
            <!-- -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-12 mb-lg-0 mb-5 ps-4">
                        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                            <div class="container-fluid flex-lg-column align-items-stretch">
                                <h4 class="mt-2">FILTROS</h4>
                                <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                                    <div class="border bg-light p-3 rounded mb-3">
                                        <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                            Verifique Disponibilidade
                                            <button id="btn_ckn" onclick="check_filter_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                        </h5>
                                        <label class="form-label">Check-in</label>
                                        <input type="date" class="form-control shadow-none mb-3" value="<?php echo $checkin_default ?>" id="checkin" onchange="check_filter()" min="<?php echo date('Y-m-d');?>">
                                        <label class="form-label">Check-out</label>
                                        <input type="date" class="form-control shadow-none" id="checkout" value="<?php echo $checkout_default ?>" onchange="check_filter()" min="<?php echo date('Y-m-d',strtotime('+1 day'));?>">
                                    </div>
                                    <div class="border bg-light p-3 rounded mb-3">
                                        <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                            Acomadações & Serviços
                                            <button id="btn_facilit" onclick="facilit_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                        </h5>
                                        <?php
                                            $x = Selecionar_all($Conexao,"acomadacao");
                                            foreach ($x as $data) {
                                                echo <<<data
                                                    <div class="mb-2">
                                                        <input type="checkbox" onclick="fetch_rooms()" name="acomadacao" value="$data[id]" class="form-check-input shadow-none me-1" id="$data[id]">
                                                        <label class="form-check-label" for="$data[id]">$data[nome]</label>
                                                    </div>
                                                data;
                                            }
                                        ?>
                                    </div>
                                    <div class="border bg-light p-3 rounded mb-3">
                                        <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                             Hóspedes
                                            <button id="btn_hosp" onclick="hosp_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                        </h5>
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <label class="form-label">Adultos</label>
                                                <input type="number" min="1" id="adulto" value="<?php echo $adulto_default;?>" oninput="hosp_filter()" class="form-control shadow-none">
                                            </div>
                                            <div>
                                                <label class="form-label">Crianças</label>
                                                <input type="number" min="1" id="crianca" oninput="hosp_filter()" value="<?php echo $crianca_default; ?>" class="form-control shadow-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <!-- -->
                    <div class="col-lg-9 col-md-12 px-4" id="quarto_data">
                            
                    </div>
                    <script>
                        let rooms_data = document.getElementById('quarto_data');
                        let checkin = document.getElementById('checkin');
                        let checkout = document.getElementById('checkout');
                        let btn_ckn = document.getElementById('btn_ckn');


                        let adulto = document.getElementById('adulto');
                        let crianca = document.getElementById('crianca');
                        let btn_hosp = document.getElementById('btn_hosp');

                        
                        let btn_facilit = document.getElementById('btn_facilit');



                        function facilit_clear() {
                            let get_acomadacao = document.querySelectorAll('[name="acomadacao"]:checked');
                            get_acomadacao.forEach((acomadacao)=>{
                                    acomadacao.checked= false;});
                            btn_facilit.classList.add('d-none');
                            fetch_rooms();
                        }

                        function hosp_filter() {
                            if (adulto.value != 0 || crianca.value != 0) {
                                fetch_rooms();
                                btn_hosp.classList.remove('d-none');
                            }
                        }

                        function hosp_clear(){
                            adulto.value ="";
                            crianca.value ="";
                            btn_hosp.classList.add('d-none');
                            fetch_rooms();

                        }

                        function check_filter() {
                            if (checkin.value!='' && checkout !='') {
                                fetch_rooms();
                                btn_ckn.classList.remove('d-none');
                            }
                        }

                        function check_filter_clear(){
                            checkin.value='';
                            checkout.value='';
                            btn_ckn.classList.add('d-none');
                            fetch_rooms();

                        }

                        function fetch_rooms(){
                            let chk_avail = JSON.stringify({
                                checkin:checkin.value,
                                checkout:checkout.value
                            });

                            let hospede = JSON.stringify({
                                crianca:crianca.value,
                                adulto:adulto.value
                            });

                            let acomadacao_list = {"acomadacao":[]};
                            let get_acomadacao = document.querySelectorAll('[name="acomadacao"]:checked');
                            if (get_acomadacao.length > 0) {
                                get_acomadacao.forEach((acomadacao)=>{
                                    acomadacao_list.acomadacao.push(acomadacao.value);
                                });
                                btn_facilit.classList.remove('d-none');
                            }else{
                                btn_facilit.classList.add('d-none');
                            }

                            acomadacao_list = JSON.stringify(acomadacao_list);

                            let xhr = new XMLHttpRequest();
                            xhr.open("GET", "../Controllers/Filter_quarto.php?fetch_room&chk_avail="+chk_avail+"&hospede="+hospede+"&acomadacao_list="+acomadacao_list, true);

                            xhr.onprogress = function(){
                                rooms_data.innerHTML ="<div class='spinner-border text-info mb-3 d-block mx-auto' id='loader' role='status'>"+
                                                        "<span class='visually-hidden'>Processando...</span>"+
                                                        "</div>";
                            }

                            xhr.onload = function(){
                                    rooms_data.innerHTML = this.responseText;
                            }

                            xhr.send();
                        }

                        window.onload = function(){
                          fetch_rooms();  
                        }

                        
                    </script>
        </main>
        <!-- /Conteúdo da Pagina -->

        <!-- Rodape da Pagina -->
        <?php require('../Views/Home_Footer.php');?>
        <!-- /Rodape da Pagina -->
        <script src="/Projecto-Final/public/js/bootstrap-5.0.2/bootstrap.min.js"></script>
    </body>
</html>