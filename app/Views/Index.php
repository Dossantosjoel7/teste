<?php 

    /*
        Nome: Pagina Inicial
        Copyright: 2022-2023 © Herman&Joel
        Descrição: Pagina Incial ou apresentaçao do Site(Caso de Uso Cliente)

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
        <title>Pagina Inicial</title>
        <?php require('../Views/Links.php');?>
    </head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php require('../Views/Home_Header.php'); 
            
        ?>
        <!-- /Conteúdo da Pagina -->

        <!-- Conteudo Principal -->
        <main>
          
            <!-- Parte de boas Vindas -->
            <section class="container-fluid Parte-Principal px-lg-4 mt-4">
                <div class="Conteudo-Principal">
                    <span>Bem Vindo</span>
                    <h3>Ao <?php echo $contactos[0]['site_titulo']; ?></h3>
                    <p><?php echo $contactos[0]['site_sobre']; ?></p>
                </div>
            </section>
            <!-- Caixa de Disponibilidade de Reservas -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 bg-white shadow p-4 rounded">
                        <h5 class="mb-4">Verifique Disponibilidade</h5>
                        <form action="Home_Quartos.php">
                            <div class="row align-items-end">
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label Fonte_T500">Check-in</label>
                                    <input type="date" class="form-control shadow-none" name="checkin" min="<?php echo date('Y-m-d');?>" require>
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label Fonte_T500">Check-out</label>
                                    <input type="date" class="form-control shadow-none" name="checkout" min="<?php echo date('Y-m-d',strtotime('+1 day'));?>"  require>
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label Fonte_T500">Adulto</label>
                                    <select class="form-select shadow-none" name="adulto">
                                        <?php 
                                            $q = "SELECT MAX(adulto) AS max_adulto, MAX(crianca) AS max_crianca FROM quartos WHERE status='1' AND removido=0";
                                            $ex = Selecao($Conexao,$q,$q,false);

                                            for ($i=1; $i <= $ex[0]['max_adulto'] ; $i++) { 
                                                echo "<option value='$i'>$i</option>";
                                            }
                                        
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label Fonte_T500" >Criança</label>
                                    <select class="form-select shadow-none" name="crianca">
                                       <?php 
                                            for ($i=1; $i <= $ex[0]['max_crianca'] ; $i++) { 
                                                echo "<option value='$i'>$i</option>";
                                            }
                                       ?>
                                    </select>
                                </div>
                                <input type="hidden" name="check_verificacao">
                                <div class="col-lg-1 mb-lg-3 mt-2">
                                    <button type="submit" class="btn text-white shadow-none custom-bg">Submeter</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Caixas dos Quartos -->
            <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-fonte color_white">Os Nossos Quartos</h2>
            <div class="container">
                <div class="row">
                <?php
                            $quarto_res = Selecao($Conexao,"SELECT * FROM quartos WHERE status=? AND removido=? ORDER BY id DESC LIMIT 3",[1,0],false);
                            foreach ($quarto_res as $quarto_data) {
                                $fea_q=Selecao($Conexao,"SELECT caracteristicas.nome FROM caracteristicas
                                INNER JOIN quartos_caracteristica ON caracteristicas.id = quartos_caracteristica.caracteristica_id
                                WHERE quartos_caracteristica.quartos_id=?",[$quarto_data['id']],false);

                                $caracteristica_data = "";
                                foreach ($fea_q as $fea_row) {
                                    $caracteristica_data .="<span class='badge rounded-pill bg-light text-dark text-wrap'>
                                                                $fea_row[nome]
                                                            </span>";
                                }

                                $fea_q=Selecao($Conexao,"SELECT acomadacao.nome FROM acomadacao
                                INNER JOIN quartos_acomadacao ON acomadacao.id = quartos_acomadacao.acomadacao_id
                                WHERE quartos_acomadacao.quartos_id=?",[$quarto_data['id']],false);

                                $acomadacao_data = "";
                                foreach ($fea_q as $fea_row) {
                                    $acomadacao_data .="<span class='badge rounded-pill bg-light text-dark text-wrap'>
                                                                $fea_row[nome]
                                                            </span>";
                                }

                                $quarto_thumb = QUARTO_IMAGE_PATH."Thumbnail.jpg";
                                $thumb_q = Selecao($Conexao,"SELECT * FROM quartos_imagem WHERE quartos_id=? AND thumb=?",[$quarto_data['id'],1],false);
                               
                                if($thumb_q){
                                    $quarto_thumb = QUARTO_IMAGE_PATH.$thumb_q[0]['image'];
                                }

                                $Reserva_btn ="";

                                if(!$contactos[0]['Desligado']){
                                    $login = 0;
                                    if(isset($_SESSION['login']) && $_SESSION['login'] ==true){
                                        $login=1;

                                    }
                                    $Reserva_btn = "<a onclick='verificalogin_reserva($login,$quarto_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Reservar Agora</a>";
                                }

                                $preco = Formato_Kwanza($quarto_data['preco']);

                                $qr= "SELECT  ROUND(AVG(rating)) AS avg_rating FROM rating_review WHERE quarto_id=? ORDER BY id_rr DESC LIMIT 20";
                                $r_rating = Selecao($Conexao,$qr,[$quarto_data['id']],false);

                                $data_rating = "";
                                if($r_rating[0]['avg_rating']!=NULL){

                                    $data_rating = "<div class='rating mb-4'>
                                    <h6 class='mb-1'>Avaliações</h6>
                                    <span class='badge rounded-pill bg-light text-dark text-wrap '>";

                                    for ($i=0; $i <$r_rating[0]['avg_rating'] ; $i++) { 
                                        $data_rating .= "<i class='bi bi-star-fill text-warning'></i>";
                                    }

                                    $data_rating .= "</span>
                                    </div>";

                                }

                                echo <<<data
                                            <div class="col-lg-4 col-md-6 my-3">
                                            <div class="card border-0 shadow style_Quarto">
                                                <img src="$quarto_thumb" class="card-img-top">
                                                <div class="card-body">
                                                    <h5>$quarto_data[nome]</h5>
                                                    <h6 class="mb-4">$preco por Noite</h6>
                                                    <div class="features mb-4">
                                                        <h6 class="mb-1">Caracteristicas</h6>
                                                        $caracteristica_data
                                                    </div>
                                                    <div class="facilities mb-4">
                                                        <h6 class="mb-1">Acomadações</h6>
                                                        $acomadacao_data
                                                    </div>
                                                    <div class="guests mb-4">
                                                        <h6 class="mb-1">Hóspedes</h6>
                                                        <span class="badge rounded-pill bg-light text-dark text-wrap ">
                                                            $quarto_data[adulto] Adultos
                                                        </span>
                                                        <span class="badge rounded-pill bg-light text-dark text-wrap ">
                                                            $quarto_data[crianca] Criança
                                                        </span>
                                                    </div>
                                                        $data_rating
                                                    <div class="d-flex justify-content-evenly mb-2">
                                                        $Reserva_btn
                                                        <a href="Home_Quartos_Detalhes.php?id=$quarto_data[id]" class="btn btn-sm btn-outline-dark shadow-none">Mais Detalhes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                data;
                            }
                        ?>
                    </div>
                <div class="col-lg-12 text-center mt-5">
                    <a href="../Views/Home_Quartos.php" class="btn btn-sm btn-outline-light rounded-0 fw-bold shadow-none">Mais Quartos</a>
                </div>
                </div>
            </div>
            <!-- Nossos Serviços-->
            <h2 class="mt-3 pt-4 mb-5 text-center fw-bold h-fonte color_white">Acomadações & Serviços</h2>
            <div class="container">
                <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
                <?php
                        $q = "SELECT * FROM acomadacao ORDER BY id DESC LIMIT 5";
                        $datab = Selecao($Conexao,$q,$q,false);
                        $path = ACOMADACAO_IMAGE_PATH;
                        foreach ($datab as $data) {
                            echo <<<data
                                <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                                    <img src="$path$data[icone]" width="50px">
                                    <h5 class="mt-3">$data[nome]</h5>
                                </div>
                            data;
                        }
                    ?>
                </div>
            </div>
            <div class="col-lg-12 text-center mt-4 pt-4 mb-4">
                <a href="../Views/Home_Nosso-Servicos.php" class="btn btn-sm btn-outline-light rounded-0 fw-bold shadow-none">Nossas Acomadações</a>
            </div>
        </main>
        <!-- /Conteudo Principal -->

        <!-- Rodape da Pagina -->
        <?php require('../Views/Home_Footer.php');?>
        <!-- /Rodape da Pagina -->

        <!-- Modal da Senha Alterada-->
        <div class="modal fade" id="Model_Rec" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="recup_form" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-shield-lock fs-3 me-2"></i>Tela para Inserir nova Senha</h5>
                               <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nova Senha</label>
                                    <input name="pass" id="pass" required type="pass" class="form-control shadow-none">
                                    <input type="hidden" name="email">
                                    <input type="hidden" name="token">
                                </div>
                                <div class="mb-2 text-end">
                                    <button type="button" class="btn  shadow-none me-2" data-bs-dismiss="modal">Saia</button>
                                    <button type="submit" class="btn btn-dark shadow-none">Envia</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
       <!-- Modal da Senha Alterada-->

        <!-- Script da Pagina -->
        <script>
            let recup_form = document.getElementById('recup_form');
            recup_form.addEventListener('submit',(e)=>{
                
                e.preventDefault();
                let formData = new FormData();
                formData.append('email',recup_form.elements['email'].value);
                formData.append('token',recup_form.elements['token'].value);
                formData.append('pass',recup_form.elements['pass'].value);
                formData.append('RecPass', true);


                var modal_config = document.getElementById('Model_Rec');
                    var modal = bootstrap.Modal.getInstance(modal_config);
                    modal.hide();

                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/User_form.php",true);

                                    
                xhr.onload = function(){
                    let formData = new FormData(form_reg);
                    let dataArray = Array.from(formData.entries());
                    console.log(dataArray);

                console.log(this.responseText.trim());
                    if(this.responseText.trim() === 'failed'){
                        Alert('error','Falha ao Recuperar Conta');
                    }else{
                        Alert('success','Sucesso ao Recuperar Conta');
                        recup_form.reset();
                    }
                }
            xhr.send(formData);                                       
            });                          
        </script>
        <script src="/Projecto-Final/public/js/bootstrap-5.0.2/bootstrap.min.js"></script>
        <!-- script php para emitir o modal atraves do input $_GET -->
       <?php 
            if(isset($_GET['Recuperacao'])){

                $data = filtracao($_GET);
                $t_date = date("Y-m-d");
                $S_existe = Selecao($Conexao, "SELECT * FROM user_home,pessoa,contactos WHERE email =? and user=? AND token=? AND t_expire=? LIMIT 1", [$data['email'],2, $data['token'],$t_date],false);
                if($S_existe){
                    echo <<<show
                        <script>
                            var modal_rec = document.getElementById('Model_Rec');

                            modal_rec.querySelector("input[name='email']").value ='$data[email]';
                            modal_rec.querySelector("input[name='token']").value ='$data[token]';

                            var modal = bootstrap.Modal.getOrCreateInstance(modal_rec);
                            modal.show();
                        </script>
                        show;
                }else {
                    alert("error","Invalido ou link expirado!");
                }
                
            }

        ?>
        <!-- Script da Pagina -->
    </body>
</html>