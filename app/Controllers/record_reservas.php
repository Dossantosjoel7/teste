<?php

    /*
        Nome: Codigo PHP relacionado com parte Administrativa, resposavel por mostrar todas  as reservas 
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
    
        $q= "SELECT reserva_pedido.*, reserva_detalhes.* FROM reserva_pedido 
               INNER JOIN reserva_detalhes ON reserva_pedido.reserva_id=reserva_detalhes.reserva_id
               WHERE ((reserva_pedido.reserva_status='reservado' AND reserva_pedido.chegada=1) OR (reserva_pedido.reserva_status='Cancelado' AND reserva_pedido.reembolso=1)) AND (reserva_pedido.ordem_id LIKE ? OR reserva_detalhes.tel LIKE ? OR reserva_detalhes.user_nome LIKE ?) ORDER BY reserva_pedido.reserva_id DESC";
    
        $limite_q = $q. " LIMIT {$perPage} OFFSET {$offset}";
        $limite_res = $Conexao->prepare($limite_q);
        $limite_res->execute(["%$data[search]%", "%$data[search]%", "%$data[search]%"]);
    
        $cont = $offset + 1;
        $text = "";
        $total_linhas = $limite_res->rowCount();
    
        if ($total_linhas == 0) {
            $output = json_encode(['table_data' => "<b>Nenhum dado encontrado!</b>", "paginacao" => '']);
            echo $output;
            exit;
        }
    
        $dataf = $limite_res->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($dataf as $data) {
            // Resto do código do loop foreach
    
            $date = date("d-m-Y",strtotime($data['datetime']));
        $checkin = date("d-m-Y",strtotime($data['check_in']));
        $checkout = date("d-m-Y",strtotime($data['check_out']));

        if($data["reserva_status"] == "reservado"){
            $status_bg = "bg-success";
        }else if($data["reserva_status"] == "Cancelado"){
            $status_bg = "bg-danger";
        }else{
            $status_bg = "bg-warning text-dark";
        }

        $preco = Formato_Kwanza($data['preco']);
        $preco_t = Formato_Kwanza($data['total_pay']);
        $m_p = ($data['tipo_pag'] =="pagamento_chegada")? "Pagamento ao Chegar ao Hotel":"Transferência Bancária";
        $codi= base64_encode($data['invoice']);
        $dt = "2ªVia-".$data['user_nome']. rand(100, 999).date('Yd');
        #$text .= print_r($dataf);
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
                <b>Quarto:</b> $data[quarto_nome]
                <br>
                <b>Preço:</b> $preco
                <br>
                <b>Nª do Quarto:</b> $data[quarto_no]
            </td>
            <td>
                <b>Total Pago:</b> $preco_t
                <br>
                <b>Tipo de Pagamento:</b> $m_p
                <br>
                <b>Data:</b> $date 
            </td>
            <td>
                <span class="badge $status_bg">$data[reserva_status]</span>
            </td>
            <td>
                <button type="button" class="btn btn-outline-success btn-sm fw-bold shadow-none">
                    <a class="btn-outline-success" href="data:application/pdf;base64,$codi" download="$dt"><i class="bi bi-filetype-pdf"></i></a>
                </button>
            </td>
        </tr>
        data;
        $cont++; 
        }
    
        $paginacao = "";
        $total = getTotal($Conexao, $q, ["%$data[search]%", "%$data[search]%", "%$data[search]%"]);
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

?>