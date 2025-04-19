<?php

session_start();
require("../Models/Database.php");
require("../Controllers/essencial.php");
date_default_timezone_set('Africa/Luanda');

if(!isset($_SESSION['rol'])){
    header('location: index.php');
}else if($_SESSION['rol']!= 2){
    header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("../Views/Links.php");?>
    <title>Pagina de Controle - Recipcionista</title>
</head>
<body class="bg-light">
    <!-- Header Page -->
    <!-- /Header Page/ -->
    <!-- Navbar Page -->
    <?php  
        require("../Admin/Recip_header.php");
    ?>
    <!-- /Navbar Page/ -->

    <?php  
        require("../Admin/Admin_dashboard.php");
    ?>

    <div class="modal fade" id="Rec" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="recup_form" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-shield-lock fs-3 me-2"></i>Tela para Inserir nova Senha</h5>
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nova Senha</label>
                                        <input name="pass" id="pass" required type="pass" class="form-control shadow-none">
                                        <input type="hidden" name="email">
                                    </div>
                                    <div class="mb-2 text-end">
                                        <button type="submit" class="btn btn-dark shadow-none">Envia</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
            <?php

            $S_existe = Selecao($Conexao, "SELECT * FROM user_admin,pessoa,contactos WHERE user_admin.id_pessoa = pessoa.id_pessoa and pessoa.id_contacto = contactos.id and user_admin.id_acesso=? LIMIT 1", [$_SESSION['At']],false);
            
            if(isset($_GET['alterar_pass']) && $S_existe[0]["verif"]==0){


                if($S_existe){
                    echo <<<show
                        <script>
                            var modal_rec = document.getElementById('Rec');

                            modal_rec.querySelector("input[name='email']").value ='{$S_existe[0]['email']}';

                            var modal = bootstrap.Modal.getOrCreateInstance(modal_rec);
                            modal.show();
                        </script>
                        show;
                }else {
                    alert("error","Invalido ou link expirado!");
                }
                
            }
            
            ?>

    <script>
                        let recup_form= document.getElementById('recup_form');
                        recup_form.addEventListener('submit',(e)=>{e.preventDefault();
                                let formData = new FormData();
                                formData.append('email',recup_form.elements['email'].value);
                                formData.append('pass',recup_form.elements['pass'].value);
                                formData.append('RecPass', true);

                                modal.hide();

                                let xhr = new XMLHttpRequest();
                                xhr.open("POST","../Controllers/Admin_config.php",true);

                                xhr.onload = function(){
                                    
                                    if(this.responseText.trim() === 'failed'){
                                        Alert('error','Falha ao Recuperar Conta');
                                    }else{
                                        Alert('success','Sucesso ao alterar a senha');
                                        recup_form.reset();
                                    }
                                }
                                xhr.send(formData);              
                               
                            });

                            
        </script>
        
    <?php require("../Views/scripts.php");?>
</body>
</html>