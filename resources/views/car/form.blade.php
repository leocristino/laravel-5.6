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

                        <form method="POST" id="car" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div id="formFields">

                                    <div class="form-group col-md-4">
                                        <label >Modelo</label>
                                        <input type="text" class="form-control" v-model="form.data.model" required maxlength="50"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Placa</label>
                                        <input type="text" class="form-control" v-model="form.data.license_plate" required maxlength="8"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Cor</label>
                                        <input type="text" class="form-control" v-model="form.data.color" required maxlength="25"/>
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>Chassi</label>
                                        <input type="text" class="form-control" v-model="form.data.chassis" required maxlength="25"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>CNH Motorista</label>
                                        <input type="text" class="form-control" v-model="form.data.driver_license" required maxlength="25"/>
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
