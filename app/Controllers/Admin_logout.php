<?php

    require("../Controllers/essencial.php");
    require("../Models/Database.php");

    session_start();

    date_default_timezone_set('Africa/Luanda');
    Atualizar($Conexao,"UPDATE acesso SET saida=? WHERE id=?",[$time,$_SESSION['At']]);
    $time = date("Y-m-d H:i:s");
    session_destroy();
    header('location: ../Admin/indexAdmin.php');

?>