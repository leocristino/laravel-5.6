@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Cadastro de Contrato [ @{{ form.data.id == undefined ? 'Novo' : namePerson }} ]</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="hidden">
                        @{{ form.setData(<?= $data ?>) }}
                    </div>
                    {{$data}}

                    <div class="box-body">

                        <form method="POST" id="person" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="text" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div id="formFields">

                                    <div class="form-group col-md-12">
                                        <label>Pessoa</label>
                                        <select class="form-control" v-model="person" required>
                                            <option value="">Selecione</option>
                                            @foreach($person as $item)
                                                <option value="{{ $item->id }}">{{ $item->name_social_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Tipo de Pagamento</label>
                                        <select class="form-control" v-model="payment_type" required>
                                            <option value="">Selecione</option>
                                            @foreach($payment_type as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

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
                                        <datepicker lang="pt-br" format="dd/MM/yyyy" required :editable="true" width="100%"  input-class="form-control" v-model="form.data.start_date" />
                                    </div>

                                    <div class="form-group col-md-6 type-date">
                                        <label>Data Final</label>
                                        <datepicker lang="pt-br" format="dd/MM/yyyy" required :editable="true" width="100%"  input-class="form-control" v-model="form.data.end_date" />
                                    </div>

                                    <br><br>
                                    <div class="form-group col-md-12">
                                        <hr>
                                        <label><input type="checkbox" class="form-check-input" v-model="form.data.active" value="S"> Ativo</label>
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
