@extends('adminlte::page')
<script src ="{{ asset('/plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>
<script src ="{{ asset('/js/scripts_gerais/setor.js') }}" type = "text/javascript" ></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/mask-input-js/maskinput.js') }}" type = "text/javascript"></script>

<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>

@section('htmlheader_title')
	Gerenciar Setor
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Setores</h3>                     
                       <div class="pull-right">      
                            <a class="btnAdicionar btn btn-primary btn-sm" title="Adicionar Material" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span> Cadastrar Setor</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">                    
                        <table class="table" id="table">
                            <thead>

                            <tr>
                                <th>Nº</th>
                                <th>Nome</th>   
                                <th>Sigla</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>

			</div>
		</div>
	</div>

@include('setor.modals.criar_setor')
@include('setor.modals.deletar_setor')
@endsection
