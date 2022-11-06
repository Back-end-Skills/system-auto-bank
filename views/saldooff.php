<?php 
    namespace models; 

    if (isset($_GET['codigo_agencia'])) 
    {
        $agencia = filter_input(INPUT_GET, 'codigo_agencia', FILTER_SANITIZE_SPECIAL_CHARS);
    } else  {
        $agencia="";
    }
    
    if(isset($_GET['codigo_conta'])) 
    {
        $conta = filter_input(INPUT_GET, 'codigo_conta', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $conta="";
    }
    
    $crud = new ModelCrud();
    
    $select_conta = $crud->selectDB("*", "conta","", array());     
    //$dados_conta=$select_conta->fetch(\PDO::FETCH_ASSOC);                                    
    
    while($dados_conta=$select_conta->fetch(\PDO::FETCH_ASSOC))
    {
        // echo "id:".$dados_conta['id_conta'] ."<br>";
        // echo "Agencia". $dados_conta['codigo_agencia'] ."<br>";
        // echo "Conta". $dados_conta['codigo_conta']."<hr>";

        // if($dados_conta['codigo_conta'] == $conta) 
        // {
        //      $res_real= number_format($dados_conta['saldo'], 2, ',', '.');
        //     return $res_real; $saldo = $real;
       
        // } else {
        //     $res = ""
        // }

        if($dados_conta['codigo_agencia'] != $agencia)
        {
            $res  =  "Agência Inválida!";
            echo $res;
        } 
        
    }  


    //$select_conta = $crud->selectDB("*", "conta","WHERE codigo_conta=? AND ", array($conta));                                         
    //$dados_conta = $select_conta->fetch(\PDO::FETCH_ASSOC);  

    //var_dump($dados_conta);

   
   

    
?>

<?php include_once './include/head.php'; ?>
<?php include_once './include/header.php'; ?>

   

    <section>

        <div class="_title">
            <h1>Verificar Saldo </h1>
        </div>

        <div class="saldo">
            <h3>Seu saldo é: </h3>
            <p><?php echo "R$ ".$saldo; ?></p>
        </div>

        <div class="features">

            <div class="_box">
                
            <form  action="" name="formSaldo" id="formSaldo" method="POST">
                <div class="__responseSaldo"></div> 
                

                <input type="text" name="codigo_agencia"  id="codigo_agencia" placeholder="Código agência" /><br><br> 
                <input type="text" name="codigo_conta"  id="codigo_conta" placeholder="Código Conta" /><br><br> 

                <button type="submit" >Consultar</button><br><br>                

            </form>
            </div>

           

        </div>
    </section>

    <script src="<?php echo DIRJS.'jquery.min.js'; ?>"></script>
    <script src="<?php echo DIRJS.'javascript.js' ; ?>"></script>

    
    