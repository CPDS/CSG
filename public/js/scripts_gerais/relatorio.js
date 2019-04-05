$(document).on('click', '.btnRelatorioSetor', function() {

        $('.modal-title').text('Relatório de Setor');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#relatorio_setor-modal').modal('show');
});


