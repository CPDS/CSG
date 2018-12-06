
@extends('adminlte::page')
<script src ="{{ asset('/plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>
<script src ="{{ asset('/js/scripts_gerais/user.js') }}" type = "text/javascript" ></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/mask-input-js/maskinput.js') }}" type = "text/javascript"></script>

<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>

@section('htmlheader_title')
	Gerenciar Permissões
@endsection
@section('usuario', 'active')

@section('main-content')
	  <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Permissões</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">  
                        @foreach($permissions as $permission)
                        {{ $permission->name }}
                        @endforeach

                    @can('criar-setor')
                        asdasd
                    @endcan
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </div>
    </div>

@endsection
