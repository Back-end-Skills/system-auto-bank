    function getRoot(){

        var root = window.location.protocol+"//"+document.location.hostname+"/github/system-auto-bank/";
        return root;
    }

   
    $("#formExtr").on("submit",function(event){
        event.preventDefault();
        var dados=$(this).serialize();

        $.ajax({
        url: getRoot()+'controllers/controllerExtrato',
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) 
            {
                if(response.retorno == 'success')
                {
                    window.location.href=response.page;
                } else {
                 
                    $.each(response.erros, function(key, value)
                    {
                        $('.__responseErr').append(value+'<br>');
                    });
                } 
            }
        });
    });

    
   