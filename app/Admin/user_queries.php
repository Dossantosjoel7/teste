<?php

session_start();

if(!isset($_SESSION['rol'])){
    header('location: indexAdmin.php');
}


require("../Models/Database.php");
require("../Controllers/essencial.php");

if(isset($_GET['visto'])){
    $dat = filtracao($_GET);
    if($dat['visto'] == "all"){
        $q = "UPDATE mensagem SET visto=?";
        $valor = [1];
        if(Atualizar($Conexao,$q,$valor)){
            alert('success','Todos Marcados');
        }else{alert('error','Operação Falhada!');}
    }else{
        $q = "UPDATE mensagem SET visto=? WHERE id_uc=?";
        $valor = [1,$dat['visto']];
        if(Atualizar($Conexao,$q,$valor)){
            alert('success','Marcado');
        }else{alert('error','Operação Falhada!');}
    }
}

if(isset($_GET['deletar'])){
    $dat = filtracao($_GET);
    if($dat['deletar'] == "all"){
        $q = "DELETE FROM mensagem";
        if(Delete($Conexao,$q,$q)){
            alert('success','Todas as mensagems deletadas');
        }else{alert('error','Operação Falhada!');}
    }else{
        $q = "DELETE FROM mensagem WHERE id_uc=?";
        $valor = [$dat['deletar']];
        if(Delete($Conexao,$q,$valor)){
            alert('success','Mensagem Deletada');
        }else{alert('error','Operação Falhada!');}
    }
}


?>

<!DOCTYPE html>
<html lang="pt-ao">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php require("../Views/Links.php");?>
        <title>Pagina de Controle - Mensagens de Contactos</title>

    </head>
    <body class="bg-light">
        <!-- -->
        <?php
        if($_SESSION['rol']== 1){
                    require("../Admin/Admin_header.php");
                } else{
                    require("../Admin/Recip_header.php");
                }?>
        <!-- -->
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <div class="col-md-12 fs-4 breadcrumb"><a href="../Admin/Admin_view.php"><i class="bi bi-house" style="color: rebeccapurple;"></i></a> / Mensagens de Contactos</div>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">

                            <div class="text-end mb-4">
                                <a href='?visto=all' class='btn btn-dark rounded-pill  shadow-none btn-sm'>
                                    <i class="bi bi-check-all"></i> Marcar todos Vistos
                                </a>
                                <a href='?deletar=all' class='btn btn-danger rounded-pill  shadow-none btn-sm'>
                                    <i class="bi bi-trash"></i> Apagar todos Vistos
                                </a>
                            </div>
                            <div class="table responsive-md" style="height: 150px; overflow-y: scroll;">
                                <table class="table table-hover border">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th scope="col">#</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Email</th>
                                            <th scope="col" width="20%">Assunto</th>
                                            <th scope="col" width="30%">Mensagem</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Acção</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $q = "SELECT * FROM mensagem ORDER BY id_uc DESC";
                                            $datab = Selecao($Conexao,$q,$q,false);
                                            $cont =1;

                                            foreach ($datab as $data) {
                                                $date =date("d-m-y",strtotime($data["datetime"]));
                                                $visto="";
                                                if($data['visto']!=1){
                                                    $visto = "<a href='?visto=$data[id_uc]' class='btn btn-sm rounded-pill btn-primary'>Visto</a> ";
                                                }
                                                $delete= "<a href='?deletar=$data[id_uc]' class='btn btn-sm rounded-pill btn-danger'> Apagar</a>";
                                                echo <<<data
                                                <tr>
                                                    <th scope="row">$cont</th>
                                                    <td>$data[nome]</td>
                                                    <td>$data[email]</td>
                                                    <td>$data[assunto]</td>
                                                    <td>$data[mensagem]</td>
                                                    <td>$date</td>
                                                    <td>
                                                        $visto
                                                        $delete
                                                    </td>
                                                </tr>
                                                data;
                                                $cont++;
                                            }

                                        ?>
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                    </div>
                    
                    </div>
                    <!-- -->
                </div>
            </div>

        <?php require("../Views/scripts.php");?>

    </body>
</html>