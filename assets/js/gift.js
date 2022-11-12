    function getRoot(){

        var root = window.location.protocol+"//"+document.location.hostname+"/github/system-auto-bank/";
        return root;
    }
    
   
    $("#formGift").on("submit",function(event){
        event.preventDefault();
        var dados=$(this).serialize();

        $.ajax({
        url: getRoot()+'controllers/controllerGift',
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) 
            {
                if(response.retorno == 'success')
                {
                   
                    $('.__responseSuccess').append('Compra realizado com Sucesso!\n');
                    
                    //Limpa os inputs
                    $('#formGift input').each(function(){
                       
                        $(this).val('');
                    
                    }); 

                } else {
                    $.each(response.erros, function(key, value)
                    {
                        $('.__responseBad').append(value+'<br>');
                    });
                } 
            }
        });
    });

   