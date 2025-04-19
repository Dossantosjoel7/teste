
<?php

/*
	Nome: Rodape da Pagina
	Copyright: 2022-2023 © Herman&Joel
	Data de Criação: 08/12/22 22:38
    Data de Ultima Revisão: 18/07/23 13:13
	Descrição: Aqui tem a estruturação em html do Rodape da nossa pagina

*/

?>
        <footer class="container-fluid  bg-white">
            <div class="row">
                <div class="col-lg-4 p-4">
                    <h3 class="h-fonte fw-bold fs-3 mb-2"><?php echo $contactos[0]['site_titulo'];?></h3>
                    <address>
                        <?php echo $contactos2[0]['endereco'];?>
                    </address>
                    
                </div>
                <div class="col-lg-4 p-4">
                    <h5>Links</h5>
                    <a href="/Projecto-Final/app/Views/Index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Pagina inicial</a><br>
                    <a href="/Projecto-Final/app/Views/Home_Quartos.php" class="d-inline-block mb-2 text-dark text-decoration-none">Quartos</a><br>
                    <a href="/Projecto-Final/app/Views/Home_Nosso-Servicos.php" class="d-inline-block mb-2 text-dark text-decoration-none">Acomadações & Serviços</a><br>
                    <a href="/Projecto-Final/app/Views/Home_Contate-Nos.php" class="d-inline-block mb-2 text-dark text-decoration-none">Fale Connosco</a><br>
                    <a href="/Projecto-Final/app/Views/Home_Sobre_nos.php" class="d-inline-block mb-2 text-dark text-decoration-none">Sobre-Nós</a><br>
                </div>
                <div class="col-lg-4 p-4">
                    <h5 class="mb-3">Segue-nos</h5>
                    <a href="<?php echo $contactos2[0]['fb'];?>" class="d-inline-block text-dark text-decoration-none mb-2">
                        <i class="bi bi-facebook me-1"></i>Facebook
                    </a><br>
                    <a href="<?php echo $contactos2[0]['insta'];?>" class="d-inline-block text-dark text-decoration-none mb-2">
                        <i class="bi bi-instagram me-1"></i>Instagram
                    </a><br>
                    <a href="<?php echo $contactos2[0]['wt']?>" class="d-inline-block text-dark text-decoration-none mb-2">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </a>
                </div>
            </div>
        </footer>
        <h6 class=" bg-dark text-center text-white p-1 m-0">2022-2023 &copy; Herman&Joel</h6>
    
    <script>

        function setActive() {
            let navbar = document.getElementById('nav-bar');
            let a_tags = navbar.getElementsByTagName('a');

            for(i=0; i<a_tags.length; i++){
                let file = a_tags[i].href.split('/').pop();
                let file_name = file.split('.')[0];

                if(document.location.href.indexOf(file_name) >=0){
                    a_tags[i].classList.add('active');
                }
            }
        }


        let form_login = document.getElementById('login_user');
        form_login.addEventListener('submit',(e)=>{e.preventDefault();
            let formData = new FormData();
            formData.append('user_pass',form_login.elements['user_pass'].value);
            formData.append('user_login',form_login.elements['user_login'].value);
            formData.append('userlogin', true);


            var modal_config = document.getElementById('Model_entrar');
                var modal = bootstrap.Modal.getInstance(modal_config);
                modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST","../Controllers/User_form.php",true);
            xhr.onload = function(){
                console.log(this.responseText.trim());
                if(this.responseText.trim() === 'Email_inv'){
                    Alert('error','Inválido Email ou Numero de Telemovel');
                }else if(this.responseText.trim() === 'Nao_verificado'){
                    Alert('error','Email não Verificado');
                }else if(this.responseText.trim() === 'inativo'){
                    Alert('error','A Conta foi Suspensa! Contacte o Hotel');
                }else if(this.responseText.trim() === 'invalid_pass'){
                    Alert('error','Password Invalido');
                }else{
                    window.location = window.location.pathname;

                    let fileurl = windows.location.href.split('/').pop().split('?').shift();
                    if(fileurl == 'Home_Quartos_Detalhes.php'){
                        window.location = window.location.href;
                    }else{
                        window.location = window.location.pathname;
                    }
                    form_login.reset();
                }
            }
            xhr.send(formData);              
        
        });


                let form_reg = document.getElementById('registro_user');
                form_reg.addEventListener('submit',(e)=>{
            e.preventDefault();
            let formData = new FormData(form_reg);

            formData.append('userreg', true);

            var modal_config = document.getElementById('Model_Registro');
                var modal = bootstrap.Modal.getInstance(modal_config);
                modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST","../Controllers/User_form.php",true);

                
            xhr.onload = function(){
                console.log(this.responseText.trim());
                if(this.responseText.trim() == 'Password Iguais'){
                    Alert('error','Senhas iguais');
                }else if(this.responseText.trim() == 'Email já existe'){
                    Alert('error','Email já existe');
                }else if(this.responseText.trim() == 'Telefone já existe'){
                    Alert('error','Telefone já existe');
                }else if(this.responseText.trim() == 'Imagem Invalida'){
                    Alert('error','Somente PNG , JPEG, WEBP');
                }else if(this.responseText.trim() == 'Upload não Feito!'){
                    Alert('error','Upload não foi feito com Sucesso!');
                }else if(this.responseText.trim() == 'Email_falido'){
                    Alert('error','Erro ao enviar o Email!');
                }else if(this.responseText.trim() == 'erro_envio'){
                    Alert('error','Falha ao Registrar');
                }else{
                    Alert('success','Registro com Sucesso');
                    form_reg.reset();
                }

            }
            xhr.send(formData);
        });
//
        let passEq_form= document.getElementById('passEq-form');
        passEq_form.addEventListener('submit',(e)=>{e.preventDefault();
            let formData = new FormData();
            formData.append('email',passEq_form.elements['email'].value);
            formData.append('passEq', true);


            var modal_config = document.getElementById('Model_PassEQ');
                var modal = bootstrap.Modal.getInstance(modal_config);
                modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST","../Controllers/User_form.php",true);

                
            xhr.onload = function(){
                let formData = new FormData(form_reg);
                let dataArray = Array.from(formData.entries());
                console.log(dataArray);

               console.log(this.responseText.trim());
                if(this.responseText.trim() === 'Email_inv'){
                    Alert('error','Inválido Email ');
                }else if(this.responseText.trim() === 'Nao_verificado'){
                    Alert('error','Email não Verificado');
                }else if(this.responseText.trim() === 'inativo'){
                    Alert('error','A Conta foi Suspensa! Contacte o Hotel');
                }else if(this.responseText.trim() === 'failed'){
                    Alert('error','Falha ao enviar o Email');
                }else if(this.responseText.trim() === 'upd_failed'){
                    Alert('error','Falha ao recuperar');
                }else{
                    Alert('success','Email foi Enviado');
                    passEq_form.reset();
                }
            }
            xhr.send(formData);              

        });

        function verificalogin_reserva(status,quarto_id){
            if(status){
                window.location.href = 'Home_confirma_reserva.php?id='+quarto_id;
            }else{
                Alert('error','Por Favor faz Login para Reserva');
            }
        }

        setActive();
    </script>