@extends('adminlte::page')
<script src ="{{ asset('/plugins/jQuery/jQuery-3.1.0.min.js'). '?update=' . str_random(3) }}" type = "text/javascript" ></script>
<script src ="{{ asset('/js/scripts_gerais/material_entrada.js'). '?update=' . str_random(3) }}" type = "text/javascript" ></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js'). '?update=' . str_random(3) }}" type = "text/javascript"></script>

<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js'). '?update=' . str_random(3) }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css'). '?update=' . str_random(3) }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css'). '?update=' . str_random(3) }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>

@section('htmlheader_title')
	Gerenciar Entrada de Materiais
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">

				<div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Entrada de Materiais</h3>
                       
                       <div class="pull-right">      
                            <a class="btnAdicionar btn btn-primary btn-sm" title="Adicionar Material" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span>Cadastrar Entrada de Materiais</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table class="table" id="table">
                            <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Nome do Material</th>
                                <th>Quantidade</th>
                                <th>Usuário</th>
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

@include('entrada_material.modals.criar_entrada_material')
@include('entrada_material.modals.deletar_entrada_material')
@endsection
