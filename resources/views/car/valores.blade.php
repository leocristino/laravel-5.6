@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Valores para [ {{ $nome }} ]</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="hidden">
                        @{{ form.setData(<?= $valores ?>) }}
                        @{{ id_pedagogico_destino = <?= $id?> }}
                    </div>

                    <div class="box-body">

                        <fieldset><legend>Adicionar Saídas</legend>
                            <div class="col-md-10 col-md-offset-1">
                                <form method="POST" @submit.prevent="addValor">
                                    <div class="form-group col-md-2">
                                        <label>Estado</label>
                                        <select class="form-control" v-model="formAdd.uf" @change="changeUf" required>
                                            @foreach($uf as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Cidade</label>
                                        <basic-select :options="cidades"
                                                      :selected-option="formAdd.cidade"
                                                      placeholder="Selecione"
                                                      @select="onSelectCidade"
                                                        required>
                                        </basic-select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Valor por pessoa</label>
                                        <money class="form-control" v-model="formAdd.valor" prefix="R$ " decimal="," thousands="." required />
                                    </div>
                                    {{--<div class="form-group col-md-3">--}}
                                        {{--<label>Qtde min. por ônibus</label>--}}
                                        {{--<input class="form-control" v-model="formAdd.qtde_min" type="number" required />--}}
                                    {{--</div>--}}
                                    <div class="form-group col-md-1">
                                        <br>
                                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus"></i></button>
                                    </div>
                                </form>
                            </div>
                        </fieldset>

                        <fieldset><legend>Saídas Cadastradas</legend>

                            <div class="col-md-8 col-md-offset-2">
                                <form method="POST" @submit.prevent="submit_form()">
                                    {{csrf_field()}}

                                    <table class="table">
                                        <tr class="hidden-xs">
                                            <th width="100px">Estado</th>
                                            <th width="30%">Cidade</th>
                                            <th width="25%">Valor por pessoa</th>
                                            {{--<th width="25%">Qtde. min. por ônibus</th>--}}
                                            <th width="50px"></th>
                                        </tr>
                                        <tr v-for="data in form.data" v-show="data.active !== false">
                                            <td class="hidden-xs">@{{ data.uf }}</td>
                                            <td class="hidden-xs">@{{ data.cidade }}</td>
                                            <td class="hidden-xs">
                                                <money class="form-control" v-model="data.valor" prefix="R$ " decimal="," thousands="." required />
                                            </td>
                                            {{--<td class="hidden-xs">--}}
                                                {{--<input class="form-control" v-model="data.qtde_min" type="number" required />--}}
                                            {{--</td>--}}
                                            <td width="90%" class="visible-xs">
                                                @{{ data.cidade }}/@{{ data.uf }} <br>
                                                <money class="form-control" v-model="data.valor" prefix="R$ " decimal="," thousands="." required ></money>
                                                {{--<br>--}}
                                                {{--<input class="form-control" v-model="data.qtde_min" type="number" required />--}}
                                            </td>
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