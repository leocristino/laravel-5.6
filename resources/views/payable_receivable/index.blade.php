@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <div class="col-md-9">
            <h1>Contas a Receber</h1>
        </div>
        <div class="col-md-3">
            <a href="{{ url()->current() }}/create">
                <button class="btn btn-block btn-success"><i class="fa fa-plus"></i> Novo</button>
            </a>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <form action="{{ url()->current() }}">

                            <div class="form-group col-md-3 col-sm-6">
                                <label>Nome</label>
                                <input type="text" class="form-control" name="name_social_name" value="{{ empty($_GET['name_social_name']) ? '' : $_GET['name_social_name'] }}" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6">
                                <label>Tipo de Despesa</label>
                                <?php
                                $select = 2;
                                if(isset($_GET['account_type'])){
                                    if($_GET['account_type'] == "R"){
                                        $select = "R";
                                    }
                                }
                                if(isset($_GET['account_type'])){
                                    if($_GET['account_type'] == "P"){
                                        $select = "P";
                                    }
                                }
                                ?>
                                <select name="account_type" id="" class="form-control" value="{{ empty($_GET['active']) ? '' : $_GET['active'] }}">
                                    <option value="">Todos</option>
                                    <option {{ $select == "P" ? 'selected' : ''}} value="P">Pagar</option>
                                    <option {{ $select == "R" ? 'selected' : ''}} value="R">Receber</option>
                                </select>
                            </div>
                                <div class="form-group col-md-3 col-sm-6">
                                <br>
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Pesquisar</button>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        <div class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-hover dataTable" >
                                        <thead>
                                            <tr role="row">
                                                <th>Pessoa</th>
                                                <th class="hidden-xs">Tipo de Despesa</th>
                                                <th class="hidden-xs">Plano de Conta</th>
                                                <th class="hidden-xs">Forma de Pagamento</th>
                                                <th class="hidden-xs">Valor a Pagar</th>
                                                <th width="50px"></th>
                                                <th width="50px"></th>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $item)
                                            <tr>
                                                <td>{{ $item->name_social_name }}</td>
                                                <td class="hidden-xs">{{ $item->account_type == "R" ? "Receber" : "Pagar" }}</td>
                                                <td class="hidden-xs">{{ $item->name_ticket }}</td>
                                                <td class="hidden-xs">{{ $item->name_payment_type }}</td>
                                                <td class="hidden-xs">R$ {{ $item->value_bill }}</td>
                                                <td>
                                                    <a href="{{ url()->current() }}/{{ $item['id'] }}/edit">
                                                        <button title="Editar" class="btn btn-small btn-default"><i class="fa fa-edit"></i></button>
                                                    </a>
                                                </td>
                                                <td><button class="btn btn-small btn-danger" title="Excluir Conta a Receber" @click="deleteAccountReceivable({{$item}})"><i class="fas fa-trash-alt"></i></button> </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <div class="dataTables_info" role="status" aria-live="polite">{{$data->total()}} registros</div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    {{$data->links()}}
                                </div>
                                <br><br>
                                <div class="col-sm-12 text-center">
                                    <a target="_blank" href="{{ url()->current() }}/pdf/?{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-pdf"></i> exportar para PDF</button>
                                    </a>
                                    <a target="_blank" href="{{ url()->current() }}/csv/?{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-excel"></i> exportar para CSV</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection