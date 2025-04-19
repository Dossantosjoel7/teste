<?php 


    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    session_start();

    if(isset($_GET['gen_pdf']) && isset($_GET['id'])){
        $frm = filtracao($_GET);

        $q1 = "SELECT reserva_pedido.*, reserva_detalhes.* FROM reserva_pedido 
               INNER JOIN reserva_detalhes ON reserva_pedido.reserva_id=reserva_detalhes.reserva_id
               WHERE ((reserva_pedido.reserva_status='reservado' AND reserva_pedido.chegada=1) OR (reserva_pedido.reserva_status='Cancelado' AND reserva_pedido.reembolso=1)) AND reserva_pedido.reserva_id ='$frm[id]'";

        $limite_res = $Conexao -> prepare($q1);
        $limite_res ->execute();

        $total_linhas = $limite_res->rowCount();

        if($total_linhas == 0){
            header('location: Admin_dashboard.php');
        }



    }else{
        header('location: Admin_dashboard.php');
    }


?>