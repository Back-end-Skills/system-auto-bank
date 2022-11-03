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
                    
                    $('.retornoCad').append('Conta Criada!\n');
                    
                    //Limpa os inputs
                    $('#formCadastro input').each(function(){
                       
                        $(this).val('');
                    
                    }); 

                }
            }
        });
    });

    /*==============================================*/
    /*         Ajax do formulário de login          */ 
    $("#formLogin").on("submit",function(event){
        event.preventDefault();
        var dados=$(this).serialize();

        $.ajax({
        url: getRoot()+'controllers/controllerLogin',
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function (response) {
                if(response.retorno == 'success'){
                    window.location.href=response.page;
                }else{
                    if(response.tentativas == true){
                        $('.loginFormulario').hide();  //Trava de segurança 
                    }
                    $('.resultadoForm').empty();
                    $.each(response.erros, function(key, value){
                        $('.resultadoForm').append(value+'<br>');
                    });
                } 
            }
        });
    });

    

    /*==============================================*/
    /*         Aviso Sobre Tecla CapsLock           */ 
    $("#senha").keypress(function(e){
        kc=e.keyCode?e.keyCode:e.which;
        sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);
        if(((kc>=65 && kc<=90) && !sk)||(kc>=97 && kc<=122)&&sk){ $(".resultadoForm").html("Caps Lock Ligado"); }
        else{ $(".resultadoForm").empty(); }
    });

    
   