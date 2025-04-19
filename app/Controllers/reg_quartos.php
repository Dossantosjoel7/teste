<?php

    /*
        Nome: Codigo PHP relacionado a registro de Quartos 
        Copyright: 2022-2023 © Herman&Joel
        Descrição: ...

    */

require("../Controllers/essencial.php");
require("../Models/Database.php");


session_start();

if(isset($_POST['add_quartos'])){
    $caracteristica = filtracao(json_decode($_POST['caracteristica']));
    $acomadacao = filtracao(json_decode($_POST['acomadacao']));
    $data = filtracao($_POST);
    $flag =0;
    $q = "INSERT INTO quartos(nome, area, preco,quant,adulto,crianca,descricao) VALUES (?,?,?,?,?,?,?)";
    $valor =[$data['nome'],$data['area'],$data['preco'],$data['quant'],$data['adulto'],$data['crianca'],$data['desc']];

    if(Inserir($Conexao,$q,$valor)){
        $flag = 1;
    }

    $quarto_id = $Conexao ->lastInsertId();
    $q2 = "INSERT INTO quartos_caracteristica(quartos_id,caracteristica_id) VALUES (?,?)";
    
    if($stm = $Conexao -> prepare($q2)){
        foreach ($caracteristica as $f) {
          $stm -> execute([$quarto_id,$f]);
        }

        $stm -> closeCursor();
    }else{
        $flag =0;
        die("A consulta não pode ser executada- Select");
    }

    $q3 = "INSERT INTO quartos_acomadacao(quartos_id,acomadacao_id) VALUES (?,?)";
    if($stm = $Conexao -> prepare($q3)){
        foreach ($acomadacao as $f) {
          $stm -> execute([$quarto_id,$f]);
        }

        $stm -> closeCursor();
    }else{
        $flag =0;
        die("A consulta não pode ser executada- Select");
    }

    if($flag){
        echo 1;
    }else{
        echo 0;
    }

}


if(isset($_POST['get_image'])){
    $data = filtracao($_POST);
    $res =Selecao($Conexao,"SELECT * FROM quartos_imagem WHERE quartos_id=?",[$data['get_image']],false);
    $path = QUARTO_IMAGE_PATH;
    foreach ($res as $data) {
        if($data['thumb']==1){
            $thumb_btn ="<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
        }else{
            $thumb_btn ="<button onclick='thumb_image($data[id],$data[quartos_id])' class='btn btn-secondary shadow-none'>
                            <i class='bi bi-check-lg'></i>
                        </button>";
        }
        echo <<<data
        <tr class='align-middle'>
            <td><img src="$path$data[image]" class='img-fluid'></td>
            <td>$thumb_btn</td>
            <td>
                <button onclick='rem_image($data[id],$data[quartos_id])' class='btn btn-danger shadow-none'>
                    <i class='bi bi-trash'></i>
                </button>
            </td>
        </tr>
        data;
    }
}

if(isset($_POST['gets_quartos'])){
    $q = "SELECT * FROM quartos WHERE removido=?";
    $datab = Selecao($Conexao,$q,[0],false);
    $cont=1;
    foreach ($datab as $data) {

        if($data['status'] ==1){
            $status = "<button onclick='trocar_Status($data[id],0)' class='btn btn-dark btn-sm shadow-none'>Activo</button>";
        }else{
            $status = "<button onclick='trocar_Status($data[id],1)' class='btn btn-warning btn-sm shadow-none'>Inactivo</button>";
        }
        
        $preco= Formato_Kwanza($data['preco']);


        echo <<<data
        <tr class='align-middle'>
            <th scope="row">$cont</th>
            <td>$data[nome]</td>
            <td>$data[area] m<sup>2</sup></td>
            <td>
                <span class="badge rounded-pill bg-light text-dark">
                    Adulto: $data[adulto]
                </span>
                <span class="badge rounded-pill bg-light text-dark">
                    Crianca: $data[crianca]
                </span>
            </td>
            <td>$preco</td>
            <td>$data[quant]</td>
            <td>$status</td>
            <td>
                <button type='button' onclick="edit_detalhes($data[id])" class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#quartos_edit'>
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button type='button' onclick="quarto_image($data[id],'$data[nome]')" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#quartos_image'>
                    <i class="bi bi-images"></i>
                </button>
                <button type='button' onclick="remove_quarto($data[id])" class='btn btn-danger shadow-none btn-sm'>
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        data;
        $cont++;
    }

}

