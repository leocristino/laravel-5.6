@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <div class="col-md-9">
            <h1>Receita / Despesa</h1>
        </div>
        <div class="col-md-3" style="margin-bottom: 10px;">
            <a href="{{ url()->current() }}/create?ticket=R">
                <button class="btn btn-block btn-success"><i class="fa fa-plus"></i> Nova Receita</button>
            </a>

        </div>
        <div class="col-md-3" style="margin-bottom: 10px;">
            <a href="{{ url()->current() }}/create?ticket=D">
                <button class="btn btn-block btn-success"><i class="fa fa-plus"></i> Nova Despesa</button>
            </a>

        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <form action="{{ url()->current() }}">

                            <div class="form-group col-md-2 col-sm-6">
                                <label>Tipo</label>
                                <?php
                                $select = 2;
                                if(isset($_GET['account_type'])){
                                    if($_GET['account_type'] == "R"){
                                        $select = "R";
                                    }
                                }
                                if(isset($_GET['account_type'])){
                                    if($_GET['account_type'] == "D"){
                                        $select = "D";
                                    }
                                }
                                ?>
                                <select name="account_type" id="" class="form-control" value="{{ empty($_GET['active']) ? '' : $_GET['active'] }}">
                                    <option value="">Todos</option>
                                    <option {{ $select == "D" ? 'selected' : ''}} value="D">Despesa</option>
                                    <option {{ $select == "R" ? 'selected' : ''}} value="R">Receita</option>
                                </select>
                            </div>

                            <div class="form-group col-md-1 col-sm-6">
                                <label>Lote</label>
                                <input type="text" class="form-control" name="lot" value="{{ empty($_GET['lot']) ? '' : $_GET['lot'] }}" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6">
                                <label>Pessoa</label>
                                <input type="text" class="form-control" name="name_social_name" value="{{ empty($_GET['name_social_name']) ? '' : $_GET['name_social_name'] }}" />
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
                                                <th width="60px">Tipo</th>
                                                <th>Lote</th>
                                                <th>Pessoa</th>
                                                <th>Valor a Pagar</th>
                                                <th >Valor Pago</th>
                                                <th class="hidden-xs">Plano de Conta</th>
                                                <th width="50px"></th>
                                                <th width="50px"></th>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $item)
                                            <tr>
                                                <td>{{ $item->account_type }}</td>
                                                <td>{{ $item->lot }}</td>
                                                <td>{{ $item->name_social_name }}</td>
                                                <td class="hidden-xs">R$ {{ number_format($item->value_bill, 2, ',', '.') }}</td>
                                                <td class="hidden-xs">R$ {{ number_format($item->amount_paid, 2, ',', '.') }}</td>
                                                <td class="hidden-xs">{{ $item->name_ticket }}</td>

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
                                    <a target="_blank" href="{{ url()->current() }}/pdf/?report=true&{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-pdf"></i> exportar para PDF</button>
                                    </a>
                                    <a target="_blank" href="{{ url()->current() }}/csv/?report=true&{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-excel"></i> exportar para EXCEL</button>
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