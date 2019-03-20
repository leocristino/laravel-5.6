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

            @if(\App\Models\Permissao::userHasPermissao(['USER', 'PERSON', 'HISTORY', 'SERVICE', 'TICKET']))
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

                    @if(\App\Models\Permissao::userHasPermissao('SERVICE'))
                        <li><a href="{{URL::to('/')}}/service">Serviços</a></li>
                    @endif

                    @if(\App\Models\Permissao::userHasPermissao('TICKET'))
                        <li><a href="{{URL::to('/')}}/ticket">Cadastro de contas</a></li>
                    @endif
                </ul>
            </li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>