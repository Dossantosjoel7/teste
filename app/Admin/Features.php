<?php

session_start();

if(!isset($_SESSION['rol'])){
    header('location: indexAdmin.php');
}else if($_SESSION['rol']!= 1){
    header('location: indexAdmin.php');
}


require("../Models/Database.php");
require("../Controllers/essencial.php");

?>

<!DOCTYPE html>
<html lang="pt-ao">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php require("../Views/Links.php");?>
        <title>Pagina de Controle - Caracteristicas & Acomadações</title>

    </head>
    <body class="bg-light">
        <!-- -->
            <?php  require("../Admin/Admin_header.php")?>

        <!-- -->
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Caracteristicas & Acomadações</div>
                        <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="card-title m-0">Caracteristicas</h5>
                                <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#Caracteristicas-s">
                                    <i class="bi bi-plus-square"></i> ADD
                                </button>
                            </div>


                            <div class="table responsive-md" style="height: 150px; overflow-y: scroll;">
                                <table class="table table-hover border">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th scope="col">#</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Acção</th>
                                        </tr>
                                    </thead>
                                    <tbody id="caracteristica_data">
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                        </div>
                        <!---->
                        <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="card-title m-0">Acomadações</h5>
                                <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#acomadacao-s">
                                    <i class="bi bi-plus-square"></i> ADD
                                </button>
                            </div>


                            <div class="table responsive-md" style="height: 350px; overflow-y: scroll;">
                                <table class="table table-hover border">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th scope="col">#</th>
                                            <th scope="col">Icone</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col" width="40%">Descrição</th>
                                            <th scope="col">Acção</th>
                                        </tr>
                                    </thead>
                                    <tbody id="acomadacao_data">
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                        </div>


                    </div>  
                    
                    <!-- -->
                </div>
            </div>

            <div class="modal fade" id="Caracteristicas-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-caracteristicas">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar Caracteristicas</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nome</label>
                                            <input type="text" name="caracteristicas_nome" id="caracteristicas_nome" class="form-control shadow-none" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset"  class="btn text-secondary shadown-none" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn custom-bg text-white shadown-none">Submeter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade" id="acomadacao-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-acomadacao">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar Acomadações</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nome</label>
                                            <input type="text" name="acomadacao_nome" id="acomadacao_nome" class="form-control shadow-none" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold"></label>
                                            <input type="file" name="acomadacao_icone" id="acomadacao_icone" accept=".svg" class="form-control shadow-none" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Descrição</label>
                                            <textarea name="acomadacao_des" id="acomadacao_des" class="form-control shadow-none" rows="1" required ></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset"  class="btn text-secondary shadown-none" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn custom-bg text-white shadown-none">Submeter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

        <?php require("../Views/scripts.php");?>

        <script>
            let form_caracteristicas = document.getElementById('form-caracteristicas');
            let form_acomadacao = document.getElementById('form-acomadacao');

            form_caracteristicas.addEventListener('submit',(e)=>{
                e.preventDefault();
                add_caracteristicas();

            });

            function add_caracteristicas(){
                let formData = new FormData();
                formData.append('caracteristicas_nome',form_caracteristicas.elements['caracteristicas_nome'].value);
                formData.append('add_caracteristicas', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/Caracteristica&Acomadacao.php",true);
                    xhr.onload = function(){

                        var modal_config = document.getElementById('Caracteristicas-s');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() != 0){
                            Alert('success','Nova Caracterista Adicionada');
                            form_caracteristicas.elements['caracteristicas_nome'].value='';
                            get_caracteristicas();
                            
                        }else{ Alert('error','Falha no Servidor');}
                        
                    }
                    xhr.send(formData);      
            }

            function get_caracteristicas(){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Caracteristica&Acomadacao.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){

                    document.getElementById('caracteristica_data').innerHTML = this.responseText;
                    
                }
                xhr.send('get_caracteristicas');
            }

            function delete_caracteristica(val){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Caracteristica&Acomadacao.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','Caracterista Deletada');
                            form_caracteristicas.elements['caracteristicas_nome'].value='';
                            get_caracteristicas();
                        }else if(this.responseText.trim() =='add_quarto') { 
                            Alert('error','Caracteristica já foi adicionada em uns dos Quartos!');
                        }else{ 
                            Alert('error','Falha no Servidor');
                        }
                }
                xhr.send('delete_caracteristicas='+val);
            }


            form_acomadacao.addEventListener('submit',(e)=>{
                e.preventDefault();
                add_acomadacao();

            });


            function add_acomadacao(){
                let formData = new FormData();
                formData.append('acomadacao_nome',form_acomadacao.elements['acomadacao_nome'].value);
                formData.append('acomadacao_icone',form_acomadacao.elements['acomadacao_icone'].files[0]);
                formData.append('acomadacao_des',form_acomadacao.elements['acomadacao_des'].value);
                formData.append('add_acomadacao', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/Caracteristica&Acomadacao.php",true);
                    xhr.onload = function(){

                        var modal_config = document.getElementById('acomadacao-s');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 'inv_img'){
                            Alert('error','Somente SVG');
                        }else if(this.responseText.trim() == 'inv_size'){
                            Alert('error','A imagem deve ter menos 2MB!');
                        }else if(this.responseText.trim() == 'upd_failed'){
                            Alert('error','Upload não foi feito com Sucesso!');
                        }else{
                            Alert('success','Nova acomadação adicionada');
                            form_acomadacao.reset();
                            get_acomadacao();
                        }
                    }
                    xhr.send(formData);      
            }

            function get_acomadacao(){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Caracteristica&Acomadacao.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){

                    document.getElementById('acomadacao_data').innerHTML = this.responseText;
                    
                }
                xhr.send('get_acomadacao');
            }

            function delete_acomadacao(val){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/Caracteristica&Acomadacao.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','Acomadação Deletada');
                            form_caracteristicas.elements['caracteristicas_nome'].value='';
                        }else if(this.responseText.trim() == "add_quarto") { 
                            Alert('error','Acomadação já foi adicionada em uns dos Quartos!');
                        }else{ 
                            Alert('error','Falha no Servidor');
                        }
                        get_acomadacao();
                }
                xhr.send('delete_acomadacao='+val);
            }

            window.onload = function(){
                get_caracteristicas();
                get_acomadacao();

            }
        

                    
        </script>
    </body>
</html>