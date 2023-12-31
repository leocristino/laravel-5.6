@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <div class="col-md-9">
            <h1>Usuários do sistema</h1>
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
                                <input type="text" class="form-control" name="name" value="{{ empty($_GET['name']) ? '' : $_GET['name'] }}" />
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
                                                <th>Nome</th>
                                                <th class="hidden-xs">E-mail</th>
                                                <th class="hidden-xs">Ativo</th>
                                                <th width="50px"></th>
                                                <th width="50px"></th>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $item)
                                            <tr class="{{ $item->active == 1 ? '' : 'danger'  }}" id="table{{ $item->id }}">
                                                <td>{{ $item->name }}</td>
                                                <td class="hidden-xs">{{ $item->email }}</td>
                                                <td class="hidden-xs"><i id="imgStatus{{ $item->id }}" class="{{ $item->active == 1 ? 'fas fa-check' : 'fas fa-times'}}"></i></td>
                                                <td>
                                                    <button id="btnCheck{{ $item->id }}" title="Desativar" class="btn btn-small btn-warning {{ $item->active === 1 ? "" : "font-active-none" }} btn-block" @click="activeDisabled({{$item->id}},1)"><i class="fa fa-times"></i></button>
                                                    <button id="btnTimes{{ $item->id }}" title="Ativar" class="btn btn-success btn-default {{ $item->active === 0 ? "" : "font-active-none" }} btn-block" @click="activeDisabled({{$item->id}},0)"><i class="fa fa-check"></i></button>
                                                </td>
                                                <td>
                                                    <a href="{{ url()->current() }}/{{ $item['id'] }}/edit">
                                                        <button class="btn btn-small btn-default"><i class="fa fa-edit"></i></button>
                                                    </a>
                                                </td>
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
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection