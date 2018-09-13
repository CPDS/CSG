@extends('adminlte::page')
<script src ="{{ asset('/plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>
<script src ="{{ asset('/js/scripts_gerais/funcionario.js') }}" type = "text/javascript" ></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/mask-input-js/maskinput.js') }}" type = "text/javascript"></script>


<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>

@section('htmlheader_title')
	Gerenciar Usuários
@endsection

@section('main-content')
	   <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <h2><i class="fa fa-clone"></i> Gerenciamento de Usuários</h2>
                </div>
                <div class="pull-right">
                     <a class="btnAdicionar btn btn-primary btn-sm" title="Adicionar Material" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span> Cadastrar Usuário</a>           
                </div>
            </div>
        </div>
<br>

                <div class="box box-solid box-primary">
                    <div class="box-header">
                      <h3 class="box-title">
                        <strong>Usuário</strong> 
                      </h3>
                </div><!-- /.box-header -->
                    
                        <table class="table" id="table">
                            <thead>

                            <tr>
                                <th>Nº</th>
                                <th>Nome</th>
                                <th>RG</th>   
                                <th>Cargo</th>
                                <th>Telefone</th>
                                <th>Setor</th>
                                <th width="20%">Ações</th>
                            </tr>
                            </thead>
                            
                        </table>
                    </div>
                    <!-- /.box-body -->

@include('funcionario.modals.criar_funcionario')
@include('funcionario.modals.deletar_funcionario')
@endsection