if(isset($_POST['edit_quarto'])){
    $caracteristica = filtracao(json_decode($_POST['caracteristica']));
    $acomadacao = filtracao(json_decode($_POST['acomadacao']));
    $data = filtracao($_POST);
    $flag =0;

    $q1 = "UPDATE  quartos SET nome=?, area=?, preco=?,quant=?,adulto=?,crianca=?,descricao=? WHERE id=?";
    $valor =[$data['nome'],$data['area'],$data['preco'],$data['quant'],$data['adulto'],$data['crianca'],$data['desc'],$data['quartos_id']];
    if(Atualizar($Conexao,$q1,$valor)){
        $flag = 1;
    }

    $del_caracteristica = Delete($Conexao,"DELETE FROM `quartos_caracteristica` WHERE quartos_id=?",[$data['quartos_id']]);
    $del_acomadacao = Delete($Conexao,"DELETE FROM `quartos_acomadacao` WHERE quartos_id=?",[$data['quartos_id']]);

    if(!($del_acomadacao && $del_caracteristica)){
        $flag = 0;
    }

    $quarto_id = $Conexao ->lastInsertId();
    $q2 = "INSERT INTO quartos_caracteristica(quartos_id,caracteristica_id) VALUES (?,?)";
    if($stm = $Conexao -> prepare($q2)){
        foreach ($caracteristica as $f) {
          $stm -> execute([$data['quartos_id'],$f]);
        }
        $flag = 1;
        $stm -> closeCursor();
    }else{
        $flag =0;
        die("A consulta não pode ser executada- Select");
    }

    $q3 = "INSERT INTO quartos_acomadacao(quartos_id,acomadacao_id) VALUES (?,?)";
    if($stm = $Conexao -> prepare($q3)){
        foreach ($acomadacao as $f) {
          $stm -> execute([$data['quartos_id'],$f]);
        }
        $flag = 1;
        $stm -> closeCursor();
    }else{
        $flag =0;
        die("A consulta não pode ser executada- Select");
    }

    if($flag){
        echo 1;
    }else{
        echo 0;
    }

}


if(isset($_POST['trocar_Status'])){
    $data = filtracao($_POST);
    $q = "UPDATE quartos SET status=?  WHERE id=?";
    $valor =[$data['value'],$data['trocar_Status']];
    if(Atualizar($Conexao,$q,$valor)){
        echo 1;
    }else{
        echo 0;
    }
}

if(isset($_POST['get_quartos'])){
    $data = filtracao($_POST);

    

    $res1 =Selecao($Conexao,"SELECT * FROM quartos WHERE id=?",[$data['get_quartos']],false);
    $res2 =Selecao($Conexao,"SELECT * FROM quartos_acomadacao WHERE quartos_id=?",[$data['get_quartos']],false);
    $res3 =Selecao($Conexao,"SELECT * FROM quartos_caracteristica WHERE quartos_id=?",[$data['get_quartos']],false);

    $caracteristica = [];
    $acomadacao = [];


    if($res2){
        foreach ($res2 as $row) {
            array_push($acomadacao,$row['acomadacao_id']);
        }
    }

    if($res3){
        foreach ($res3 as $row) {
            array_push($caracteristica,$row['caracteristica_id']);
        }
    }

    $list= ["quartos_data" => $res1, "caracteristica" => $caracteristica,"acomadacao" => $acomadacao];

    $x =json_encode($list);
    
    echo $x;
}

if(isset($_POST['add_image'])){
    $data = filtracao($_POST);
    $img = uploadImage($_FILES['image'],QUARTO_FOLDER);

    if($img == 'inv_img'){
        echo $img;
    }else if($img == 'inv_size'){
        echo $img;
    }else if($img == 'upd_failed'){
        echo $img;
    }else{
        $q = "INSERT INTO  quartos_imagem(quartos_id, image)  VALUES (?,?)";
        $valor =[$data['quarto_id'],$img];
        $res = Inserir($Conexao,$q,$valor);
        echo $res;
    }
}

if(isset($_POST['rem_image'])){
    $data = filtracao($_POST);
    $valor =[$data['image_id'],$data['quartos_id']];
    $q = "SELECT * FROM quartos_imagem WHERE id=? AND quartos_id=?";
    $datab = Selecao($Conexao,$q,$valor,false);

    if(deleteImage($datab[0]['image'],QUARTO_FOLDER)){
        $q = "DELETE FROM quartos_imagem WHERE id=? AND quartos_id=?";
        $res = Delete($Conexao,$q,$valor);
        echo $res;
    }else{
         echo 0;
    }


}

if(isset($_POST['thumb_image'])){
    $data = filtracao($_POST);
    $pre_q = "UPDATE quartos_imagem SET  thumb=? WHERE quartos_id=?";
    $pre_v = [0,$data['quartos_id']];
    
    $pre_res = Atualizar($Conexao,$pre_q,$pre_v);

    $q = "UPDATE quartos_imagem SET  thumb=? WHERE id=? AND quartos_id=?";
    $v = [1,$data['image_id'],$data['quartos_id']];
    $res = Atualizar($Conexao,$q,$v);

    echo $res;



}

if(isset($_POST['remove_quarto'])){
    $data = filtracao($_POST);
    $res1 =Selecao($Conexao,"SELECT * FROM quartos_imagem WHERE quartos_id=?",[$data['quartos_id']],false);

    foreach ($res1 as $key) {
        deleteImage($key['image'],QUARTO_FOLDER);
    }
    $res2 =Delete($Conexao,"DELETE FROM quartos_imagem WHERE quartos_id=?",[$data['quartos_id']]);
    $res3 =Delete($Conexao,"DELETE FROM quartos_caracteristica WHERE quartos_id=?",[$data['quartos_id']]);
    $res4 =Delete($Conexao,"DELETE FROM quartos_acomadacao WHERE quartos_id=?",[$data['quartos_id']]);
    $res5 =Atualizar($Conexao,"UPDATE quartos SET removido=? WHERE id=?",[1,$data['quartos_id']]);

    if($res2 || $res3 || $res4 || $res5){
        echo 1;
    }else{
        echo 0;
    }
}




?>