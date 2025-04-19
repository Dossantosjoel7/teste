<?php

    require("../Controllers/essencial.php");
    require("../Models/Database.php");

    $metodo = $_REQUEST['metodo'] ?? null;


    if ($metodo == "adicionar") {
        $data = filtracao($_POST);

        $S_existe = Selecao($Conexao, "SELECT * FROM contactos WHERE user=? LIMIT 1", [1],false);
        if($S_existe[0]['email'] == $data['email'] || $S_existe[0]['tel'] == $data['tel']){
            echo ($S_existe[0]['email'] == $data['email']) ? 'Email já existe' : 'Telefone já existe';
            exit;
        }
        
        $id_contacto = Inserir($Conexao,"INSERT INTO contactos(email,tel,user) VALUES (?,?,?)",[$data["email"],$data["tel"],1]);

        $q1 = "INSERT INTO pessoa(nome,sobrenome,genero,endereco,data_nas,n_ide,id_contacto) VALUES (?,?,?,?,?,?,?)";
        $id_pessoa = Inserir($Conexao,$q1,[$data["nome"],$data["subnome"],$data["genero"],$data["endereco"],$data["data_nas"],$data["n_ide"],$id_contacto]);

        if($_POST["admin"] !=0){
            $d = Selecao($Conexao,"SELECT site_titulo FROM configuracoes WHERE id_confg=?",[1],false);
            $nome = $data["nome"]."_".$data["subnome"]."@".str_replace(' ', '',strtolower($d[0]["site_titulo"]));
            $id_acesso = Inserir($Conexao,"INSERT INTO acesso(entrada,saida ,nome_acesso) VALUES (current_timestamp(),current_timestamp(),?)",[$nome]);
            $id_admin = Inserir($Conexao,"INSERT INTO user_admin(username,password,id_role,id_acesso,id_cont,id_config,id_pessoa) VALUES (?,?,?,?,?,?,?)",[$nome,password_hash("1234",PASSWORD_BCRYPT),$_POST["admin"],$id_acesso,1,1,$id_pessoa]);
        }

        $id_funcionario = Inserir($Conexao,"INSERT INTO funcionario(id_pessoa,tipo_funcionario,Yes_admin) VALUES (?,?,?)",[$id_pessoa,$data["funcao"],($_POST["admin"]!=0)? $id_admin:0]);

        if ($id_funcionario != 0) {
            echo 1;
        } else {
            echo 'Falha';
        }

    }


    if($metodo == "get"){
        $data = filtracao($_POST);

        $page = $data['page'] ?? 1;
        // Itens por página
        $perPage = 5;
        $offset = ($page - 1) * $perPage;
    

        $q1 = " SELECT DISTINCT * FROM funcionario,contactos,pessoa where pessoa.id_pessoa=funcionario.id_pessoa and contactos.id = pessoa.id_contacto and tel LIKE ?";
        $limite_q = $q1 . " LIMIT {$perPage} OFFSET {$offset}";
        $l_res = $Conexao->prepare($limite_q);
        $l_res->execute(["%$data[username]%"]);
        $datab = $l_res->fetchAll(PDO::FETCH_ASSOC);

        $cont = $offset + 1;
        $text = "";
        $total_linhas = $l_res->rowCount();
    
        if ($total_linhas == 0) {
            $output = json_encode(['func_data' => "<b>Nenhum Funcionario encontrado!</b>", "paginacao" => '']);
            echo $output;
            exit;
        }
        
            $text ="";
            foreach ($datab as $data) {
                $nome = $data["nome"]." ".$data["sobrenome"];
                $text .= <<<data
                <tr class='align-middle'>
                    <th scope="row">$cont</th>
                    <td>
                        $nome
                    </td>
                    <td>$data[tipo_funcionario]</td>
                    <td>$data[email]</td>
                    <td>$data[tel]</td>
                    <td>
                        <button type='button' onclick="ver_funcionario($data[id_funcionario])" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#func_view'>
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        <button type='button' onclick="editar_ver_funcionario($data[id_funcionario])" class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#func_edit'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type='button' onclick="remove_funcionario($data[id_funcionario])" class='btn btn-danger shadow-none btn-sm'>
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                data;
                $cont++;

            }

        $paginacao = "";
        $total = getTotal($Conexao, $q1, ["%$data[username]%"]);
        // Total de páginas
        $numPages = ceil($total / $perPage);
        
            $paginacao = "
            <nav aria-label='Page navigation'>
            <ul class='pagination'>

                <li class='page-item " . (($page == 1) ? 'disabled' : '') . "'>
                    <button onclick='change_page(($page-1))' class='page-link'>Anterior</button>
                </li>
                
                ";
                
            for($i = 1; $i <= $numPages; $i++):

            $paginacao .= "
                <li class='page-item " . (($page == $i) ? 'active' : '') . "'>
                    <button  onclick='change_page(($i))' class='page-link'>$i</button>
                </li>
            ";

            endfor;

            $paginacao .= "

                <li class='page-item " . (($page == $numPages) ? 'disabled' : '') . "'>
                    <button  onclick='change_page(($page+1))' class='page-link'>Próximo</button>
                </li>

            </ul>  
            </nav>
            ";
        

        $output = json_encode(['func_data' => $text, 'paginacao' => $paginacao]);
        echo $output;

    }

    if ($metodo == "ver") {
        $data = filtracao($_POST);

        $q = "SELECT DISTINCT * FROM funcionario,contactos,pessoa where pessoa.id_pessoa=funcionario.id_pessoa and contactos.id = pessoa.id_contacto  and id_funcionario =?";
        $res1 =Selecao($Conexao,$q,[$data['ver']],false);

        $json = json_encode($res1);

        echo $json;
        
    }

    if ($metodo == "editar") {
        $data = filtracao($_POST);

        $q = "SELECT DISTINCT * FROM funcionario,contactos,pessoa where pessoa.id_pessoa=funcionario.id_pessoa and contactos.id = pessoa.id_contacto  and id_funcionario =?";
        $res1 =Selecao($Conexao,$q,[$data['id']],false);

        if($data['tel'] != $res1[0]['tel'] & $data['email'] != $res1[0]['email'] ) {
            $S_existe = Selecao($Conexao, "SELECT * FROM contactos WHERE email=? and tel=? and user=? LIMIT 1", [$data[0]['email'],$data[0]['tel'] ,1],false);
            if($S_existe){
                echo ($S_existe[0]['email'] == $data['email']) ? 'Email já existe' : 'Telefone já existe';
                exit;
            }
        }

        Atualizar($Conexao,"UPDATE contactos SET email=?, tel=? WHERE id=?",[$data["email"],$data["tel"],$res1[0]["id_contacto"]]);
        $sd = Atualizar($Conexao,"UPDATE funcionario SET tipo_funcionario=? WHERE id_funcionario=?",[$data["funcao"],$data['id']]);
        $q1 ="UPDATE pessoa SET nome=?,sobrenome=?,genero=?,endereco=?,data_nas=?,n_ide=? WHERE id_pessoa=?";
        $ok = Atualizar($Conexao,$q1,[$data["nome"],$data["subnome"],$data["genero"],$data["endereco"],$data["data_nas"],$data["n_ide"],$res1[0]["id_pessoa"]]);

        if ($ok != 0 || $sd != 0) {
            echo 1;
        } else {
            echo 0;
        }
        
    }

    if($metodo == "eliminar"){

         $q = "SELECT DISTINCT * FROM funcionario,contactos,pessoa where pessoa.id_pessoa=funcionario.id_pessoa and contactos.id = pessoa.id_contacto  and id_funcionario =?";
         $res1 =Selecao($Conexao,$q,[$_POST['id_funcionario']],false);


         if($res1[0]["Yes_admin"] != 0){
            $r =Selecao($Conexao,"SELECT id_acesso FROM user_admin WHERE id=?",[$res1[0]["Yes_admin"]],false);
            Delete($Conexao,"DELETE FROM user_admin WHERE id=?",[$res1[0]["Yes_admin"]]);
            Delete($Conexao,"DELETE FROM acesso WHERE id =?",[$r[0]["id_acesso"]]);

         }

         Delete($Conexao,"DELETE FROM funcionario WHERE id_funcionario=?",[$_POST['id_funcionario']]);
         Delete($Conexao,"DELETE FROM pessoa WHERE id_pessoa=?",[$res1[0]["id_pessoa"]]);

        $ok =Delete($Conexao,"DELETE FROM contactos WHERE id=?",[$res1[0]["id_contacto"]]);

        if ($ok != 0) {
            echo 1;
        }else{
            echo 0;
        }


    }


?>