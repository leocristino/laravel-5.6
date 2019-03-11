@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Usuário [ @{{ form.data.id == undefined ? 'Novo' : form.originalData.user }} ]</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="hidden">
                        @{{ form.setData(<?= $data ?>) }}
                        @{{ setPermissoes(<?= $permissoes ?>) }}
                    </div>

                    <div class="box-body">

                        <form method="POST" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div class="form-group col-md-12">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" v-model="form.data.nome" maxlength="50" required autofocus/>
                                </div>

                                <fieldset class="col-md-12"><legend>Permissões</legend>

                                    <div class="row">
                                        <div class="col-md-4" v-for="item in permissoes">
                                            <label><input type="checkbox"
                                                          :checked="form.data.permissoes.indexOf(item.id) != -1"
                                                          @change="onSelectPermissao(item.id)"> @{{ item.nome }} </label>
                                        </div>
                                    </div>
                                </fieldset>

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