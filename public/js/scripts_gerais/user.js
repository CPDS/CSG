$(document).ready(function($) {
    
    $("#telefone").mask("(99) 9?9999-9999"); 
    $("#cpf").mask("999.999.999-99");
    $("#cnpj").mask(" 99.999.999/9999-99");

    var base_url = 'http://' + window.location.host.toString();
    var base_url = location.protocol + '//' + window.location.host.toString();

    $('#nome_role').change(function(){
        if($("#nome_role :selected").text() == 'Empresa'){
            $('.user').addClass('hidden');
            $('.empresa').removeClass('hidden');
        }else{ 
            $('.empresa').addClass('hidden');
            $('.user').removeClass('hidden'); 
        }    
    });


    $('#papel').change(function(){
   
        var papel = $("#papel :selected").val();
        $.ajax({
            type: 'get',
            url: "/gerenciar-users/get-permissions/"+papel,
            processData: false,
            contentType: false,
              success: function(response) {
               
                $('input[id="permissao"]').each(function() {
                    $(this).prop('checked', false);
                    for(var i = 0; i < response.data.length; i++){
                        if(response.data[i].permission_id == this.value){
                            $(this).prop('checked', true);
                            return;
                        }else{
                            $(this).prop('checked', false);
                        }
                    }
                });  
            },
        });
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
            ajax: './gerenciar-users/list',
            columns: [
            { data: null, name: 'order' },
            { data: 'nome_user', name: 'nome_user' },
            { data: 'nome_role', name: 'nome_role' },
            { data: 'telefone', name: 'telefone' },
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
              { targets : [4], sortable : false },
              { "width": "5%", "targets": 0 }, //nº
              { "width": "50%", "targets": 1 },//nome
              { "width": "15%", "targets": 2 },//nome
              { "width": "15%", "targets": 3 },//nome
              { "width": "15%", "targets": 4 }//ação
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
            url: "/gerenciar-users/store",
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
                            message: 'Usuário adicionado com Sucesso!',
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

    $(document).on('click', '.permission', function() {
        var dados = new FormData($("#form")[0]); //pega os dados do form

        console.log(dados);

        $.ajax({
            type: 'post',
            url: "/gerenciar-users/permission",
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


                    $(function() {
                        iziToast.destroy();
                        iziToast.success({
                            title: 'OK',
                            message: 'Usuário adicionado com Sucesso!',
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

       $.ajax({
            type: 'post',
            url: "/gerenciar-users/update",
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
                            message: 'Usuário alterado com Sucesso!',
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
            url: "/gerenciar-users/delete",
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
                            message: 'Usuário deletado com Sucesso!',
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
        $('#justifica').addClass('hidden');
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');
        $('.modal-footer .btn-action').removeClass('hidden');
        $('.empresa').addClass('hidden');


        //habilita os campos desabilitados
        $('#nome_user').prop('readonly',false);
        $('#contato').prop('readonly',false);
        $('#responsavel').prop('readonly',false);
        $('#telefone').prop('readonly',false);
        $('#email').prop('readonly',false);
        $('#nome_role').prop('disabled',false);
        $('#endereco').prop('readonly',false);
        $('#cpf').prop('readonly',false);
        $('#cnpj').prop('readonly',false);
        $('#fk_setor').prop('disabled',false);
        $('#password').prop('readonly',false);


        $('.modal-title').text('Novo Cadastro de Usuário');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#criar_editar-modal').modal('show');
});

$(document).on('click', '.btnVer', function() {
        $('#justifica').addClass('hidden');
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-title').text('Ver Usuário');
        $('.modal-footer .btn-action').addClass('hidden');
        
        //desabilita os campos
        $('#nome_user').prop('readonly',true);
        $('#responsavel').prop('readonly',true);
        $('#contato').prop('readonly',true);
        $('#endereco').prop('readonly',true);
        $('#telefone').prop('readonly',true);
        $('#email').prop('readonly',true);
        $('#cpf').prop('readonly',true);
        $('#endereco').prop('readonly',true);
        $('#cnpj').prop('readonly',true);
        $('#fk_setor').prop('disabled',true);
        $('#nome_role').prop('disabled',true);
        $('#password').prop('readonly',true);
        $('#senha').addClass("hidden"); //ocultar a div de aviso


        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        
        jQuery('#criar_editar-modal').modal('show');
});
$(document).on('click', '.btnEditar', function() {
        $('#justifica').addClass('hidden');

        $("#fk_setor").change(function() {
             $('#justifica').removeClass('hidden');
        });

        $('.modal-footer .btn-action').removeClass('add');
        $('.modal-footer .btn-action').addClass('edit');
        $('.modal-footer .btn-action').removeClass('hidden');

        $('.modal-title').text('Editar Usuário');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        //habilita os campos desabilitados
        $('#nome_user').prop('readonly',false);
        $('#responsavel').prop('readonly',false);
        $('#contato').prop('readonly',false);
        $('#nome_role').prop('disabled',false);
        $('#endereco').prop('readonly',false);
        $('#email').prop('readonly',false);
        $('#telefone').prop('readonly',false);
        $('#cpf').prop('readonly',false);
        $('#cnpj').prop('readonly',false);
        $('#password').prop('readonly',false);
        $('#fk_setor').prop('disabled',false);

        var btnEditar = $(this);


        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        
        jQuery('#criar_editar-modal').modal('show'); //Abrir o modal
});


$(document).on('click', '.btnDeletar', function() {
   $('.modal-title').text('Deletar Usuário');   
   $('.modal-footer .btn-action').addClass('excluir');
   $('.modal-footer .btn-action').removeClass('add');
   $('.modal-footer .btn-action').removeClass('edit');
   $('.modal-footer .btn-action').removeClass('hidden');
   
   var btnExcluir = $(this);

    $('#deletar :input').each(function(index,input){
        $('#'+input.id).val($(btnExcluir).data(input.id));
    });

    jQuery('#criar_deletar-modal').modal('show'); //Abrir o modal 

});
