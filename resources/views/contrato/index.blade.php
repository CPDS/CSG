@extends('adminlte::page')
<script src ="{{ asset('/plugins/jQuery/jQuery-3.1.0.min.js') . '?update=' . str_random(3)}}" type = "text/javascript" ></script>
<script src ="{{ asset('/js/scripts_gerais/contrato.js') . '?update=' . str_random(3)}}" type = "text/javascript" ></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') . '?update=' . str_random(3) }}" type = "text/javascript"></script>

<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') . '?update=' . str_random(3)}}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') . '?update=' . str_random(3)}}">
<script src="{{ asset('js/iziToast.min.js'). '?update=' . str_random(3) }}"></script>

@section('htmlheader_title')
	Gerenciar Contratos
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">

				<div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Contratos</h3>
                       
                       <div class="pull-right">      
                            <a class="btnAdicionar btn btn-primary btn-sm" title="Adicionar Material" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span> Cadastrar Contrato</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    
                        <table class="table" id="table">
                            <thead>

                            <tr>
                                <th>Nº</th>
                                <th>Número</th>   
                                <th>Valor Total</th>
                                <th>Data Início</th>
                                <th>Data Fim</th>
                                <th width="20%">Ações</th>
                            </tr>
                            </thead>
                            
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>

			</div>
		</div>
	</div>

@include('contrato.modals.criar_contrato')
@include('contrato.modals.deletar_contrato')
@endsection
