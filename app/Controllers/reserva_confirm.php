<?php 

    /*
        Nome: Codigo PHP relacionado a confirmaçao da reserva
        Copyright: 2022-2023 © Herman&Joel
        Descrição: ...

    */

    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    date_default_timezone_set('Africa/Luanda');

    #Checagem da parte do Usuario 
    if(isset($_POST['check_disponivel'])){
        $dados = filtracao($_POST);
        $status ="";
        $resultado ="";

       // entrada e saida validação

       $data_hoje = new DateTime(date("Y-m-d"));
       $data_entrada = new DateTime($dados['entrada']);
       $data_saida = new DateTime($dados['saida']);

       if ($data_entrada == $data_saida) {
            $status ="check_in_out_iguais";
            $resultado =json_encode(["status"=> $status]);
       }else if ($data_saida < $data_entrada) {
            $status ="check_out_cedo";
            $resultado =json_encode(["status"=> $status]);
       }else if ($data_entrada < $data_hoje) {
            $status ="check_in_cedo";
            $resultado =json_encode(["status"=> $status]);
        }

        if($status!=""){
            echo $resultado;
        }else{
            session_start();
            
            $tb_query = "SELECT COUNT(*) AS total_bookings FROM reserva_pedido WHERE reserva_status=? AND quarto_id=? AND check_out>? AND check_in<?";
            $res = $Conexao->prepare($tb_query);
            $res->execute(["reservado",$_SESSION["quarto"]["id"],$dados["entrada"],$dados["saida"]]);
            $rd= $res->fetchAll(PDO::FETCH_ASSOC);

            $r = Selecao($Conexao,"SELECT quant FROM quartos WHERE id=?",[$_SESSION["quarto"]["id"]],false);

            
            if (($r[0]["quant"] - $rd[0]["total_bookings"]) == 0) {
                $status = "Indisponivel";
                $resultado = json_encode(["status"=>$status]);
                echo $resultado;
                exit;
            }

            $cont_dias = date_diff($data_entrada,$data_saida) ->days;
            $pagamento = $_SESSION['quarto']['preco'] * $cont_dias;

            $_SESSION['quarto']['pagamento'] = $pagamento;
            $_SESSION['quarto']['disponivel'] = true;

            $resultado = json_encode(["status" =>'disponivel', "dias"=> $cont_dias, "pagamento" => Formato_Kwanza($pagamento)]);
            echo $resultado;


        }   
    }


    #Checagem da parte Administrativa 
    if(isset($_POST['check_admin'])){
        $dados = filtracao($_POST);
        $status ="";
        $resultado ="";
        
        session_start();

        $quarto_res = Selecao($Conexao,"SELECT * FROM quartos WHERE nome=? AND status=? AND removido=?",[$dados['tipo_quarto'],1,0],false);

        $_SESSION['quarto'] = [
            "id" => $quarto_res[0]['id'],
            "nome" => $quarto_res[0]['nome'],
            "preco" => $quarto_res[0]['preco'],
            "pagamento" => null,
            "disponivel" => false,
            ];

       // entrada e saida validação

       $data_hoje = new DateTime(date("Y-m-d"));
       $data_entrada = new DateTime($dados['entrada']);
       $data_saida = new DateTime($dados['saida']);

       if ($data_entrada == $data_saida) {
            $status ="check_in_out_iguais";
            $resultado =json_encode(["status"=> $status]);
       }else if ($data_saida < $data_entrada) {
            $status ="check_out_cedo";
            $resultado =json_encode(["status"=> $status]);
       }else if ($data_entrada < $data_hoje) {
            $status ="check_in_cedo";
            $resultado =json_encode(["status"=> $status]);
        }

        if($status!=""){
            echo $resultado;
        }else{
            $_SESSION['quarto'];
            //
            /*$tb_query = "SELECT COUNT(*) AS total_bookings WHERE reserva_pedido WHERE reserva_status=? AND quarto_id=? AND check_out>? AND check_in<?";
            $values = ["reservado",$_SESSION["quarto"]["id"],$dados["entrada"],$dados["saida"]];
*/
            $cont_dias = date_diff($data_entrada,$data_saida) ->days;
            $pagamento = $_SESSION['quarto']['preco'] * $cont_dias;

            $_SESSION['quarto']['pagamento'] = $pagamento;
            $_SESSION['quarto']['disponivel'] = true;

            $resultado = json_encode(["status" =>'disponivel', "dias"=> $cont_dias, "pagamento" => Formato_Kwanza($pagamento)]);
            echo $resultado;


        }



       
    }


?>