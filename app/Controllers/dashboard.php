<?php 

    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    session_start();



    if(isset($_POST['Analise_da_Reservas'])){

        $data = filtracao($_POST);

        $condicao = "";

        if ($data['periodo'] == 1) {
            $condicao = "AND datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
        }else if ($data['periodo'] == 2) {
            $condicao = "AND datetime BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()";
        }else if ($data['periodo'] == 3) {
            $condicao = "AND datetime BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()";
        }else if ($data['periodo'] == 4) {
            $condicao = "AND datetime BETWEEN DATE_SUB(NOW(), INTERVAL 1 YEAR) AND NOW()";
        }
        
        $corrent_reservas = $Conexao->prepare("SELECT
            SUM(total_pay) AS pagamento_total,
            COUNT(reserva_pedido.reserva_id) AS total_reservas,

            COUNT(CASE WHEN reserva_status='reservado' AND chegada=1 THEN 1 END) AS reservas_activa,
            SUM(CASE WHEN reserva_status='reservado'  AND chegada=1 THEN total_pay END) AS pagamento_activo,

            COUNT(CASE WHEN reserva_status='Cancelado' AND reembolso=1 THEN 1 END) AS refund_reservas,
            SUM(CASE WHEN reserva_status='Cancelado' AND reembolso=1 THEN total_pay END) AS sum_reservas

            FROM reserva_pedido ,reserva_detalhes WHERE reserva_pedido.reserva_id = reserva_detalhes.reserva_id $condicao");
            $corrent_reservas-> execute();
            $result = $corrent_reservas ->fetchAll(PDO::FETCH_ASSOC);

            $result[0]["pagamento_total"] = Formato_Kwanza($result[0]["pagamento_total"]);
            $result[0]["pagamento_activo"] = Formato_Kwanza($result[0]["pagamento_activo"]);
            $result[0]["sum_reservas"] = Formato_Kwanza($result[0]["sum_reservas"]);
            echo $output = json_encode($result);
            
    }


    if (isset($_POST['Analise_da_User'])) {
        $data = filtracao($_POST);
        $condicao = "";

        if ($data['periodo'] == 1) {
            $condicao = "WHERE datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
        }else if ($data['periodo'] == 2) {
            $condicao = "WHERE datetime BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()";
        }else if ($data['periodo'] == 3) {
            $condicao = "WHERE datetime BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()";
        }else if ($data['periodo'] == 4) {
            $condicao = "WHERE datetime BETWEEN DATE_SUB(NOW(), INTERVAL 1 YEAR) AND NOW()";
        }

        $cr = $Conexao->prepare("SELECT COUNT(id_rr) AS count FROM rating_review  $condicao");
        $cr -> execute();
        $d1= $cr ->fetchAll(PDO::FETCH_ASSOC);

        $cm = $Conexao->prepare("SELECT COUNT(id_uc) AS count FROM mensagem $condicao");
        $cm -> execute();
        $d2= $cm ->fetchAll(PDO::FETCH_ASSOC);

        $cu = $Conexao->prepare("SELECT COUNT(id_user) AS count FROM user_home $condicao");
        $cu -> execute();
        $d3= $cu ->fetchAll(PDO::FETCH_ASSOC);

        $output =[
            "d1"=> $d1[0]["count"],
            "d2" => $d2[0]["count"],
            "d3" => $d3[0]["count"]
        ];

        $output = json_encode($output);
        echo $output;
    }

?>