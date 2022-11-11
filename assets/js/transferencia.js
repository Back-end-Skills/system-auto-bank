    /*==============================================*/
    /*          Retorno do root                     */ 
    function getRoot(){

        var root = window.location.protocol+"//"+document.location.hostname+"/github/system-auto-bank/";
        return root;
    }
    
    /*==============================================*/
    /*         Ajax do Transferencia               */ 
    $("#formTransf").on("submit",function(event){
        event.preventDefault();
        var dados=$(this).serialize();

        $.ajax({
        url: getRoot()+'controllers/controllerTransferi',
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) 
            {
                if(response.retorno == 'success')
                {
                   
                    $('.__responseSuccess').append('Transferência realizado com Sucesso!\n');
                    
                    //Limpa os inputs
                    $('#formTransf input').each(function(){
                       
                        $(this).val('');
                    
                    }); 

                } else {
                    $.each(response.erros, function(key, value)
                    {
                        $('.__responseErr').append(value+'<br>');
                    });
                } 
            }
        });
    });

   