<?php

    /*
        Nome: Script de Editagem do Perfil 
        Copyright: 2022-2023 © Herman&Joel
        Descrição: Documento resposavel por enviar os dados editados para base de dados

    */

    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    date_default_timezone_set('Africa/Luanda');


    # Editar os dados Pesoais do Usuario
    if(isset($_POST['info_form'])){
        $data = filtracao($_POST);
        session_start();

        $q = "SELECT DISTINCT * FROM user_home,contactos,pessoa WHERE user_home.id_pessoa = pessoa.id_pessoa and pessoa.id_contacto = contactos.id AND id_user =?";
        $res1 =Selecao($Conexao,$q,[$_SESSION["uId"]],false);


        if($data['tel'] != $res1[0]['tel']) {
            $S_existe = Selecao($Conexao, "SELECT * FROM contactos  WHERE tel =? AND user=? LIMIT 1", [$data['tel'],2],false);
            if($S_existe){
                echo "tel_exit";
                exit;
            }
       
        }
        
        $q1 ="UPDATE pessoa SET nome=?,sobrenome=?,genero=?,endereco=?,data_nas=?,n_ide=? WHERE id_pessoa=?";
        $ok = Atualizar($Conexao,$q1,[$data["nome"],$data["sobrenome"],$data["genero"],$data["endereco"],$data["data_nas"],$data["n_ide"],$res1[0]["id_pessoa"]]);
        $op = Atualizar($Conexao,"UPDATE contactos SET tel=? WHERE id=?",[$data["tel"],$res1[0]["id_contacto"]]);
        
        if($ok !=0){
            $_SESSION['uName'] = $data['nome']." ".$data["sobrenome"];
            $_SESSION['uPhone'] = $data['tel'];
            echo 1;
        } else {
            echo 0;
        }
    }

    # Editar a Foto do Usuario
    if(isset($_POST['profile_form'])){
        session_start();

        $img = uploadUser_Image($_FILES["profile"]);
        if ($img == "inv_img") {
            echo "inv_img";
            exit;
        } else if($img == "upd_failed") {
            echo "upd_failed";
            exit;
        }

        $u_exist = Selecao($Conexao,"SELECT profile FROM user_home WHERE  id_user=? LIMIT 1",[$_SESSION["uId"]],false);
        deleteImage($u_exist["profile"],USER_FOLDER);
        $q = "UPDATE user_home SET profile=? WHERE id_user=?";
        $values = [$img,$_SESSION["uId"]];

        if (Atualizar($Conexao,$q,$values)) {
            $_SESSION["uPic"] =$img;
            echo 1;
        } else {
            echo 0;
        }
        
        
    }

    # Editar o Password do Usuario
    if(isset($_POST['pass_form'])){
        session_start();
        $dados = filtracao($_POST);

        if ($dados["new_pass"]!=$dados["conf_pass"]) {
            echo "mismach";
            exit;
        }

        $enc_pass = password_hash($dados["new_pass"],PASSWORD_BCRYPT);

        $q = "UPDATE user_home SET pass=? WHERE id_user=?";
        $values = [$enc_pass,$_SESSION["uId"]];

        if (Atualizar($Conexao,$q,$values)) {
            echo 1;

        } else {
            echo 0;
        }
        
        
    }



?>