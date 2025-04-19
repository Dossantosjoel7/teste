<?php 


    /*
        Nome: Codigo PHP relacionado a Cancelamento da reserva
        Copyright: 2022-2023 © Herman&Joel
        Descrição: ...

    */

    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    date_default_timezone_set('Africa/Luanda');
    session_start();

    if(!(isset($_SESSION['login']) && $_SESSION['login'] ==true)){
        redirect("index.php");
    }

    if(isset($_POST['cancel_reserva'])){
        $dados = filtracao($_POST);

        $q= "UPDATE reserva_pedido SET reserva_status=?, reembolso=? WHERE reserva_id=? AND user_id=?";

        $val =["Cancelado",0,$dados["id"],$_SESSION["uId"]];
        
        $result = Atualizar($Conexao,$q,$val);

        echo $result;
    }


?>