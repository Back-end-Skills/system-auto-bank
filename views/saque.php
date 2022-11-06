<?php session_start(); ?>

<?php include_once './include/head.php'; ?>
<?php include_once './include/header.php'; ?>

    <section>

        <div class="_title">
            <h1>Realizar Saque</h1>
        </div>

        <div class="saldo">
            
            <p><?php
                if(isset($_SESSION["id_conta"])) 
                {
                    $res =  $_SESSION['saldo'];
                    $res_real = number_format($res, 2, ',', '.');
                    
                    $saldo =  $res_real;

                    echo "<h3>Seu saldo é: R$</h3> ".$saldo;
                    
                    unset($_SESSION['id_conta']);
                } else {
                    echo "";
                }
            ?></p>
        </div>

        <div class="features">

            <div class="_box">
                
                <form  action="" name="formSaldo" id="formSaldo" method="POST">
                    <div class="__responseSaque"></div> 
                    
                    <label for="">Código Agência</label><br>
                    <input type="text" name="codigo_agencia"  id="codigo_agencia" placeholder="Código agência" /><br><br> 

                    <label for="">Código Conta</label><br>
                    <input type="text" name="codigo_conta"  id="codigo_conta" placeholder="Código Conta" /><br><br> 

                    <label for="">Valor Saque</label><br>
                    <input type="text" name="valor_saque"  id="valor_saque" placeholder="valor saque" /><br><br> 

                    <button type='submit'>Enviar</button><br><br>
                    
                </form>
            </div>

        </div>
    </section>

    <script src="<?php echo DIRJS.'jquery.min.js'; ?>"></script>
    <script src="<?php echo DIRJS.'saque.js' ; ?>"></script>