<?php

/*
	Nome: Pagina Home Reservas
	Copyright: 2022-2023 © Herman&Joel
	Descrição: Pagina Resposavel por Apresentar as reservas do Cliente

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
        <title><?php echo $contactos[0]['site_titulo'];?> - Reserva</title>
        <?php require('../Views/Links.php'); ?>
    </head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php 
        
            require('../Views/Home_Header.php');
            if(!(isset($_SESSION['login']) && $_SESSION['login'] ==true)){
                redirect("index.php");
            }
        
        ?>
        <!-- /Cabeçario da Pagina -->

        <?php

            /*$data = filtracao($_GET);
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

            #$user_res = Selecao($Conexao,"SELECT * FROM user_home WHERE id=? LIMIT 1",[$_SESSION['uId']],false);
        ?>

        <!-- Conteúdo da Pagina -->
        <main>
            <!-- -->
            <div class="container mb-4">
                <div class="row">
                    <div class=" col-12 my-5 px-4">
                        <h2 class="fw-bold color_white">Reservas</h2>
                        <div style="font-size: 18px;">
                            <a href="index.php" class=" text-decoration-none color_white">Home</a>
                            <span class=" color_white"> &gt;</span>
                            <a href="Home_Quartos.php" class=" text-decoration-none color_white">Reservas</a>
                        </div>
                    </div>
                    <!-- -->
                    <?php 

                        // Página atual
                        $page = $_GET['page'] ?? 1;

                        // Itens por página
                        $perPage = 3;

                        $offset = ($page - 1) * $perPage;

                        $q = "SELECT DISTINCT reserva_pedido.*, reserva_detalhes.* FROM reserva_pedido 
                            INNER JOIN reserva_detalhes ON reserva_pedido.reserva_id=reserva_detalhes.reserva_id
                            WHERE ((reserva_pedido.reserva_status='reservado') OR (reserva_pedido.reserva_status='Cancelado')) AND (reserva_pedido.user_id=?) ORDER BY reserva_pedido.reserva_id DESC ";
                        

                        $stmt = $Conexao->prepare($q." LIMIT {$perPage} OFFSET {$offset}");

                        $stmt->execute([$_SESSION["uId"]]);
                        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        
                        #$res = Selecao($Conexao,$q,[$_SESSION["uId"]],false);
                        $text = "";
                        $cont=1;
                        
                        foreach ($res as $data) {

                            $date = date("d-m-Y",strtotime($data['datetime']));
                            $checkin = date("d-m-Y",strtotime($data['check_in']));
                            $checkout = date("d-m-Y",strtotime($data['check_out']));
                
                            $status_bg ="";
                            $btn ="";
                            $preco = Formato_Kwanza($data['preco']);
                            $preco_t = Formato_Kwanza($data['total_pay']);
                            $m_p = ($data['tipo_pag'] =="pagamento_chegada")? "Pagamento ao Chegar ao Hotel":"Transferência Bancária";
                            $codi= base64_encode($data['invoice']);
                            $dt = "Pedido-".$data['user_nome']. rand(100, 999).date('Yd');

                            if($data["reserva_status"] == "reservado"){
                                $status_bg = "bg-success";
                                if($data["chegada"] == 1){
                                    $btn = "
                                        <a class='btn btn-dark btn-sm shadow-none' href='data:application/pdf;base64,$codi' download='$dt'>Download PDF</a>
                                    ";

                                    if ($data["rate_review"] == 0) {
                                        $btn.= "
                                            <button type='button' class='btn btn-dark ms-2 btn-sm shadow-none' onclick='review_quarto($data[reserva_id],$data[quarto_id])' data-bs-toggle='modal' data-bs-target='#Model_RR'>Avaliar & Review</button>
                                        ";
                                    }
                                }else{
                                    $btn = "
                                        <button onclick='cancel_booking($data[reserva_id])' type='button' class='btn btn-danger btn-sm shadow-none'>Cancelar</button>
                                    ";
                                }

                            }else if($data["reserva_status"] == "Cancelado"){
                                $status_bg = "bg-danger";
                                if($data["reembolso"] == 0){
                                    $btn = "
                                        <span class='badge bg-primary'>Reembolso em Processo...</span>
                                    ";
                                }else{
                                    $btn = "
                                        <a class='btn btn-dark btn-sm shadow-none' href='data:application/pdf;base64,$codi' download='$dt'>Download PDF</a>
                                    ";
                                }

                            }else{
                                $status_bg = "bg-warning";
                                $btn = "
                                        <a class='btn btn-dark btn-sm shadow-none' href='data:application/pdf;base64,$codi' download='$dt'>Download PDF</a>
                                    ";

                            }
                            
                            #$text .= print_r($dataf);
                            echo <<<data
                                <div class="col-md-4 px-4 mb-4">
                                    <div class="bg-white p-3 rounded shadow-sm">
                                        <h5 class="fw-bold">$data[quarto_nome]</h5>
                                        <p>$preco por Noite</p>
                                        <p>
                                            <b>Check in:</b> $checkin <br>
                                            <b>Check out</b>: $checkout<br>
                                        </p>
                                        <p>
                                            <b>Total a Pagar:</b> $preco_t <br>
                                            <b>Pedido nº</b>: $data[ordem_id]<br>
                                            <b>Data</b>: $date<br>
                                        </p>
                                        <p>
                                            <span class='badge $status_bg'>$data[reserva_status]</span>
                                        </p>
                                        $btn
                                    </div>
                                </div>
                            data;
                            //<!--onclick="download($data[reserva_id])"-->
                        }

                        $total = getTotal($Conexao, $q, [$_SESSION["uId"]]);

                        // Total de páginas
                        $numPages = ceil($total / $perPage);
                    ?>
                        <nav aria-label="Page navigation">
                        <ul class="pagination">

                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                <a style="color: black;" class="page-link" href="?page=<?= $page-1 ?>">Anterior</a>
                            </li>

                            <!-- Links das páginas -->
                            <?php for($i = 1; $i <= $numPages; $i++): ?>
                            <li class="page-item<?= ($page == $i) ? 'active' : '' ?>">
                                <a style="color: black;" class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor ?>
                            
                            <li class="page-item <?= ($page == $numPages) ? 'disabled' : '' ?>">
                                <a style="color: black;" class="page-link " href="?page=<?= $page+1 ?>">Próximo</a>
                            </li>

                        </ul>
                        </nav>

                </div>
                <!-- Modal da Avaliaçao-->
                <div class="modal fade" id="Model_RR" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="rate_review" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-chat-square-heart-fill fs-3 me-2"></i>Avaliar & Review</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Avaliar</label>
                                        <select class="form-select shadow-none" name="rating">
                                            <option value="5">Excelente</option>
                                            <option value="4">Bom</option>
                                            <option value="3">Razoável</option>
                                            <option value="2">Mau</option>
                                            <option value="1">Péssimo</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Review</label>
                                        <textarea name="review" rows="3" required class="form-control shadow-none"></textarea>
                                    </div>
                                    <input type="hidden" name="reserva_id">
                                    <input type="hidden" name="quarto_id">
                                    <div class="text-end">
                                        <button type="submit" class="btn custom-bg text-white shadow-none">Submeter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Modal da Avaliaçao-->
            </div>
        </main>
        <?php
            if (isset($_GET["cancel_status"])) {
                Alert("success","Reserva Cancelado");
            } else if (isset($_GET["rate_review"])) {
                Alert("success","Obrigado por sua Avaliação e clasificação!");
            }
        ?>
        <!-- /Conteúdo da Pagina -->

        <!-- Rodape da Pagina -->
         <?php require('../Views/Home_Footer.php');?>
        <!-- /Rodape da Pagina -->

        <!-- Script da Pagina -->
        <script>

            function cancel_booking(id) {
                if (confirm('Queres mesmo cancelar essa reserva?')) {
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/reserva_cancela.php",true);
                    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                    xhr.onload = function(){
                        if (this.responseText.trim() == 1) {
                            window.location.href ='Home_reservas.php?cancel_status=true';
                        }else {
                            Alert("error","Falha em cancelar...")   
                        }
                        
                    }
                    xhr.send('cancel_reserva&id='+encodeURIComponent(id));
                }
                
            }

            let review_form = document.getElementById('rate_review');
            function review_quarto(bid,rid) {
                review_form.elements['reserva_id'].value = bid;
                review_form.elements['quarto_id'].value = rid;
                
            }

            review_form.addEventListener('submit',(e)=>{
                e.preventDefault();
                let formData = new FormData(review_form);
                formData.append('rate_review','');
        

                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/review_quarto.php",true);

                xhr.onload = function(){
                    console.log(this.responseText.trim());
                    if(this.responseText.trim() == 0){ 
                        var modal_config = document.getElementById('Model_RR');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();
                        Alert('error','Avaliação & Review Falhada!');
                    }else{
                        window.location.href ='Home_reservas.php?rate_review=true'; 
                    }}
                    xhr.send(formData);              
            });

        </script>
        <script src="/Projecto-Final/public/js/bootstrap-5.0.2/bootstrap.min.js"></script>
        <!-- /Script da Pagina -->
    </body>
</html>