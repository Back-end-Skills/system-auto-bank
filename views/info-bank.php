<?php 
    namespace models; 

    $crud = new ModelCrud();

    $select_conta = $crud->selectDB("*", "conta","ORDER BY id_conta DESC", array());                                         
    $dados_conta = $select_conta->fetch(\PDO::FETCH_ASSOC);  

    //var_dump($dados_conta);
    

?>

<?php include_once './include/head.php'; ?>
<?php include_once './include/header.php'; ?>

    <section>

        <div class="_title">
            <h1>Dados da Sua Nova Conta</h1>
        </div>

        <div>

            <h2>Número da sua Conta</h2>
              <p> <span><?php echo $dados_conta['codigo_conta']; ?></span></p>
            
            <h2>Sua Agência</h2>
             <p> <span><?php echo $dados_conta['codigo_agencia']; ?></span></p>

            <p>Utilize sua conta e agencia, juntamente com sua senha para realizar <a href="<?php echo DIRPAGE . 'login'; ?>"> login </a> </p>
            <a href="<?php echo DIRPAGE . ''; ?>"> Inicial </a>  
 

           
        </div>

       
    </section>