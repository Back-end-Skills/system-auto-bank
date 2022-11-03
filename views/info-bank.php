<?php 
    namespace models; 

    $crud = new ModelCrud();

    $select_conta = $crud->selectDB("*", "conta","ORDER BY id_conta DESC", array()); 
                                            
$dados_conta = $select_conta->fetch(\PDO::FETCH_ASSOC);  

     var_dump($dados_conta);
    

?>

<?php include_once './include/head.php'; ?>
<?php include_once './include/header.php'; ?>

    <section>

        <div class="_title">
            <h1>Nova Conta Corrente </h1>
        </div>

        <div>
            <?php 


                echo $dados_conta['id_conta']. "<br>";
                echo $dados_conta['codigo_conta']. "<br>";
                echo  $dados_conta['codigo_agencia']."<br>";
            ?>

        </div>

       
    </section>

    <script src="<?php echo DIRJS.'jquery.min.js'; ?>"></script>
    <script src="<?php echo DIRJS.'javascript.js' ; ?>"></script>
    
    