<?php 

    require("../Controllers/essencial.php");
    require("../Models/Database.php");


    if(isset($_GET['Confirmacao'])){
        $data = filtracao($_GET);

        $q = Selecao($Conexao, "SELECT * FROM user_home,contactos,pessoa WHERE email =? and token=? and user=2 LIMIT 1", [$data['email'], $data['token']],false);
        if ($q == true) {
            $con= $q[0];
            if($con['se_verificado']==1){
                print"<script>alert('Email já existe no Sistema');</script>";
                print "<script>window.location.href='../Views/Index.php';</script>";

            }else{
                $u = Atualizar($Conexao, "UPDATE user_home SET se_verificado=? WHERE id_user=?", [1,$con['id_user']]);
                print"<script>alert('Email Confirmado com Sucesso');</script>"; 
                print "<script>window.location.href='../Views/Index.php';</script>";
            }
        }else{
            print"<script>alert('Invalido Link!!')</script>";
            print "<script>window.location.href='../Views/Index.php';</script>";
        }

    }


?>