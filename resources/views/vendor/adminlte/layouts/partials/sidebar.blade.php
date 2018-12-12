<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
        
            
            <li  class="@yield('setor') | '' " ><a href="{{ url('home') }}"><i class='fa fa-dashboard '></i> <span>Dashboard</span></a></li>
            <li  class="@yield('setor') | '' " ><a href="{{ url('gerenciar-setores') }}"><i class='fa fa-university'></i> <span>Setores</span></a></li>

             <li class="treeview" class="active">
                
                <a href="#"><i class='fa fa-users'></i> <span>Gerenciar Usuários</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    <li><a href="{{ url('gerenciar-users') }}"><i class='fa fa-user'></i> <span>Usuários</span></a></li>
                   <li><a href="{{ url('gerenciar-escalas') }}"><i class='fa fa-user'></i> <span>Escala</span></a></li>
                   <li><a href="{{ url('gerenciar-horas') }}"><i class='fa fa-clock-o'></i> <span>Horas Extras</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-cubes'></i> <span>Gerenciar Material</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                   <li><a href="{{ url('gerenciar-materiais') }}"><i class='fa fa-user'></i> <span>Material</span></a></li>
                   <li><a href="{{ url('gerenciar-entradas-materiais') }}"><i class='fa fa-database'></i> <span>Estoque</span></a></li>
                </ul>
            </li> 
            
            <li class="treeview">
                <a href="#"><i class='fa fa-clone'></i> <span>Gerenciar Contratos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('gerenciar-contratos') }}"><i class='fa fa-wrench'></i> <span>Contrato</span></a></li>
                    <li><a href="{{ url('gerenciar-itens') }}"><i class='fa fa-wrench'></i> <span>Itens</span></a></li>
               </ul>
            </li>     

            <li class="treeview">
                <a href="#"><i class='fa fa-clone'></i> <span>Gerenciar Solicitação</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                   <li><a href="{{ url('gerenciar-solicitacoes') }}"><i class='fa fa-sticky-note-o'></i> <span>Solicitação</span></a></li>
                   <li><a href="{{ url('gerenciar-servicos') }}"><i class='fa fa-wrench'></i> <span>Servicos</span></a></li>
                   <li><a href="{{ url('gerenciar-baixa-itens') }}"><i class='fa fa-wrench'></i> <span>Baixa de material</span></a></li>
                  <!-- <li><a href="{{ url('gerenciar-solicitacao-tipos') }}"><i class='fa fa-pencil-square-o'></i> <span>Tipo</span></a></li> -->
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
