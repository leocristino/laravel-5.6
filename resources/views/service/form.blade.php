@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Serviço [ @{{ form.data.id == undefined ? 'Novo' : form.originalData.name_social_name }} ]</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="hidden">
                        @{{ form.setData(<?= $data ?>) }}

                    </div>

                    <div class="box-body">

                        <form method="POST" id="person" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div id="formFields">
                                <div class="form-group col-md-6">
                                    <label >Nome</label>
                                    <input type="text" class="form-control" v-model="form.data.name" required maxlength="200"/>
                                </div>

                                <div class="form-group col-md-6">
                                    <label >Valor</label>
                                    <money class="form-control" v-model="form.data.price" prefix="R$ " decimal="," thousands="." required />
                                </div>

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
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
