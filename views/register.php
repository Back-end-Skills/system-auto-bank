<!DOCTYPE html>
<html lang="pr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo DIRCSS.'style-register.css'; ?>">

    <title>Criar um Nova Conta | Constrool</title>
</head>
<body>
    
    <header>
    
    <h1 style="margin: 3rem auto 4rem auto;text-align:center">Register</h1>
    </header>

    <div class="register">
    
      
        
            <!-- START form de Cadastro-->
            <form action="<?php echo DIRPAGE.'controllers/controllerRegister'; ?>" name="formCadastro" id="formCadastro" method="post" >				
                                        
                <!-- Response Cadast | Ajax-->
                <div class="retornoCad"></div>

                <input type="text" name="nome"  id="nome" placeholder="Nome"  required><br><br>
                <input type="email" name="email"  id="email" placeholder="meuemail@gmail.com"  required><br><br>			  
                                            
                <input type="text" name="contato"  id="contato" placeholder="Fone 9xxxx-xxxx" require><br><br>
                                            
                <input type="password" name="senha"  id="senha" placeholder="Crie Uma Senha" required><br><br>
                <input type="password" name="senhaConf"  id="senhaConf" placeholder="Confirme Sua Senha"  required><br><br>
                                        
                <button type="submit" class="btn">Registrar</button><br>
                                    
            </form>
            
       

    </div>

    <script src="<?php echo DIRJS.'jquery.min.js'; ?>"></script>
    <script src="<?php echo DIRJS.'javascript.js'; ?>"></script>

    </body>
</html>    