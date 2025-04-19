<?php 

        require("../Controllers/essencial.php");
        require("../Models/Database.php");
        date_default_timezone_set('Africa/Luanda');
        session_start();


        if (isset($_GET["fetch_room"])) {
      
            $chk_avail = json_decode($_GET["chk_avail"],true);

            if ($chk_avail["checkin"]!="" && $chk_avail["checkout"]!="") {
                $data_hoje = new DateTime(date("Y-m-d"));
                $data_entrada = new DateTime($chk_avail["checkin"]);
                $data_saida = new DateTime($chk_avail["checkout"]);

                if ($data_entrada == $data_saida) {
                        echo "<h3 class='text-center text-danger'>Datas Invalidas!</h3>";
                        exit;
                }else if ($data_saida < $data_entrada) {
                        echo "<h3 class='text-center text-danger'>Datas Invalidas!</h3>";
                        exit;
                }else if ($data_entrada < $data_hoje) {
                        echo "<h3 class='text-center text-danger'>Datas Invalidas!</h3>";
                        exit;
                    }
            }

            $hospede = json_decode($_GET["hospede"],true);
            $adultos = ($hospede['adulto'] !="") ? $hospede['adulto']:0;
            $crianca = ($hospede['crianca'] !="") ? $hospede['crianca']:0;

            $acomadacao_list = json_decode($_GET["acomadacao_list"],true);
            
            $cont_room = 0;
            $output = "";

            $quer1 = "SELECT * FROM configuracoes WHERE id_confg=?";
            $value = [1];
            $contactos = Selecao($Conexao,$quer1,$value,false);
        
            $quarto_res = Selecao($Conexao,"SELECT * FROM quartos WHERE adulto >=? AND crianca >=? AND status=? AND removido=?",[$adultos,$crianca,1,0],false);
            foreach ($quarto_res as $quarto_data) {
                if ($chk_avail["checkin"]!="" && $chk_avail["checkout"]!=""){

                    $tb_query = "SELECT COUNT(*) AS total_bookings FROM reserva_pedido WHERE reserva_status=? AND quarto_id=? AND check_out>? AND check_in<?";
                    $res = $Conexao->prepare($tb_query);
                    $res->execute(["reservado",$quarto_data["id"],$chk_avail["checkin"],$chk_avail["checkout"]]);
                    $rd= $res->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (($quarto_data["quant"] - $rd[0]["total_bookings"]) == 0) {
                        continue;
                    }
                }

                $fea_q=Selecao($Conexao,"SELECT caracteristicas.nome FROM caracteristicas
                INNER JOIN quartos_caracteristica ON caracteristicas.id = quartos_caracteristica.caracteristica_id
                WHERE quartos_caracteristica.quartos_id=?",[$quarto_data['id']],false);

                $caracteristica_data = "";
                foreach ($fea_q as $fea_row) {
                    $caracteristica_data .="<span class='badge rounded-pill bg-light text-dark text-wrap'>
                                                $fea_row[nome]
                                            </span>";
                }

                $fa_cont = 0;
                $fea_q=Selecao($Conexao,"SELECT acomadacao.nome, acomadacao.id FROM acomadacao
                INNER JOIN quartos_acomadacao ON acomadacao.id = quartos_acomadacao.acomadacao_id
                WHERE quartos_acomadacao.quartos_id=?",[$quarto_data['id']],false);

                $acomadacao_data = "";
                foreach ($fea_q as $fea_row) {
                    if (in_array($fea_row['id'],$acomadacao_list['acomadacao'])) {
                        $fa_cont++;
                    }
                    $acomadacao_data .="<span class='badge rounded-pill bg-light text-dark text-wrap'>
                                                $fea_row[nome]
                                            </span>";
                }

                if (count($acomadacao_list['acomadacao']) != $fa_cont ) {
                    continue;
                }

                $quarto_thumb = QUARTO_IMAGE_PATH."Thumbnail.jpg";
                $thumb_q = Selecao($Conexao,"SELECT * FROM quartos_imagem WHERE quartos_id=? AND thumb=?",[$quarto_data['id'],1],false);
               
                if($thumb_q){
                    $quarto_thumb = QUARTO_IMAGE_PATH.$thumb_q[0]['image'];
                }

                
                $Reserva_btn ="";

                if(!$contactos[0]['Desligado']){
                    $login = 0;
                    if(isset($_SESSION['login']) && $_SESSION['login'] ==true){
                        $login=1;

                    }
                    $Reserva_btn = "<a onclick='verificalogin_reserva($login,$quarto_data[id])'  class=\"btn btn-sm w-100 text-white custom-bg shadow-none mb-2\">Reservar Agora</a>";
                }

                $preco = Formato_Kwanza($quarto_data['preco']);

                $output .= <<<data
                        <div class="card mb-4 border-0 shadow">
                        <div class="row g-0 p-3 align-items-center">
                            <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                <img src="$quarto_thumb" width="500px" height="200px" class="img-fluid rounded">
                            </div>
                            <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                <h5 class="mb-3">$quarto_data[nome]</h5>
                                <div class="features mb-4">
                                    <h6 class="mb-1">Caracteristicas</h6>
                                    $caracteristica_data
                                </div>
                                <div class="Facilities mb-3">
                                    <h6 class="mb-1">Acomadações</h6>
                                    $acomadacao_data
                                </div>
                                <div class="guests">
                                    <h6 class="mb-1">Hóspedes</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                        $quarto_data[adulto] Adulto
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                        $quarto_data[crianca] Criança
                                    </span>
                                </div>  
                            </div>
                            <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                <h6 class="mb-4">$preco por Noite</h6>
                                $Reserva_btn
                                <a href="Home_Quartos_Detalhes.php?id=$quarto_data[id]" class="btn btn-sm w-100 btn-outline-dark shadow-none">Mais Detalhes</a>
                            </div>
                        </div>
                    </div>  
                data;
                $cont_room++;
            }

            if ($cont_room > 0) {
                echo $output;
            }else {
                echo "<h3 class='text-center text-danger'>Não Existem Quartos para Mostrar!</h3>";
            }

        }

?>