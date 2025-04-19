<?php

/*
	Nome: Arquivo que contem informaçoes basicas do Website 
	Copyright: 2022-2023 © Herman&Joel
	Descrição: Aqui tem as informacoes tiradas apartir da base de dados como configuraçoes e contactos

*/

        require("../Models/Database.php");
        require("../Controllers/essencial.php");
        date_default_timezone_set('Africa/Luanda');


        $quer1 = "SELECT * FROM configuracoes WHERE id_confg=? ";
        $quer2 = "SELECT * FROM contactos_detalhes WHERE id_cont=? ";
        $value = [1];
        $value2 = [1];
        $contactos = Selecao($Conexao,$quer1,$value,false);
        $contactos2 = Selecao($Conexao,$quer2,$value,false);

        if($contactos[0]['Desligado']){
            echo <<<alertbar
                <div class='bg-danger text-center p-2 fw-bold'>
                    <i class="bi bi-exclamation-triangle-fill"></i> As Reservas estão Temporariamente Encerradas
                </div>
            alertbar;
        }

?>