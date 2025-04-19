<?php 

    /*
        Nome: Codigo PHP relacionado com parte Administrativa, resposavel por mostrar as reservas rembolsadas 
        Copyright: 2022-2023 © Herman&Joel
        Descrição: ...

    */

    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    session_start();



    if(isset($_POST['get_reserva'])){

        $data = filtracao($_POST);

        $page = $data['page'] ?? 1;
        // Itens por página
        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $q1 = "SELECT reserva_pedido.*, reserva_detalhes.* FROM reserva_pedido 
               INNER JOIN reserva_detalhes ON reserva_pedido.reserva_id=reserva_detalhes.reserva_id
               WHERE (reserva_pedido.ordem_id LIKE ? OR reserva_detalhes.tel LIKE ? OR reserva_detalhes.user_nome LIKE ?) AND (reserva_pedido.reserva_status=? AND reserva_pedido.reembolso=?) ORDER BY reserva_pedido.reserva_id ASC
            ";

        $limite_q = $q1 . " LIMIT {$perPage} OFFSET {$offset}";
        $limite_res = $Conexao->prepare($limite_q);
        $limite_res->execute(["%$data[search]%","%$data[search]%","%$data[search]%","Cancelado",0]);

        $cont = $offset + 1;
        $total_linhas = $limite_res->rowCount();
    
        if ($total_linhas == 0) {
            $output = json_encode(['table_data' => "<b>Nenhum Reserva encontrado!</b>", "paginacao" => '']);
            echo $output;
            exit;
        }

        $datab = $limite_res->fetchAll(PDO::FETCH_ASSOC);
        $text ="";
        foreach ($datab as $data) {

            $date = date("d-m-Y",strtotime($data['datetime']));
            $checkin = date("d-m-Y",strtotime($data['check_in']));
            $checkout = date("d-m-Y",strtotime($data['check_out']));

            $preco = Formato_Kwanza($data['preco']);
            $preco_t = Formato_Kwanza($data['total_pay']);
            $m_p = ($data['tipo_pag'] =="pagamento_chegada")? "Pagamento ao Chegar ao Hotel":"Transferência Bancária";


            $text .= <<<data
            <tr>
                <th scope="row">$cont</th>
                <td>
                    <span class='badge bg-primary'>
                        Nª do Pedido: $data[ordem_id]
                    </span>
                    <br>
                    <b>Nome:</b> $data[user_nome]
                    <br>
                    <b>Número:</b> $data[tel]
                </td>
                <td>
                    <b>Check in:</b> $checkin
                    <br>
                    <b>Check out:</b> $checkout
                    <br>
                    <b>Tipo de Pagamento:</b> $m_p
                    <br>
                    <b>Data:</b> $date 
                </td>
                <td>
                    $preco_t
                </td>
                <td>
                    <button type="button" onclick="reembolso_reserva($data[reserva_id])" class="btn btn-success btn-sm fw-boldshadow-none">
                        <i class="bi bi-cash-stack"></i> Reembolso
                    </button>
                </td>
            </tr>
            data;
            $cont++;  
        }
        
        $paginacao = "";
        $total = getTotal($Conexao, $q1, ["%$data[search]%","%$data[search]%","%$data[search]%","Cancelado",0]);
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

        $output = json_encode(['table_data' => $text, 'paginacao' => $paginacao]);
        echo $output;
    }

    if(isset($_POST["reembolso_reserva"])){
        $data = filtracao($_POST);

        $q= "UPDATE reserva_pedido SET reembolso=? WHERE reserva_id=?";

        $valor = [1,$data["reserva_id"]];
        $res = Atualizar($Conexao,$q,$valor);
        echo $res;
    }

?>