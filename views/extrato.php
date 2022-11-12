<?php include_once './include/head.php'; ?>
<?php include_once './include/header.php'; ?>

   

    <section>

        <div class="_title">
            <h1>Extrato da Sua conta </h1>
        </div>

        <div class="features">

            <div class="_box">
                <form action="" method="POST" name="formExtr" id="formExtr">
                    <div class="__responseErr"></div>
                    
                    <label for="">Código Agência</label><br>
                    <input type="text" name="codigo_agencia"  id="codigo_agencia" placeholder="Código agência" require/><br><br> 

                    <label for="">Código Conta</label><br>
                    <input type="text" name="codigo_conta"  id="codigo_conta" placeholder="Código Conta" require/><br><br> 

                    <label for="">Data Inicial</label>
                    <input type="date" name="data_inicial"> <br><br>
                    
                    <label for="">Data Final</label>
                    <input type="date" name="data_final"><br><br>

                    <button type="submit">Pesquisar</button>

                </form>
            </div>

        

        </div>
    </section>

    <script src="<?php echo DIRJS.'jquery.min.js'; ?>"></script>
    <script src="<?php echo DIRJS.'extrato.js' ; ?>"></script>

   
    