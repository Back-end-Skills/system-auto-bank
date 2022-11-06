<?php include_once './include/head.php'; ?>
<?php include_once './include/header.php'; ?>

    <section>

        <div class="_title">
            <h1>Nova Conta Corrente </h1>
        </div>

        <div>
            

        </div>

        <div class="features">

            <form action="" method="post" id="formCadastro">

                   <!-- Response Cadast | Ajax-->
                   <div class="retornoCad"></div>

                    <input type="text" name="nome"  id="nome" placeholder="Nome Completo"  ><br><br>                                                
                    <input type="date" name="nascimento"  id="nascimento" placeholder="Sua data de nascimento" require><br><br>
                    <input type="text" name="cpf"  id="cpf" placeholder="cpf" require><br><br>                                                
                    <input type="email" name="email"  id="email" placeholder="meuemail@gmail.com"  ><br><br>			  
                    
                    <input type="password" name="senha"  id="senha" placeholder="Crie Uma Senha" ><br><br>
                                            
                    <button type="submit" class="btn">Registrar</button><br>

            </form>
           

        </div>
    </section>

    <script src="<?php echo DIRJS.'jquery.min.js'; ?>"></script>
    <script src="<?php echo DIRJS.'javascript.js' ; ?>"></script>
    
    