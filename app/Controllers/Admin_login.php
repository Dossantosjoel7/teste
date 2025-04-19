<?php 

    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    date_default_timezone_set('Africa/Luanda');
    AdminLogin();

    if(isset($_POST['login'])){
        $Val_digit = filtracao($_POST);
        $query = "SELECT * FROM user_admin WHERE  username = ?";
        $valores = [$Val_digit['Admin_login']];
        $res = Selecao($Conexao,$query, $valores,false);

        if(!$res){
            alert('error', 'Falha no login - Credenciais invalidas!');
        }else{
            if(!password_verify($Val_digit['Admin_pass'],$res[0]['password'])){
             alert('error', 'Falha no login - Credenciais invalidas!');
            }else{
                $time = date("Y-m-d H:i:s");
                $_SESSION['At'] = $res[0]["id_acesso"];
                Atualizar($Conexao,"UPDATE acesso SET entrada=? WHERE id=?",[$time,$res[0]["id_acesso"]]);
                if($res[0]["id_pessoa"] == NULL){
                    $_SESSION['Name'] = "admin";
                }else{
                    $r1 = Selecao($Conexao,"SELECT * FROM pessoa WHERE id_pessoa=?",[$res[0]["id_pessoa"]],false);
                    $_SESSION['Name'] = $r1[0]["nome"]." ".$r1[0]["sobrenome"];
                }
                     $_SESSION['rol'] = $res[0]["id_role"];
                     $_SESSION['Adlogin'] = true;
                     $_SESSION['verif'] = ($res[0]["verif"] != 0)? 1:0;
                    AdminLogin();
            }
        }

        

        

    }

?>