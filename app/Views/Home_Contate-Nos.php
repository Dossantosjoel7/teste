<?php

/*
	Nome: Pagina Contate-Nos
	Copyright: 2022-2023 © Herman&Joel
	Data de Criação: 14/12/22 22:53
    Data de Ultima Revisão: 08/12/22 22:39
	Descrição: Pagina Resposavel por Apresentar contatos
    

*/


    require('../Controllers/d_con.php');
?>


<!DOCTYPE html>
<html lang="pt-ao">
    <head>
        <meta name="Copyright" content="2022-2023 © Herman&Joel">
        <meta name="description" content="Pagina Resposavel por Apresentar contatos">
        <meta name="Generator" content="VSCode">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php require('../Views/Links.php'); ?>
        <title>Hotel Home - Fale Connosco</title>
    </head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php 
            require('../Views/Home_Header.php');
        ?>

        <!-- Conteúdo da Pagina -->
        <main>
            <!-- Conteúdo da Pagina -->
            <div class="my-5 px-4">
                <h2 class="fw-bold h-fonte text-center color_white">Fale Connosco</h2>
                <div class="h-linha bg-white"></div>
                <p class="text-center mt-3 color_white">Fale Connosco,aqui tem  os nossos contactos,e se quiser podes nós mandar uma mensagem</p>
            </div>
            <!-- Conteúdo da Pagina -->
            <div class="container my-5">
                <div class="row">
                    <div class="col-lg-6 col-md-6 px-4">
                        <div class="bg-white rounded shadow p-4">
                            <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contactos2[0]['iframe'];?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <h5>Enderenço</h5>
                            <a href="<?php echo $contactos2[0]['gmap'];?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                                <i class="bi bi-geo-alt-fill"></i><?php echo $contactos2[0]['endereco'];?>
                            </a>
                            <h5 class="mt-4">Contacta-nos</h5>
                            <a href="tel:<?php echo $contactos2[0]['pn1'];?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> <?php echo $contactos2[0]['pn1'];?></a>
                            <br>
                            <a href="tel:<?php echo $contactos2[0]['pn2'];?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i><?php echo $contactos2[0]['pn2'];?></a>
                            <h5 class="mt-4">E-mail</h5>
                            <a href="mailto:<?php echo $contactos2[0]['email'];?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i> <?php echo $contactos2[0]['email'];?></a>
                            <br>
                            <!-- O que ta em baixo e so para efeito-->
                            <a href="mailto: herman12471@gmail.com" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i> herman12471@gmail.com</a>
                            <h5 class="mt-4">Segue-nos</h5>

                            <a href="<?php echo $contactos2[0]['wt'];?>" class="d-inline-block text-dark fs-5 me-2">
                                <i class="bi bi-whatsapp me-1"></i>
                            </a>
                            <a href="<?php echo $contactos2[0]['fb'];?>" class="d-inline-block text-dark fs-5 me-2">
                                <i class="bi bi-facebook me-1"></i>
                            </a>
                            <a href="<?php echo $contactos2[0]['insta'];?>" class="d-inline-block text-dark fs-5">
                                <i class="bi bi-instagram me-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-5 px-4">
                        <div class="mt-2 bg-white rounded shadow p-4">
                            <form method="post">
                                <h5>Enviar uma Mensagem</h5>
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 500;">Nome</label>
                                    <input name="nome" required type="text" class="form-control shadow-none">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 500;">E-mail</label>
                                    <input name="email" required type="email" class="form-control shadow-none">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 500;">Assunto</label>
                                    <input name="assunto" required type="text" class="form-control shadow-none">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 500;">Mensagem</label>
                                    <textarea name="mensagem" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                                </div>
                                <button name="visto" type="submit" class="btn text-white custom-bg mt-3">Enviar</button>
                            </form>
                    </div>
                    </div>
                </div>
            </div>
        </main>

        <?php
            if(isset($_POST['visto'])){
                $frm_data = filtracao($_POST);

                $q="INSERT INTO mensagem (nome, email, assunto, mensagem) VALUES (?,?,?,?)";
                $values = [$frm_data['nome'],$frm_data['email'],$frm_data['assunto'],$frm_data['mensagem']];

                $res = Inserir($Conexao, $q, $values);
                if($res != 0){
                    alert('success','Email enviado!');
                }else{
                    alert('error','Servidor caiu! Tente mais Tarde');
                }

            }
        
        ?>

        <!-- Rodape da Pagina -->
        <?php require('../Views/Home_Footer.php');?>
        <script src="/Projecto-Final/public/js/bootstrap-5.0.2/bootstrap.min.js"></script>
    </body>
</html>