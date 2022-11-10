<?php include_once './include/head.php'; ?>
<?php include_once './include/header.php'; ?>

   

    <section class="_container">

    
        <div class="container__box">

            <div class="_title container__box ">
                <h1>Gift Card</h1>
            </div>

            <div class="__responseBad"></div>
            <div class="__responseSuccess"></div>

            <form action="" method="POST" class="formGift" id="formGift">

                <div class="_box">
                    <select name="tipo" id="tipo">
                        <option selected>Seleciona o Gift</option>
                        <option value="recarga">Recarga</option>
                        <option value="stream">Stream</option>
                        <option value="game">Game</option>
                    </select>
                    
                </div>
        
                <div id="_tipo-stream" style="display: none;">
                    <select name="empresa" id="stream">
                        <option selected value="netflix">NETFLIX</option>
                        <option value="prime">PRIME VIDEO</option>
                        <option value="disney">DISNEY</option>
                        <option value="hbo">HBO</option>
                    </select><br>
                </div>

                <div id="_tipo-recarga" style="display:none;">
                    <select name="empresa" id="recarga">
                        <option value="vivo">VIVO </option>
                        <option value="claro">CLARO </option>
                        <option value="tim">TIM </option>
                        <option value="oi">OI </option>

                    </select>
                </div>

                <div id="_tipo-game" style="display: none;">
                    <select name="empresa" id="game">
                        <option value="xbox">XBOX</option>
                        <option value="nitendo">NITENDO</option>
                        <option value="steam">STEAM</option>
                        <option value="atari">ATARI</option>
                    </select>
                </div>

                <div class="_gift-valor">
                    <label for="">valor </label><br>
                    <input type="text" name="valor_gift"><br>
                </div>

                <div class="_dados-conta">
                    <label for="">agencia </label><br>
                    <input type="text" name="codigo_agencia"><br>

                    <label for="">Conta</label><br>
                    <input type="text" name="codigo_conta"><br>
                </div>

                <button type="submit">Comprar</button>

            </form>

        </div>
    </section>

    <script>

        var tipo = document.getElementById("tipo");
     
       
       //setAttribute('name');
        tipo.addEventListener('change', function () {
           
           if (this.value == 'stream')
           {
               document.getElementById('_tipo-stream').style.display = 'block';  
          
               let name_recarga =document.getElementById('recarga').removeAttribute("name");
               let name_game =document.getElementById('game').removeAttribute("name");                
               
           } else {
            document.getElementById('_tipo-stream').style.display = 'none';
           }

           if (this.value == 'recarga')
           {
               document.getElementById('_tipo-recarga').style.display = 'block';  

               let name_recarga =document.getElementById('stream').removeAttribute("name");
               let name_game =document.getElementById('game').removeAttribute("name");

           }  else {
            document.getElementById('_tipo-recarga').style.display = 'none';  
           }

           if (this.value == 'game')
           {
               document.getElementById('_tipo-game').style.display = 'block';  

               let name_recarga =document.getElementById('stream').removeAttribute("name");
               let name_game =document.getElementById('recarga').removeAttribute("name");

           }  else {
                document.getElementById('_tipo-game').style.display = 'none';  
           }
       }); 

    </script>


<script src="<?php echo DIRJS.'jquery.min.js' ; ?>"></script>

    <script src="<?php echo DIRJS.'gift.js'; ?>"></script>
    
   

</html>


    