<?php

    /*
        Nome: Codigo PHP para fazer logout do Usuario
        Copyright: 2022-2023 © Herman&Joel
        Descrição: ...

    */

    require("../Controllers/essencial.php");
    require("../Models/Database.php");
    date_default_timezone_set('Africa/Luanda');
    session_start();

    $time = date("Y-m-d H:i:s");

    Atualizar($Conexao,"UPDATE acesso SET saida=? WHERE id=?",[$time,$_SESSION['uT']]);

    session_destroy();
    header('location: ../Views/Index.php');

?>