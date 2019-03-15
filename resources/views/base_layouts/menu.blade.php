<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form (Optional) -->
    {{--<div class="input-group">
        <input type="text" class="form-control" placeholder="Pesquisar" id="sidebar-menu-search">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                <i class="fa fa-search"></i>
            </button>
        </span>
    </div>--}}
    <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="{{$view_name == 'home' ? 'active' : ''}}">
                <a href="{{URL::to('/')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
            </li>

            @if(\App\Models\Permissao::userHasPermissao(['USER', 'USER_GRUPO']))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users-cog"></i> <span>Segurança</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @if(\App\Models\Permissao::userHasPermissao('USER'))
                    <li><a href="{{URL::to('/')}}/user">Usuários</a></li>
                    @endif

                    @if(\App\Models\Permissao::userHasPermissao('PERSON'))
                        <li><a href="{{URL::to('/')}}/person">Pessoas</a></li>
                    @endif

                    @if(\App\Models\Permissao::userHasPermissao('HISTORY'))
                        <li><a href="{{URL::to('/')}}/history">Histórico de Clientes</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if(\App\Models\Permissao::userHasPermissao(['PESSOA', 'CB_GERAL_INSTITUICAO', 'VISITA']))
            <li class="treeview menu-open">
                <a href="#">
                    <i class="fa fa-cogs"></i> <span>Cadastros</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu" style="display: block">
                    @if(\App\Models\Permissao::userHasPermissao('PESSOA'))
                    <li><a href="{{URL::to('/')}}/pessoa">Pessoas</a></li>
                    @endif

                    @if(\App\Models\Permissao::userHasPermissao('CB_GERAL_INSTITUICAO'))
                    <li><a href="{{URL::to('/')}}/cb_geral_instituicao">Colégios</a></li>
                    @endif

                    @if(\App\Models\Permissao::userHasPermissao('VISITA'))
                        <li><a href="{{URL::to('/')}}/visita">Visitas</a></li>
                    @endif
                    {{--<li><a href="{{URL::to('/')}}/pessoa/relatorios">Relatórios</a></li>--}}
                </ul>
            </li>
            @endif

            @if(\App\Models\Permissao::userHasPermissao(['PEDAGOGICO_DESTINO', 'PEDAGOGICO_VENDA', 'PEDAGOGICO_VENDA_PAX', 'PEDAGOGICO_VENDA_MON']))
            <li class="treeview menu-open">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>Pacotes pedagógicos</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu" style="display: block">
                    @if(\App\Models\Permissao::userHasPermissao(['PEDAGOGICO_DESTINO']))
                    <li><a href="{{URL::to('/')}}/pedagogico/destinos">Destinos</a></li>
                    @endif

                    @if(\App\Models\Permissao::userHasPermissao(['PEDAGOGICO_VENDA']))
                    <li><a href="{{URL::to('/')}}/pedagogico/vendas">Vendas</a></li>
                    @endif
                </ul>
            </li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>