@extends('base_layouts.master')

@section('content')
    <section class="content-header">

        <h1>Contrato {{ isset($name->name_social_name) ? ' nº ' . str_pad($data->id, 5, '0', STR_PAD_LEFT) . ' - ' . $name->name_social_name : '[ Novo ]' }} </h1>
    </section>
    <section class="content" :json="[form.setData({{ $data }})]">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">

                        <form method="POST" id="person" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div id="formFields">

                                    <div class="form-group col-md-12">
                                        <label>Pessoa</label>
                                        <select class="form-control" v-model="person" required>
                                            <option value="">Selecione</option>
                                            @foreach($person as $item)
                                                <option {{ $item->active == 0 ? 'disabled' : '' }} value="{{ $item->id }}">{{ $item->name_social_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Tipo de Pagamento</label>
                                        <select class="form-control" v-model="payment_type" required>
                                            <option value="">Selecione</option>
                                            @foreach($payment_type as $item)
                                                <option {{ $item->active == 0 ? 'disabled' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{--<div class="form-group col-md-6">--}}
                                        {{--<label>Serviço</label>--}}
                                        {{--<select class="form-control" v-model="service" required>--}}
                                            {{--<option value="">Selecione</option>--}}
                                            {{--@foreach($service as $item)--}}
                                                {{--<option {{ $item->active == 0 ? 'disabled' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}

                                    <div class="form-group col-md-6">
                                        <label >Dia de Pagamento</label>
                                        <input type="number" class="form-control" v-model="form.data.due_day" required maxlength="2" min="1" max="31"/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label >Senha</label>
                                        <input type="text" class="form-control" v-model="form.data.emergency_password" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label >Contra Senha</label>
                                        <input type="text" class="form-control" v-model="form.data.contra_emergency_password" required />
                                    </div>

                                    <div class="form-group col-md-6 type-date">
                                        <label>Data Inicial</label>
                                        <datepicker lang="pt-br" format="dd/MM/yyyy" :editable="true" width="100%" input-class="form-control"
                                                    input-name="data_saida" v-model="form.data.start_date" />
                                    </div>

                                    <div class="form-group col-md-6 type-date">
                                        <label>Data Final</label>
                                        <datepicker lang="pt-br" format="dd/MM/yyyy" :editable="true" width="100%" input-class="form-control"
                                                    input-name="data_saida" v-model="form.data.end_date" />
                                    </div>

                                    <br><br>
                                    <div class="form-group col-md-12">
                                        <hr>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="form-group col-md-6">
                                        <button type="button" class="btn btn-default btn-block" onclick="history.back(-1)">Cancelar</button>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block">Salvar</button>
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
