$(document).ready(function($){
    
    var base_url = 'http://' + window.location.host.toString();
    var base_url = location.protocol + '//' + window.location.host.toString();
    var materiais = new Array();
    

    $('.js-example-basic-multiple').select2({
        placeholder: "Selecione",
        allowClear: true,
        tags: true,
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    
    var tabela = $('#table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: './gerenciar-solicitacoes/list',
            columns: [
            { data: null, name: 'order' },
            { data: 'descricao_solicitacao', name: 'descricao_solicitacao' },
            { data: 'data_solicitacao', name: 'data_solicitacao' },
            { data: 'titulo', name: 'titulo' },
            { data: 'observacao_solicitado', name: 'observacao_solicitado' },
            { data: 'observacao_solicitante', name: 'observacao_solicitante' },
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
                "scarregandoRecords": "Carregando...",
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
              { targets : [6], sortable : false },
              { "width": "5%", "targets": 0 }, //nº
              { "width": "25%", "targets": 1 },//nome
              { "width": "10%", "targets": 2 }, //nº
              { "width": "20%", "targets": 3 },//nome
              { "width": "15%", "targets": 4 }, //nº
              { "width": "15%", "targets": 5 },//nome
              { "width": "5%", "targets": 6 }//ação
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
            url: "/gerenciar-solicitacoes/store",
             data: {
                'data_solicitacao': $("#data_solicitacao").val(),
                'local_servico': $("#local_servico").val(),
                'titulo': $("#titulo").val(),
                'descricao': $("#descricao").val(),
                'observacao_solicitado': $("#observacao_solicitado").val(),
                'observacao_solicitante': $("#observacao_solicitante").val(),
                'fk_servico': $("#fk_servico").val(),
                'fk_user': $("#fk_user").val(),
                'fk_solicitacao_tipo': $("#fk_solicitacao_tipo").val(),
                'servicos': $("#servicos").val(),
                'status': $("#status :selected").val(),
                'materiais': materiais
            },
            /*processData: false,
            contentType: false,*/
            beforeSend: function(){
                jQuery('.add').button('carregando');
            },
            complete: function() {
                jQuery('.add').button('redefinido');
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
                            message: 'solicitação adicionado com Sucesso!',
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
            url: "/gerenciar-solicitacoes/update",
             data: {
                'data_solicitacao': $("#data_solicitacao").val(),
                'local_servico': $("#local_servico").val(),
                'titulo': $("#titulo").val(),
                'descricao': $("#descricao").val(),
                'observacao_solicitado': $("#observacao_solicitado").val(),
                'observacao_solicitante': $("#observacao_solicitante").val(),
                'fk_servico': $("#fk_servico").val(),
                'fk_user': $("#fk_user").val(),
                'id': $("#id").val(),
                'fk_solicitacao_tipo': $("#fk_solicitacao_tipo").val(),
                'servicos': $("#servicos").val(),
                'status': $("#status :selected").val(),
                'materiais': materiais
            },
            /*processData: false,
            contentType: false,*/
            beforeSend: function(){
                jQuery('.edit').button('carregando');
            },
            complete: function() {
                jQuery('.edit').button('redefinido');
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
                            message: 'solicitação alterado com Sucesso!',
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
            url: "/gerenciar-solicitacoes/delete",
            data: dados,
            processData: false,
            contentType: false,
            beforeSend: function(){
                jQuery('.excluir').button('carregando');
            },
            complete: function() {
                jQuery('.excluir').button('redefinido');
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
                            message: 'solicitação deletado com Sucesso!',
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
    $(document).on('click', '.btnAdcMaterial', function() {
        //verificar se a opção selecionada possiu valor
        //verificar se a opção selecionada já se encontra no array materiais e emitir alerta quando já estiver
        
        var cols = '';
        cols = '';
        novaLinha = null; 
        var fk_material = $('#fk_material :selected').val();
        var descricao_material = $('#fk_material :selected').text();
        var quantidade = $('#quantidade').val();

        var novaLinha = '<tr class="'+'linha'+i+'">';
        //Adc material ao array
        materiais.push({'fk_material': fk_material, 'quantidade': quantidade});

        
        /* Crian a linha p/ tabela*/
        
        cols += '<td>'+descricao_material+'</td>';
        cols += '<td>'+quantidade+'</td>';
        cols += '<td class="text-left"><a class="btnRemoverMaterial btn btn-xs btn-danger" data-indexof="'+materiais.indexOf(materiais[i])+'" data-linha="'+i+'"><i class="fa fa-trash"></i> Remover</a></td>';
        novaLinha += cols + '</tr>';
        


        $('#material_id').append(novaLinha); /*Adc a linha  tabela*/
        i+=1;

        $('#quantidade').val('');

    });

    //Remover Material
    $(document).on('click', '.btnRemoverMaterial', function(){
        materiais.splice($(this).data('indexof'),1); //remove do array de acordo com o indice
        $('.linha'+ $(this).data('linha')).remove(); //Remove a linha da tela 
    });



    $(document).on('click', '.btnAdicionar', function() {
            $('.modal-footer .btn-action').removeClass('edit');
            $('.modal-footer .btn-action').addClass('add');
            $('.modal-footer .btn-action').removeClass('hidden');

            //habilita os campos desabilitados
            $('#horario_inicio').prop('readonly',false);
            $('#horario_pausa').prop('readonly',false);
            $('#horario_pos_pausa').prop('readonly',false);
            $('#horario_termino').prop('readonly',false);
            $('#fk_servidor').prop('disabled',false);
            

            $('.modal-title').text('Novo Cadastro de solicitação');
            $('.callout').addClass("hidden"); 
            $('.callout').find("p").text(""); 

            $('#form')[0].redefinido();

            jQuery('#criar_editar-modal').modal('show');
    });

    $(document).on('click', '.btnVer', function() {

            $('.modal-footer .btn-action').removeClass('edit');
            $('.modal-footer .btn-action').addClass('hidden');
            $('.modal-title').text('Ver solicitação de horário');
            
            //desabilita os campos
            $('#horario_inicio').prop('readonly',true);
            $('#horario_pausa').prop('readonly',true);
            $('#horario_pos_pausa').prop('readonly',true);
            $('#horario_termino').prop('readonly',true);
            $('#fk_servidor').prop('disabled',true);

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

            $('.modal-title').text('Editar Setor');
            $('.callout').addClass("hidden"); //ocultar a div de aviso
            $('.callout').find("p").text(""); //limpar a div de aviso

            $('#servicos').val('').trigger('change');

            var btnEditar = $(this);
            $.ajax({
                type:'get',
                url: './gerenciar-servicos/servicos/'+btnEditar.data('id'),
                success: function(data){
                    $('#servicos').val(data);
                    $('#servicos').trigger('change');
                }
            });

            $('#id').val(btnEditar.data('id'));
            $('#titulo').val(btnEditar.data('titulo'));
            $('#status').val(btnEditar.data('status'));
            $('#observacao_solicitante').val(btnEditar.data('observacao_solicitante'));
            $('#observacao_solicitado').val(btnEditar.data('observacao_solicitado'));
            $('#descricao').val(btnEditar.data('descricao_solicitacao'));

        var id = $('#id').val();
        j = 0;
        $.ajax({
            type: 'get',
            url: "/gerenciar-solicitacoes/materiais/"+id,
            processData: false,
            contentType: false,
              success: function(response) {

                if(response.data[0].id != null){ 
                    for(var i = 0; i < response.data.length; i++){
                        var cols = '';
                        cols = '';
                        novaLinha = null; 
                        var fk_material = response.data[i].id;
                        var descricao_material = response.data[i].descricao;
                        var quantidade = response.data[i].quantidade;

                        var novaLinha = '<tr class="'+'linha'+j+'">';
                        //Adc material ao array
                        materiais.push({'fk_material': fk_material, 'quantidade': quantidade});
                        
                        /* Crian a linha p/ tabela*/
                        
                        cols += '<td>'+descricao_material+'</td>';
                        cols += '<td>'+quantidade+'</td>';
                        cols += '<td class="text-left"><a class="btnRemoverMaterial btn btn-xs btn-danger" data-indexof="'+materiais.indexOf(materiais[i])+'" data-linha="'+j+'"><i class="fa fa-trash"></i> Remover</a></td>';
                        novaLinha += cols + '</tr>';

                        $('#material_id').append(novaLinha); /*Adc a linha  tabela*/
                        j+=1;

                        $('#quantidade').val('');
                    }
                }    
            },
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
});
