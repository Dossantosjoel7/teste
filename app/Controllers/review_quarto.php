<?php 

    /*
        Nome: Codigo PHP relacionado as avaliacoes do Quarto feitas do usuario 
        Copyright: 2022-2023 © Herman&Joel
        Descrição: ...

    */

    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    session_start();


    if (isset($_POST['rate_review'])) {
        $data = filtracao($_POST);

        $q= "UPDATE reserva_pedido SET rate_review=? WHERE reserva_id=? AND user_id=?";
        $valor1 = [1,$data["reserva_id"],$_SESSION["uId"]];
        $res = Atualizar($Conexao,$q,$valor1);

        $q1= "INSERT INTO rating_review(reserva_id,quarto_id,user_id,rating,review) VALUES (?,?,?,?,?)";
        $valor2 = [$data["reserva_id"],$data["quarto_id"],$_SESSION["uId"],$data["rating"],$data["review"]];
        $r1 = Inserir($Conexao,$q1,$valor2);
        echo $r1;
    }

?>