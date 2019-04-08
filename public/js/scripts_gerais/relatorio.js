$(document).on('click', '.btnRelatorioMaterial', function() {
        var option = '' ;

        $.getJSON('./relatorios/materiais', function(dados){
                
                //console.log(dados);
                
                if(dados.length > 0){
                    $.each(dados, function(i,dado){
                        console.log(dado.tipo);
                        option += '<option>'+dado.tipo+'</option>' ;//agrupando ambientes por tipo
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

$(document).on('click', '.btnRelatorioSetor', function() {

        $('.modal-title').text('Relatório de Setor');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#relatorio_setor-modal').modal('show');
});