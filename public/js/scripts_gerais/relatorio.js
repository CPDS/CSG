$(document).on('click', '.btnRelatorioMaterial', function() {
        var option = '<option></option>' ;
        $.getJSON('./gerenciar-materiais/materiais', function(dados){
                if(dados.length > 0){
                    $.each(dados, function(i,dado){
                        option += '<option value='+dado.id+'>'+dado.tipo+'</option>' ;//agrupando ambientes por tipo
                    });
                            $('#materiais').html(option).show();
                }
        });
        $('.modal-title').text('Relatório de Material');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#relatorio_material-modal').modal('show');
});

$(document).on('click', '.btnRelatorioEscala', function() {
        var option = '<option></option>' ;
        $.getJSON('./gerenciar-users/funcionarios', function(dados){
                if(dados.length > 0){
                    $.each(dados, function(i,dado){
                        option += '<option value='+dado.id+'>'+dado.name+'</option>' ;//agrupando ambientes por tipo
                    });
                $('#funcionariosEscala').html(option).show();
                }
        });  
        var option_setores = '<option></option>' ;
        $.getJSON('./gerenciar-setores/setores', function(dados){
                if(dados.length > 0){
                    $.each(dados, function(i,dado){
                        option_setores += '<option value='+dado.id+'>'+dado.nome+'</option>' ;//agrupando ambientes por tipo
                    });
                $('#setoresEscala').html(option_setores).show();
                }
        });      
        $('.modal-title').text('Relatório de Escala');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#relatorio_escala-modal').modal('show');
});

$(document).on('click', '.btnRelatorioHora', function() {
        var option = '<option></option>' ;
        $.getJSON('./gerenciar-users/funcionarios', function(dados){
                if(dados.length > 0){
                    $.each(dados, function(i,dado){
                        option += '<option value='+dado.id+'>'+dado.name+'</option>' ;//agrupando ambientes por tipo
                    });
                $('#funcionariosHora').html(option).show();
                }
        });  
        
        $('.modal-title').text('Relatório de Horas Extras');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#relatorio_horas-modal').modal('show');
});
