<?php include_once './include/head.php'; ?>
<?php include_once './include/header.php'; ?>

   

    <section>

        <div class="_title">
            <h1>Realizar Uma Transferência</h1>
        </div>

        <div class="features">

            <div class="_box">
                  
                <form  action="" name="formTransf" id="formTransf" method="POST">
                    <div class="__responseSuccess"></div> 
                    <div class="__responseErr"></div> 
                    
                    <h2>Dados de Origem</h2> <br>
                    <label for="">Código Agência</label><br>
                    <input type="text" name="codigo_agencia"  id="codigo_agencia" placeholder="Código agência" require/><br><br> 

                    <label for="">Código Conta</label><br>
                    <input type="text" name="codigo_conta"  id="codigo_conta" placeholder="Código Conta" require/><br><br> 

                    <label for="">Valor</label><br>
                    <input type="text" name="valor"  id="valor" placeholder="valor " require/><br><br> 
                    

                    <h2>Dados de Destino</h2><br>
                    <label for="">Agência destino</label><br>
                    <input type="text" name="codigo_agencia_destino"  id="codigo_agencia_destino" placeholder="Código agência destino" require/><br><br> 

                    <label for="">Conta destino</label><br>
                    <input type="text" name="codigo_conta_destino"  id="codigo_conta_destino" placeholder="Código Conta destino" require/><br><br> 
              
                    <button type='submit' >Enviar</button><br><br>
                    
                </form>
            </div>
           
        </div>
    </section>

    <script src="<?php echo DIRJS.'jquery.min.js'; ?>"></script>
    <script src="<?php echo DIRJS.'transferencia.js' ; ?>"></script>

    
    