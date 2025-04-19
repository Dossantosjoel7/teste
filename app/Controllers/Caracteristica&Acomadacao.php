<?php 

require("../Controllers/essencial.php");
require("../Models/Database.php");

session_start();


if(isset($_POST['add_caracteristicas'])){
    $data = filtracao($_POST);

    $q = "INSERT INTO caracteristicas (nome) VALUES (?)";
    $valor =[$data['caracteristicas_nome']];
    $res = Inserir($Conexao,$q,$valor);
    echo $res;
}

if(isset($_POST['get_caracteristicas'])){
    $q = "SELECT * FROM caracteristicas ORDER BY id DESC";
    $datab = Selecao($Conexao,$q,$q,false);
    $cont=1;
    foreach ($datab as $data) {
        echo <<<data
        <tr>
            <th scope="row">$cont</th>
            <td>$data[nome]</td>
            <td>
                <button type="button" onclick="delete_caracteristica($data[id])" class='btn btn-sm shadown-none btn-danger'>
                <i class="bi bi-trash"></i> Apagar
                </button>
            </td>
        </tr>
        data;
        $cont++;
    }

}

if(isset($_POST['delete_caracteristicas'])){
    $data = filtracao($_POST);
    $check_q = Selecao($Conexao,'SELECT * FROM quartos_caracteristica WHERE caracteristica_id=?',[$data['delete_caracteristicas']],true);

    if($check_q == 0){
       $q = "DELETE FROM caracteristicas  WHERE id=?";
       $valor =[$data['delete_caracteristicas']];
       $res = Delete($Conexao,$q,$valor);
       echo $res; 
    }else{
        echo 'add_quarto';
    }
    
}


if(isset($_POST['add_acomadacao'])){
    $data = filtracao($_POST);
    $img = uploadSVG_Image($_FILES['acomadacao_icone'],ACOMADACAO_FOLDER);

    if($img == 'inv_img'){
        echo $img;
    }else if($img == 'inv_size'){
        echo $img;
    }else if($img == 'upd_failed'){
        echo $img;
    }else{
        $q = "INSERT INTO  acomadacao (icone,nome,descricao)  VALUES (?,?,?)";
        $valor =[$img,$data['acomadacao_nome'],$data['acomadacao_des']];
        $res = Inserir($Conexao,$q,$valor);
        echo $res;
    }
}

if(isset($_POST['get_acomadacao'])){
    $q = "SELECT * FROM acomadacao ORDER BY id DESC";
    $datab = Selecao($Conexao,$q,$q,false);
    $path = ACOMADACAO_IMAGE_PATH;
    $cont=1;
    foreach ($datab as $data) {
        echo <<<data
        <tr>
            <th scope="row">$cont</th>
            <td><img src="$path$data[icone]" width="100px"></td>
            <td>$data[nome]</td>
            <td>$data[descricao]</td>
            <td>
                <button type="button" onclick="delete_acomadacao($data[id])" class='btn btn-sm shadown-none btn-danger'>
                <i class="bi bi-trash"></i> Apagar
                </button>
            </td>
        </tr>
        data;
        $cont++;
    }

}

if(isset($_POST['delete_acomadacao'])){
    $data = filtracao($_POST);
    $check_q = Selecao($Conexao,'SELECT * FROM quartos_acomadacao WHERE acomadacao_id=?',[$data['delete_acomadacao']],true);
    if($check_q == 0){
        $valor =[$data['delete_acomadacao']];
        $q = "SELECT * FROM acomadacao WHERE id=?";
        $datab = Selecao($Conexao,$q,$valor,false);

        if(deleteImage($datab[0]['icone'],ACOMADACAO_FOLDER)){
            $q = "DELETE FROM acomadacao  WHERE id=?";
            $res = Delete($Conexao,$q,$valor);
            echo $res;
        }else{
            echo 0;
        }

    }else{
        echo 'add_quarto';
    }
    
}

?>