<?php

session_start();

if(!isset($_SESSION['rol'])){
    header('location: indexAdmin.php');
}else if($_SESSION['rol']!= 1){
    header('location: indexAdmin.php');
}

?>

<!DOCTYPE html>
<html lang="pt-ao">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php require("../Views/Links.php");?>
        <title>Pagina de Controle - Admin</title>

    </head>
    <body class="bg-light">
        <!-- -->
            <?php  require("../Admin/Admin_header.php")?>

        <!-- -->
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Configurações</div>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="card-title m-0">Configurações Gerais</h5>
                                <button type="button" class="btn btn-dark shadown-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>
                            </div>
                            <h6 class="card-subtitle mb-1 fw-bold">Titulo do Site</h6>
                                <p class="card-text" id="site_titulo"></p>
                            <h6 class="card-subtitle mb-1 fw-bold">Sobre-nos</h6>
                                <p class="card-text" id="site_sobre"></p>
                        </div>
                    </div>
                    <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="post" id="form-configuracoes">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Configurações Gerais</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                                <label class="form-label fw-bold">Titulo do Site</label>
                                                <input type="text" name="site_titulo" id="site_titulo_m" class="form-control shadow-none" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Sobre-nos</label>
                                            <textarea name="site_sobre" class="form-control shadow-none" id="site_sobre_m" rows="6" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="Get_configuracoes()" class="btn text-secondary shadown-none" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" onclick="Upd_configuracoes()" class="btn custom-bg text-white shadown-none">Submeter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="card-title m-0">Modo desligamento</h5>
                                <div class="form-check form-switch">
                                    <input onchange="upd_shutdown(this.value)"  class="form-check-input" type="checkbox" id="shutdown_toggle">
                                </div>
                            </div>
                            
                            <p class="card-text">
                                Nenhum Cliente tera permissão de reservar um quarto, enquanto o modo desligamento tiver ativado.
                            </p>
                        </div>
                    </div>
                        <!-- -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h5 class="card-title m-0">Configurações dos Contactos</h5>
                                    <button type="button" class="btn btn-dark shadown-none btn-sm" data-bs-toggle="modal" data-bs-target="#Contactos-s">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <h6 class="card-subtitle mb-1 fw-bold">Endereço</h6>
                                            <p class="card-text" id="endereco"></p>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="card-subtitle mb-1 fw-bold">GoogleMap</h6>
                                            <p class="card-text" id="Gmap"></p>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="card-subtitle mb-1 fw-bold">E-mail</h6>
                                            <p class="card-text" id="email"></p>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="card-subtitle mb-1 fw-bold">Phone Number</h6>
                                            <p class="card-text mb-1">
                                                <i class="bi bi-telephone-fill"></i>
                                                <span id="pn1"></span>
                                            </p>
                                            <p class="card-text">
                                                <i class="bi bi-telephone-fill"></i>
                                                <span id="pn2"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                                <h6 class="card-subtitle mb-1 fw-bold">Segue-nos</h6>
                                                <p class="card-text mb-1">
                                                    <i class="bi bi-whatsapp me-1"></i>
                                                    <span id="wt"></span>
                                                </p>
                                                <p class="card-text mb-1">
                                                    <i class="bi bi-facebook me-1"></i>
                                                    <span id="fb"></span>
                                                </p>
                                                <p class="card-text">
                                                    <i class="bi bi-instagram me-1"></i>
                                                    <span id="insta"></span>
                                                </p>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="card-subtitle mb-1 fw-bold">Iframe</h6>
                                            <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- -->
                    <div class="modal fade" id="Contactos-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-contactos">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Configurações de Contactos</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Endereço</label>
                                                        <input type="text" name="endereco" id="endereco_m" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">GoogleMap link</label>
                                                        <input type="text" name="gmap" id="gmap_m" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">E-mail</label>
                                                        <input type="text" name="email" id="email_m" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Números de Telefone(com codigo do país)</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
                                                            <input type="text" name="pn1" id="pn1_m" class="form-control shadow-none" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
                                                            <input type="text" name="pn2" id="pn2_m" class="form-control shadow-none" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Links para Redes Sociais</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-whatsapp me-1"></i></span>
                                                            <input type="text" name="wt" id="wt_m" class="form-control shadow-none" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-facebook me-1"></i></span>
                                                            <input type="text" name="fb" id="fb_m" class="form-control shadow-none" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-instagram me-1"></i></span>
                                                            <input type="text" name="insta" id="insta_m" class="form-control shadow-none" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Iframe src</label>
                                                        <input type="text" name="iframe" id="iframe_m" class="form-control shadow-none" required>
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="Contactos_inp(data_contactos)" class="btn text-secondary shadown-none" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" onclick="Upd_contactos()" class="btn custom-bg text-white shadown-none">Submeter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- -->
                </div>
            </div>
        </div>

        <?php require("../Views/scripts.php");?>

        <script>
            let data_configuracoes;
            let data_contactos;
        

            function Get_configuracoes() {

                let titulo_site = document.getElementById('site_titulo');
                let sobre_site = document.getElementById('site_sobre');

                let titulo_site_m = document.getElementById('site_titulo_m');
                let sobre_site_m = document.getElementById('site_sobre_m');

                let shutdown_toggle = document.getElementById('shutdown_toggle');

                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Admin_config.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){

                    data_configuracoes = JSON.parse(this.responseText);

                    titulo_site.innerText = data_configuracoes[0].site_titulo;
                    sobre_site.innerText = data_configuracoes[0].site_sobre;

                    titulo_site_m.value = data_configuracoes[0].site_titulo;
                    sobre_site_m.value = data_configuracoes[0].site_sobre;

                    if(data_configuracoes[0].Desligado == 0){
                        shutdown_toggle.checked = false;
                        shutdown_toggle.value = 0;
                    }else{
                        shutdown_toggle.checked = true;
                        shutdown_toggle.value = 1;
                    }
                }

                xhr.send('Get_config');
            }

            function Upd_configuracoes(){

                let form = document.getElementById("form-configuracoes"); 
                let formData = new FormData(form);
                formData.append("Upd_conf", true);
  
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Admin_config.php",true);
  
                xhr.onload = function(){
                    var modal_config = document.getElementById('general-s');
                    var modal = bootstrap.Modal.getInstance(modal_config);
                    modal.hide();

                    if(this.responseText == 1){
                        Alert('success','Mudanças Salvadas');
                        Get_configuracoes();
                    }else{
                        Alert('error','Mudanças não-Salvadas');
                    }
                }
  
                xhr.send(formData);
            }

                function upd_shutdown(value){

                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Admin_config.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                console.log(this.responseText);

                xhr.onload = function(){
                if(this.responseText == 1 && data_configuracoes[0].Desligado ==0){
                        Alert('success','O Site esta Desligado!');
                    }else{
                        Alert('success','O Site esta Aberto!');
                    }
                    Get_configuracoes();
                }
                xhr.send('upd_shutdown='+value);
            }

            function Get_contactos() {

                let contactos_p_id = ['endereco','Gmap','pn1','pn2','email','fb','insta','wt'];
                let iframe = document.getElementById('iframe');

                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Admin_config.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    data_contactos = JSON.parse(this.responseText);
                    data_contactos =Object.values(data_contactos[0]);
                    
                    console.log(data_contactos);
                    console.log(contactos_p_id);
            
                    for(i=0;i<contactos_p_id.length;i++){
                        document.getElementById(contactos_p_id[i]).innerText = data_contactos[i+1];
                    }

                    iframe.src = data_contactos[9];
                    Contactos_inp(data_contactos);
                }

                xhr.send('Get_contactos');
            }

            function Contactos_inp(data) {
                let contactos_p_id = ['endereco_m','gmap_m','pn1_m','pn2_m','email_m','fb_m','insta_m','wt_m','iframe_m'];

                for(i=0;i<contactos_p_id.length;i++){
                        document.getElementById(contactos_p_id[i]).value = data[i+1];
                    }
            }

            function Upd_contactos(){

                let form = document.getElementById("form-contactos"); 
                let formData = new FormData(form);
                formData.append("Upd_contactos", true);

                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Admin_config.php",true);
  
                xhr.onload = function(){
                    var modal_config = document.getElementById('Contactos-s');
                    var modal = bootstrap.Modal.getInstance(modal_config);
                    modal.hide();
                    console.log(this.responseText);
                    if(this.responseText == 1){
                        Alert('success','Mudanças Salvadas');
                        Get_contactos();
                    }else{
                        Alert('error','Mudanças não-Salvadas');
                    }
                }
  
                xhr.send(formData);
            }

            window.onload = function(){
                Get_configuracoes();
                Get_contactos();
            }

        </script>
    </body>
</html>