@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <div class="col-md-9">
            <h1>Contratos</h1>
        </div>
        <div class="col-md-3">
            <a href="{{ url()->current() }}/create">
                <button class="btn btn-block btn-success"><i class="fa fa-plus"></i> Novo</button>
            </a>
        </div>
    </section>
    <section class="content" >
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <form action="{{ url()->current() }}">

                            <div class="form-group col-md-2 col-sm-6">
                                <label>Nº do Contrato</label>
                                <input type="text" class="form-control" name="id_contract" value="{{ empty($_GET['id_contract']) ? '' : $_GET['id_contract'] }}" />
                            </div>
                            <div class="form-group col-md-2 col-sm-6">
                                <label>Cliente</label>
                                <input type="text" class="form-control" name="name_social_name" value="{{ empty($_GET['name_social_name']) ? '' : $_GET['name_social_name'] }}" />
                            </div>

                            <div class="form-group col-md-2 col-sm-6">
                                <label>Tipo Pagamento</label>
                                <?php
                                $selectPayment_type = '';
                                if(isset($_GET['id_payment_type'])){
                                    if($_GET['id_payment_type']){
                                        $selectPayment_type = $_GET['id_payment_type'];
                                    }
                                }
                                ?>
                                {{--{{isset($_GET['id_payment_type'])}}--}}
                                <select name="id_payment_type" id="" class="form-control" value="{{ empty($_GET['id_payment_type']) ? '' : $_GET['id_payment_type'] }}">
                                    <option value="">Todos</option>
                                    @foreach ($payment_type as $item)
                                        <option {{ $selectPayment_type == $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-2 col-sm-6">
                                <label>Ativo</label>
                                <?php
                                $select = 2;
                                if(isset($_GET['end_date'])){
                                    if($_GET['end_date'] == 1){
                                        $select = 1;
                                    }
//                                    else{
//                                        $select = 0;
//                                    }
                                }
                                if(isset($_GET['end_date'])){
                                    if($_GET['end_date'] == date('Y-m-d')){
                                        $select = 0;
                                    }
                                }
                                ?>
                                <select name="end_date" id="" class="form-control" value="{{ empty($_GET['end_date']) ? '' : $_GET['end_date'] }}">
                                    <option value="">Todos</option>
                                    <option {{ $select == 1 ? 'selected' : ''}} value="1">Ativo</option>
                                    <option {{ $select == 0 ? 'selected' : ''}} value="{{ date('Y-m-d') }}">Inativo</option>
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
                                            <th>Nº Contrato</th>
                                            <th>Cliente</th>
                                            <th class="hidden-xs">Tipo de pagamento</th>
                                            <th class="hidden-xs">Data Inicial</th>
                                            <th class="hidden-xs">Data Final</th>
                                            <th class="hidden-xs">Valor Contrato</th>
                                            <th class="hidden-xs">Ativo</th>
                                            <th class="hidden-xs" width="50px"></th>
                                            <th class="hidden-xs" width="50px"></th>
                                            <th class="hidden-xs" width="50px"></th>
                                            <th width="50px"></th>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $item)
                                            {{--desktop--}}
                                            <tr class="hidden-xs {{ $item->contractActive == 0 ? 'danger' : ''  }}" id="table{{ $item->id }}" >
                                                <td>{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $item->name_social_name }}</td>
                                                <td class="hidden-xs">{{ $item->name }}</td>
                                                <td class="hidden-xs">{{ date("d/m/Y", strtotime($item->start_date)) }}</td>
                                                <td class="hidden-xs">{{ empty($item->end_date) ? '' : date("d/m/Y", strtotime($item->end_date)) }}</td>
                                                <td class="hidden-xs">R$ {{ $item->valueContract != '' ? $item->valueContract : '0,00' }}</td>
                                                <td class="hidden-xs"><i id="imgStatus{{ $item->id }}" class="{{ $item->contractActive == 1 ? 'fas fa-check' : 'fas fa-times'}}"></i></td>
                                                <td>
                                                    <a href="{{ url()->current() }}/contract_service/{{ $item['id'] }}/save">
                                                        <button class="btn btn-small btn-default" title="Serviços">
                                                            <i class="fas fa-tasks"></i>
                                                            <span class="badge badge-light">{{ $item->qtde_valores_service }}</span>
                                                        </button>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ url()->current() }}/contract_car/{{ $item['id'] }}/save">
                                                        <button class="btn btn-small btn-default" title="Carros">
                                                            <i class="fas fa-car"></i>
                                                            <span class="badge badge-light">{{ $item->qtde_valores_car }}</span>
                                                        </button>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ url()->current() }}/contract_imei/{{ $item['id'] }}/save">
                                                        <button class="btn btn-small btn-default" title="IMEIs">
                                                            <i class="fas fa-mobile-alt"></i>
                                                            <span class="badge badge-light">{{ $item->qtde_valores_imei }}</span>
                                                        </button>
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="{{ url()->current() }}/{{ $item['id'] }}/edit">
                                                        <button title="Editar" class="btn btn-small btn-default"><i class="fa fa-edit"></i></button>
                                                    </a>
                                                </td>
                                            </tr>
                                            {{--mobile--}}
                                            <tr class="visible-xs" >
                                                <td>{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $item->name_social_name }}</td>
                                                <td class="hidden-xs"><i id="imgStatus{{ $item->id }}" class="{{ $item->contractActive == 1 ? 'fas fa-check' : 'fas fa-times'}}"></i></td>
                                                <td>
                                                    <a href="{{ url()->current() }}/contract_service/{{ $item['id'] }}/save">
                                                        <button class="btn btn-small btn-default" title="Serviços">
                                                            <i class="fas fa-tasks"></i>
                                                            <span class="badge badge-light">{{ $item->qtde_valores_service }}</span>
                                                        </button>
                                                    </a>
                                                <br>
                                                    <a href="{{ url()->current() }}/contract_car/{{ $item['id'] }}/save">
                                                        <button class="btn btn-small btn-default" title="Carros">
                                                            <i class="fas fa-car"></i>
                                                            <span class="badge badge-light">{{ $item->qtde_valores_car }}</span>
                                                        </button>
                                                    </a>
                                                <br>
                                                    <a href="{{ url()->current() }}/contract_imei/{{ $item['id'] }}/save">
                                                        <button class="btn btn-small btn-default" title="IMEIs">
                                                            <i class="fas fa-mobile-alt"></i>
                                                            <span class="badge badge-light">{{ $item->qtde_valores_imei }}</span>
                                                        </button>
                                                    </a>
                                                <br>
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
                                    <a target="_blank" href="{{ url()->current() }}/pdf/?full=yes&{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-pdf"></i> Completo para PDF</button>
                                    </a>
                                    <a target="_blank" href="{{ url()->current() }}/csv/?full=yes&report=true&{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-excel"></i> Completo para Excel</button>
                                    </a>
                                </div>
                                <br><br>
                                <div class="col-sm-12 text-center">
                                    <a target="_blank" href="{{ url()->current() }}/pdf/?full=no&{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-pdf"></i> Simplificado para PDF</button>
                                    </a>
                                    <a target="_blank" href="{{ url()->current() }}/csv/?full=no&report=true&{{ http_build_query($params) }}">
                                        <button class="btn btn-small btn-default"><i class="fa fa-file-excel"></i> Simplificado para EXCEL</button>
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