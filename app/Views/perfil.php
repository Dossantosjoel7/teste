<?php

/*
	Nome: Pagina de alterar os dados do Perfil
	Copyright: 2022-2023 © Herman&Joel
	Descrição: Pagina resposavel para editar os dados do Perfil do Caso de Uso Cliente 

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
        <title><?php echo $contactos[0]['site_titulo'];?> - Perfil</title>
        <?php require('../Views/Links.php'); ?>
    </head>
    <body>
        <!-- Cabeçario da Pagina -->
        <?php 
            
            require('../Views/Home_Header.php'); 
            
            if(!(isset($_SESSION['login']) && $_SESSION['login'] ==true)){
                redirect("index.php");
            }

            $u_existe = "SELECT * FROM user_home,contactos,pessoa WHERE user_home.id_pessoa = pessoa.id_pessoa and pessoa.id_contacto = contactos.id and  id_user=? LIMIT 1";
            $slct_res = $Conexao->prepare($u_existe);
            $slct_res -> execute([$_SESSION["uId"]]);

            if($slct_res->rowCount() == 0){
                redirect('../Views/Index.php');
            }

            $slct_fetch = $slct_res->fetchAll(PDO::FETCH_ASSOC);
        
        ?>
        <!-- /Cabeçario da Pagina -->

        <!-- Conteúdo da Pagina -->
        <main>
            <!-- -->
            <div class="container">
                <div class="row">
                    <div class=" col-12 my-5 px-4">
                        <h2 class="fw-bold color_white">Perfil</h2>
                        <div style="font-size: 18px;">
                            <a href="index.php" class=" text-decoration-none color_white">Home</a>
                            <span class=" color_white"> &gt;</span>
                            <a href="perfil.php" class=" text-decoration-none color_white">Perfil</a>
                        </div>
                    </div>
                    <!-- -->

                    <!-- DIV onde contem o formulario de editar as informaçoes -->
                    <div class="col-12 mb-5 px-4">
                        <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                            <form id="info_form" method="post">
                                <h5 class="mb-3 fw-bold">Informações Basicas</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Nome</label>
                                        <input type="text" name="nome" id="nome" value="<?php echo $slct_fetch[0]['nome']?>" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Sobrenome</label>
                                        <input type="text" name="sobrenome" id="sobrenome" value="<?php echo $slct_fetch[0]['sobrenome']?>" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Telemovel</label>
                                        <input type="tel" name="tel" id="tel" value="<?php echo $slct_fetch[0]["tel"]?>" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Genero</label>
                                                <select class="form-control shadow-none" type="genero" name="genero" required>
                                                    <option value="Feminino" <?php if($slct_fetch[0]["genero"]=="Femenino"){?>selected<?php } ?>>Femenino</option>
                                                    <option value="Masculino" <?php if($slct_fetch[0]["genero"]=="Masculino"){?>selected<?php } ?>>Masculino</option>
                                                </select>
                                        </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Data de nascimento</label>
                                        <input type="date" name="data_nas" id="data_nas" value="<?php echo $slct_fetch[0]["data_nas"]?>" class="form-control shadow-none" max="<?php echo date('Y-m-d');?>" min="1900-01-01" required >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Nª de identidade(passaporte,B.I,etc)</label>
                                        <input type="text" name="n_ide" id="n_ide" value="<?php echo $slct_fetch[0]['n_ide']?>" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label class="form-label">Endereço de Morada</label>
                                        <textarea name="endereco" id="endereco" class="form-control shadow-none" rows="1" required><?php echo $slct_fetch[0]['endereco']?></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn text-white custom-bg shadow-none">Salva as mudanças</button>
                            </form>
                        </div>
                    </div>

                    <!-- DIV Mudar Foto do Perfil -->
                    <div class="col-md-4 mb-5 px-4">
                            <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                                <form id="profile_form" method="post">
                                    <h5 class="mb-3 fw-bold">Foto do Perfil</h5>
                                    <img src="<?php echo USER_IMAGE_PATH.$slct_fetch[0]['profile'] ?>" class="img-fluid mb-3 rounded-circle">
                                    <label class="form-label">Nova foto de Perfil</label>
                                    <input type="file" name="profile" id="profile" accept=".jpg, .jpeg, .png, .webp" class=" mb-4 form-control shadow-none" required>
                                    <button type="submit" class="btn text-white custom-bg shadow-none">Salva as mudanças</button>
                                </form>
                            </div>
                    </div>
                
                    <!-- DIV Mudar senha -->
                    <div class="col-md-8 mb-5 px-4">
                            <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                                <form id="pass_form" method="post">
                                    <h5 class="mb-3 fw-bold">Mudar a Senha</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nova Senha</label>
                                            <input name="pass_new" id="new_pass" required type="password" class="form-control shadow-none">
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Confirmar Senha</label>
                                            <input name="conf_pass" id="conf_pass" required type="password" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn text-white custom-bg shadow-none">Salva as mudanças</button>
                                </form>
                            </div>
                    </div>
                    <!-- -->
                </div>
            </div>
        </main>
        <!-- /Conteúdo da Pagina -->
       
        <!-- Rodape da Pagina -->
        <?php require('../Views/Home_Footer.php');?>
        <!-- /Rodape da Pagina -->

        <!-- Script da Pagina -->
        <script>

            // Ajax -> Envio dos dados do formulario editar informaçoes pessoais.
            let info_form =document.getElementById("info_form");
            info_form.addEventListener('submit',function(e){
                
                e.preventDefault();
                let data = new FormData();

                data.append('info_form','');
                data.append('nome',info_form.elements['nome'].value);
                data.append('sobrenome',info_form.elements['sobrenome'].value);
                data.append('genero',info_form.elements['genero'].value);
                data.append('tel',info_form.elements['tel'].value);
                data.append('data_nas',info_form.elements['data_nas'].value);
                data.append('n_ide',info_form.elements['n_ide'].value);
                data.append('endereco',info_form.elements['endereco'].value);
                
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/editar_perfil.php",true);
                xhr.onload = function(){
                    if (this.responseText.trim()=='tel_exit') {
                        Alert("error","Numero já existe");
                    }else if(this.responseText.trim() == 0) {
                        Alert("error","Nenhuma mudança feita..."); 
                    }else{
                        Alert("success","Mudança feita com Sucesso"); 
                    }
                    }
                    xhr.send(data);
                });

            // Ajax -> Envio da foto perfil editada.
            let profile_form =document.getElementById('profile_form');
            profile_form.addEventListener('submit',function(e){
                e.preventDefault();

                let data = new FormData();
                
                data.append('profile_form','');
                data.append('profile',profile_form.elements['profile'].files[0]);
                
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/editar_perfil.php",true);

                xhr.onload = function(){
                    if(this.responseText.trim() == 'inv_img'){
                        Alert('error','Somente JPG, WEBP ou PNG');
                    }else if(this.responseText.trim() == 'upd_failed'){
                        Alert('error','Upload não foi feito com Sucesso!');
                    }else if(this.responseText.trim() == 0){
                        Alert('error','Atualização Falhada');
                    }else{
                        window.location.href =window.location.pathname;
                    }
                    }
                    xhr.send(data);
                })

            // Ajax -> Envio da foto perfil editada.
            let pass_form =document.getElementById('pass_form');
            pass_form.addEventListener('submit',function(e){
                e.preventDefault();

                let conf_pass =pass_form.elements["conf_pass"].value;
                let new_pass =pass_form.elements["new_pass"].value;

                /*if (new_pass =! conf_pass) {
                    Alert("error","Senhas não igual");
                    return false;
                }*/

                let data = new FormData();
                data.append('pass_form','');
                data.append('conf_pass',conf_pass);
                data.append('new_pass',new_pass);
                
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/editar_perfil.php",true);

                xhr.onload = function(){
                    if(this.responseText.trim() == 'mismach'){
                        Alert('error','Password não iguais');
                    }else if(this.responseText.trim() == 0){
                        Alert('error','Atualização Falhada');
                    }else{
                        Alert("success","Mudança Efetuada");
                        pass_form.reset();
                    }
                    }
                    xhr.send(data);
            })

        </script>
        <script src="/Projecto-Final/public/js/bootstrap-5.0.2/bootstrap.min.js"></script>
        <!-- /Script da Pagina -->
    </body>
</html>