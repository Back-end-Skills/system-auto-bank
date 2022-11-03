
<h1 style="margin: 3rem auto 4rem auto; text-align:center">Entrar</h1>

<div style="margin-top:3rem; display: flex; align-items: center; justify-content:center;">  

    <form  action="<?php echo DIRPAGE.'controller/controllerLogin'; ?>" name="formLogin" id="formLogin" method="post">


        <input name="email" type="email" id="email" placeholder="Seu Email" required><br><br>
        <input name="senha" type="password" id="senha" placeholder="Sua Senha" required><br><br>

        <button type="submit" >Entrar</button><br><br>
        
        <a href="<?php echo DIRPAGE.'recover-password'; ?>">Esqueci minha senha</a>

    </form>

</div>

<script src="<?= DIRJS.'jquery.min.js'; ?>"></script>
<script src="<?= DIRJS.'javascript.js'; ?>"></script>
