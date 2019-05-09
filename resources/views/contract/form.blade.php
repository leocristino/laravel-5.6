@extends('base_layouts.master')

@section('content')
    <section class="content-header">

        <h1>Contrato {{ isset($name->name_social_name) ? ' nº ' . str_pad($data->id, 5, '0', STR_PAD_LEFT) . ' - ' . $name->name_social_name : '[ Novo ]' }} </h1>
    </section>
    <section class="content" :json="[form.setData({{ $data }}), functionPaymentType({{ $payment_type }})]">
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
                                        <label>Cliente</label>
                                        <select class="form-control" v-model="person" required>
                                            <option value="">Selecione</option>
                                            @foreach($person as $item)
                                                <option {{ $item->active == 0 ? 'disabled' : '' }} value="{{ $item->id }}">{{ $item->name_social_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Forma de Pagamento</label>

                                        <select class="form-control" v-model="payment_type" @change="valuePaymentType()" required>
                                            <option value="">Selecione</option>
                                            <option v-for="option in optionPaymentType" :value="option.id">
                                                @{{ option.name }}
                                            </option>

                                        </select>
                                    </div>

                                    <div class="form-group col-md-6" id="current_account" v-show="ifBill == true">
                                        <label>Conta Corrente</label>
                                        <select class="form-control" v-model="current_account">
                                            <option value="">Selecione</option>
                                            @foreach($current_account as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6" id="emit_invoice">
                                        <label>Emite NFS</label>
                                        <select class="form-control" v-model="emit_invoice" required>
                                            <option value="">Selecione</option>
                                            <option value="S">SIM</option>
                                            <option value="N">NÃO</option>

                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label >Dia de Vencimento</label>
                                        <input type="number" min="1" max="31" class="form-control" v-model="form.data.due_day" required v-mask="'##'"/>
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
