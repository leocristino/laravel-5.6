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

            @if(\App\Models\Permissao::userHasPermissao(['USER', 'HISTORY', 'SERVICE', 'TICKET']))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users-cog"></i> <span>Segurança</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @if(\App\Models\Permissao::userHasPermissao('USER'))
                    <li><a href="{{URL::to('/')}}/user">Usuários</a></li>
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

            @if(\App\Models\Permissao::userHasPermissao(['PERSON']))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Cadastros</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @if(\App\Models\Permissao::userHasPermissao('PERSON'))
                            <li><a href="{{URL::to('/')}}/person">Pessoas</a></li>
                        @endif

                    </ul>
                </li>
            @endif

            @if(\App\Models\Permissao::userHasPermissao(['CONTRACT', 'PAYMENT_TYPE', 'BANK_ACCOUNT']))
                <li class="treeview">
                    <a href="#">
                        <i class="fas fa-coins"></i> <span>Financeiro</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @if(\App\Models\Permissao::userHasPermissao('BANK_ACCOUNT'))
                            <li><a href="{{URL::to('/')}}/bank_account">Conta Corrente</a></li>
                        @endif

                        @if(\App\Models\Permissao::userHasPermissao('CONTRACT'))
                            <li><a href="{{URL::to('/')}}/contract">Contrato</a></li>
                        @endif

                        @if(\App\Models\Permissao::userHasPermissao('PAYMENT_TYPE'))
                            <li><a href="{{URL::to('/')}}/payment_type">Forma de Pagamento</a></li>
                        @endif

                    </ul>
                </li>
            @endif

            @if(\App\Models\Permissao::userHasPermissao(['REPORT']))
                <li class="treeview">
                    <a href="#">
                        <i class="fas fa-chart-pie"></i> <span>Relatórios</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @if(\App\Models\Permissao::userHasPermissao('REPORT'))
                            <li><a href="{{URL::to('/')}}/report">Relatório</a></li>
                        @endif


                    </ul>
                </li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>