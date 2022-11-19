<?php    
    namespace Classes;

    use Models\ModelCrud;

    $session = new SessionClass();
   
    $id_conta = $_SESSION["id_conta"];

    $crud = new ModelCrud();

    // $query = $crud->selectDB("*", "transacao", "WHERE fk_conta=?, BETWEEN data_create=? AND data_create=?", array($id_conta));
    
    $query = $crud->selectDB("*", "transacao", "WHERE fk_conta=?", array($id_conta));
    
    echo "<h1>Exibir Extrato </h1> ";
    echo "<h2>Agência: {$_SESSION["agencia"]} Conta: {$_SESSION["conta"]} </h2> <br>";
    
    while($query_row = $query->fetch(\PDO::FETCH_ASSOC))
    {
        extract($query_row);

        $data_format_brazil = date('d-m-Y H:i:s', strtotime($data_create));
        echo "<b> data </b> = ". $data_format_brazil . "<br>";
               
        echo "<b> descricao </b> = ". $descricao . "<br>";        

        $query_log = $crud->selectDB("*", "log", "WHERE fk_codigo_transacao=?", array($codigo));

        while($result_log = $query_log->fetch(\PDO::FETCH_ASSOC))
        {
            extract($result_log);

            if($tipo == 'credito' )
            {
                echo "<b>Valor Crédito </b> +" . $valor_transacao . "<br>";
       
            } else {
                echo "<b>Valor Débito </b>  -" . $valor_transacao . "<br>";
                
            }
            echo "------------------------------------------ <br>"; 

        }
        
    }

    echo "<br>Saldo =".  $_SESSION["saldo"];