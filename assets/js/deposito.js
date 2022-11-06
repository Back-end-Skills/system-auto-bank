    /*==============================================*/
    /*          Retorno do root                     */ 
    function getRoot(){

        var root = window.location.protocol+"//"+document.location.hostname+"/github/system-auto-bank/";
        return root;
    }
    
    /*==============================================*/
    /*      Ajax do formulário de cadastro          */ 
    $("#formCadastro").on("submit",function(event){
        event.preventDefault();
        var dados=$(this).serialize();

        $.ajax({
        url: getRoot()+'controllers/controllerRegister',
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) {
                
                $('.retornoCad').empty();

                if(response.retorno == 'erro'){

                    $.each(response.erros,function(key,value){
                    
                        $('.retornoCad').append(value+'');
                    
                    });

                } else {
                    //Redireciona depois de 1 segundo para login
                    setTimeout(function() {
                        window.location.href=getRoot()+'views/info-bank';
                    }, 1000);

                }
            }
        });
    });


    /*==============================================*/
    /*         Ajax do Saldo                       */ 
    $("#formDepos").on("submit",function(event){
        event.preventDefault();
        var dados=$(this).serialize();

        $.ajax({
        url: getRoot()+'controllers/controllerDeposito',
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) 
            {
                if(response.retorno == 'success')
                {
                    $('.__responseDeposito').empty();
                    $('.__responseDeposito').append('Depósito realizado com Sucesso!\n');

                } else {
                    $.each(response.erros, function(key, value)
                    {
                        $('.__responseDeposito').append(value+'<br>');
                    });
                } 
            }
        });
    });

   