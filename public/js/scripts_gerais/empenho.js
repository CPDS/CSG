var id;
var linhas = 0;
var itens = new Array();
var qtd_itens = 0;
var soma_total_itens = 0;
var soma_total_empenho = 0;
var i = 0;
var fk_item_global;
$(document).ready(function($) {
  
  

    $("#telefone").mask("(99) 9?9999-9999");

    $("#fk_item").on('change', function() {

        var campo = this.value;
        var valor = campo.split("|");

        $('#valor_unitario').val(valor[1]);
    });

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
            ajax: './gerenciar-empenhos/list',
            columns: [            
            { data: null, name: 'order' },
            { data: 'valor', name: 'valor' },
            { data: 'data', name: 'data' },
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
              { targets : [2], sortable : false },
              { "width": "5%", "targets": 0 }, //nº
              { "width": "35%", "targets": 1 },//nome
              { "width": "5%", "targets": 2 },//ação
            ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();


    $('.modal-footer').on('click', '.add', function() {
        var dados = new FormData($("#form")[0]); //pega os dados do form

        $.ajax({
            type: 'post',
            url: "/gerenciar-empenhos/store",
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
                            message: 'Empenho adicionado com Sucesso!',
                        });
                    });

                
                }
            },

            error: function(data) {
                iziToast.error({
                    title: 'Erro Interno',
                    message: data.responseJSON,
                });
            },

        });
    });

 $('.modal-footer').on('click', '.addItem', function() {
        var dados = new FormData($("#form")[0]); //pega os dados do form

        $.ajax({
            type: 'post',
            url: "/gerenciar-empenhos/itens",
             data: {
                'itens': itens
            },
            beforeSend: function(){
                jQuery('.addItem').button('loading');
            },
            complete: function() {
                jQuery('.addItem').button('reset');
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
                            message: 'Empenho adicionado com Sucesso!',
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
            url: "/gerenciar-empenhos/update",
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
                            message: 'Empenho alterado com Sucesso!',
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
            url: "/gerenciar-empenhos/delete",
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
                            message: 'Empenho deletado com Sucesso!',
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


  //Adicionar material
  $(document).on('click', '.btnAdcItem', function() {
    //verificar se a opção selecionada possiu valor
    //verificar se a opção selecionada já se encontra no array itens e emitir alerta quando já estiver
    
    if( $('#fk_item').val() == '' || $('#quantidade').val() == '' ){
        iziToast.destroy();
        iziToast.error({
            title: 'Erro',
            message: 'Preencha todos campos!',
        });
    }else{

    var cols = '';
    cols = '';
    novaLinha = null; 
    var campo = $('#fk_item :selected').val();
    var fk_item = campo.split("|");
    var valor_unitario = campo.split("|");
    var descricao_material = $('#fk_item :selected').text();
    var quantidade = $('#quantidade').val();
    var novaLinha = '<tr class="'+'linha'+linhas+'">';
    //Adc material ao array
    

    let valor1 = $('#subtotal').text();

     var verifica_soma = parseFloat(valor1) - parseFloat(valor_unitario[1] * quantidade)
    console.log(verifica_soma);
    if(verifica_soma < 0){
        iziToast.destroy();
        iziToast.error({
            title: 'Erro',
            message: 'Você não tem mais saldo nesse empenho!',
        });

        return;
    }

    fk_item_global++;
    console.log('fk'+fk_item_global);

    itens.push({'fk_item': fk_item_global, 'quantidade': quantidade, 'valor_unitario': valor_unitario[1],'fk_empenho': id  } );
   
    var itens_aux = new Array();
    itens_aux.push({'fk_item': fk_item[0], 'quantidade': quantidade, 'valor_unitario': valor_unitario[1],'fk_empenho': id  } );
    
    $.ajax({
        type: 'post',
        url: "/gerenciar-empenhos/itens",
         data: {
            'itens': itens_aux
        },
    });   

    
    /* Crian a linha p/ tabela*/
    
    cols += '<td>'+descricao_material+'</td>';
    cols += '<td>'+quantidade+'</td>';
    cols += '<td>'+valor_unitario[1]+'</td>';
    cols += '<td class="text-left"><a class="btnRemoverItem btn btn-xs btn-danger" data-indexof="'+linhas+'" data-linha="'+linhas+'"><i class="fa fa-trash"></i> Remover</a></td>';
    novaLinha += cols + '</tr>';
    
    let valor = $('#subtotal').text();

    $('#subtotal').text( parseFloat(valor) - parseFloat(valor_unitario[1] * quantidade));


    $('#item_id').append(novaLinha); /*Adc a linha  tabela*/
    i+=1;
    linhas++;

    $('#quantidade').val('');
    $('#valor_unitario').val('');
    $('#fk_item').val('');

    }
  });


    //Remover Item
$(document).on('click', '.btnRemoverItem', function(){
    console.log( itens[$(this).data('indexof')]);
    
    $.ajax({
        type: 'get',
        url: "/gerenciar-empenhos/delete/item/"+ itens[$(this).data('indexof')].fk_item,
    });

    let valor = parseFloat( (itens[$(this).data('indexof')].valor_unitario) * (itens[$(this).data('indexof')].quantidade))  + parseFloat($('#subtotal').text());

    $('#subtotal').text(valor);
   
    itens.splice($(this).data('indexof'),1); //remove do array de acordo com o indice
    
    $('.linha'+ $(this).data('linha')).remove(); //Remove a linha da tela 
    linhas--;

});
  
});

$(document).on('click', '.btnAdicionar', function() {
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');
        $('.modal-footer .btn-action').removeClass('hidden');

        //habilita os campos desabilitados
        $('#valor').prop('readonly',false);
        $('#data').prop('readonly',false);
        $('#fk_contrato').prop('readonly',false);
       
        $('.modal-title').text('Novo Cadastro de Empenho');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#criar_editar-modal').modal('show');
});

$(document).on('click', '.btnVer', function() {

        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('hidden');
        $('.modal-title').text('Ver Empenho');
        
        //desabilita os campos
        $('#valor').prop('readonly',true);
        $('#data').prop('readonly',true);
        $('#fk_contrato').prop('readonly',true);
        

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

        $('.modal-title').text('Editar Empenho');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        //habilita os campos desabilitados
        $('#nome').prop('readonly',false);
        $('#sigla').prop('readonly',false);
        $('#fk_contrato').prop('readonly',false);

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });
        
        jQuery('#criar_editar-modal').modal('show'); //Abrir o modal
});

$(document).on('click', '.btnAdd', function() {
    $('.modal-footer .btn-action').removeClass('add');
    $('.modal-footer .btn-action').removeClass('edit');
    $('.modal-footer .btn-action').addClass('addItem');
    $('.modal-footer .btn-action').removeClass('hidden');

    $('.modal-title').text('Editar Empenho');
    $('.callout').addClass("hidden"); //ocultar a div de aviso
    $('.callout').find("p").text(""); //limpar a div de aviso
   
    id =  $(this).data('id');
    soma_total_empenho =  $('#valor_empenho').text();
    let saldo_anterior = parseFloat($(this).data('saldo_anterior'));

    if(Number.isNaN(saldo_anterior)){
        saldo_anterior = 0;
    }

    let subtotal = parseFloat($(this).data('valor')) +  saldo_anterior; 
    $('#valor_empenho').text(subtotal);
    $('#subtotal').text($(this).data('valor'));
    $('#valor_contrato').text($(this).data('valor_contrato'));
    itens = [];

    for (var i = 0; i < linhas; i++) {
        $('.linha'+ i).remove(); //Remove a linha da tela 
    }
    
    linhas = 0;

    $.ajax({
            type: 'get',
            url: "/gerenciar-empenhos/get/itens/"+id,
            processData: false,
            contentType: false,
              success: function(response) {
                for(var i = 0; i < response.data.length; i++){
                var cols = '';
                cols = '';
                novaLinha = null; 
                var fk_item = response.data[i].id ;
                fk_item_global = parseInt(fk_item); 
                var descricao_item = response.data[i].nome;
                var quantidade = response.data[i].quantidade;
                var valor_unitario = response.data[i].valor;
                soma_total_itens +=  parseFloat(valor_unitario) * quantidade; 
                qtd_itens +=  parseInt(quantidade); 
                var novaLinha = '<tr class="'+'linha'+i+'">';

                //Adc material ao array
                itens.push({'fk_item': fk_item, 'quantidade': quantidade, 'valor_unitario': valor_unitario,'fk_empenho': id  } );
                
                /* Crian a linha p/ tabela*/
                cols += '<td>'+descricao_item+'</td>';
                cols += '<td>'+quantidade+'</td>';
                cols += '<td>'+valor_unitario+'</td>';
                cols += '<td class="text-left"><a class="btnRemoverItem btn btn-xs btn-danger" data-indexof="'+itens.indexOf(itens[linhas])+'" data-linha="'+linhas+'"><i class="fa fa-trash"></i> Remover</a></td>';
                novaLinha += cols + '</tr>';
                
                $('#item_id').append(novaLinha); /*Adc a linha  tabela*/
                linhas ++; 
                $('#quantidade').val('');
                $('#valor_unitario').val('');
                $('#fk_item').val('');
                }
                let valor = $('#subtotal').text();

                $('#subtotal').text( parseFloat(valor) - soma_total_itens);
                
            },
        });
    jQuery('#item-modal').modal('show'); //Abrir o modal
});

$(document).on('click', '.btnDeletar', function() {
   $('.modal-title').text('Deletar Empenho');   
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

