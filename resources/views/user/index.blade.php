@extends('adminlte::page')
<script src ="{{ asset('/plugins/jQuery/jQuery-3.1.0.min.js'). '?update=' . str_random(3) }}" type = "text/javascript" ></script>
<script src ="{{ asset('/js/scripts_gerais/user.js') }}" type = "text/javascript" ></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js'). '?update=' . str_random(3) }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/mask-input-js/maskinput.js'). '?update=' . str_random(3) }}" type = "text/javascript"></script>

<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js'). '?update=' . str_random(3) }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css'). '?update=' . str_random(3) }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') . '?update=' . str_random(3)}}">
<script src="{{ asset('js/iziToast.min.js') . '?update=' . str_random(3)}}"></script>

@section('htmlheader_title')
	Gerenciar Usuários
@endsection
@section('usuario', 'active')

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Usuários</h3>
                        <div class="pull-right">      
                            <a class="btnAdicionar btn btn-primary btn-sm" title="Adicionar Material" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span> Cadastrar Usuário</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table" id="table">
                            <thead>

                            <tr>
                                <th>Nº</th>
                                <th>Nome</th>
                                <th>Tipo de usuário</th>
                                <th>Telefone</th>
                                <th width="20%">Ações</th>
                            </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
    </div>
</div>

@include('user.modals.criar_user')
@include('user.modals.deletar_user')
@endsection
