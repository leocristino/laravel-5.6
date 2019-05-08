@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <div class="col-md-9">
            <h1>Faturamento</h1>
        </div>
        {{--<div class="col-md-3">--}}
            {{--<a href="{{ url()->current() }}/create">--}}
                {{--<button class="btn btn-block btn-success"><i class="fa fa-plus"></i> Novo</button>--}}
            {{--</a>--}}
        {{--</div>--}}
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">

                        <form method="POST" id="paymant_type" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div id="formFields">

                                    <div class="form-group col-md-6 type-date">
                                        <label>Data Inicial</label>
                                        <datepicker lang="pt-br" format="dd/MM/yyyy" :editable="true" width="100%" input-class="form-control" required
                                                    input-name="data_saida" v-model="form.data.start_date" />
                                    </div>
                                    <div class="form-group col-md-6 type-date">
                                        <label>Data Final</label>
                                        <datepicker lang="pt-br" format="dd/MM/yyyy" :editable="true" width="100%" input-class="form-control" required
                                                    input-name="data_saida" v-model="form.data.end_date" />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label >Plano de Contas</label>
                                        <select name="" id="" v-model="form.data.id_ticket" class="form-control" required>
                                            <option value="">Selecione</option>
                                            @foreach($ticket as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 type-date">
                                        <label>Mês / Ano Referência</label>
                                        <input type="tel" class="form-control" v-model="form.data.referenceDate" placeholder="{{ date('m') }}/{{ date('Y') }}" v-mask="'##/####'"  required/>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <hr>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="form-group col-md-6">
                                        <button type="button" class="btn btn-default btn-block" onclick="history.back(-1)">Cancelar</button>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block">Gerar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection