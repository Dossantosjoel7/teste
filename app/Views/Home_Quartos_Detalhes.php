<?php

/*
	Nome: Pagina dos datalhes de um Quarto
	Copyright: 2022-2023 © Herman&Joel
	Descrição: Pagina Resposavel por Apresentar os Datalhes de um quarto

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
        <title>Hotel Home - Detalhes do Quarto</title>
        <?php require('../Views/Links.php'); ?>
</head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php require('../Views/Home_Header.php'); ?>
        <?php
        
            if(!isset($_GET['id'])){
                redirect("Home_Quartos.php");
            }

            $data = filtracao($_GET);
            $quarto_res = Selecao($Conexao,"SELECT * FROM quartos WHERE id=? AND status=? AND removido=?",[$data['id'],1,0],false);

            if(!$quarto_res){
                redirect("Home_Quartos.php");
            }

        
        ?>
        <!-- Cabeçario da Pagina -->

        <!-- Conteúdo da Pagina -->
        <main>
            <!-- -->
            <div class="container">
                <div class="row">
                    <div class=" col-12 my-5 mb-4 px-4">
                        <h2 class="fw-bold color_white"><?php echo $quarto_res[0]['nome']?></h2>
                        <div style="font-size: 18px;">
                            <a href="/Projecto-Final/app/Views/Index.php" class=" text-decoration-none color_white">Home</a>
                            <span class=" color_white"> &gt;</span>
                            <a href="Home_Quartos.php" class=" text-decoration-none color_white">Quarto</a>
                        </div>
                    </div>
                    <!-- -->
                    <div class="col-lg-7 col-md-12 px-4 mb-5">
                        <div id="quarto_carousel" class="carousel slide">
                            <div class="carousel-inner">
                                <?php
                                    $quarto_img = QUARTO_IMAGE_PATH."Thumbnail.jpg";
                                    $img_q = Selecao($Conexao,"SELECT * FROM quartos_imagem WHERE quartos_id=?",[$quarto_res[0]['id']],false);
                                   
                                    if($img_q){
                                        $active_class= 'active';
                                        foreach ($img_q as $img_res) {
                                            echo "<div class='carousel-item $active_class'>".
                                            "<img src=".QUARTO_IMAGE_PATH.$img_res['image']." class='d-block w-100 rounded'>
                                            </div>";
                                            $active_class='';
                                        }
                                    }else{
                                        echo "<div class='carousel-item active'>".
                                            "<img src=".$quarto_img." class='d-block w-100 rounded'>
                                            </div>";
                                    }

                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#quarto_carousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#quarto_carousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-12 px-4 mb-1">
                        <div class="card mb-4 border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <?php

                                    $qr= "SELECT  ROUND(AVG(rating)) AS avg_rating FROM rating_review WHERE quarto_id=? ORDER BY id_rr DESC LIMIT 20";
                                    $r_rating = Selecao($Conexao,$qr,[$quarto_res[0]['id']],false);

                                    $data_rating = "";
                                    if($r_rating[0]['avg_rating']!=NULL){

                                        for ($i=0; $i <$r_rating[0]['avg_rating'] ; $i++) { 
                                            $data_rating .= "<i class='bi bi-star-fill text-warning'></i>";
                                        }

                                    }


                                    $preco = Formato_Kwanza($quarto_res[0]['preco']);
                                    echo <<<preco
                                            <h4 class="mb-2">$preco por Noite</h4>
                                        preco;

                                    echo <<<rating
                                        <div class="mb-2">
                                            $data_rating
                                        </div>
                                    rating;

                                    $fea_q=Selecao($Conexao,"SELECT caracteristicas.nome FROM caracteristicas
                                                INNER JOIN quartos_caracteristica ON caracteristicas.id = quartos_caracteristica.caracteristica_id
                                                WHERE quartos_caracteristica.quartos_id=?",[$quarto_res[0]['id']],false);

                                    $caracteristica_data = "";
                                    foreach ($fea_q as $fea_row) {
                                        $caracteristica_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                        $fea_row[nome]
                                        </span>";
                                    }

                                    echo <<<caracteristica
                                        <div class="features mb-3">
                                            <h6 class="mb-1">Caracteristicas</h6>
                                            $caracteristica_data
                                        </div>
                                        caracteristica;

                                    $fea_q=Selecao($Conexao,"SELECT acomadacao.nome FROM acomadacao
                                    INNER JOIN quartos_acomadacao ON acomadacao.id = quartos_acomadacao.acomadacao_id
                                    WHERE quartos_acomadacao.quartos_id=?",[$quarto_res[0]['id']],false);

                                    $acomadacao_data = "";
                                    foreach ($fea_q as $fea_row) {
                                        $acomadacao_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                                            $fea_row[nome]
                                                            </span>";
                                    
                                     }

                                     echo <<<acomadacao
                                     <div class="Facilities mb-3">
                                         <h6 class="mb-1">Acomadações</h6>
                                         $acomadacao_data
                                     </div>
                                     acomadacao;

                                     echo "
                                        <div class='mb-3'>
                                            <h6 class='mb-1'>Hóspedes</h6>
                                            <span class='badge rounded-pill bg-light text-dark text-wrap'>
                                                ".$quarto_res[0]['adulto']." Adulto
                                            </span>
                                            <span class='badge rounded-pill bg-light text-dark text-wrap'>
                                                ".$quarto_res[0]['crianca']." Criança
                                            </span>
                                        </div>  
                                        ";
                                    
                                        echo "
                                        <div class='mb-3'>
                                            <h6 class='mb-1'>Area</h6>
                                            <span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'> 
                                                ".$quarto_res[0]['area']." m<sup>2</sup>
                                            </span>
                                        </div>
                                        ";
                                        
                                        if(!$contactos[0]['Desligado']){
                                            $login = 0;
                                            if(isset($_SESSION['login']) && $_SESSION['login'] ==true){
                                                $login=1;
                                            }
                                            echo "
                                                <button onclick='verificalogin_reserva(".$login.",".$quarto_res[0]['id'].")'  class=\"btn btn-sm w-100 text-white custom-bg shadow-none mb-1\">Reservar Agora</button>
                                            ";
                                        }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3 px-3">
                        <div class="card mb-4 border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <div class="mb-5">
                                    <h4>Descrição</h4>
                                    <p>
                                        <?php
                                            echo $quarto_res[0]['descricao'];
                                        ?>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="mb-3">Avaliações & Review</h4>
                                    <?php
                                    
                                        $q = "SELECT DISTINCT rating_review.*, user_home.id_user, user_home.id_pessoa,user_home.profile, pessoa.nome as nome_pessoa ,pessoa.sobrenome, quartos.nome FROM rating_review INNER JOIN  user_home ON rating_review.user_id = user_home.id_user INNER JOIN quartos ON rating_review.quarto_id = quartos.id INNER JOIN pessoa ON user_home.id_pessoa = pessoa.id_pessoa  and rating_review.quarto_id=? ORDER BY id_rr DESC LIMIT 15";
                                        $r_user = Selecao($Conexao,$q,[$quarto_res[0]['id']],false);
                                        $img_user = USER_IMAGE_PATH;
                                        if (!$r_user || $r_user <=0) {
                                            echo "Nenhuma Avaliações & Review";
                                        }else {
                                            foreach ($r_user as $data) {
                                                $rating ="";
                                                for ($i=0; $i < $data['rating'] ; $i++) { 
                                                    $rating .= "<i class='bi bi-star-fill text-warning'></i>";
                                                }
                                                echo <<<text
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <img src='$img_user$data[profile]' style="width: 30px; height: 30px;" class="me-1 rounded-circle">
                                                            <h6 class="m-0 ms-2">$data[nome_pessoa] $data[sobrenome]</h6>
                                                        </div>
                                                        <p class="mb-1">
                                                            $data[review]
                                                        </p>
                                                        <div>
                                                            $rating
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    text;
                                            }
                                            
                                        }


                                    ?>
                                    
                                </div>
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