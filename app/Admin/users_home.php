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
        <title>Pagina de Controle - Usuarios</title>

    </head>
    <body class="bg-light">
        <!-- -->
            <?php  require("../Admin/Admin_header.php")
            
                #style="height: 450px; overflow-y: scroll;"
            ?>

            

        <!-- -->
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Usuarios do Sistema / Usuarios</div>
                        <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="text-end mb-4">
                                <input type="text" id="pes_page" oninput="get_user(this.value)" class="form-control shadow_none w-25 ms-auto" placeholder="Pesquise o Usuario">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover border text-center" style="min-width: 1300px;">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th scope="col">Nª</th>
                                            <th scope="col">Picture</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Sobrenome</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Telefone</th>
                                            <th scope="col">Verificação</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Acção</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user_data">
                                    </tbody>
                                </table>
                                <nav>
                                <ul class="pagination mt-3" id="table_pagination">
                                </ul>
                            </nav>   
                            </div>
                        </div>
                        </div>

                    </div>  
                    <!-- -->
                    <div class="modal fade" id="admin_view" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-ver" autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Ver Usuario</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Nome</label>
                                                <input type="text" name="nome" id="nome" class="form-control shadow-none" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Sobrenome</label>
                                                <input type="text" name="subnome" id="subnome" class="form-control shadow-none" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Genero</label>
                                                <input type="text" name="genero" id="genero" class="form-control shadow-none" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Endereço</label>
                                                <input type="text" name="endereco" id="endereco" class="form-control shadow-none" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold ">E-mail</label>
                                                <input type="email" name="email" id="email" class="form-control shadow-none" readonly >
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Números de Telefone</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="tel" id="tel" class="form-control shadow-none" readonly >
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Numero de identidade(Bilhete, etc)</label>
                                                <input type="text" name="n_ide" id="n_ide" class="form-control shadow-none" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Data de Nascimento</label>
                                                <input type="date" name="data_nas" id="data_nas" class="form-control shadow-none" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Data de registro no Sistema</label>
                                                <input type="text" name="user" id="user" class="form-control shadow-none" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset"  class="btn text-secondary shadown-none" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- -->
                </div>
            </div>
        
        
        <?php require("../Views/scripts.php");?>

        <script>

            function get_user(username='',page=1){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/gets_user.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    let data = JSON.parse(this.responseText);
                    document.getElementById('user_data').innerHTML = data.user_data;
                    document.getElementById('table_pagination').innerHTML = data.paginacao;
                }
                xhr.send('gets_user&username='+encodeURIComponent(username)+'&page='+page);
            }

            function change_page(page){
                get_user(document.getElementById('pes_page').value,page);
            }

            let form_ver = document.getElementById('form-ver');

            function ver_user(id){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/gets_user.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    
                    let data = JSON.parse(this.responseText.trim());
                    form_ver.elements['nome'].value = data[0].nome;
                    form_ver.elements['subnome'].value = data[0].sobrenome;
                    form_ver.elements['genero'].value = data[0].genero;
                    form_ver.elements['endereco'].value = data[0].endereco;
                    form_ver.elements['email'].value = data[0].email;
                    form_ver.elements['tel'].value = data[0].tel;
                    form_ver.elements['n_ide'].value = data[0].n_ide;
                    form_ver.elements['data_nas'].value = data[0].data_nas;
                    form_ver.elements['user'].value = data[0].datetime;
                   
                }
                xhr.send('ver='+encodeURIComponent(id));
            }

           /* */

            function trocar_Status(id,val){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/gets_user.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    if(this.responseText.trim() == 1){
                        Alert('success','Status Trocado');
                        get_user();
                    }else{ Alert('error','Falha no Servidor');}
                }
                xhr.send('trocar_Status='+encodeURIComponent(id)+'&value='+encodeURIComponent(val));
            }

            function remove_user(id){
                if(window.confirm("Atenção! Queres mesmo Deletar este Usuario?")){
                    let formData = new FormData();
                    formData.append('user_id',id);
                    formData.append('remove_user', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/gets_user.php",true);
                    xhr.onload = function(){

                        /*var modal_config = document.getElementById('quartos_image');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();*/

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','User Removido!');
                            get_user();

                        }else{
                            Alert('error','Falha em Remover o User');
                        }
                    }
                    xhr.send(formData);    
                }

            }

            /*function Procurar_User(username){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/gets_user.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){

                    document.getElementById('user_data').innerHTML = this.responseText;
                    
                }
                xhr.send('procurar_user&username='+encodeURIComponent(username));
              }*/
                
 
 

            window.onload = function(){
                get_user();

            }
            
        

                    
        </script>
    </body>
</html>
