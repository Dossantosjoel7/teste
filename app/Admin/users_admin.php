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
        <title>Pagina de Controle - Usuarios Administrativos</title>

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
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Usuarios do Sistema / Usuarios Administrativos </div>
                        <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="text-end mb-4">
                                <input type="text" id="pes_page" oninput="get_admin(this.value)" class="form-control shadow_none w-25 ms-auto" placeholder="Pesquise o Usuario">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover border text-center" style="min-width: 1300px;">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th scope="col">Nª</th>
                                            <th scope="col">Utilizador</th>
                                            <th scope="col">Tipo de Perfil</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user_admin">
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

            function get_admin(username='',page=1){
                let xhr = new XMLHttpRequest();
                xhr.open("POST","../Controllers/gets_user.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function(){
                    let data = JSON.parse(this.responseText);
                    document.getElementById('user_admin').innerHTML = data.user_admin;
                    document.getElementById('table_pagination').innerHTML = data.paginacao; 
                }
                xhr.send('ver_admin&username='+encodeURIComponent(username)+'&page='+page);
            }

            function change_page(page){
                get_admin(document.getElementById('pes_page').value,page);
            }

            window.onload = function(){
                get_admin();

            }
            
        

                    
        </script>
    </body>
</html>
