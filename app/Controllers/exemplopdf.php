<!DOCTYPE html>
<html lang="pt-AO" dir="ltr">
<head>
    <meta charset='utf-8'>
    <title>Recibo da Reserva</title>
    <style>
        *{
            font-family: 'Times New Roman', Times, serif;
        }

        /* */
        header h1 {
            text-transform: uppercase;
            font-family: 'Courier New', Courier, monospace;
        }

        #imagem{
            position:absolute;
            left: 550px;
            top: 25px;
        }

        #head1 span{
            display: block;
            font-size: 10pt;
            font-weight: normal;
        }

        header h2 {
            margin-bottom: 1.5px;
        }

        header h1 {
            margin-bottom: 1.5px;
            margin-top: 0px;
        }
        /* */

        table {   
            width: 100%;
            font-family: 'Courier New', Courier, monospace;
            
        }

        tbody div span strong{
          text-transform: capitalize;  
        }

        tbody div span{
            display: block;
            font-size: 12pt;
            margin: 5px;
        }

        /** */

        table{
            background-color: #fefefe;
            border-radius: 5px;
            border: 1px solid;
        }

        table td,th{
            border: 1px solid #ccc;
        }

        table th{
            font-weight: bold;
            color:aliceblue;
            background-color: #a650f1;

        }
        
        #pagamento {
          position: relative;
          top: 70px;  
        }

        #pagamento span {
            display: block;
            font-size: 11pt;
            font-weight: normal;
        }

        footer{
            position: relative;
            top: 250px
        }

        footer p {
            font-size: 10pt;
        }


    </style>
</head>
<body>
    <header>
        <h1>Recibo da Reserva</h1>
        <h2><?php echo $contactos[0]['site_titulo'];?></h2>
        <div id="head1">
            <span>Cassequel do Lourenço</span>
            <span>Luanda-Angola</span>
            <span>1 Nª Telemovel: <?php echo $contactos2[0]['pn1'];?></span>
            <span>2 Nª Telemovel: <?php echo $contactos2[0]['pn2'];?></span>
        </div>
        <div id="imagem">
            <img src="LOGO.png" height="100px" width="150px"> 
        </div>
    </header>
    <hr>
    <main>
        <br>
        <table>
            <thead> 
                <tr>
                    <th>Informações da Reserva</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div>
                            <span><strong>Número da Reserva: </strong><?php echo $od;?> </span>
                            <span><strong>Data da Reserva: </strong> <time datatime><?php echo $slct_fetch['datetime'];?></time></span>
                            <span><strong>Nome do Hóspode: </strong> <?php echo $frm_data['nome'];?></span>
                            <span><strong>Telefone: </strong><?php echo $frm_data['tel'];?></span>
                            <span><strong>Endereço: </strong><?php echo $frm_data['endereco'];?></span>
                            <span><strong>Check-in: </strong><time date><?php echo $frm_data['entrada'];?></time></span>
                            <span><strong>Check-out: </strong><time date><?php echo $frm_data['saida'];?></time></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table>
            <thead> 
                <tr>
                    <th>Informações do Pagamento</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $m_p = ($frm_data['Pag'] =="pagamento_chegada")? "Pagamento ao Chegar ao Hotel":"Transferência Bancária";
                ?>
                <tr>
                    <td>
                        <strong>Tipo de Pagamento: </strong> <?php echo $m_p;?>
                    </td>
            
                </tr>
                <tr>
                    <td>
                        <strong>Tipo de Quarto: </strong><?php echo $_SESSION['quarto']['nome'];?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Preço: </strong><?php echo formato_kwanza($_SESSION['quarto']['preco']);?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Valor a Pagar: </strong><?php echo formato_kwanza($_SESSION['quarto']['pagamento']);?>
                    </td>
                </tr>
                <!--<tr>
                    <td>
                        <strong>Desconto: </strong><php# echo formato_kwanza("0");?>
                    </td>
                </tr>-->
            </tbody>
        </table>
        <br>
        <div id="pagamento">
            <p><strong>CONDIÇÃO E FORMA DE PAGAMENTO</strong></p>
            <span>O pagamento deve ser feito no prazo de 48 horas</span>
            <span>- Banco CAIXA GERAL ANGOLA</span>
            <span>- IBAN: AO06 0004000000832929210124</span>
            <span>- Nº de conta: 016003188 11 001</span>
        </div>
    </main>
    <footer>
        <?php 
            $q= "<a href='mailto:".$contactos2[0]['email']."'>".$contactos2[0]['email']."</a> ou Whatsapp: <a href='".$contactos2[0]['wt']."'>".$contactos2[0]['pn1']."</a>";
        ?>
        <p>Em caso de dúvida respectivamente a esta factura, contacte-nos através do E-mail <?php echo $q; ?>.</p>
        <h4 style="text-align: center;">AGRADECEMOS A SUA PREFERÊNCIA!</h4>

    </footer>

</body>
</html> 