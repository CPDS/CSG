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
            ajax: './gerenciar-materiais/list',
            columns: [
            { data: null, name: 'order' },
            { data: 'nome', name: 'nome' },
            { data: 'colaborador', name: 'colaborador' },
            { data: 'n_licitacao', name: 'n_licitacao' },
            { data: 'modalidade', name: 'modalidade' },
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
                "sLoadingRecords": "Carregando...",
                "sProcessing": "<div><i class='fa fa-circle-o-notch fa-spin' style='font-size:38px;'></i> <span style='font-size:20px; margin-left: 5px'> Carregando...</span></div>",
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
              { targets : [2], sortable : false },
              { "width": "5%", "targets": 0 }, //nº
              { "width": "20%", "targets": 1 },//nome
              { "width": "10%", "targets": 2 }//ação
            ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();

  
});

$(document).on('click', '.btnAdicionar', function() {
    
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');

        $('.modal-title').text('Novo Cadastro de Material');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#criar_editar-modal').modal('show');
});
$(document).on('click', '.btnVer', function() {
        $('.modal-footer .btn-action').removeClass('add');
        $('.modal-footer .btn-action').addClass('edit');
        $('.modal-title').text('Ver Material');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        
        jQuery('#criar_ver-modal').modal('show'); //Abrir o modal
});
$(document).on('click', '.btnEditar', function() {
    $('.modal-footer .btn-action').removeClass('add');
        $('.modal-footer .btn-action').addClass('edit');
        $('.modal-title').text('Editar Cadastro de Manutenção');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        
        jQuery('#criar_editar-modal').modal('show'); //Abrir o modal
});
$(document).on('click', '.btnDeletar', function() {
    
});

