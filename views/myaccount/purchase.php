<?php      
    namespace models;
    
    \Classes\ClassUserSession::setUser('user');
  
    $crud = new ModelCrud();

    $email = $_SESSION['email'];
    $id_user=$_SESSION['id_account'];
    $name_user = $_SESSION['name'];
                                                                      

?>

    <h2>Meus Orçamento</h2>

    <?php  
        $select_purchase=$crud->selectDB("*", "purchase","WHERE fk_account=?", array($id_user)); 
                                            
        while($items=$select_purchase->fetch(\PDO::FETCH_ASSOC)){   
        ?>


    <?php
        echo $items['id'] . "<br>";
        echo $items['items'] ."<br>";
    ?>

    <hr>

    <label>Ações:</label>
    <a href="<?php echo "inserir-anuncio?id={$items['id']}"; ?>"> Editar</a>
    <a class="deletar-anuncio" href="<?php echo "controllers/controllerExcluir?ads-id={$items['id']}"; ?>">
        Deletar</a>

    <hr style="border: 2px solid #999;">



    <?php 
    }
    ?>