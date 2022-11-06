
<h1 style="margin: 3rem auto 4rem auto; text-align:center">Entrar</h1>

<div style="margin-top:3rem; display: flex; align-items: center; justify-content:center;">  

    <form  action="<?php echo DIRPAGE.'controller/controllerLogin'; ?>" name="formLogin" id="formLogin" method="post">
        <div class="__responseLogin"></div>

        <input type="text" name="codigo_agencia"  id="codigo_agencia" placeholder="Código agência" require/><br><br> 
        <input type="text" name="codigo_conta"  id="codigo_conta" placeholder="Código Conta" require/><br><br> 
        
        <input type="password" name="senha"  id="senha" placeholder="Sua Senha" required><br><br>

        <button type="submit" >Entrar</button><br><br>
                
        <a href="<?php echo DIRPAGE.'nova-conta-corrente'; ?>" >Nova Conta </button><br><br>
        

    </form>

</div>

<script src="<?= DIRJS.'jquery.min.js'; ?>"></script>
<script src="<?= DIRJS.'javascript.js'; ?>"></script>
