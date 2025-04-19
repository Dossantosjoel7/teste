<?php

/*
	Nome: Pagina Confirmar a Reserva
	Copyright: 2022-2023 © Herman&Joel
	Data de Criação: 19/03/23 23:01
    Data de Ultima Revisão: 02/06/23 09:49
	Descrição: Pagina Resposavel por Confirmação da Reserva

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
        <title><?php echo $contactos[0]['site_titulo'];?> - Confirmar a Reserva</title>
        <?php require('../Views/Links.php'); ?>
</head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php require('../Views/Home_Header.php'); ?>

        <?php
        
            if(!isset($_GET['id']) || $contactos[0]['Desligado'] ==true ){
                redirect("Home_Quartos.php");
            }else if(!(isset($_SESSION['login']) && $_SESSION['login'] ==true)){
                redirect("Home_Quartos.php");
            }

            $data = filtracao($_GET);
            $quarto_res = Selecao($Conexao,"SELECT * FROM quartos WHERE id=? AND status=? AND removido=?",[$data['id'],1,0],false);

            if(!$quarto_res){
                redirect("Home_Quartos.php");
            }

            $_SESSION['quarto'] = [
                "id" => $quarto_res[0]['id'],
                "nome" => $quarto_res[0]['nome'],
                "preco" => $quarto_res[0]['preco'],
                "pagamento" => null,
                "disponivel" => false,

            ];

            /*print_r($_SESSION['quarto']);
            exit;*/

            $user_res = Selecao($Conexao,"SELECT * FROM user_home,pessoa,contactos WHERE user_home.id_pessoa = pessoa.id_pessoa and pessoa.id_contacto = contactos.id and id_user=? LIMIT 1",[$_SESSION['uId']],false);
        ?>
        <!-- Conteúdo da Pagina -->
        <main>
            <!-- -->
            <div class="container">
                <div class="row">
                    <div class=" col-12 my-5 mb-4 px-4">
                        <h2 class="fw-bold color_white">Confirmar Reserva</h2>
                        <div style="font-size: 18px;">
                            <a href="index.php" class=" text-decoration-none color_white">Home</a>
                            <span class=" color_white"> &gt;</span>
                            <a href="Home_Quartos.php" class=" text-decoration-none color_white">Quarto</a>
                            <span class=" color_white"> &gt;</span>
                            <a href="Home_Quartos.php" class=" text-decoration-none color_white">Confirmacao</a>
                        </div>
                    </div>
                    <!-- -->
                    <div class="col-lg-7 col-md-12 px-4 mb-5">
                        <?php 
                            $quarto_thumb = QUARTO_IMAGE_PATH."Thumbnail.jpg";
                            $thumb_q = Selecao($Conexao,"SELECT * FROM quartos_imagem WHERE quartos_id=? AND thumb=?",[$quarto_res[0]['id'],1],false);
                           
                            if($thumb_q){
                                $quarto_thumb = QUARTO_IMAGE_PATH.$thumb_q[0]['image'];
                            }

                            $preco = Formato_Kwanza($quarto_res[0]['preco']);

                            echo <<<data
                                    <div class="card p-3 shadow-sm rounded">
                                        <img src="$quarto_thumb" class="img-fluid rounded mb-3">
                                        <h5>{$quarto_res[0]['nome']}</h5>
                                        <h6>{$preco} por Noite</h6>
                                    </div>
                                data;
                        
                        
                        ?>
                    </div>

                    <div class="col-lg-5 col-md-12 px-4 mb-1">
                        <div class="card mb-4 border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <form action="../Controllers/reserva_finalizacao.php" id="reserva_form" method="post">
                                    <h6 class="mb-3">Detalhes da Reserva</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nome</label>
                                            <input type="text" name="nome" id="nome" value="<?php echo $user_res[0]['nome']." ".$user_res[0]['sobrenome'];?>" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Número do Telemovel</label>
                                            <input type="number" name="tel" id="tel" value="<?php echo $user_res[0]['tel'];?>" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Endereço</label>
                                            <textarea name="endereco" id="endereco" class="form-control shadow-none" rows="1" required ><?php echo $user_res[0]['endereco'];?></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Check-in</label>
                                            <input type="date" name="entrada" onchange="check_disponivel()" class="form-control shadow-none" min="<?php echo date('Y-m-d');?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Check-out</label>
                                            <input type="date" name="saida" onchange="check_disponivel()" class="form-control shadow-none" min="<?php echo date('Y-m-d',strtotime('+1 day'));?>" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Tipo de Pagamento</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="Pag" id="pagamento-chegada" value="pagamento_chegada" required>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Pagamento na chegada <strong>(Dinheiro/Cartão)</strong>
                                                </label>
                                                <div id="info-pagamento-chegada" class="d-none fw-bolder">
                                                    <p>Pagar em dinheiro quando chegar ao Estabelecimento</p>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="Pag" id="transferencia-bancaria" value="transferencia_bancaria" required>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Transferência Bancária
                                                </label>
                                                <div id="info-transferencia-bancaria" class="d-none fw-bolder">
                                                    <p>Efectue o seu pagamento por transferência bancária ou depósito directo na nossa conta. Por favor indique o seu nome da reserva como referência da transferência ou depósito e recibo da reserva. <!--A sua reserva não será marcada como sucesso até confirmação do montante na nossa conta.--><br><br>
                                                       Envie o comprovativo para o E-mail: <a href="mailto:<?php echo $contactos2[0]['email'];?>"><?php echo $contactos2[0]['email'];?></a> ou Whatsapp: <a href="<?php echo $contactos2[0]['wt'];?>"><?php echo $contactos2[0]['pn1'];?></a>.
                                                    </p>
                                                </div>
                                                <input type="hidden" name="user">
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-12">
                                            <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                                <span class="visually-hidden">Processando...</span>
                                            </div>
                                            <h6 class="mb-3 text-danger" id="pay_info">Forneça a data do Check-in(entrada) & Check-out(saida)!</h6>
                                            <button nome="pay_now" id="pay_now" class="btn w-100 text-white custom-bg shadow-none mb-1" disabled>FINALIZAR PEDIDO</button>
                                        </div>   
                                </form>
                            </div>
                        </div>
                    </div>
                        
                </div>
        </main>
        <!-- Rodape da Pagina -->
        <?php require('../Views/Home_Footer.php');?>
        <script src="/Projecto-Final/public/js/bootstrap-5.0.2/bootstrap.min.js"></script>
        <script>

            var pagamentoChegadaInput = document.getElementById('pagamento-chegada');
            var transferenciaBancariaInput = document.getElementById('transferencia-bancaria');
            var infoPagamentoChegada = document.getElementById('info-pagamento-chegada');
            var infoTransferenciaBancaria = document.getElementById('info-transferencia-bancaria');

            pagamentoChegadaInput.addEventListener('change', function() {
                if (pagamentoChegadaInput.checked) {
                infoPagamentoChegada.classList.remove('d-none');
                infoTransferenciaBancaria.classList.add('d-none');
                }
            });

            transferenciaBancariaInput.addEventListener('change', function() {
                if (transferenciaBancariaInput.checked) {
                infoTransferenciaBancaria.classList.remove('d-none');
                infoPagamentoChegada.classList.add('d-none');
                }
            });

            let reserva_form = document.getElementById("reserva_form");
            let info_loader = document.getElementById("info_loader");
            let pay_info = document.getElementById("pay_info");

            function check_disponivel(){
                let entrada_val = reserva_form.elements['entrada'].value;
                let saida_val = reserva_form.elements['saida'].value;

                reserva_form.elements['pay_now'].setAttribute('desabled',true);

                if(entrada_val!='' && saida_val!=''){
                    pay_info.classList.add('d-none');
                    pay_info.classList.replace('text-dark','text-danger');
                    info_loader.classList.remove('d-none');

                    let data = new FormData();

                    data.append('check_disponivel','');
                    data.append('entrada',entrada_val);
                    data.append('saida',saida_val);

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/reserva_confirm.php",true);
                    xhr.onload = function(){
                        console.log(this.responseText.trim());
                        let data = JSON.parse(this.responseText.trim());
                        if(data.status.trim() == 'check_in_out_iguais'){
                            pay_info.innerText = "Você não pode fazer check-out(saida) no mesmo dia ";
                        }else if(data.status.trim() == 'check_out_cedo'){
                            pay_info.innerText = "A data de check_out é anterior à data de check-in";
                        }else if(data.status.trim() == 'check_in_cedo'){
                            pay_info.innerText = "A data de check_in é anterior à data de hoje!";
                        }else if(data.status.trim() == 'Indisponivel'){
                            pay_info.innerText = "Quarto indisponivel para esta data de check-in!";
                        }else{
                            pay_info.innerHTML ="Núm. de dias: "+data.dias+"<br>Total de dinheiro a pagar: "+data.pagamento;
                            pay_info.classList.replace('text-danger','text-dark');
                            reserva_form.elements['pay_now'].removeAttribute('disabled');
                        }

                        pay_info.classList.remove('d-none');
                        info_loader.classList.add('d-none');
                        
                        }
                        xhr.send(data);  
                }
            }
        </script>
    </body>
</html>