
            <?php  
            
            //
            $se_desligado = $Conexao->prepare("SELECT desligado FROM configuracoes");
            $se_desligado-> execute();
            $d1 =  $se_desligado->fetchAll(PDO::FETCH_ASSOC);
            //
            $corrent_reservas = $Conexao->prepare("SELECT COUNT(CASE WHEN reserva_status='reservado' AND chegada=0 THEN 1 END) AS new_reservas,
            COUNT(CASE WHEN reserva_status='Cancelado' AND reembolso=0 THEN 1 END) AS refund_reservas FROM reserva_pedido");
            $corrent_reservas-> execute();
            $d2 = $corrent_reservas ->fetchAll(PDO::FETCH_ASSOC);
            //
            $cm = $Conexao->prepare("SELECT COUNT(id_uc) AS count FROM mensagem WHERE visto=0");
            $cm -> execute();
            $d3= $cm ->fetchAll(PDO::FETCH_ASSOC);
            //
            $cr = $Conexao->prepare("SELECT COUNT(id_rr) AS count FROM rating_review WHERE visto=0");
            $cr -> execute();
            $d4= $cr ->fetchAll(PDO::FETCH_ASSOC);
            //
            $corrent_usuarios = $Conexao->prepare("SELECT COUNT(id_user) AS total , COUNT(CASE WHEN status=1 THEN 1 END) AS activo, COUNT(CASE WHEN status=0 THEN 1 END) AS inativo,
            COUNT(CASE WHEN se_verificado=0 THEN 1 END) AS nao_verificado FROM user_home WHERE not id_user=3");
            $corrent_usuarios-> execute();
            $d5 =  $corrent_usuarios ->fetchAll(PDO::FETCH_ASSOC);
            
            ?>
        <!-- -->

        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3>DASHBOARD</h3>
                        <?php 
                            if ($d1[0]["desligado"]) {
                                echo <<<data
                                        <h6 class="badge bg-danger py-2 px-3 rounded">Modo Desligamento activado!</h6>
                                    data;
                            }
                        ?>
                        
                    </div>

                    <div class="row mb-4">

                        <div class="col-md-3 mb-4">
                            <a href="new_reservas.php" class="text-decoration-none">
                                <div class="card text-center text-success p-3">
                                    <h6>Novas Reservas</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $d2[0]["new_reservas"];?></h1>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-4">
                            <a href="refund_reservas.php" class="text-decoration-none">
                                <div class="card text-center text-warning p-3">
                                    <h6>Reservas de reembolso</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $d2[0]["refund_reservas"];?></h1>
                                </div>              
                            </a>
                        </div>

                        <div class="col-md-3 mb-4">
                            <a href="user_queries.php" class="text-decoration-none">
                                <div class="card text-center text-info p-3">
                                    <h6>Nª de mensagens</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $d3[0]["count"];?></h1>
                                </div>
                            </a>
                        </div>
                    
                        <div class="col-md-3 mb-4">
                            <a href="Avaliações_Review.php" class="text-decoration-none">
                                <div class="card text-center text-info p-3">
                                    <h6>Rating & Review</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $d4[0]["count"] ?></h1>
                                </div>
                            </a>
                        </div>

                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3>Analises das Reservas</h3>
                        <select class="form-select shadow-none bg-light w-auto" onchange="Analise_da_Reservas(this.value)">
                            <option value="1">De 1 semana</option>
                            <option value="2">De 30 dias</option>
                            <option value="3">De 90 dias</option>
                            <option value="4">De 1 ano</option>
                            <option value="5">De todo tempo</option>
                        </select>
                    </div>

                   <div class="row mb-3">
                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-primary p-3">
                                    <h6>Reservas Totais</h6>
                                    <h1 class="mt-2 mb-0" id="totais">0</h1>
                                    <h4  class="mt-2 mb-0" id="totais_kz">0 kz</h4>
                                </div>
                        </div>
                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-success p-3">
                                    <h6>Reservas Activas</h6>
                                    <h1 class="mt-2 mb-0" id="RA_t">>0</h1>
                                    <h4 class="mt-2 mb-0" id="RA_kz">0 KZ</h4>
                                </div>
                        </div>
                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-danger p-3">
                                    <h6>Reservas Canceladas</h6>
                                    <h1 class="mt-2 mb-0" id="RC_t">0</h1>
                                    <h4 class="mt-2 mb-0" id="RC_kz">0 KZ</h4>
                                </div>
                        </div>

                        

                    </div>


                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3>Analises dos Usuario , mensagens</h3>
                        <select class="form-select shadow-none bg-light w-auto" onchange="Analise_da_User(this.value)">
                            <option value="1">De 1 semana</option>
                            <option value="2">De 30 dias</option>
                            <option value="3">De 90 dias</option>
                            <option value="4">De 1 ano</option>
                            <option value="5">De todo tempo</option>
                        </select>
                    </div>

                  <div class="row mb-3">

                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-success  p-3">
                                    <h6>Novos Registros</h6>
                                    <h1 class="mt-2 mb-0" id="d3">0</h1>
                                </div>
                        </div>
                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-primary p-3">
                                    <h6>Mensagens</h6>
                                    <h1 class="mt-2 mb-0" id="d2">0</h1>
                                </div>
                        </div>

                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-success p-3">
                                    <h6>Reviews</h6>
                                    <h1 class="mt-2 mb-0" id="d1">0</h1>
                                </div>
                        </div>
                    

                        

                    </div>
                    <h5>Usuarios</h5>
                     <div class="row mb-3">

                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-info p-3">
                                    <h6>Totais</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $d5[0]["total"];?></h1>
                                </div>
                        </div>
                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-success p-3">
                                    <h6>Activos</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $d5[0]["activo"];?></h1>
                                </div>
                        </div>
                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-warning p-3">
                                    <h6>Inativos</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $d5[0]["inativo"];?></h1>
                                </div>
                        </div>
                        <div class="col-md-3 mb-4"> 
                                <div class="card text-center text-danger p-3">
                                    <h6>Não-verificado</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $d5[0]["nao_verificado"];?></h1>
                                </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <?php require('../Views/scripts.php');?>
<script>
    function Analise_da_Reservas(periodo=1) {
        let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/dashboard.php",true);
                    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                    xhr.onload = function(){
                        let data = JSON.parse(this.responseText);
                        console.log(data);
                        document.getElementById('totais_kz').textContent = data[0].pagamento_total;
                        document.getElementById('totais').textContent = data[0].total_reservas;

                        document.getElementById('RA_kz').textContent = data[0].pagamento_activo;
                        document.getElementById('RA_t').textContent = data[0].reservas_activa;

                        document.getElementById('RC_kz').textContent = data[0].sum_reservas;
                        document.getElementById('RC_t').textContent = data[0].refund_reservas;
                        
                    }
                    xhr.send('Analise_da_Reservas&periodo='+encodeURIComponent(periodo));
        
    }

    function Analise_da_User(periodo=1) {
        let xhr = new XMLHttpRequest();
                    xhr.open("POST","../Controllers/dashboard.php",true);
                    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                    xhr.onload = function(){
                        let data = JSON.parse(this.responseText);
                        console.log(data);
                        document.getElementById('d3').textContent = data.d3;
                        document.getElementById('d2').textContent = data.d2;
                        document.getElementById('d1').textContent = data.d1;    
                    }
                    xhr.send('Analise_da_User&periodo='+encodeURIComponent(periodo));
        
    }

    window.onload = function(){
        Analise_da_Reservas();
        Analise_da_User();
        }
</script>