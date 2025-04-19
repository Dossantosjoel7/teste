<?php


    /*
        Nome: Codigo PHP relacionado ao Registro e Login e Recuperaçao do Usuario 
        Copyright: 2022-2023 © Herman&Joel
        Descrição: ...

    */

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use function PHPSTORM_META\type;

    require_once '../vendor/autoload.php';
    require('../Controllers/d_con.php');
    date_default_timezone_set('Africa/Luanda');

    # Funçao de envio de mensagens 
    function send_Mail($Email,$token,$type){
        global  $contactos;

        if($type === "Confirmacao"){
            $page = 'Controllers/email_confirm.php';
            $assunto = 'Link da Verificação da Conta';
            $sumario = "confirmar teu email";
        }else if($type === "Recuperacao"){
            $page = 'Views/Index.php';
            $assunto = 'Link para recuperação da Conta';
            $sumario = "recuperar teu email";
        }

        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        // Configuração do servidor de e-mail
        $mail->isSMTP();                                      // Seta que vai usar SMTP
        $mail->Host = 'smtp.gmail.com';                   // Servidor de e-mail
        $mail->SMTPAuth = true;                               // Autenticação ativada
        $mail->Username = PHPMAILER_API_EMAIL;           // Nome de usuário do e-mail
        $mail->Password = PHPMAILER_API_PASSWORD;              // Senha do e-mail
        $mail->Encoding = 'base64';
        $mail->SMTPDebug = 0; // desativar o modo de depuração do SMTP
        $mail->SMTPSecure = 'ssl'; // usar SSL para conexão segura com o servidor SMTP
        $mail->Port = 465; // definir a porta para conexão com o servidor SMTP
        // $mail->SMTPSecure = 'tls';                            // Encriptação ativada
        // $mail->Port = 587;                                    // Porta do SMTP

        // Destinatário
        $mail->setFrom(PHPMAILER_API_EMAIL,$contactos[0]['site_titulo']);
        $mail->addAddress($Email);     // Adicionar destinatário

        // Conteúdo
        $mail->isHTML(true);                                  // Seta que vai usar HTML
        $mail->Subject =$assunto;
        $mail->Body =
            "Aperta no link para $sumario:<br>
            <a href='".$_SERVER['SERVER_NAME'].SITE_URL."app/$page?$type&email=$Email&token=$token'>Confirme a sua Conta </a>
            ";

        // Envia o e-mail
        if(!$mail->send()){
            return false;
        } else {
            return true;
        }
        
    }
    
    # Codigo para Registrar o Usuario 
    if(isset($_POST['userreg'])){
        $data = filtracao($_POST);


        if($data['pass'] != $data['v_pass']){
            echo 'Password Iguais';
            exit();
        }


        $S_existe = Selecao($Conexao, "SELECT * FROM contactos WHERE user=? LIMIT 1", [2],false);
        if($S_existe[0]['email'] == $data['email'] || $S_existe[0]['tel'] == $data['tel']){
            echo ($S_existe[0]['email'] == $data['email']) ? 'Email já existe' : 'Telefone já existe';
            exit;
        }

        $img = uploadUser_Image($_FILES['profile']);

        if($img == 'inv_img'){
            echo 'Imagem Invalida!';
            exit;
        }else if($img == 'upd_failed'){
            echo 'Upload não Feito!';
            exit;
        }


        $token = bin2hex(random_bytes(16));
        if(send_Mail($data['email'],$token,"Confirmacao") == false){
            echo 'Email_falido';
            exit;
        }

        $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);


        $id_acesso = Inserir($Conexao,"INSERT INTO acesso(entrada,saida,nome_acesso) VALUES (current_timestamp(),current_timestamp(),?)",["User ".$data['nome']]);
        $id_contactos =Inserir($Conexao,"INSERT INTO contactos(email,tel,user) VALUES (?,?,?)",[$data['email'],$data['tel'],2]);
        $id_pessoa = Inserir($Conexao,"INSERT INTO pessoa(nome, sobrenome, genero, endereco, data_nas, n_ide, id_contacto) VALUES (?,?,?,?,?,?,?)",[$data['nome'],$data['subnome'],$data['genero'],$data['endereco'],$data['data_nas'],$data['n_ide'],$id_contactos]);
        $q = "INSERT INTO user_home(profile,pass,token, id_acesso, id_pessoa) VALUES (?,?,?,?,?)";
        $valores_enviados = [$img, $enc_pass,$token,$id_acesso,$id_pessoa];
        $res = Inserir($Conexao,$q,$valores_enviados);

        if($res !=0){
            echo 1;
        } else {
            echo 'erro_envio';
        }
        
    }

    # Codigo para Logar o Usuario 
    if(isset($_POST['userlogin'])){
        $data = filtracao($_POST);
        $S_existe = Selecao($Conexao, "SELECT * FROM user_home,contactos,pessoa WHERE user_home.id_pessoa = pessoa.id_pessoa and pessoa.id_contacto = contactos.id AND email =? OR tel =? and user=2 LIMIT 1", [$data['user_login'], $data['user_login']],false);
        if(!$S_existe){
            echo 'Email_inv';
            exit;
        }else {
            if($S_existe[0]['se_verificado']==0){
                echo 'Nao_verificado';
            }else if($S_existe[0]['status']==0){
                echo 'inativo';
            }else {
                if(!password_verify($data['user_pass'],$S_existe[0]['pass'])){
                    echo 'invalid_pass';
                }else{
                    $time = date("Y-m-d H:i:s");
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uId'] = $S_existe[0]['id_user'];
                    $_SESSION['uName'] = $S_existe[0]['nome']." ".$S_existe[0]['sobrenome'];
                    $_SESSION['uPic'] = $S_existe[0]['profile'];
                    $_SESSION['uPhone'] = $S_existe[0]['tel'];
                    $_SESSION['uT'] = $S_existe[0]['id_acesso'];
                    Atualizar($Conexao,"UPDATE acesso SET entrada=?, nome_acesso =? WHERE id=?",[$time,"User ".$S_existe[0]['nome'],$S_existe[0]["id_acesso"]]);
                    echo 1;
                }
               
            }
        }
        
    }

    # Codigo para enviar Token de recuperaçao na BD
    if(isset($_POST['passEq'])){
        $data = filtracao($_POST);
        $S_existe = Selecao($Conexao, "SELECT * FROM user_home,contactos,pessoa WHERE user_home.id_pessoa = pessoa.id_pessoa and pessoa.id_contacto = contactos.id and  email =? and user=? LIMIT 1", [$data['email'],2],false);
        if(!$S_existe){
            echo 'Email_inv';
        }else{
            if($S_existe[0]['se_verificado']==0){
                echo 'Nao_verificado';
            }else if($S_existe[0]['status']==0){
                echo 'inativo';
            }else {
                $token = bin2hex(random_bytes(14));
                if(!send_Mail($S_existe[0]['email'],$token,"Recuperacao")){
                    echo 'failed';
                }else{
                    $date = date("Y-m-d");
                    $q = Atualizar($Conexao,"UPDATE user_home SET token=?, t_expire=? WHERE id_user=?",[$token,$date,$S_existe[0]['id_user']]);

                    if($q){
                        echo 1;
                    }
                    else{
                        echo 'upd_failed';
                    }
                }
            }
        }
        
    }

    # Codigo para enviar o pass novo na BD
    if(isset($_POST['RecPass'])){
        $data = filtracao($_POST);
        $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);
        $v = Selecao($Conexao,"SELECT * FROM contactos WHERE email =? and user=?",[$data['email'],2],false);

        if($data['email'] == $v[0]["email"]){
            $q = "UPDATE user_home SET pass=? , token=? , t_expire=? WHERE token=?";
            $valores=[$enc_pass,null,null,$data['token']];
            $op = Atualizar($Conexao,$q,$valores);
            if($op){
                echo 1;
            }else{
                echo "failed";
            }
        }else{echo "failed";}
        
    }




?>

