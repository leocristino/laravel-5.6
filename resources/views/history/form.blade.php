@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Cadastro de Histórico [ @{{ form.data.id == undefined ? 'Novo' : namePerson }} ]</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="hidden">
                        @{{ form.setData(<?= $data ?>) }}
                        @{{ nomePessoa(<?= $person ?>) }}

                    </div>

                    <div class="box-body">

                        <form method="POST" id="person" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div id="formFields">

                                    <div class="form-group col-md-12">
                                        <label>Cliente</label>
                                        <select class="form-control" v-model="person" required>
                                            <option value="">Selecione um cliente</option>
                                            @foreach($person as $item)
                                                <option value="{{ $item->id }}">{{ $item->name_social_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 type-date">
                                        <label>Data do Contato</label>
                                        <datepicker lang="pt-br" format="dd/MM/yyyy" required :editable="true" width="100%"  input-class="form-control" v-model="form.data.contact_time" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Horário</label>
                                        <input type="time" class="form-control" v-model="form.data.contact_time_hour" />
                                    </div>



                                    <div class="form-group col-md-12">
                                        <label>Observação</label>
                                        <textarea v-model="form.data.description" id="description" required  class="form-control ckeditor" required maxlength="255"></textarea>
                                    </div>


                                <br><br>

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
