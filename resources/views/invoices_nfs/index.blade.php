@extends('base_layouts.master')

@section('content')
    <div class="loading" style="display:none;">

    </div>
    <section class="content-header">
        <div class="col-md-9">
            <h1>Contas a Receber</h1>
        </div>
        <div class="col-md-3">
            {{--<a href="{{ url()->current() }}/create">--}}
                {{--<button class="btn btn-block btn-success"><i class="fa fa-plus"></i> Novo</button>--}}
            {{--</a>--}}
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <form action="{{ url()->current() }}">

                            <div class="form-group col-md-3 col-sm-6">
                                <label>Lote</label>
                                <input type="text" class="form-control" name="lot" value="{{ empty($_GET['lot']) ? '' : $_GET['lot'] }}" />
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
                                                <th width="80px">Lote</th>
                                                <th width="120px">Qtd Lote</th>
                                                <th width="220px" class="hidden-xs">Data Lote</th>
                                                <th width="220px" class="hidden-xs">Mês Referência</th>
                                                <th width="220px">Total do Lote</th>
                                                <th width="90px">Boleto</th>
                                                <th width="90px">NFS-e</th>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $item)
                                            <tr>
                                                <td>{{ str_pad($item->lot, 3, "0", STR_PAD_LEFT) }}</td>
                                                <td>{{ str_pad($item->totalLot, 3, "0", STR_PAD_LEFT) }}</td>
                                                <td class="hidden-xs">{{ date("d/m/Y h:m", strtotime($item->dateLot)) }}</td>
                                                <td class="hidden-xs">{{ date("m/Y", strtotime($item->due_date)) }}</td>
                                                <td>R$ {{ number_format($item->value, 2, ',', '.') }}</td>
                                                <td>

                                                    <a @click.stop.prevent="sendLotToEmail('{{ md5($item->lot) }}','{{ md5($item->id_bank_account) }}')">
                                                        <button title="Enviar e-mail" class="btn btn-small btn-default"><i class="fas fa-envelope"></i></button>
                                                    </a>
                                                </td>
                                                {{--<td>--}}
                                                    {{--<a href="{{ url()->current() }}/{{ md5($item->lot) }}/nfs">--}}
                                                        {{--<button title="Enviar e-mail" class="btn btn-small btn-default"><i class="fas fa-envelope"></i></button>--}}
                                                    {{--</a>--}}
                                                {{--</td>--}}
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

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection