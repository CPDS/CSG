var itens = new Array();
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
            ajax: './gerenciar-contratos/list',
            columns: [
            
            { data: null, name: 'order' },
            { data: 'numero', name: 'numero' },
            { data: 'valor_total', name: 'valor_total' },
            { data: 'data_inicio', name: 'data_inicio' },
            { data: 'data_fim', name: 'data_fim' },
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
              { "width": "20%", "targets": 1 },//numero
              { "width": "8%", "targets": 2 },//ação
              { "width": "15%", "targets": 3 }, //nº
              { "width": "15%", "targets": 4 },//nome
            ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();



    $('.modal-footer').on('click', '.add', function() {
        var dados = new FormData($("#form")[0]); //pega os dados do form

        console.log(itens);

        $.ajax({
            type: 'post',
            url: "/gerenciar-contratos/store",
            data: {
                'numero': $("#numero").val(),
                'valor_total': $("#valor_total").val(),
                'data_inicio': $("#data_inicio").val(),
                'data_fim': $("#data_fim").val(),
                'fk_user': $("#fk_user").val(),
                'itens': itens
            },
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
                            message: 'Contrato adicionado com Sucesso!',
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

        console.log(itens);

        $.ajax({
            type: 'post',
            url: "/gerenciar-contratos/update",
            data: {
                'id': $("#id").val(),
                'numero': $("#numero").val(),
                'valor_total': $("#valor_total").val(),
                'data_inicio': $("#data_inicio").val(),
                'data_fim': $("#data_fim").val(),
                'fk_user': $("#fk_user").val(),
                'itens': itens
            },
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
                            message: 'Contrato alterado com Sucesso!',
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
            url: "/gerenciar-contratos/delete",
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
                            message: 'Contrato deletado com Sucesso!',
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

    var i = 0;
  //Adicionar material
  $(document).on('click', '.btnAdcItem', function() {
    //verificar se a opção selecionada possiu valor
    //verificar se a opção selecionada já se encontra no array itens e emitir alerta quando já estiver
    
    var cols = '';
    cols = '';
    novaLinha = null; 
    var fk_item = $('#fk_item :selected').val();
    var descricao_material = $('#fk_item :selected').text();
    var quantidade = $('#quantidade').val();
    var valor_unitario = $('#valor_unitario').val();

    var novaLinha = '<tr class="'+'linha'+i+'">';
    //Adc material ao array
    itens.push({'fk_item': fk_item, 'quantidade': quantidade, 'valor_unitario': valor_unitario});

    
    /* Crian a linha p/ tabela*/
    
    cols += '<td>'+descricao_material+'</td>';
    cols += '<td>'+quantidade+'</td>';
    cols += '<td>'+valor_unitario+'</td>';
    cols += '<td class="text-left"><a class="btnRemoverItem btn btn-xs btn-danger" data-indexof="'+itens.indexOf(itens[i])+'" data-linha="'+i+'"><i class="fa fa-trash"></i> Remover</a></td>';
    novaLinha += cols + '</tr>';
    


    $('#item_id').append(novaLinha); /*Adc a linha  tabela*/
    i+=1;

    $('#quantidade').val('');
    $('#valor_unitario').val('');
  });


    //Remover Item
    $(document).on('click', '.btnRemoverItem', function(){
    itens.splice($(this).data('indexof'),1); //remove do array de acordo com o indice
    $('.linha'+ $(this).data('linha')).remove(); //Remove a linha da tela 
    });

});

$(document).on('click', '.btnAdicionar', function() {
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');
        $('.modal-footer .btn-action').removeClass('hidden');

        //habilita os campos desabilitados
        $('#numero').prop('readonly',false);
        $('#valor_total').prop('readonly',false);
        $('#data_inicio').prop('readonly',false);
        $('#data_fim').prop('readonly',false);
        

        $('.modal-title').text('Novo Cadastro de Contrato');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#criar_editar-modal').modal('show');
});

var j = 0;
$(document).on('click', '.btnVer', function() {
        while (itens.length) {
            itens.pop();
          }
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('hidden');
        $('.modal-title').text('Ver Contrato');
        
        //desabilita os campos
        $('#numero').prop('readonly',true);
        $('#valor_total').prop('readonly',true);
        $('#data_inicio').prop('readonly',true);
        $('#data_fim').prop('readonly',true);

        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        var id = $('#id').val();
        $.ajax({
            type: 'get',
            url: "/gerenciar-contratos/itens/"+id,
            processData: false,
            contentType: false,
              success: function(response) {
                for(var i = 0; i < response.data.length; i++){
                    console.log(response.data[i].nome);
                 
                var cols = '';
                cols = '';
                novaLinha = null; 
                var fk_item = response.data[i].fk_item;
                var descricao_item = response.data[i].nome;
                var quantidade = response.data[i].quantidade;
                var valor_unitario = response.data[i].valor_unitario;

                var novaLinha = '<tr class="'+'linha'+i+'">';
                //Adc material ao array
                itens.push({'fk_item': fk_item, 'quantidade': quantidade});

                
                /* Crian a linha p/ tabela*/
                
                cols += '<td>'+descricao_item+'</td>';
                cols += '<td>'+quantidade+'</td>';
                cols += '<td>'+valor_unitario+'</td>';
                cols += '<td class="text-left"><a class="btnRemoverItem btn btn-xs btn-danger" data-indexof="'+itens.indexOf(itens[j])+'" data-linha="'+j+'"><i class="fa fa-trash"></i> Remover</a></td>';
                novaLinha += cols + '</tr>';

                $('#item_id').append(novaLinha); /*Adc a linha  tabela*/
                j+=1;

                $('#quantidade').val('');
                $('#valor_unitario').val('');
                }
                
            },
        });

        
        jQuery('#criar_editar-modal').modal('show');
});


$(document).on('click', '.btnEditar', function() {
        while(itens.length > 0) {
            itens.pop();
        }

        alert('asdasd');

        $('.modal-footer .btn-action').removeClass('add');
        $('.modal-footer .btn-action').addClass('edit');
        $('.modal-footer .btn-action').removeClass('hidden');

        $('.modal-title').text('Editar Contrato');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        //habilita os campos desabilitados
        $('#numero').prop('readonly',false);
        $('#valor_total').prop('readonly',false);
        $('#data_inicio').prop('readonly',false);
        $('#data_fim').prop('readonly',false);

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });
        
        var id = $('#id').val();
        $.ajax({
            type: 'get',
            url: "/gerenciar-contratos/itens/"+id,
            processData: false,
            contentType: false,
              success: function(response) {
                for(var i = 0; i < response.data.length; i++){
                    
                var cols = '';
                cols = '';
                novaLinha = null; 
                var fk_item = response.data[i].fk_item;
                var descricao_item = response.data[i].nome;
                var quantidade = response.data[i].quantidade;
                var valor_unitario = response.data[i].valor_unitario;

                var novaLinha = '<tr class="'+'linha'+i+'">';
                //Adc material ao array
                itens.push({'fk_item': fk_item, 'quantidade': quantidade, 'valor_unitario': valor_unitario });

                
                /* Crian a linha p/ tabela*/
                
                cols += '<td>'+descricao_item+'</td>';
                cols += '<td>'+quantidade+'</td>';
                cols += '<td>'+valor_unitario+'</td>';
                cols += '<td class="text-left"><a class="btnRemoverItem btn btn-xs btn-danger" data-indexof="'+itens.indexOf(itens[j])+'" data-linha="'+j+'"><i class="fa fa-trash"></i> Remover</a></td>';
                novaLinha += cols + '</tr>';

                $('#item_id').append(novaLinha); /*Adc a linha  tabela*/
                j+=1;

                $('#quantidade').val('');
                }
                
            },
        });

        
        jQuery('#criar_editar-modal').modal('show'); //Abrir o modal
});
$(document).on('click', '.btnDeletar', function() {
   $('.modal-title').text('Deletar Contrato');   
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
