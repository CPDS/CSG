$(document).ready(function($) {
    
    var base_url = 'http://' + window.location.host.toString();
    var base_url = location.protocol + '//' + window.location.host.toString();


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    
    var tabela = $('#table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: './gerenciar-horas/list',
            columns: [
            { data: null, name: 'order' },
            { data: 'nome_funcionario', name: 'nome_funcionario' },
            { data: 'horas_excedidas', name: 'horas_excedidas' },
            { data: 'dia', name: 'dia' },
            { data: 'local', name: 'local' },
            { data: 'acao', name: 'acao' },
            ],
            createdRow : function( row, data, index ) {
                row.id = "item-" + data.id;   
            },

            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            scrollX: true,
            sorting: [[ 1, "asc" ]],
            responsive: true,
            lengthMenu: [
                [10, 15, -1],
                [10, 15, "Todos"]
            ],
            language: {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sloadingRecords": "carregando...",
                "sProcessing": "<div><i class='fa fa-circle-o-notch fa-spin' style='font-size:38px;'></i> <span style='font-size:20px; margin-left: 5px'> carregando...</span></div>",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            columnDefs : [
              { targets : [4], sortable : false },
              { "width": "5%", "targets": 0 }, 
              { "width": "20%", "targets": 1 },
              { "width": "20%", "targets": 2 }, 
              { "width": "10%", "targets": 3 },
              { "width": "12%", "targets": 4 }
            ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();



    $('.modal-footer').on('click', '.add', function() {
        var dados = new FormData($("#form")[0]); //pega os dados do form

        console.log(dados);

        $.ajax({
            type: 'post',
            url: "/gerenciar-horas/store",
            data: dados,
            processData: false,
            contentType: false,
            beforeSend: function(){
                jQuery('.add').button('loading');
            },
            complete: function() {
                jQuery('.add').button('reset');
            },
            success: function(data) {
                 //Verificar os erros de preenchimento
                if ((data.errors)) {

                    $('.callout').removeClass('hidden'); //exibe a div de erro
                    $('.callout').find('p').text(""); //limpa a div para erros successivos

                    $.each(data.errors, function(nome, mensagem) {
                            $('.callout').find("p").append(mensagem + "</br>");
                    });

                } else {
                    
                    $('#table').DataTable().draw(false);

                    jQuery('#criar_editar-modal').modal('hide');

                    $(function() {
                        iziToast.destroy();
                        iziToast.success({
                            title: 'OK',
                            message: 'Hora extra adicionado com Sucesso!',
                        });
                    });

                
                }
            },

            error: function() {
                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });


    $('.modal-footer').on('click', '.edit', function() {
        var dados = new FormData($("#form")[0]); //pega os dados do form

        console.log(dados);

        $.ajax({
            type: 'post',
            url: "/gerenciar-horas/update",
            data: dados,
            processData: false,
            contentType: false,
            beforeSend: function(){
                jQuery('.edit').button('loading');
            },
            complete: function() {
                jQuery('.edit').button('reset');
            },
            success: function(data) {
                 //Verificar os erros de preenchimento
                if ((data.errors)) {

                    $('.callout').removeClass('hidden'); //exibe a div de erro
                    $('.callout').find('p').text(""); //limpa a div para erros successivos

                    $.each(data.errors, function(nome, mensagem) {
                            $('.callout').find("p").append(mensagem + "</br>");
                    });

                } else {
                    
                    $('#table').DataTable().draw(false);

                    jQuery('#criar_editar-modal').modal('hide');

                    $(function() {
                        iziToast.destroy();
                        iziToast.success({
                            title: 'OK',
                            message: 'Hora extra alterado com Sucesso!',
                        });
                    });
                }
            },

            error: function() {
                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });

    $('.modal-footer').on('click', '.excluir', function() {
        var dados = new FormData($("#deletar")[0]); //pega os dados do form

        console.log(dados);

        $.ajax({
            type: 'post',
            url: "/gerenciar-horas/delete",
            data: dados,
            processData: false,
            contentType: false,
            beforeSend: function(){
                jQuery('.excluir').button('loading');
            },
            complete: function() {
                jQuery('.excluir').button('reset');
            },
            success: function(data) {
                 //Verificar os erros de preenchimento
                if ((data.errors)) {

                    $('.callout').removeClass('hidden'); //exibe a div de erro
                    $('.callout').find('p').text(""); //limpa a div para erros successivos

                    $.each(data.errors, function(nome, mensagem) {
                            $('.callout').find("p").append(mensagem + "</br>");
                    });

                } else {
                    
                    $('#table').DataTable().draw(false);

                    jQuery('#criar_deletar-modal').modal('hide');

                    $(function() {
                        iziToast.destroy();
                        iziToast.success({
                            title: 'OK',
                            message: 'Hora extra deletado com Sucesso!',
                        });
                    });
                }
            },

            error: function() {
                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });
  
});

$(document).on('click', '.btnAdicionar', function() {
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');
        $('.modal-footer .btn-action').removeClass('hidden');

        //habilita os campos desabilitados
        $('#horas_excedidas').prop('readonly',false);
        $('#dia').prop('readonly',false);
        $('#fk_user').prop('disabled',false);
        

        $('.modal-title').text('Novo Cadastro de Hora Extra');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#criar_editar-modal').modal('show');
});

$(document).on('click', '.btnVer', function() {

        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('hidden');
        $('.modal-title').text('Ver hora extra');
        
        //desabilita os campos
        $('#horas_excedidas').prop('readonly',true);
        $('#dia').prop('readonly',true);
        $('#fk_user').prop('disabled',true);

        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        
        jQuery('#criar_editar-modal').modal('show');
});
$(document).on('click', '.btnEditar', function() {
        $('.modal-footer .btn-action').removeClass('add');
        $('.modal-footer .btn-action').addClass('edit');
        $('.modal-footer .btn-action').removeClass('hidden');

        $('.modal-title').text('Editar hora extra');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        //habilita os campos desabilitados
        $('#horas_excedidas').prop('readonly',false);
        $('#dia').prop('readonly',false);
        $('#fk_user').prop('disabled',true);

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        
        jQuery('#criar_editar-modal').modal('show'); //Abrir o modal
});
$(document).on('click', '.btnDeletar', function() {
   $('.modal-title').text('Deletar Setor');   
   $('.modal-footer .btn-action').removeClass('add');
   $('.modal-footer .btn-action').removeClass('edit');
   $('.modal-footer .btn-action').addClass('excluir');
   $('.modal-footer .btn-action').removeClass('hidden');
   
   var btnExcluir = $(this);

    $('#deletar :input').each(function(index,input){
        $('#'+input.id).val($(btnExcluir).data(input.id));
    });

    jQuery('#criar_deletar-modal').modal('show'); //Abrir o modal 

});
