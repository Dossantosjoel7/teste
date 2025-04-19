<?php

/*
	Nome: Pagina Emitida durante o Sucesso de uma Reserva
	Copyright: 2022-2023 © Herman&Joel
	Descrição: Reserva Sucesso

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
        <title><?php echo $contactos[0]['site_titulo'];?> - Confirmação da Reserva</title>
        <?php require('../Views/Links.php'); ?>
</head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php require('../Views/Home_Header.php'); ?>

        <?php
 
            if(!(isset($_SESSION['login']) && $_SESSION['login'] ==true)){
                redirect('../Views/Index.php');
            }
        ?>
        <!-- /Cabeçario da Pagina -->

        <!-- Conteúdo da Pagina -->
        <main>
            <!-- -->
            <div class="container">
                <div class="row">
                    <div class=" col-12 my-5 mb-3 px-4">
                        <h2 class="fw-bold color_white">Detalhes da Reserva</h2>
                    </div>
                    <?php

                        $data = filtracao($_GET);

                        if(!(isset($_SESSION['login']) && $_SESSION['login'] ==true)){
                            redirect('../Views/Index.php');
                        }

                        $q1 = "SELECT reserva_pedido.*, reserva_detalhes.* FROM reserva_pedido 
                               INNER JOIN reserva_detalhes ON reserva_pedido.reserva_id=reserva_detalhes.reserva_id
                               WHERE reserva_pedido.ordem_id=? AND reserva_pedido.user_id=? AND reserva_pedido.pedido_status!=?; 
                            ";
                        $reserva_res = $Conexao->prepare($q1);
                        $reserva_res -> execute([$data['pedido'],$_SESSION['uId'],'pendente']);

                        if($reserva_res->rowCount() == 0){
                            redirect('../Views/Index.php');
                        }

                        $reserva_pedido = $reserva_res->fetch(PDO::FETCH_ASSOC);

                        #print_r($reserva_pedido);
                    ?>

                    <!-- -->
                    <div class="col-lg-7 col-md-12 px-4 mb-5">
                        <?php

                            if($reserva_pedido['tipo_pag'] =="pagamento_chegada"){
                                echo <<<data
                                    <div class="card p-3 shadow-sm rounded">
                                        <h5>Prezedo (a) Aguardamos sua espera no estabelecimento</h5>
                                        <h6>Quando chegar ao estabelecimento, efetua seu pagamento(Multicaixa ou Cash) e entrega o recibo ao Recipcionista</h6>
                                    </div>
                                data;
                            }else if($reserva_pedido['tipo_pag'] == "transferencia_bancaria"){
                                $q= "Envie o comprovativo para o E-mail: <a href='mailto:".$contactos2[0]['email']."'>".$contactos2[0]['email']."</a> ou Whatsapp: <a href='".$contactos2[0]['wt']."'>".$contactos2[0]['pn1']."</a>";
                                echo <<<data
                                    <div class="card p-3 shadow-sm rounded">
                                        <h5>Prezedo (a) Aguardamos sua espera no estabelecimento</h5>
                                        <h6>Efectue o seu pagamento por transferência bancária ou depósito directo na nossa conta.
                                            Por favor indique o seu nome da reserva como referência da transferência ou depósito e recibo da reserva<br><br>$q
                                        </h6>
                                        
                                        <p>Por favor, efetue a transferência bancária para a conta abaixo:</p>
                                        <p>Banco: Caixa Angola</p>
                                        <p>Conta: IBAN A0060004000000832929210124</p>
                                        <p> Nº de conta: 016003188 11 001</p>
                                    </div>
                                data;
                            }
                            
                        ?>
                    </div>
                    
                    <div class="col-lg-5 col-md-12 px-4 mb-1">
                        <?php
                            $dat= date_parse_from_format('Y-m-d H:i',$reserva_pedido['datetime']);
                            $preco = Formato_Kwanza($reserva_pedido['total_pay']);
                            $m_p = ($reserva_pedido['tipo_pag'] =="pagamento_chegada")? "Pagamento na chegada (Dinheiro/Cartão)":"Transferência Bancária";
                            $codi= base64_encode($reserva_pedido['invoice']);
                            if($reserva_pedido['pedido_status'] == 'sucesso'){
                                echo <<<data
                                    <div class="card mb-4 border-0 shadow-sm rounded-3 alert alert-success">
                                        <div class="card-body">
                                            <p class="fw-bold">
                                                <h4>
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Reserva Feita com Sucesso
                                                </h4>
                                                <br><br>
                                                <ul class="fs-5">
                                                    <li><strong>Número da Reserva:</strong> {$reserva_pedido['ordem_id']}</li>
                                                    <li><strong>Data e Hora da marcação:</strong> {$dat['day']}/{$dat['month']}/{$dat['year']} as {$dat['hour']}:{$dat['minute']} horas</li>
                                                    <li><strong>Total:</strong> $preco</li>
                                                    <li><strong>Método de pagamento:</strong> {$m_p}</li>
                                                </ul>
                                                <br><br>
                                                <a href="Home_reservas.php">Vai em Minhas Reservas</a>
                                                <br>
                                                <a href="data:application/pdf;base64,$codi" download="$_GET[in]">Baixar recibo</a>
                                            </p>
                                        </div>
                                    </div>
                            data;
                            }else{
                                echo <<<data
                                    <div class="card mb-4 border-0 shadow-sm rounded-3 alert alert-danger">
                                        <div class="card-body">
                                            <p class="fw-bold">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                    Falha em fazer Reserva
                                                <br><br>
                                                <a href="reserva.php">Vai em Minhas Reservas</a>
                                            </p>
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