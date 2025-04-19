<?php

session_start();

if(!isset($_SESSION['rol'])){
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
        <title>Pagina de Controle - Novas Reservas</title>

    </head>
    <body class="bg-light">
        <!-- -->

            <?php  
                if($_SESSION['rol']== 1){
                    require("../Admin/Admin_header.php");
                } else{
                    require("../Admin/Recip_header.php");
                }
    
                #style="height: 450px; overflow-y: scroll;"
            ?>

            

        <!-- -->
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Reservas / Novas Reservas</div>
                        <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="text-end mb-4">
                                <button type="button" class="btn btn-dark shadow-none btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#reserva_add">
                                    <i class="bi bi-plus-square"></i>  Adicionar Reserva
                                </button>
                                <input type="text" id="pes_page" oninput="get_reserva(this.value)" class="form-control shadow_none w-25 ms-auto" placeholder="Pesquise Reservas">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover border">
                                    <thead>
                                        <tr class="bg-dark text-light" style="min-width: 1200px;">
                                            <th scope="col">Nª</th>
                                            <th scope="col">Detalhes do Usuario</th>
                                            <th scope="col">Detalhes do Quartos</th>
                                            <th scope="col">Detalhes da Reserva</th>
                                            <th scope="col">Acção</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_data">
                                    </tbody>
                                </table>    
                            </div>
                            <nav>
                                <ul class="pagination mt-3" id="table_pagination">
                                </ul>
                            </nav>
                        </div>
                        </div>

                    </div>  
                    
                    <!-- -->
                </div>
            </div>
            <div class="modal fade" id="reserva_add" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="reserva_form" autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar Reserva</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Nome</label>
                                                <input type="text" name="nome" id="nome" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Número de Telefone</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="tel" id="tel" class="form-control shadow-none" required >
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Endereço</label>
                                                <input type="text" name="endereco" id="endereco" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Tipo de Quarto</label>
                                                <select class="form-control shadow-none" onchange="check_disponivel()" type="tipo_quarto" name="tipo_quarto" required>
                                                    <?php 
                                                        $q = "SELECT nome FROM quartos where removido=0";
                                                        $datab = Selecao($Conexao,$q,$q,false);
                                                        foreach ($datab as $data) {
                                                            echo <<<data
                                                                <option value="$data[nome]" name="tipo_quarto">$data[nome]</option>
                                                            data;
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Check-in</label>
                                                <input type="date" name="entrada" onchange="check_disponivel()" class="form-control shadow-none" min="<?php echo date('Y-m-d');?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Check-out</label>
                                                <input type="date" name="saida" onchange="check_disponivel()" class="form-control shadow-none" min="<?php echo date('Y-m-d',strtotime('+1 day'));?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                            <label class="form-label">Tipo de Pagamento</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="Pag" id="pagamento-chegada" value="pagamento_chegada" required>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Multicaixa
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="Pag" id="transferencia-bancaria" value="transferencia_bancaria" required>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Dinheiro em mão
                                                </label>
                                            </div>
                                            <input type="hidden" name="admin">
                                        </div>
                                        <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                                <span class="visually-hidden">Processando...</span>
                                            </div>
                                            <h6 class="mb-3 text-danger" id="pay_info">Forneça a data do Check-in(entrada) & Check-out(saida)!</h6>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset"  class="btn text-secondary shadown-none" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" nome="pay_now" id="pay_now" class="btn custom-bg text-white shadown-none" disabled>Finalizar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <script>

                                let reserva_form = document.getElementById("reserva_form");
                                let info_loader = document.getElementById("info_loader");
                                let pay_info = document.getElementById("pay_info");

                                function check_disponivel(){
                                    let entrada_val = reserva_form.elements['entrada'].value;
                                    let saida_val = reserva_form.elements['saida'].value;
                                    let tipo_quarto = reserva_form.elements['tipo_quarto'].value;


                                    reserva_form.elements['pay_now'].setAttribute('desabled',true);

                                    if(entrada_val!='' && saida_val!=''){
                                        pay_info.classList.add('d-none');
                                        pay_info.classList.replace('text-dark','text-danger');
                                        info_loader.classList.remove('d-none');

                                        let data = new FormData();

                                        data.append('check_admin','');
                                        data.append('entrada',entrada_val);
                                        data.append('saida',saida_val);
                                        data.append('tipo_quarto',tipo_quarto);

                                        let xhr = new XMLHttpRequest();
                                        xhr.open("POST","../Controllers/reserva_confirm.php",true);
                                        xhr.onload = function(){
                                            console.log(this.responseText.trim());
                                            let data = JSON.parse(this.responseText.trim());
                                            if(data.status.trim() == 'check_in_out_iguais'){
                                                pay_info.innerText = "Você não pode fazer check-out(saida) no mesmo dia ";
                                            }else if(data.status.trim() == 'check_out_cedo'){
                                                pay_info.innerText = "A data de check_out é anterior à data de check-in";
                                            }else if(data.status.trim() == 'check_in_cedo'){
                                                pay_info.innerText = "A data de check_in é anterior à data de hoje!";
                                            }else if(data.status.trim() == 'Indisponivel'){
                                                pay_info.innerText = "Quarto indisponivel para esta data de check-in!";
                                            }else{
                                                pay_info.innerHTML ="Núm. de dias: "+data.dias+"<br>Total de dinheiro a pagar: "+data.pagamento;
                                                pay_info.classList.replace('text-danger','text-dark');
                                                reserva_form.elements['pay_now'].removeAttribute('disabled');
                                            }

                                            pay_info.classList.remove('d-none');
                                            info_loader.classList.add('d-none');
                                            
                                            }
                                            xhr.send(data);  
                                    }
                                }


                                let form_reg = document.getElementById('reserva_form');
                                form_reg.addEventListener('submit',(e)=>{
                                e.preventDefault();
                                let formData = new FormData(form_reg);

                                var modal_config = document.getElementById('reserva_add');
                                    var modal = bootstrap.Modal.getInstance(modal_config);
                                    modal.hide();

                                let xhr = new XMLHttpRequest();
                                xhr.open("POST","../Controllers/reserva_finalizacao.php",true);
                
                                xhr.onload = function(){
                                    console.log(this.responseText.trim());

                                    if(this.responseText.trim() == 0){
                                        Alert('error','Houve um problema em Reservar');
                                    }else{
                                        Alert('success','Reservado com Sucesso');
                                        get_reserva();
                                        form_reg.reset();
                                    }
                                    
                                }
                                xhr.send(formData);
                            });
                        </script>
                    </div>
                    <!-- -->
                    <div class="modal fade" id="atribuir_quarto" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" id="form-atribuir">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Atribuir Quarto</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Número do Quarto</label>
                                            <input type="text" name="num_quarto" id="num_quarto" class="form-control shadow-none" required>
                                        </div>
                                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                                            Atenção!:  Atribuia o número do Quarto, somente quando hospede chegar ao estabelecimento!
                                        </span>
                                        <input type="hidden" name="id_reserva">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset"  class="btn text-secondary shadown-none" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn custom-bg text-white shadown-none">Atribuir</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
        
        
        <?php require("../Views/scripts.php");?>

        <script>

                ///
                function get_reserva(search='',page=1){
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/nova_reservas.php",true);
                    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                    xhr.onload = function(){
                        let data = JSON.parse(this.responseText);
                        document.getElementById('table_data').innerHTML = data.table_data;
                        document.getElementById('table_pagination').innerHTML = data.paginacao; 
                    }
                    xhr.send('get_reserva&search='+encodeURIComponent(search)+'&page='+page);
                }

                function change_page(page){
                    get_reserva(document.getElementById('pes_page').value,page);
                }


                let atribuir_quarto_form = document.getElementById("form-atribuir");

                function atribuir_quarto(id){
                    atribuir_quarto_form.elements["id_reserva"].value = id;
                }
                
                atribuir_quarto_form.addEventListener("submit",function(e){
                    e.preventDefault();
                    
                    let formData = new FormData();
                    formData.append('num_quarto',atribuir_quarto_form.elements['num_quarto'].value);
                    formData.append('id_reserva',atribuir_quarto_form.elements['id_reserva'].value);
                    formData.append('atribui_quarto',"");

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/nova_reservas.php",true);
                    xhr.onload = function(){

                        var modal_config = document.getElementById('atribuir_quarto');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();

                        if(this.responseText ==1){
                            Alert("success","Numero do Quarto Alocado! Reserva realizada com Sucesso");
                            atribuir_quarto_form.reset();
                            get_reserva();
                        }else{
                            Alert("error","Servidor caiu!");
                        }
                    }
                    xhr.send(formData);    
                });

                function cancelar_reserva(id){

                    if(window.confirm("Atenção! Queres mesmo Cancelar esta Reserva?")){
                    let formData = new FormData();
                    formData.append('reserva_id',id);
                    formData.append('cancelar_reserva', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/nova_reservas.php",true);
                    xhr.onload = function(){

                        /*var modal_config = document.getElementById('quartos_image');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();*/
                        console.log(this.responseText);
                        if(this.responseText.trim() == 1){
                            Alert('success','Reserva Cancelado com Sucesso!');
                            get_reserva();

                        }else{
                            Alert('error','Falha em Cancelar a Reserva');
                        }
                    }
                    xhr.send(formData);    

                }
            }
        

            window.onload = function(){
                get_reserva();

            }
        </script>
    </body>
</html>
