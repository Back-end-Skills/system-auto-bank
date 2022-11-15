<?php    
    namespace Classes;

    use Models\ModelCrud;

    $session = new SessionClass();
    //session_start(); 
    $id_conta = $_SESSION["id_conta"];

    $crud = new ModelCrud();

    $query = $crud->selectDB("*", "transacao", "WHERE fk_conta=?", array($id_conta));
    echo "<h1>Exibir Extrato de ".$_SESSION["conta"]."</h1> <br>";
    while($query_row = $query->fetch(\PDO::FETCH_ASSOC))
    {
        extract($query_row);

        echo "<b> codigo </b> = ". $codigo . "<br>";        
        echo "<b> fk_conta </b> = ". $fk_conta . "<br>";        
        echo "<b> descricao </b> = ". $descricao . "<br>";        
        echo "<b> tipo </b> = ". $tipo . "<br>";        
        echo "<b> data </b> = ". $data_create . "<br>";
        echo "____________________________________________ <br>";    
        $query_log = $crud->selectDB("*", "log", "WHERE fk_codigo_transacao=?", array($codigo));

        while($result_log = $query_log->fetch(\PDO::FETCH_ASSOC))
        {
            extract($result_log);
            echo "id log = " . $id_log . "<br>";
            echo "fk_codigo_transacao = " . $fk_codigo_transacao . "<br>";
            echo "Valor da transacao = " . $valor_transacao . "<br>";
            echo "------------------------------------------ <br>";

        }
        
    }

    



    

    // echo "id_cont = " . $_SESSION["id_conta"] ."<br> Agência  = ". $_SESSION["agencia"] . "<br>";
    // echo "Código da Transação = " . $_SESSION["fk_conta"];
    // echo "<br>Conta =".  $_SESSION["conta"];