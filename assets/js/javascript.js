    function getRoot()
    {
        var root = window.location.protocol+"//"+document.location.hostname+"/github/system-auto-bank/";
        return root;
    }
    
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

                if(response.retorno == 'erro')
                {
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
 
    $("#formLogin").on("submit",function(event){
        event.preventDefault();
        var dados=$(this).serialize();

        $.ajax({
        url: getRoot()+'controllers/controllerLogin',
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
                        $('.__responseLogin').append(value+'<br>');
                    });
                } 
            }
        });
    });

    $("#formSaldo").on("submit",function(event){
        event.preventDefault();
        var dados=$(this).serialize();

        $.ajax({
        url: getRoot()+'controllers/controllerSaldo',
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
                        $('.__responseSaldo').append(value+'<br><br>');
                    });
                } 
            }
        });
    });

   