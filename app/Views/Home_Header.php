<?php

/*
	Nome: Cabeçario da Pagina
	Copyright: 2022-2023 © Herman&Joel
	Data de Criação: 08/12/22 22:32
    Data de Ultima Revisão: 18/07/23 13:06
	Descrição: Aqui tem a estruturação em html do cabeçario da nossa pagina, aqui tambem fica o modal do login e do Registro e tamb do recuperacao 

*/

?>

            <header>
                <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-light px-lg-3 py-lg-2 shadow-sm sticky-top">
                    <div class="container-fluid">
                        <a class="navbar-brand me-5 fw-bold fs-3 h-fonte" href="/Projecto-Final/app/Views/Index.php"><img id="navImg" src="../../public/media/LOGO.png" alt="Logotipo_de_Imagem"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                              <!-- <li class="nav-item">
                                    <a class="nav-link me-2" aria-current="page" href="/Projecto-Final/app/Views/Index.php">Página Inicial</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link me-2" href="/Projecto-Final/app/Views/Home_Quartos.php">Quartos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-2" href="/Projecto-Final/app/Views/Home_Nosso-Servicos.php">Acomadações & Serviços</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-2" href="/Projecto-Final/app/Views/Home_Contate-Nos.php">Fale Connosco</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-2" href="/Projecto-Final/app/Views/Home_Sobre_nos.php">Sobre-Nos</a>
                                </li>
                            </ul>
                            <div class="d-flex">
                                <?php 
                                        session_start();
                                        if(isset($_SESSION['login']) && $_SESSION['login'] ==true) {
                                        $path = USER_IMAGE_PATH;
                                        echo <<<data
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                <img src="$path$_SESSION[uPic]" style="width: 30px; height: 30px;" class="me-1 rounded-circle">
                                                $_SESSION[uName]
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg-end">
                                                <li><a class="dropdown-item" href="perfil.php"><i class="bi bi-person-lines-fill"></i> Perfil</a></li>
                                                <li><a class="dropdown-item" href="Home_reservas.php"><i class="bi bi-journal-plus"></i> Reserva</a></li>
                                                <li><a class="dropdown-item" href="../Controllers/user_logout.php"><i class="bi bi-box-arrow-right"></i> Sair</a></li>
                                            </ul>
                                        </div>
                                      data;
                                      }else{
                                        echo <<<data
                                                <button class="btn btn-outline-dark shadow-none me-lg-3 me-3"  data-bs-toggle="modal" data-bs-target="#Model_entrar">Login</button>
                                                <button class="btn btn-outline-primary shadow-none" data-bs-toggle="modal" data-bs-target="#Model_Registro">Registar</button>
                                        data;
                                      }
                                ?>
                            </div>
                        </div>
                    </div>
                </nav>
            <!-- Tela de Logar ao Sistema-->
            <div class="modal fade" id="Model_entrar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="login_user" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-person-circle me-2"></i>Tela de Login</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Endereço do E-mail/Número do Telemovel</label>
                                    <input name="user_login" id="user_login" required type="text" class="form-control shadow-none">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Password</label>
                                    <input name="user_pass" id="user_pass" required type="password" class="form-control shadow-none">
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <button name="login"   type="submit" class="btn btn-outline-dark shadow-none">Entrar</button>
                                    <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0"  data-bs-toggle="modal" data-bs-target="#Model_PassEQ" data-bs-dismiss="modal" >Esqueceu o Password?</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Tela de Registro-->
            <div class="modal fade" id="Model_Registro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="registro_user" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-person-vcard me-2"></i>Tela de Registro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!--<span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                                    Atenção!: Se identifica correctamente,ensira os dados(Nome,Número de indentidade(passaporte,Bilhete,etc),Telefone,etc...) com cautela.
                                </span>-->
                                <div class="container-fluid">
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
                                            <label class="form-label fw-bold ">E-mail</label>
                                            <input type="email" name="email" id="email" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Números de Telefone(com codigo do país)</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
                                                <input type="text" name="tel" id="tel" class="form-control shadow-none" required >
                                            </div>
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
                                            <label class="form-label fw-bold">Foto de Perfil</label>
                                            <input type="file" name="profile" id="profile" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6  mb-3">
                                            <label class="form-label fw-bold">Numero de identidade(passaporte,Bilhete,etc)</label>
                                            <input type="text" name="n_ide" id="n_ide" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Data de Nascimento</label>
                                            <input type="date" name="data_nas" id="data_nas" class="form-control shadow-none" max="<?php echo date('Y-m-d');?>" min="1900-01-01" required >
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label fw-bold">Endereço de Morada</label>
                                            <textarea name="endereco" id="endereco" class="form-control shadow-none" rows="1" required ></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Password</label>
                                            <input name="pass" id="pass" type="password" class="form-control shadow-none" required >
                                        </div>
                                        <div class="col-md-6  mb-3">
                                            <label class="form-label fw-bold">Confirma Password</label>
                                            <input name="v_pass" id="v_pass" type="password" class="form-control shadow-none" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center my-1">
                                    <button type="submit"  class="btn btn-dark shadow-none">Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="Model_PassEQ" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="passEq-form" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-person-circle me-2"></i>Tela de Recuperamento da Senha</h5>
                               <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                            </div>
                            <div class="modal-body">
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                                    Atenção!: Ensira seu Email para recuperar a sua senha.
                                </span>
                                <div class="mb-3">
                                    <label class="form-label">Endereço do E-mail</label>
                                    <input name="email" id="email" required type="email" class="form-control shadow-none">
                                </div>
                                <div class="mb-2 text-end">
                                    <button type="button" class="btn  shadow-none p-0 me-2"  data-bs-toggle="modal" data-bs-target="#Model_entrar" data-bs-dismiss="modal">Saia</button>
                                    <button name="" type="submit" class="btn btn-dark shadow-none">Enviar o link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            </header>

            <script>

                function Alert(type,msg){
                let bg_class = (type == "success") ? "alert-success" : "alert-danger";
                let elemento = document.createElement('div');

                    elemento.innerHTML = `<div class="alert ${bg_class} alert-dismissible fade show custom-alert" role="alert">
                        <strong class="me-3">${msg}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;

                    /*if(position=='body'){
                        document.body.append(elemento);
                        elemento.classList.add('custom-alert');
                    }else{
                        document.getElementById(position).appendChild(elemento);
                    }*/
                    //setTimeout(remAlert(),2000);
                        
                document.body.append(elemento);
            }
                
            </script>