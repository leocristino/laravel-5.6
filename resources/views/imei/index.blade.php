@extends('base_layouts.master')

@section('content')
    <section class="content-header">

    </section>
    <div class="col-md-9">
        <h1>Contrato nº {{ str_pad($data->id, 5, '0', STR_PAD_LEFT)}} - {{$name->name_social_name}}</h1>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="hidden">
                        @{{ form.setData(<?= $values ?>) }}
                        @{{ id_contract = <?= $data->id ?> }}
                    </div>

                    <div class="box-body">

                        <fieldset><legend>Adicionar IMEI</legend>
                            <div class="col-md-10 col-md-offset-1">
                                <form method="POST" @submit.prevent="addValor">

                                    <div class="form-group col-md-4">
                                        <label>Número</label>
                                        <input class="form-control" v-model="formAdd.number" type="text" required />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Descrição</label>
                                        <input class="form-control" v-model="formAdd.description" type="text" required />
                                    </div>

                                    <div class="form-group col-md-1">
                                        <br>
                                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus"></i></button>
                                    </div>
                                </form>
                            </div>
                        </fieldset>

                        <fieldset><legend>IMEIs Cadastrados</legend>

                            <div class="col-md-8 col-md-offset-2">
                                <form method="POST" @submit.prevent="submit_form()">
                                    {{csrf_field()}}

                                    <table class="table">
                                        <tr >
                                            <th width="40%">Número</th>
                                            <th width="60%">Descrição</th>
                                        </tr>
                                        <tr v-for="data in form.data" v-show="data.active !== false">
                                            <td>@{{ data.number }}</td>
                                            <td>@{{ data.description }}</td>


                                            <td><button type="button" @click="delValor(data)" class="btn btn-small btn-default"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                    </table>

                                    <div class="clearfix">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-default btn-block" onclick="history.back(-1)">Cancelar</button>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="submit" class="btn btn-primary btn-block">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </fieldset>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection