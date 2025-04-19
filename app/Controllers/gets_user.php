<?php

    require("../Controllers/essencial.php");
    require("../Models/Database.php");


    session_start();

    if(isset($_POST['gets_user'])){
        $data = filtracao($_POST);
        
        $q ="SELECT DISTINCT * FROM user_home,pessoa,contactos WHERE user_home.id_pessoa = pessoa.id_pessoa and pessoa.id_contacto = contactos.id AND user=2 AND nome LIKE ?";
        $page = $data['page'] ?? 1;
        // Itens por página
        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $limite_q = $q . " LIMIT {$perPage} OFFSET {$offset}";
        $limite_res = $Conexao->prepare($limite_q);
        $limite_res->execute(["%$data[username]%"]);

        $cont = $offset + 1;
        $total_linhas = $limite_res->rowCount();
    
        if ($total_linhas == 0) {
            $output = json_encode(['user_data' => "<b>Nenhum encontrado!</b>", "paginacao" => '']);
            echo $output;
            exit;
        }

        $datab = $limite_res->fetchAll(PDO::FETCH_ASSOC);
        $text ="";

            $path = USER_IMAGE_PATH;
            foreach ($datab as $data) {
                $del_btn = "<button type='button' onclick='remove_user($data[id_user])' class='btn btn-danger shadow-none btn-sm'>
                                <i class=\"bi bi-trash\"></i>
                            </button>";

                $verificado ="<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
                if($data['se_verificado']){
                    $verificado ="<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
                    $del_btn="";
                }

                $status = "<button onclick='trocar_Status($data[id_user],0)' class='btn btn-danger btn-sm shadown-none'>Activo</button>";
                if(!$data['status']){
                    $status = "<button onclick='trocar_Status($data[id_user],1)' class='btn btn-danger btn-sm shadown-none'>Inativo</button>";
                }

                //$data_reg = date("d-m-y",strtotime($data['datantime']));
                
                $text.= <<<data
                <tr class='align-middle'>
                    <th scope="row">$cont</th>
                    <td>
                        <img src='$path$data[profile]' width='40px'>
                    </td>
                    <td>
                        $data[nome]
                    </td>
                    <td>$data[sobrenome]</td>
                    <td>$data[email]</td>
                    <td>$data[tel]</td>
                    <td>$verificado</td>
                    <td>$status</td>
                    <td>
                        <button type='button' onclick="ver_user($data[id_user])" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#admin_view'>
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        $del_btn
                    </td>
                </tr>
                data;
                $cont++;

            }
            $paginacao = "";
            $total = getTotal($Conexao, $q, ["%$data[username]%"]);
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
    
            $output = json_encode(['user_data' => $text, 'paginacao' => $paginacao]);
            echo $output;
    }

    if(isset($_POST['ver'])){
        $data = filtracao($_POST);
        $q = "SELECT DISTINCT * FROM user_home,pessoa,contactos WHERE user_home.id_pessoa = pessoa.id_pessoa and pessoa.id_contacto = contactos.id AND user=2 AND id_user=?";
        $datab = Selecao($Conexao,$q,[$data["ver"]],false);
        
        $json = json_encode($datab);

        echo $json;

    }

    if(isset($_POST['ver_acesso'])){
        $data = filtracao($_POST);
        $q = "SELECT * FROM acesso WHERE NOT nome_acesso='admin'  and nome_acesso LIKE ?";

        $page = $data['page'] ?? 1;
        // Itens por página
        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $limite_q = $q . " LIMIT {$perPage} OFFSET {$offset}";
        $limite_res = $Conexao->prepare($limite_q);
        $limite_res->execute(["%$data[username]%"]);

        $cont = $offset + 1;
        $total_linhas = $limite_res->rowCount();
    
        if ($total_linhas == 0) {
            $output = json_encode(['acess_data' => "<b>Nenhum encontrado!</b>", "paginacao" => '']);
            echo $output;
            exit;
        }

        $datab = $limite_res->fetchAll(PDO::FETCH_ASSOC);
        $text ="";

            foreach ($datab as $data) {
                $text.=  <<<data
                <tr class='align-middle'>
                    <th scope="row">$cont</th>
                    <td>$data[nome_acesso]</td>
                    <td>$data[entrada]</td>
                    <td>$data[saida]</td>
                </tr>
                data;
                $cont++;

            }

            $paginacao = "";
            $total = getTotal($Conexao, $q, ["%$data[username]%"]);
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

        $output = json_encode(['acess_data' => $text, 'paginacao' => $paginacao]);
        echo $output;

    }

    if(isset($_POST['ver_admin'])){
        $data = filtracao($_POST);
        $q = "SELECT * FROM user_admin WHERE username LIKE ?";
        
        $page = $data['page'] ?? 1;
        // Itens por página
        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $limite_q = $q . " LIMIT {$perPage} OFFSET {$offset}";
        $limite_res = $Conexao->prepare($limite_q);
        $limite_res->execute(["%$data[username]%"]);

        $cont = $offset + 1;
        $total_linhas = $limite_res->rowCount();
    
        if ($total_linhas == 0) {
            $output = json_encode(['user_admin' => "<b>Nenhum encontrado!</b>", "paginacao" => '']);
            echo $output;
            exit;
        }

        $text ="";

        $datab = $limite_res->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datab as $data) {
                $role = ($data["id_role"]!=1)? "Recipcionista":"Administrador";
                $text.=<<<data
                <tr class='align-middle'>
                    <th scope="row">$cont</th>
                    <td>$data[username]</td>
                    <td>$role</td>
                </tr>
                data;
                $cont++;
            }

        $paginacao = "";
        $total = getTotal($Conexao, $q, ["%$data[username]%"]);
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

        $output = json_encode(['user_admin' => $text, 'paginacao' => $paginacao]);
        echo $output;
      

    }

    if(isset($_POST['trocar_Status'])){
        $data = filtracao($_POST);

        $q = "UPDATE user_home SET status=? WHERE id_user=?";
        $valor =[$data['value'],$data['trocar_Status']];

        if(Atualizar($Conexao,$q,$valor)){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['remove_user'])){
        $data = filtracao($_POST);
        $r =Selecao($Conexao,"SELECT DISTINCT * FROM user_home,contactos,pessoa where user_home.id_pessoa= pessoa.id_pessoa and pessoa.id_contacto = contactos.id  and id_user =?",[$data['user_id']],false);

        Delete($Conexao,"DELETE FROM acesso WHERE id = ?",[$r[0]['id_acesso']]);
        Delete($Conexao,"DELETE FROM contactos WHERE id=?",[$r[0]['id_contacto']]);
        Delete($Conexao,"DELETE FROM pessoa WHERE id_pessoa=?",[$r[0]['id_pessoa']]);
        $res =Delete($Conexao,"DELETE FROM user_home WHERE id_user=? AND se_verificado=?",[$data['user_id'],0]);
        deleteImage($r[0]['profile'],USER_FOLDER);
    
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }



    /*if(isset($_POST['procurar_user'])){
        $frm_data = filtracao($_POST);
        $q = "SELECT * FROM user_home WHERE nome LIKE ?";
        $datab = Selecao($Conexao,$q,["%$frm_data[username]%"],false);
        $path = USER_IMAGE_PATH;
        $cont=1;
        foreach ($datab as $data) {
            $del_btn = "<button type='button' onclick=\"remove_user($data[id])\" class='btn btn-danger shadow-none btn-sm'>
                            <i class=\"bi bi-trash\"></i>
                        </button>";

            $verificado ="<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
            if($data['se_verificado']){
                $verificado ="<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
                $del_btn="";
            }

            $status = "<button onclick='trocar_Status($data[id],0)' class='btn btn-danger btn-sm shadown-none'>Activo</button>";
            if(!$data['status']){
                $status = "<button onclick='trocar_Status($data[id],1)' class='btn btn-danger btn-sm shadown-none'>Inativo</button>";
            }

            $data_reg = date("d-m-y",strtotime($data['datantime']));
            
            echo <<<data
            <tr class='align-middle'>
                <th scope="row">$cont</th>
                <td>
                    <img src='$path$data[profile]' width='55px'>
                    $data[nome]
                </td>
                <td>$data[email]</td>
                <td>$data[tel]</td>
                <td>$data[endereco]</td>
                <td>$data[n_ide]</td>
                <td>$data[data_nas]</td>
                <td>$verificado</td>
                <td>$status</td>
                <td>$data_reg</td>
                <td>
                    $del_btn
                </td>
            </tr>
            data;
            $cont++;

        }
      
    }*/



?>