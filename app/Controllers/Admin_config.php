<?php 

    require("../Controllers/essencial.php");
    require("../Models/Database.php");

    session_start();


    if(isset($_POST['Get_config'])){
        $q = "SELECT * FROM configuracoes WHERE id_confg=?";
        $values = [1];
        $res = Selecao($Conexao, $q, $values, false);
        $json_data = json_encode($res);
        echo $json_data;

    }

    if(isset($_POST['Upd_conf'])){

        $Val_digit = filtracao($_POST);
        $q = "UPDATE configuracoes SET site_titulo=?, site_sobre=? WHERE id_confg=?";
        $valores = [$Val_digit['site_titulo'],$Val_digit['site_sobre'],1];
        $res=Atualizar($Conexao,$q,$valores);
        echo $res;
    }

    if(isset($_POST['upd_shutdown'])){

        $Val_digit = ($_POST['upd_shutdown'] ==0) ? 1:0;
        $q = "UPDATE configuracoes SET Desligado=? WHERE id_confg=?";
        $valores = [$Val_digit,1];
        $res=Atualizar($Conexao,$q,$valores);
        echo $res;
    }

    if(isset($_POST['Get_contactos'])){
        $q = "SELECT * FROM contactos_detalhes WHERE id_cont=?";
        $values = [1];
        $res = Selecao($Conexao, $q, $values, false);
        $json_data = json_encode($res);
        echo $json_data;

    }

    if(isset($_POST['Upd_contactos'])){

        $Val_digit = filtracao($_POST);
        $q = "UPDATE contactos_detalhes SET endereco=?, gmap=?, pn1=?, pn2=? , email=?, fb=? , insta=? , wt=? , iframe=? WHERE id_cont=?";
        $valores = [$Val_digit['endereco'],$Val_digit['gmap'],$Val_digit['pn1'],$Val_digit['pn2'],$Val_digit['email'],$Val_digit['fb'],$Val_digit['insta'],$Val_digit['wt'],$Val_digit['iframe'],1];
        $res=Atualizar($Conexao,$q,$valores);
        echo $res;
    }

    if(isset($_POST['RecPass'])){
        $data = filtracao($_POST);
        $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);

        $v = Selecao($Conexao,"SELECT * FROM contactos WHERE email =? and user=?",[$data['email'],1],false);

        if($data['email'] == $v[0]["email"]){
            $q = "UPDATE user_admin SET password=?,verif=? WHERE id_acesso=?";
            $valores=[$enc_pass,1, $_SESSION['At']];
            if(Atualizar($Conexao,$q,$valores)){
                echo 1;
            }else{
                echo "failed";
            }
        }else{echo "failed";}
        
    }

?>