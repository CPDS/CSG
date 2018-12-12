@extends('adminlte::page')
@section('main-content')
<section class="content-header">
 
  <h1>
    <span class='glyphicon glyphicon-stats'></span>
    @yield('contentheader_title', 'Painel de Controle')
    
    <small>
      @yield('contentheader_description')
    </small>
  </h1>

</section>


<!-- Small boxes (Stat box) -->
<!-- row -->
<div class="row">
 <br><br>
</div>
<!-- row -->
<div class="row">

  <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-disabled" style="color: black;">
     
      <div class="inner">
        <h3>Geral</h3>
        <p>Materiais Total/Disponíveis: {{ $material }}</p>
        <p>Solicitações Total/Em aberto: {{ $solicitacao }}</p>
      </div>
      <div class="icon">  
        <i class="glyphicon glyphicon-eye-open"></i>
      </div>
      <span class="small-box-footer" ><br></span>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>X</h3>
        <p>Contrato(s)</p>
        <br>
      </div>
      <div class="icon">
        <i class="fa fa-clone"></i>
      </div>
      <a href="{{url('gerenciar-contratos')}}" class="small-box-footer">Exibir contrato(s) <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div> 

  <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3>X</h3>
        <p>Solicitação(s)</p>
        <br>
      </div>
      <div class="icon">
        <i class="fa fa-clone"></i>
      </div>
      <a href="{{ url('gerenciar-solicitacoes') }}" class="small-box-footer">Exibir solicitação <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<!-- row -->
<div class="row">

  <!-- ./col -->
  <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>X</h3>
        <p>Material(s)</p>
      </div>
      <div class="icon">
        <i class="fa fa-cubes"></i>
      </div>
      <a href="{{ url('gerenciar-materiais') }}" class="small-box-footer">Exibir material(s) <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>  

  <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>X</h3>
        <p>Usuário(s)</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <a href="{{ url('gerenciar-users') }}" class="small-box-footer">Exibir usuário(s) <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>X</h3>
        <p>Setor(s)</p>
      </div>
      <div class="icon">
        <i class="fa fa-university"></i>
      </div>
      <a href="{{ url('gerenciar-setores') }}" class="small-box-footer"> Exibir setor <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
@endsection
