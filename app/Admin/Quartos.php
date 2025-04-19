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
        <title>Pagina de Controle - Quartos</title>

    </head>
    <body class="bg-light">
        <!-- -->
            <?php  require("../Admin/Admin_header.php")?>

        <!-- -->
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Quartos</div>
                        <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="text-end mb-4">
                                <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#quartos_add">
                                    <i class="bi bi-plus-square"></i> ADD
                                </button>
                            </div>


                            <div class="table responsive-lg" style="height: 450px; overflow-y: scroll;">
                                <table class="table table-hover border text-center">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th scope="col">#</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Dimensão</th>
                                            <th scope="col">Hóspedes</th>
                                            <th scope="col">Preço</th>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Acção</th>
                                        </tr>
                                    </thead>
                                    <tbody id="quartos_data">
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                        </div>

                    </div>  
                    
                    <!-- -->
                </div>
            </div>

            <div class="modal fade" id="quartos_add" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-quartos" autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar Quartos</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Nome</label>
                                                <input type="text" min="1" name="nome" id="nome" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Dimensão</label>
                                                <input type="number" min="1" name="area" id="area" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Preço</label>
                                                <input type="number" min="1" name="preco" id="preco" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Quantidade</label>
                                                <input type="number" min="1" name="quant" id="quant" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Adultos (Max.)</label>
                                                <input type="number" min="1" name="adulto" id="adulto" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Crianças (Max.)</label>
                                                <input type="number" name="crianca" id="crianca" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Caracteristicas</label>
                                                <div class="row">
                                                    <?php 
                                                        $q = "SELECT * FROM caracteristicas";
                                                        $datab = Selecao($Conexao,$q,$q,false);
                                                        foreach ($datab as $data) {
                                                            echo <<<data
                                                                <div class="col-md-3">
                                                                    <label>
                                                                    <input type='checkbox' name='caracteristica' value='$data[id]' class='form-check-input shadow-none'>
                                                                    $data[nome]
                                                                    </label>
                                                                </div>     
                                                            data;
                                                        }
                                                    ?>
                                                </div>    
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Acomadação</label>
                                                <div class="row">
                                                    <?php 
                                                        $q = "SELECT * FROM acomadacao";
                                                        $datab = Selecao($Conexao,$q,$q,false);
                                                        foreach ($datab as $data) {
                                                            echo <<<data
                                                                <div class="col-md-3">
                                                                    <label>
                                                                    <input type='checkbox' name='acomadacao' value='$data[id]' class='form-check-input shadow-none'>
                                                                    $data[nome]
                                                                    </label>
                                                                </div>     
                                                            data;
                                                        }
                                                    ?>
                                                </div>    
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Descrição</label>
                                                <textarea name="desc" id="desc"  rows="4" class="form-control shadown-none" required></textarea>
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

                    <div class="modal fade" id="quartos_edit" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form_quartos_edit" autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Editar Quartos</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Nome</label>
                                                <input type="text" min="1" name="nome" id="nome" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Area</label>
                                                <input type="number" min="1" name="area" id="area" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Preço</label>
                                                <input type="number" min="1" name="preco" id="preco" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Quantidade</label>
                                                <input type="number" min="1" name="quant" id="quant" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Adultos (Max.)</label>
                                                <input type="number" min="1" name="adulto" id="adulto" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Crianças (Max.)</label>
                                                <input type="number" name="crianca" id="crianca" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Caracteristicas</label>
                                                <div class="row">
                                                <?php 
                                                        $q = "SELECT * FROM caracteristicas";
                                                        $datab = Selecao($Conexao,$q,$q,false);
                                                        foreach ($datab as $data) {
                                                            echo <<<data
                                                                <div class="col-md-3">
                                                                    <label>
                                                                    <input type='checkbox' name='caracteristica[]' value='$data[id]' class='form-check-input shadow-none'>
                                                                    $data[nome]
                                                                    </label>
                                                                </div>     
                                                            data;
                                                        }
                                                    ?>
                                                </div>    
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Acomadação</label>
                                                <div class="row">
                                                    <?php 
                                                        $q = "SELECT * FROM acomadacao";
                                                        $datab = Selecao($Conexao,$q,$q,false);
                                                        foreach ($datab as $data) {
                                                            echo <<<data
                                                                <div class="col-md-3">
                                                                    <label>
                                                                    <input type='checkbox' name='acomadacao[]' value='$data[id]' class='form-check-input shadow-none'>
                                                                    $data[nome]
                                                                    </label>
                                                                </div>     
                                                            data;
                                                        }
                                                    ?>
                                                </div>    
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Descrição</label>
                                                <textarea name="desc" id="desc"  rows="4" class="form-control shadown-none" required></textarea>
                                            </div>
                                            <input type="hidden" name="quartos_id">                                                     
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
                    <!-- Modal -->
                    <div class="modal fade" id="quartos_image" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Nome do Quarto</h1>
                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <div class="modal-body">
                                <div id="image-alert"></div>
                                <div class="border-bottom border-3 pb-3 mb-3">
                                    <form id="add_image_form" method="post">
                                            <label class="form-label fw-bold">Adicionar Imagem</label>
                                            <input type="file" name="image" id="image" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3" required>
                                            <button class="btn custom-bg text-white shadown-none">ADD</button>
                                            <input type="hidden" name="quarto_id">
                                    </form>
                                </div>
                                <div class="table responsive-lg" style="height: 350px; overflow-y: scroll;">
                                <table class="table table-hover border text-center">
                                    <thead>
                                        <tr class="bg-dark text-light sticky-top">
                                            <th scope="col" width="60%">Imagem</th>
                                            <th scope="col">Thumb</th>
                                            <th scope="col">Deletar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="quartos_image_data">
                                    </tbody>
                                </table>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


        <?php require("../Views/scripts.php");?>

        <script>

            let form_quartos = document.getElementById('form-quartos');
            form_quartos.addEventListener('submit',(e)=>{
                e.preventDefault();
                add_quartos();

            });

            function add_quartos(){
                let formData = new FormData();
                formData.append('add_quartos', '');
                formData.append('nome',form_quartos.elements['nome'].value);
                formData.append('area',form_quartos.elements['area'].value);
                formData.append('preco',form_quartos.elements['preco'].value);
                formData.append('quant',form_quartos.elements['quant'].value);
                formData.append('adulto',form_quartos.elements['adulto'].value);
                formData.append('crianca',form_quartos.elements['crianca'].value);
                formData.append('desc',form_quartos.elements['desc'].value);
                
                let caracteristicas = [];
                form_quartos.elements['caracteristica'].forEach(el =>{
                    if(el.checked){
                        caracteristicas.push(el.value);
                    }
                });

                let acomadacao = [];
                form_quartos.elements['acomadacao'].forEach(el =>{
                    if(el.checked){
                        acomadacao.push(el.value);
                    }
                });

                formData.append('caracteristica',JSON.stringify(caracteristicas));
                formData.append('acomadacao',JSON.stringify(acomadacao));

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/reg_quartos.php",true);
                    xhr.onload = function(){

                        var modal_config = document.getElementById('quartos_add');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();
                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','Novo Quarto Adicionado');
                            form_quartos.reset();
                            gets_quartos();
                        }else{ Alert('error','Falha no Servidor');}
                    }
                    xhr.send(formData);      
            }

            function gets_quartos(){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/reg_quartos.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){

                    document.getElementById('quartos_data').innerHTML = this.responseText;
                    
                }
                xhr.send('gets_quartos');
            }

            function trocar_Status(id,val){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/reg_quartos.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    if(this.responseText.trim() == 1){
                        Alert('success','Status Trocado');
                        gets_quartos();
                    }else{ Alert('error','Falha no Servidor');}
                }
                xhr.send('trocar_Status='+encodeURIComponent(id)+'&value='+encodeURIComponent(val));
            }

            let form_quartos_edit = document.getElementById('form_quartos_edit');
            form_quartos_edit.addEventListener('submit',(e)=>{
                e.preventDefault();
                submit_edit_quarto();

            });


            function edit_detalhes(id){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/reg_quartos.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

               
                xhr.onload = function(){
                    let data = JSON.parse(this.responseText.trim());
                    
                    form_quartos_edit.elements['nome'].value = data.quartos_data[0].nome;
                    form_quartos_edit.elements['area'].value = data.quartos_data[0].area;
                    form_quartos_edit.elements['preco'].value = data.quartos_data[0].preco;
                    form_quartos_edit.elements['quant'].value = data.quartos_data[0].quant;
                    form_quartos_edit.elements['adulto'].value = data.quartos_data[0].adulto;
                    form_quartos_edit.elements['crianca'].value = data.quartos_data[0].crianca;
                    form_quartos_edit.elements['desc'].value = data.quartos_data[0].descricao;
                    form_quartos_edit.elements['quartos_id'].value = data.quartos_data[0].id;

            
                    form_quartos_edit.elements['caracteristica[]'].forEach(el => {
                        if (data.caracteristica.indexOf(Number(el.value)) !== -1) {
                            el.checked = true;
                        }
                });

                    form_quartos_edit.elements['acomadacao[]'].forEach(el => {
                        if (data.acomadacao.indexOf(Number(el.value)) !== -1) {
                            el.checked = true;
                        }
                    }); 

                }
                xhr.send('get_quartos='+encodeURIComponent(id));
            }

            function submit_edit_quarto(){
                let formData = new FormData();
                formData.append('edit_quarto', '');
                formData.append('quartos_id', form_quartos_edit.elements['quartos_id'].value);
                formData.append('nome',form_quartos_edit.elements['nome'].value);
                formData.append('area',form_quartos_edit.elements['area'].value);
                formData.append('preco',form_quartos_edit.elements['preco'].value);
                formData.append('quant',form_quartos_edit.elements['quant'].value);
                formData.append('adulto',form_quartos_edit.elements['adulto'].value);
                formData.append('crianca',form_quartos_edit.elements['crianca'].value);
                formData.append('desc',form_quartos_edit.elements['desc'].value);
                
                let caracteristicas = [];
                form_quartos_edit.elements['caracteristica[]'].forEach(el =>{
                    if(el.checked){
                        caracteristicas.push(el.value);
                    }
                });

                let acomadacao = [];
                form_quartos_edit.elements['acomadacao[]'].forEach(el =>{
                    if(el.checked){
                        acomadacao.push(el.value);
                    }
                });

                formData.append('caracteristica',JSON.stringify(caracteristicas));
                formData.append('acomadacao',JSON.stringify(acomadacao));

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/reg_quartos.php",true);
                    xhr.onload = function(){

                        var modal_config = document.getElementById('quartos_edit');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();

                        if(this.responseText.trim() == 1){
                            Alert('success','Quarto Editado');
                            form_quartos_edit.reset();
                            gets_quartos();
                        }else{ Alert('error','Falha no Servidor');}
                    }
                    xhr.send(formData);      
            }

            let add_image_form= document.getElementById('add_image_form');
            add_image_form.addEventListener('submit',function(e){
                e.preventDefault();
                add_image();
            });

            function add_image(){
                let formData = new FormData();
                formData.append('image',add_image_form.elements['image'].files[0]);
                formData.append('quarto_id',add_image_form.elements['quarto_id'].value);
                formData.append('add_image', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/reg_quartos.php",true);
                    xhr.onload = function(){

                        /*var modal_config = document.getElementById('quartos_image');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();*/

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 'inv_img'){
                            Alert('error','Somente JPG, WEBP ou PNG','image-alert');
                        }else if(this.responseText.trim() == 'inv_size'){
                            Alert('error','A imagem deve ter menos 2MB!','image-alert');
                        }else if(this.responseText.trim() == 'upd_failed'){
                            Alert('error','Upload não foi feito com Sucesso!','image-alert');
                        }else{
                            Alert('success','Nova image adicionada','image-alert');
                            quarto_image(add_image_form.elements['quarto_id'].value,document.querySelector("#quartos_image .modal-title").innerText)
                            add_image_form.reset();
                        }
                    }
                    xhr.send(formData);    
            }

            function rem_image(img_id,quarto_id){
                let formData = new FormData();
                formData.append('image_id',img_id);
                formData.append('quartos_id',quarto_id);
                formData.append('rem_image', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/reg_quartos.php",true);
                    xhr.onload = function(){

                        /*var modal_config = document.getElementById('quartos_image');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();*/

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','Imagem Removida','image-alert');
                            quarto_image(quarto_id,document.querySelector("#quartos_image .modal-title").innerText);
                        }else{
                            Alert('error','Falha em Remover a Imagem','image-alert');
                            add_image_form.reset();
                        }
                    }
                    xhr.send(formData);    
            }

            function thumb_image(img_id,quarto_id){
                let formData = new FormData();
                formData.append('image_id',img_id);
                formData.append('quartos_id',quarto_id);
                formData.append('thumb_image', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/reg_quartos.php",true);
                    xhr.onload = function(){

                        /*var modal_config = document.getElementById('quartos_image');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();*/

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','A Imagem da Thumbnail Mudada','image-alert');
                            quarto_image(quarto_id,document.querySelector("#quartos_image .modal-title").innerText);
                        }else{
                            Alert('error','Falha em Remover a Imagem da Thumbnail','image-alert');
                            add_image_form.reset();
                        }
                    }
                    xhr.send(formData);    
            }

            function quarto_image(id,rname){
                document.querySelector("#quartos_image .modal-title").innerText = rname;
                add_image_form.elements['quarto_id'].value = id;
                add_image_form.elements['image'].value = '';

                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/reg_quartos.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
            
                xhr.onload = function(){
                    document.getElementById('quartos_image_data').innerHTML = this.responseText;
                }

                xhr.send('get_image='+encodeURIComponent(id));

            }

            function remove_quarto(id){
                if(window.confirm("Atenção! Queres mesmo Deletar este Quarto?")){
                    let formData = new FormData();
                    formData.append('quartos_id',id);
                    formData.append('remove_quarto', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/reg_quartos.php",true);
                    xhr.onload = function(){

                        /*var modal_config = document.getElementById('quartos_image');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();*/

                        console.log(this.responseText.trim());
                        if(this.responseText.trim() == 1){
                            Alert('success','Quarto Removido!');
                            gets_quartos();

                        }else{
                            Alert('error','Falha em Remover o Quarto');
                            add_image_form.reset();
                        }
                    }
                    xhr.send(formData);    
                }
                
 
            }

            window.onload = function(){
                gets_quartos();

            }
            
        

                    
        </script>
    </body>
</html>
