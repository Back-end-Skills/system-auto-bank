    function getRoot(){

        var root = window.location.protocol+"//"+document.location.hostname+"/github/system-auto-bank/";
        return root;
    }

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
                    $('.__responseSuccess').append('Depósito realizado com Sucesso!\n');
                    
                    //Limpa os inputs
                    $('#formDepos input').each(function(){
                       
                        $(this).val('');
                    
                    }); 

                } else {
                    $.each(response.erros, function(key, value)
                    {
                        $('.__responseDeposito').append(value+'<br>');
                    });
                } 
            }
        });
    });

   