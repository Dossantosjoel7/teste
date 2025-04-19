<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
        <h3 class="mb-0 h-fonte">Painel do Recipcionista</h3>
        <a href="http://localhost/Projecto-Final/app/Controllers/Admin_logout.php" class="btn btn-light btn-sn">Sair</a>
</div>


<div id="painel-menu" class="col-lg-2 bg-dark border-top border-3 border-secondary painel-menu">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid flex-lg-column align-items-stretch">
                    <h4 class="mt-2 text-light">Recipcionista</h4>
                    <?php 
                        if($_SESSION['Name'] == 'admin'){
                            ;
                        }else{
                            echo "<h5 class='mt-2 text-light'>".$_SESSION['Name']."</h5>";
                        }
                      ?>
                    <button class="navbar-toggler shadow-none me-2" type="button" data-bs-toggle="collapse" data-bs-target="#AdminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="AdminDropdown">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="Recip_view.php">
                                    <span class="me-2" style="font-size: 20px;" ><i class="bi bi-speedometer2 me-2" width="16" height="16"></i></span>
                                    Painel
                                </a>
                            </li>
                            <li class="nav-item">
                                <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#reserva">
                                    <span><i class="bi bi-journal-bookmark me-3" width="15" height="16"></i> Reservas</span>
                                    <span><i class="bi bi-caret-down-fill"></i></span>
                                </button>
                                <div class="collapse px-3 small mb-1" id="reserva">
                                    <ul class="nav nav-pills flex-column rounded border border-secondary">
                                        <li class="nav-item">
                                            <a class="nav-link text-white" href="../Admin/new_reservas.php"><i class="bi bi-journal-plus  me-2" width="16" height="16"></i>Novas Reservas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" href="../Admin/refund_reservas.php"><i class="bi bi-journal-x  me-2" width="16" height="16"></i>Reservas em reembolso</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" href="../Admin/records_reservas.php"><i class="bi bi-journal-text me-2" width="16" height="16"></i>Registros de reservas</a>
                                        </li>
                                    </ul>                      
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../Admin/user_queries.php">
                                    <span class="me-2" style="font-size: 20px;" ><i class="bi bi-chat-left-fill me-2" width="16" height="16"></i></span>
                                    Mensagems
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../Admin/Avaliações_Review.php">
                                    <span class="me-2" style="font-size: 20px;" ><i class="bi bi-chat-square-heart-fill me-2" width="16" height="16"></i></span>
                                    Avaliações & Review
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
s
        <script>
            function setActive() {
                let navbar = document.getElementById('painel-menu');
                let a_tags = navbar.getElementsByTagName('a');

                for(i=0; i<a_tags.length; i++){
                    let file = a_tags[i].href.split('/').pop();
                    let file_name = file.split('.')[0];

                    if(document.location.href.indexOf(file_name) >=0){
                        a_tags[i].classList.add('active');
                    }
                }
            }
            setActive();
        </script>