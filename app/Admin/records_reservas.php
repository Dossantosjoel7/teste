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
        <title>Pagina de Controle - Registros de Reserva</title>

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
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Reservas / Registros de Reserva</div>
                        <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="text-end mb-4">
                                <input type="text" id="pes_page" oninput="get_reserva(this.value)" class="form-control shadow_none w-25 ms-auto" placeholder="Pesquise Reservas">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover border" style="min-width: 1200px;">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th scope="col">#</th>
                                            <th scope="col">Detalhes do Usuario</th>
                                            <th scope="col">Detalhes do Quartos</th>
                                            <th scope="col">Detalhes da Reserva</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Acção</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_data">
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
                </div>
            </div>

    
        
        <?php require("../Views/scripts.php");?>

        <script>
                function get_reserva(search='',page=1){
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/record_reservas.php",true);
                    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                    xhr.onload = function(){
                     let data = JSON.parse(this.responseText);
                     console.log(data);
                        document.getElementById('table_data').innerHTML = data.table_data;
                        document.getElementById('table_pagination').innerHTML = data.paginacao; 
                    }
                    
                    xhr.send('get_reserva&search='+encodeURIComponent(search)+'&page='+page);
                }

                function change_page(page){
                    get_reserva(document.getElementById('pes_page').value,page);
                }


                function download(id){
                    window.location.href = "generate_pdf.php?gen_pdf$id="+id;
                }


                function reembolso_reserva(id){

                    if(window.confirm("Atenção! Queres mesmo reembolsar o dinheiro desta Reserva?")){
                    let formData = new FormData();
                    formData.append('reserva_id',id);
                    formData.append('reembolso_reserva', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/refun_reservas.php",true);
                    xhr.onload = function(){

                        /*var modal_config = document.getElementById('quartos_image');
                        var modal = bootstrap.Modal.getInstance(modal_config);
                        modal.hide();*/
                        console.log(this.responseText);
                        if(this.responseText.trim() == 1){
                            Alert('success','Reembolsado!');
                            get_reserva();

                        }else{
                            Alert('error','Falha no Servidor!');
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
