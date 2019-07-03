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
                    <a href="#"><i class="fa fa-circle text-success"></i> </a>
                </div>
            </div>
        @endif
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">

            <li  class="@yield('setor') | '' " ><a href="{{ url('home') }}"><i class='fa fa-dashboard '></i> <span>Painel de Controle</span></a>
            </li>

           @if(Auth::user()->HasAnyPermission(['ver-setor']))  
            <li class="treeview" class="active">   
                <a href="#"><i class='fa fa-users'></i> <span>Gerenciar Setores</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    <li  class="@yield('setor') | '' " ><a href="{{ url('gerenciar-setores') }}"><i class='fa fa-university'></i> <span>Setores</span></a>
                    </li>

                   @can('ver-relatorio-setor')
                    <li><a href="{{ url('gerenciar-setores/relatorio') }}" target="_blank"><i class=' fa fa-file-text'></i> <span>Relatório dos setores</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endif
            
            @if(Auth::user()->HasAnyPermission(['ver-usuario','ver-escala','ver-horas-extras']))
             <li class="treeview" class="active">   
                <a href="#"><i class='fa fa-users'></i> <span>Gerenciar Usuários</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    @can('ver-usuario')
                    <li><a href="{{ url('gerenciar-users') }}"><i class='fa fa-user'></i> <span>Usuários</span></a></li>
                    @endcan

                    @can('ver-permission')
                    <li><a href="{{ url('gerenciar-users/permissions') }}"><i class='fa fa-user'></i> <span>Permissão</span></a></li>
                    @endcan
                   
                   @can('ver-escala')
                   <li><a href="{{ url('gerenciar-escalas') }}"><i class='fa fa-user'></i> <span>Escala</span></a></li>
                   @endcan

                   @can('ver-horas-extras') 
                   <li><a href="{{ url('gerenciar-horas') }}"><i class='fa fa-clock-o'></i> <span>Horas Extras</span></a></li>
                   @endcan

                   @can('ver-relatorio-hora')
                    <li><a href="{{ url('gerenciar-horas/relatorio') }}" target="_blank"><i class='fa fa-file-text'></i> <span>Relatório horas extras</span></a></li>
                   @endcan

                    @can('ver-relatorio-hora')
                    <li><a href="{{ url('gerenciar-users/relatorio') }}" target="_blank"><i class='fa fa-file-text'></i> <span>Relatório Usuários</span></a></li>
                   @endcan 

                    @can('ver-relatorio-escala')
                    <li><a href="{{ url('gerenciar-escalas/relatorio') }}" target="_blank"><i class='fa fa-file-text'></i> <span>Relatório Escala</span></a></li>
                    @endcan
                </ul>
            </li>
            @endif

            @if(Auth::user()->HasAnyPermission(['ver-materiais','ver-estoque']))
            <li class="treeview">
                <a href="#"><i class='fa fa-cubes'></i> <span>Gerenciar Material</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                   @can('ver-materiais')
                   <li><a href="{{ url('gerenciar-materiais') }}"><i class='fa fa-user'></i> <span>Material</span></a></li>
                   @endcan

                   @can('ver-estoque')
                   <li><a href="{{ url('gerenciar-entradas-materiais') }}"><i class='fa fa-database'></i> <span>Estoque</span></a></li>
                   @endcan

                   <!-- @can('ver-relatorio-material')
                    <li><a href="{{ url('gerenciar-materiais/relatorio') }}" target="_blank"><i class='fa fa-file-text'></i> <span>Relatório</span></a></li>
                    @endcan -->

                    @can('ver-relatorio-material')
                    <li><a href="#" class="btnRelatorioMaterial" data-toggle="tooltip"><i class="fa fa-file-text"></i> Relatório Material</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endif 
            
            @if(Auth::user()->HasAnyPermission(['ver-contrato','ver-item-contrato']))
            <li class="treeview">
                <a href="#"><i class='fa fa-clone'></i> <span>Gerenciar Contratos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @can('ver-contrato')
                    <li><a href="{{ url('gerenciar-contratos') }}"><i class='fa fa-wrench'></i> <span>Contrato</span></a></li>
                    @endcan

                    @can('ver-item-contrato')
                    <li><a href="{{ url('gerenciar-itens') }}"><i class='fa fa-wrench'></i> <span>Itens</span></a></li>
                    @endcan

                    @can('ver-relatorio-contrato')
                    <li><a href="{{ url('gerenciar-contratos/relatorio') }}" target="_blank"><i class='fa fa-file-text'></i> <span>Relatório</span></a></li>
                    @endcan
               </ul>
            </li>     
            @endif

             <li class="treeview">
                <a href="#"><i class='fa fa-clone'></i> <span>Gerenciar Empenhos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('gerenciar-empenhos') }}"><i class='fa fa-wrench'></i> <span>Empenhos </span></a></li>
               </ul>
            </li>     

            @if(Auth::user()->HasAnyPermission(['ver-contrato','ver-item-contrato']))
            <li class="treeview">
                <a href="#"><i class='fa fa-clone'></i> <span>Gerenciar Solicitação</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                   @can('ver-solicitacao')
                   <li><a href="{{ url('gerenciar-solicitacoes') }}"><i class='fa fa-sticky-note-o'></i> <span>Solicitação</span></a></li>
                   @endcan

                   @can('ver-servico-solicitacao')
                   <li><a href="{{ url('gerenciar-servicos') }}"><i class='fa fa-wrench'></i> <span>Servicos</span></a></li>
                   @endcan

                   @can('ver-baixa-material')
                   <li><a href="{{ url('gerenciar-baixa-itens') }}"><i class='fa fa-wrench'></i> <span>Baixa de material</span></a></li>
                   @endcan 
                    
                   @can('ver-relatorio-solicitacao')
                    <li><a href="{{ url('gerenciar-solicitacoes/relatorio') }}" target="_blank"><i class='fa fa-file-text'></i> <span>Relatório</span></a></li>
                   @endcan

            </li>
            @endif


        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
