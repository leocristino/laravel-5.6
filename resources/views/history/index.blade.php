@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <div class="col-md-9">
            <h1>Histórico de Clientes</h1>
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
                                <label>Cliente</label>
                                <input type="text" class="form-control" name="name_social_name" value="{{ empty($_GET['name_social_name']) ? '' : $_GET['name_social_name'] }}" />
                            </div>

                            <div class="form-group col-md-3 type-date col-sm-6">
                                <label>Data Contato Inicial</label>
                                {{--<datepicker lang="pt-br" format="dd/MM/yyyy" readonly="true" :editable="true" width="100%" input-class="form-control" value="{{ empty($_GET['bigger_than']) ? '' : $_GET['bigger_than'] }}"--}}
                                            {{--input-name="bigger_than" />--}}
                                <input type="date" class="form-control" name="bigger_than"  value="{{ empty($_GET['bigger_than']) ? '' : $_GET['bigger_than'] }}" />


                            </div>

                            <div class="form-group col-md-3 type-date">
                                <label>Data Contato Final</label>
                                <input type="date" class="form-control" name="less_than"  value="{{ empty($_GET['less_than']) ? '' : $_GET['less_than'] }}" />
                                {{--<datepicker lang="pt-br" format="dd/MM/yyyy" readonly="true" :editable="true" width="100%" input-class="form-control" value="{{ empty($_GET['less_than']) ? '' : $_GET['less_than'] }}"--}}
                                            {{--input-name="less_than" v-model="form.data.less_than" />--}}
                            </div>

                            <div class="form-group col-md-3 col-sm-6">
                                <br>
                                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 5px"><i class="fa fa-search"></i> Pesquisar</button>
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
                                                <th class="hidden-xs">Data Cadastro</th>
                                                <th class="hidden-xs">Data Contato</th>
                                                <th width="50px"></th>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $item)
                                            <tr id="table{{ $item->id }}" >
                                                <td>{{ $item->name_social_name }}</td>
                                                <td class="hidden-xs">{{ $item->created_at }}</td>
                                                <td class="hidden-xs">{{  date("d/m/Y", strtotime(substr($item->contact_time,0,10))) }} {{ substr($item->contact_time_hour, 0 ,5) }}</td>
                                                <td>
                                                    <a href="{{ url()->current() }}/{{ $item['id'] }}/edit">
                                                        <button title="Editar" class="btn btn-small btn-default"><i class="fa fa-edit"></i></button>
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
                                <br><br>
                                <div class="col-sm-12 text-center">
                                    <a target="_blank" href="{{ url()->current() }}/pdf/?{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-pdf"></i> exportar para PDF</button>
                                    </a>
                                    <a target="_blank" href="{{ url()->current() }}/csv/?{{ http_build_query($params) }}">
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