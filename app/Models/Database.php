
<?php

    /*
        Nome: Arquivo de conexão de Base de Dados 
        Copyright: 2022-2023 © Herman&Joel
        Data de Criação: 16/01/23 19:58
        Data de Ultima Revisão: 16/01/23 22:26
        Descrição: Arquivo PHP Resposavel por criar base de dados usado PDO.

    */

    define('DB_NAME','bd_hotelhome'); // Corresponde ao Nome do Banco de dados 
    define('DB_SERVER','localhost'); // Corresponde ao Servidor de acesso do Banco de Dados
    define('DB_USERNAME','root');// Corresponde ao Nome do Usuario  do Banco de Dados
    define('DB_PASSWORD',''); // Corresponde ao PASSWORD do Banco de dados conetado no Servidor 


    try{
        $Conexao = new PDO("mysql:dbname=".DB_NAME.";host=".DB_SERVER,DB_USERNAME,DB_PASSWORD);
        $Conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        #echo "<p>Base de dados <strong>" . DB_NAME . "</strong>,conectado com Sucesso!!!</p>";
    }catch(PDOException $e){
        echo "<p>Houve um erro ao conectar a Base de dados -> <strong>" . DB_NAME . "</strong>, ".$e->getMessage()."</p>";
    }catch(Exception $e){
        echo "<p>Houve um erro generico: ".$e->getMessage()."</p>";
    }


    function filtracao($data){
        foreach ($data as $elemento => $valor) {

            $valor = trim($valor);//retira o espaço no inicio e final de uma string
            $valor = stripcslashes($valor);// retira as barras invertidas uma string
            $valor = strip_tags($valor);// retira as tags html de uma string
            $valor = htmlspecialchars($valor);// converte caracteres especiais em entidade html de uma string
            
            $data[$elemento] =$valor;  
        }
        return $data;
    }

    function Selecionar_all($Conexao,$Tabela){
        $stmt = $Conexao->prepare("SELECT * FROM $Tabela");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    function Selecao($Conexao,$sql,$valores,$retorno){
            try {
                $stmt = $Conexao->prepare($sql);
                $stmt->execute($sql === $valores? null: $valores);
                if($retorno == true){
                    return $stmt->fetch(PDO::FETCH_NUM);
                }else{
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                
            } catch (PDOException $e) {
                die("A consulta não pode ser executada- Select: ".$e->getMessage());
            }

        }

        function Atualizar($Conexao,$sql,$valores){
            try {
                $stmt = $Conexao->prepare($sql);
                $stmt->execute($sql === $valores? null: $valores);
                $res = $stmt->rowCount();
                return $res;
            } catch (PDOException $e) {
                die("A consulta não pode ser executada- Update: ".$e->getMessage());
            }
        }

        function Inserir($Conexao,$sql,$valores){
            try {
                $stmt = $Conexao->prepare($sql);
                $stmt->execute($sql === $valores? null: $valores);
                return $Conexao->lastInsertId();
            } catch (PDOException $e) {
                die("A consulta não pode ser executada- Insert: ".$e->getMessage());
            }
        }

        function Delete($Conexao,$sql,$valores){
            try {
                $stmt = $Conexao->prepare($sql);
                $stmt->execute($sql === $valores? null: $valores);
                $res = $stmt->rowCount();
                return $res;
            } catch (PDOException $e) {
                die("A consulta não pode ser executada- Delete: ".$e->getMessage());
            }
        }

        function getTotal($pdo, $sql, $params) {

            // Remover order, limit, etc
            $countSql = preg_replace('/\.ORDER BY .*/i', '', $sql); 
            $countSql = preg_replace('/\.LIMIT .*/i', '', $countSql);
          
            // Trocar select por count(*)
            $countSql = preg_replace('/SELECT .* FROM/i', 'SELECT COUNT(*) FROM', $countSql);
          
            $stmt = $pdo->prepare($countSql);
            $stmt->execute($params);
          
            return $stmt->fetchColumn();
          
          }
          

?>
