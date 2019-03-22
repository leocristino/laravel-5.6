@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Cadastro de Veículo [ @{{ form.data.id == undefined ? 'Novo' : form.data.number }} ]</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="hidden">
                        @{{ form.setData(<?= $data ?>) }}

                    </div>

                    <div class="box-body">

                        <form method="POST" id="paymant_type" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div id="formFields">

                                    <div class="form-group col-md-6">
                                        <label >Número do IMEI</label>
                                        <input type="number" class="form-control" v-model="form.data.number" required maxlength="50"/>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Descrição</label>
                                        <textarea v-model="form.data.description" id="description" required  class="form-control ckeditor" required maxlength="255"></textarea>
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
