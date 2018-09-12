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

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
        
            
            <li class="active"><a href="{{ url('gerenciar-setores') }}"><i class='fa fa-university'></i> <span>Setores</span></a></li>

             <li class="treeview">
                <a href="#"><i class='fa fa-users'></i> <span>Gerenciar Usuários</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('gerenciar-funcionarios') }}"><i class='fa fa-user'></i> <span>Usuários</span></a></li>
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
            
            <li><a href="{{ url('gerenciar-servicos') }}"><i class='fa fa-wrench'></i> <span>Serviços</span></a></li>

            <li class="treeview">
                <a href="#"><i class='fa fa-clone'></i> <span>Gerenciar Solicitação</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                   <li><a href="{{ url('gerenciar-solicitacoes') }}"><i class='fa fa-sticky-note-o'></i> <span>Solicitação</span></a></li>
                   <li><a href="{{ url('gerenciar-solicitacao-tipos') }}"><i class='fa fa-pencil-square-o'></i> <span>Tipo</span></a></li>

                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
