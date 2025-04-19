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
        <title>Pagina de Controle - Funcionarios</title>

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
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Funcionarios</div>
                        <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="text-end mb-4">
                                <button type="button" class="btn btn-dark shadow-none btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#func_add">
                                    <i class="bi bi-plus-square"></i>  Cadastrar
                                </button>
                                <input type="text" id="pes_page"  oninput="get_funcionario(this.value)" class="form-control shadow_none w-25 ms-auto" placeholder="Pesquise o Funcionario">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover border text-center" style="min-width: 1300px;">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th scope="col">Nª</th>
                                            <th scope="col">Nome do Funcionario</th>
                                            <th scope="col">Função</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Telemovel</th>
                                            <th scope="col">Acção</th>
                                        </tr>
                                    </thead>
                                    <tbody id="func_data">
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
                    <div class="modal fade" id="func_add" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-reg" autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar Funcionarios</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Nome</label>
                                                <input type="text" name="nome" id="nome" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Sobrenome</label>
                                                <input type="text" name="subnome" id="subnome" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Função</label>
                                                <input type="text" name="funcao" id="funcao" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Genero</label>
                                                <select class="form-control shadow-none" type="genero" name="genero" required>
                                                    <option value="Nenhum" name="genero">Nenhum</option>
                                                    <option value="Femenino" name="genero">Femenino</option>
                                                    <option value="Masculino" name="genero">Masculino</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Endereço</label>
                                                <input type="text" name="endereco" id="endereco" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold ">E-mail</label>
                                                <input type="email" name="email" id="email" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Números de Telefone</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="tel" id="tel" class="form-control shadow-none" pattern="[9]{1}[0-9]{2}[0-9]{3}[0-9]{3}" title="Ensira de acordo ao Padrão 9xx-xxx-xxx" required maxlength="9" required >
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Numero de identidade(Bilhete, etc)</label>
                                                <input type="text" name="n_ide" id="n_ide" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Data de Nascimento</label>
                                                <input type="date" name="data_nas" id="data_nas" class="form-control shadow-none" max="<?php echo date('Y-m-d');?>" min="1900-01-01" required >
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Usuario administrativo?</label>
                                                <select class="form-control shadow-none" type="admin" name="admin" required>
                                                    <option value="0" name="admin">Não</option>
                                                    <option value="1" name="admin">Administrador</option>
                                                    <option value="2" name="admin">Recipcionista</option>
                                                </select>
                                            </div>
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
                    <!-- -->
                    <div class="modal fade" id="func_view" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-ver" autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Ver Funcionario</h5>
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
                                                <label class="form-label fw-bold">Função</label>
                                                <input type="text" name="funcao" id="funcao" class="form-control shadow-none" readonly>
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
                                                <label class="form-label fw-bold">Usuario do Sistema?</label>
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
                    <div class="modal fade" id="func_edit" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-edit" autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Editar Funcionario</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Nome</label>
                                                <input type="text" name="nome" id="nome" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Sobrenome</label>
                                                <input type="text" name="subnome" id="subnome" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Função</label>
                                                <input type="text" name="funcao" id="funcao" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Genero</label>
                                                <select class="form-control shadow-none" type="genero" name="genero" required>
                                                    <option value="Nenhum" name="genero">Nenhum</option>
                                                    <option value="Femenino" name="genero">Femenino</option>
                                                    <option value="Masculino" name="genero">Masculino</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Endereço</label>
                                                <input type="text" name="endereco" id="endereco" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold ">E-mail</label>
                                                <input type="email" name="email" id="email" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Números de Telefone</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="tel" id="tel" class="form-control shadow-none" pattern="[9]{1}[0-9]{2}[0-9]{3}[0-9]{3}" title="Ensira de acordo ao Padrão 9xx-xxx-xxx" required maxlength="9" required >
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Numero de identidade(Bilhete, etc)</label>
                                                <input type="text" name="n_ide" id="n_ide" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Data de Nascimento</label>
                                                <input type="date" name="data_nas" id="data_nas" class="form-control shadow-none" max="<?php echo date('Y-m-d');?>" min="1900-01-01" required >
                                            </div>
                                            <input type="hidden" name="id">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset"  class="btn text-secondary shadown-none" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn custom-bg text-white shadown-none">Editar</button>
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

            /* */
                let form_reg = document.getElementById('form-reg');
                form_reg.addEventListener('submit',(e)=>{
                                e.preventDefault();
                                let formData = new FormData(form_reg);

                                var modal_config = document.getElementById('func_add');
                                    var modal = bootstrap.Modal.getInstance(modal_config);
                                    modal.hide();

                                let xhr = new XMLHttpRequest();
                                xhr.open("POST","../Controllers/funcionario.php?metodo=adicionar",true);
                
                                xhr.onload = function(){
                                    console.log(this.responseText.trim());

                                    if(this.responseText.trim() == 'Falha'){
                                        Alert('error','Houve um problema em cadastrar o Funcionário');
                                    }else if(this.responseText.trim() == 'Email já existe'){
                                        Alert('error','Email já existe');
                                    }else if(this.responseText.trim() == 'Telefone já existe'){
                                        Alert('error','Telefone já existe');
                                    }else{
                                        Alert('success','Registro com Sucesso');
                                        get_funcionario();
                                        form_reg.reset();
                                    }
                                    
                                }
                                xhr.send(formData);
                            });
            /* */
            function get_funcionario(username='',page=1){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/funcionario.php?metodo=get",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    let data = JSON.parse(this.responseText);
                        document.getElementById('func_data').innerHTML = data.func_data;
                        document.getElementById('table_pagination').innerHTML = data.paginacao; 
                    
                }
                xhr.send('username='+encodeURIComponent(username)+'&page='+page);
            }
            /* */

            function change_page(page){
                get_funcionario(document.getElementById('pes_page').value,page);
            }

            let form_ver = document.getElementById('form-ver');
            function ver_funcionario(id){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/funcionario.php?metodo=ver",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    let data = JSON.parse(this.responseText.trim());
                    console.log(data);
                    form_ver.elements['nome'].value = data[0].nome;
                    form_ver.elements['subnome'].value = data[0].sobrenome;
                    form_ver.elements['funcao'].value = data[0].tipo_funcionario;
                    form_ver.elements['genero'].value = data[0].genero;
                    form_ver.elements['endereco'].value = data[0].endereco;
                    form_ver.elements['email'].value = data[0].email;
                    form_ver.elements['tel'].value = data[0].tel;
                    form_ver.elements['n_ide'].value = data[0].n_ide;
                    form_ver.elements['data_nas'].value = data[0].data_nas;

                    
                    if(data[0].Yes_admin== 0){
                        form_ver.elements['user'].value = "Não";
                    }else{
                        form_ver.elements['user'].value = "Sim";
                    }
                   
                }
                xhr.send('ver='+encodeURIComponent(id));
            }

           /* */

            let form_edit = document.getElementById('form-edit');

            form_edit.addEventListener('submit',(e)=>{
                e.preventDefault();
                editar_funcionario();

            });

            function editar_ver_funcionario(id){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/funcionario.php?metodo=ver",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    let data = JSON.parse(this.responseText.trim());
                    form_edit.elements['nome'].value = data[0].nome;
                    form_edit.elements['subnome'].value = data[0].sobrenome;
                    form_edit.elements['funcao'].value = data[0].tipo_funcionario;
                    form_edit.elements['genero'].value = data[0].genero;
                    form_edit.elements['endereco'].value = data[0].endereco;
                    form_edit.elements['email'].value = data[0].email;
                    form_edit.elements['tel'].value = data[0].tel;
                    form_edit.elements['n_ide'].value = data[0].n_ide;
                    form_edit.elements['data_nas'].value = data[0].data_nas;
                    form_edit.elements['id'].value = data[0].id_funcionario;
                   
                }
                xhr.send('ver='+encodeURIComponent(id));
            }

            function editar_funcionario(){
                let formData = new FormData(form_edit);
                let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/funcionario.php?metodo=editar",true);
                    xhr.onload = function(){
                        var modal_config = document.getElementById('func_edit');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','Funcionario Editado');
                            form_edit.reset();
                            get_funcionario();
                        }else if(this.responseText.trim() == 'Email já existe'){
                            Alert('error','Email já existe');
                        }else if(this.responseText.trim() == 'Telefone já existe'){
                            Alert('error','Telefone já existe');
                        }else{
                            Alert('error','Falha no Servidor ou Nenhum Dados Editado');
                        }
                    }
                    xhr.send(formData); 

                

            }

            function remove_funcionario(id){
                if(window.confirm("Atenção! Queres mesmo Deletar este Funcionario?")){
                    let formData = new FormData();
                    formData.append('id_funcionario',id);

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/funcionario.php?metodo=eliminar",true);
                    xhr.onload = function(){

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','Funcionario Removido!');
                            get_funcionario();

                        }else{
                            Alert('error','Falha em Remover o Funcionario');
                        }
                    }
                    xhr.send(formData);    
                }

            }
            
            window.onload = function(){
                get_funcionario();

            }
                    
        </script>
    </body>
</html>
