<?php 

    /*
        Nome: Codigo PHP relacionado a finalizaçao da reserva e geraçao de PDF
        Copyright: 2022-2023 © Herman&Joel
        Descrição: ...

    */

    require('../Controllers/d_con.php');
    require_once '../vendor/autoload.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;
    
    session_start();

    function GerarPDF()
    {

        global $_POST;
        global $_SESSION;
        global $Conexao;
        global $slct_fetch;
        global $contactos;
        global $contactos2;
        global $od;
        $frm_data = filtracao($_POST);

        $opt = new Options();
        $opt -> setChroot(__DIR__);
        $opt -> setIsRemoteEnabled(true);

        $pdf = new Dompdf($opt);

        ob_start();
        require_once('../Controllers/exemplopdf.php');
        $html = ob_get_clean();

        // Renderize o HTML com o Dompdf
        $pdf->loadHtml($html);
        $pdf -> setPaper('A4','portrait');
        $pdf ->render();
        #$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        /*$pdf->SetCreator('Herman&Joel');
        $pdf->SetAuthor($contactos[0]['site_titulo']);
        $pdf->SetTitle('Recibo da Reserva');
        $pdf->SetSubject('Recibo responsavel por apresentar dados da reserva do cliente ');
        
        #$pdf->SetFont('times', '', 14);
        $pdf->setPrintHeader(false); // desabilita a impressão do cabeçalho padrão
        $pdf->setHeaderData('','', '', '', array(), array(255, 255, 255)); // define o cabeçalho personalizado
        $pdf->setHeaderMargin(0); // define a margem superior do cabeçalho
        $pdf->AddPage();*/

        ////
        

       /* $pdf->SetFont('times','B',20);
        $pdf->Cell(130 ,5,$contactos[0]['site_titulo'],0,0);
        $pdf->Cell(59 ,5,'Recibo de Reserva',0,1);
        $pdf->Cell(59 ,10,"",0,2);


        $pdf->SetFont('times','',12);

        $pdf->Cell(130 ,5,"Cassequel do Lourenço",0,0);
        $pdf->Cell(59 ,5,'',0,1);//end of line

        $pdf->Cell(130 ,5,'Luanda-Angola',0,0);
        $pdf->Cell(20 ,5,'Dª Reserva:',0,0);
        $pdf->Cell(40 ,5,$slct_fetch['datatime'],0,1);

        $pdf->Cell(130 ,5,'1ª Telemovel: '.$contactos2[0]['pn1'],0,0);
        $pdf->Cell(25 ,5,'Nª Reserva:',0,0);
        $pdf->Cell(34 ,5,$od,0,1);
        $pdf->Cell(130 ,5,'2ª Telemovel: '.$contactos2[0]['pn2'],0,0);

        $pdf->Cell(189 ,10,'',0,1);

        $pdf->SetFont('times','B',20);
        // adicionar informações da reserva
        $pdf->Cell(0, 10, 'Informações da Reserva', 0, 1);
        $pdf->SetFont('times','',14);
        $pdf->Cell(0, 10, "Nome: ".$frm_data['nome'], 0, 1);
        $pdf->Cell(0, 10, 'Telefone: '.$frm_data['tel'], 0, 1);
        $pdf->Cell(0, 10, 'Check-in: '.$frm_data['entrada'], 0, 1);
        $pdf->Cell(0, 10, 'Check-out: '.$frm_data['saida'], 0, 1);
        $pdf->Cell(0, 10, 'Endereço: '.$frm_data['endereco'], 0, 1);
        
        $m_p = ($frm_data['Pag'] =="pagamento_chegada")? "Pagamento ao Chegar ao Hotel":"Transferência Bancária";
        // adicionar informações de pagamento
        $pdf->SetFont('times','B',20);
        $pdf->Cell(0, 10, 'Informações de Pagamento', 0, 1);
        $pdf->SetFont('times','',14);
        $pdf->Cell(0, 10, 'Tipo: '.$m_p, 0, 1);
        $pdf->Cell(0, 10, 'Total a pagar: '.formato_kwanza($_SESSION['quarto']['pagamento']), 0, 1);
*/

        if(isset($_POST['user'])){
             $comprovante_nome = "invoice" .$_SESSION['uId']. rand(100, 999).date('Yd').".pdf";
        }else{
            $comprovante_nome = "invoice" .$_SESSION['At']. rand(100, 999).date('Yd').".pdf";
        }

       
        #$caminho_completo = __DIR__ . '/invoice/' . $comprovante_nome;

        // verifique se o diretório existe e tem permissão de escrita
        /*if (!is_dir(__DIR__ . '/invoice')) {
            mkdir(__DIR__ . '/invoice', 0777, true);
        }*/

        $pdf_data = $pdf->Output();
        
        #UPDATE reserva_pedido SET invoice='HH' WHERE reserva_id='".$slct_fetch['reserva_id']."'"
        #"INSERT INTO reservas (invoice) VALUES (:pdf_data)"
        #:pdf_data WHERE id = :reserva_id"
        $query = $Conexao->prepare("UPDATE reserva_pedido SET invoice=:pdf_data WHERE reserva_id =:reserva_id");
        $query->bindParam(':pdf_data', $pdf_data, PDO::PARAM_LOB);
        $query->bindParam(':reserva_id',$slct_fetch['reserva_id'], PDO::PARAM_INT);
        $query->execute();
        
        return $comprovante_nome;
        // gerar o PDF e salvá-lo no caminho completo
        #return $pdf->Output($caminho_completo, 'F');
        #return $pdf->Output('http://localhost/Projecto-Final/app/Libs/TCPDF/comprovante/'.$comprovante_nome, 'F');
    }

    function Regeneracao_session($uid)
    {
        global $Conexao;
        $user_q = Selecao($Conexao, "SELECT * FROM user_home WHERE id=? LIMIT 1", [$uid],false);
        $_SESSION['login'] = true;
        $_SESSION['uId'] = $user_q[0]['id'];
        $_SESSION['uName'] = $user_q[0]['nome'];
        $_SESSION['uPic'] = $user_q[0]['profile'];
        $_SESSION['uPhone'] = $user_q[0]['tel'];
    }

    if(!isset($_SESSION['login']) && !isset($_SESSION['Adlogin'])){
        if(isset($_SESSION['Adlogin'])){
            echo "";
        }else{
           redirect("../Views/Index.php");  
        }
    }

    /*if( (!(isset($_SESSION['login']) || !(isset($_SESSION['Adlogin'])))) && (($_SESSION['login'] ==true || $_SESSION['Adlogin'] == true))){
        redirect("../Views/Index.php");
    }*/

    # Finalizaçao da Reserva na parte Cliente
    if(isset($_POST['user'])){
        header("Pragma: no-cache");
        header("Cache-Control: no_cache");
        header("Expires: 0");

        $frm_data = filtracao($_POST);
        $od = 'Pedido_'.$_SESSION['uId'].random_int(1111,9999).date('Yd');

        $q1 ="INSERT INTO reserva_pedido(user_id, quarto_id, check_in, check_out, ordem_id) VALUES (?,?,?,?,?)";

        Inserir($Conexao,$q1,[$_SESSION['uId'],$_SESSION['quarto']['id'],$frm_data['entrada'],$frm_data['saida'],$od]);

        $reserva_id = $Conexao->lastInsertId();
        $q2="INSERT INTO reserva_detalhes(reserva_id,quarto_nome,preco,total_pay,user_nome,tel,endereco,tipo_pag) VALUES (?,?,?,?,?,?,?,?)";
        $result= Inserir($Conexao,$q2,[$reserva_id,$_SESSION['quarto']['nome'],$_SESSION['quarto']['preco'],$_SESSION['quarto']['pagamento'],$frm_data['nome'],$frm_data['tel'],$frm_data['endereco'],$frm_data['Pag']]);

        if ($result) {

            $slct_query ="SELECT reserva_id,user_id,pedido_status,datetime FROM reserva_pedido WHERE ordem_id='".$od."'";
            $slct_res = $Conexao->prepare($slct_query);
            $slct_res -> execute();

            if($slct_res->rowCount() == 0){
                redirect('../Views/Index.php');
            }

            $slct_fetch = $slct_res->fetch(PDO::FETCH_ASSOC);
            $rt=GerarPDF();
            if(!(isset($_SESSION['login']) && $_SESSION['login'] ==true)){
                Regeneracao_session($slct_fetch['user_id']);
            }

            if($slct_fetch['pedido_status'] == 'pendente'){
                $upd_query = "UPDATE reserva_pedido SET reserva_status ='reservado' ,pedido_status='sucesso' WHERE reserva_id='".$slct_fetch['reserva_id']."'";
                $rex = $Conexao->prepare($upd_query);
                $rex ->execute();
                #print_r($slct_fetch);
                redirect('../Views/sucesso_reserva.php?pedido='.$od.'&in='.$rt);
            }else{
                $upd_query = "UPDATE reserva_pedido SET reserva_status ='falha em reserva' ,pedido_status='sucesso' WHERE reserva_id='".$slct_fetch['reserva_id']."'";
                $rex = $Conexao->prepare($upd_query);
                $rex ->execute();
                redirect('../Views/sucesso_reserva.php?pedido='.$od);
            }

        } else {
            redirect("../Views/Index.php");
        }
    

    }


    # Finalizaçao da Reserva na parte Administrativa
    if(isset($_POST['admin'])){
        header("Pragma: no-cache");
        header("Cache-Control: no_cache");
        header("Expires: 0");

        $frm_data = filtracao($_POST);
        $od = 'Pedido_'.$_SESSION['At'].random_int(1111,9999).date('Yd');

        $q1 ="INSERT INTO reserva_pedido(user_id, quarto_id, check_in, check_out, ordem_id) VALUES (?,?,?,?,?)";

        Inserir($Conexao,$q1,[3,$_SESSION['quarto']['id'],$frm_data['entrada'],$frm_data['saida'],$od]);

        $reserva_id = $Conexao->lastInsertId();
        $q2="INSERT INTO reserva_detalhes(reserva_id,quarto_nome,preco,total_pay,user_nome,tel,endereco,tipo_pag) VALUES (?,?,?,?,?,?,?,?)";
        $result= Inserir($Conexao,$q2,[$reserva_id,$_SESSION['quarto']['nome'],$_SESSION['quarto']['preco'],$_SESSION['quarto']['pagamento'],$frm_data['nome'],$frm_data['tel'],$frm_data['endereco'],$frm_data['Pag']]);

        if ($result) {

            $slct_query ="SELECT reserva_id,user_id,pedido_status,datetime FROM reserva_pedido WHERE ordem_id='".$od."'";
            $slct_res = $Conexao->prepare($slct_query);
            $slct_res -> execute();

            if($slct_res->rowCount() == 0){
                echo 0;
            }

            $slct_fetch = $slct_res->fetch(PDO::FETCH_ASSOC);
            $rt=GerarPDF();
            if($slct_fetch['pedido_status'] == 'pendente'){
                $upd_query = "UPDATE reserva_pedido SET reserva_status ='reservado' ,pedido_status='sucesso' WHERE reserva_id='".$slct_fetch['reserva_id']."'";
                $rex = $Conexao->prepare($upd_query);
                $rex ->execute();
                echo 1;
            }else{
                $upd_query = "UPDATE reserva_pedido SET reserva_status ='falha em reserva' ,pedido_status='sucesso' WHERE reserva_id='".$slct_fetch['reserva_id']."'";
                $rex = $Conexao->prepare($upd_query);
                $rex ->execute();
                echo 1;
            }

        } else {
            echo 0;
        }
    
    }


?>