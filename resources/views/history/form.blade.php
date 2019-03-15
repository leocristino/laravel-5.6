@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Cadastro de Histórico [ @{{ form.data.id == undefined ? 'Novo' : form.originalData.name_social_name }} ]</h1>
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

                            <div class="col-md-12">

                                <br><br>

                                <div id="formFields">

                                    <div class="form-group col-md-6">
                                        <label>Cliente</label>
                                        <select class="form-control" name="" id="">
                                            @foreach($person as $item)
                                                <option value="{{ $item->id }}">{{ $item->name_social_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 type-date">
                                        <label>Data de Cadastro</label>
                                        <input type="date" class="form-control" v-model="form.data.contact_time" />
                                    </div>




                                    <div class="form-group col-md-12">
                                        <label>Observação</label>
                                        <textarea v-model="form.data.description" id="description"  class="form-control ckeditor" maxlength="255"></textarea>
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
