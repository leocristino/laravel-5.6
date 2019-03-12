@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Usuário [ @{{ form.data.id == undefined ? 'Novo' : form.originalData.name }} ]</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="hidden">
                        @{{ form.setData(<?= $data ?>) }}

                    </div>

                    <div class="box-body">

                        <form method="POST" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div class="form-group col-md-4">
                                    <label>Tipo: </label>

                                    <input type="radio" name="type" value="F" v-model="picked" required/>
                                    <label for="F">Física</label>

                                    <input type="radio" name="type" value="J" v-model="picked" required/>
                                    <label for="J">Jurídica</label>
                                </div>

                                <br><br>

                                <div id="physical" style="display: none">

                                    <div class="form-group col-md-4">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" v-model="form.data.name_social_name" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>CPF</label>
                                        <input type="text" class="form-control" v-model="form.data.cpf_cnpj" maxlength="14" v-mask="['###.###.###-##']"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>RG</label>
                                        <input type="text" class="form-control" v-model="form.data.rg" maxlength="20"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Data Nascimento</label>
                                        <input type="date" class="form-control" v-model="form.data.date_birth" />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>E-mail</label>
                                        <input type="email" class="form-control" v-model="form.data.email" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Telefone Fixo</label>
                                        <input type="text" class="form-control" v-model="form.data.fixed_telephone" maxlength="20" v-mask="['(##) ####-####', '(##) #####-####']"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Celular</label>
                                        <input type="text" class="form-control" v-model="form.data.cellphone" maxlength="50" v-mask="['(##) ####-####', '(##) #####-####']"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>CEP</label>
                                        <input type="text" class="form-control" v-on:blur="findCep()" v-model="form.data.zip" maxlength="100"  v-mask="['##.###-###']"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Rua</label>
                                        <input type="text" class="form-control" v-model="form.data.street" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Número</label>
                                        <input type="text" class="form-control" v-model="form.data.number" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Complemento</label>
                                        <input type="text" class="form-control" v-model="form.data.complement" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Bairro</label>
                                        <input type="text" class="form-control" v-model="form.data.district" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Estado</label>
                                        <select name="state" id="state" class="form-control" v-model="form.data.state">
                                            @foreach($uf as $state)
                                                <option value="{{$state}}">{{$state}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Cidade</label>
                                        <input type="text" class="form-control" v-model="form.data.city" maxlength="50"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Observação</label>
                                        <input type="text" class="form-control" v-model="form.data.obs" maxlength="255"/>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <hr>
                                        <label><input type="checkbox" class="form-check-input" v-model="form.data.active" value="S"> Ativo</label>
                                    </div>

                                </div>

                                <div id="entity" style="display: none">

                                    <div class="form-group col-md-4">
                                        <label>Social Name</label>
                                        <input type="text" class="form-control" v-model="form.data.name_social_name" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Fantasy Name</label>
                                        <input type="text" class="form-control" v-model="form.data.fantasy_name" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>CNPJ</label>
                                        <input type="text" class="form-control" v-model="form.data.cpf_cnpj" maxlength="18" v-mask="['##.###.###/####-##']"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Inscrição Estadual</label>
                                        <input type="text" class="form-control" v-model="form.data.ie" maxlength="20"/>
                                    </div>

                                   <div class="form-group col-md-4">
                                        <label>E-mail</label>
                                        <input type="email" class="form-control" v-model="form.data.email" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Telefone Fixo</label>
                                        <input type="text" class="form-control" v-model="form.data.fixed_telephone" maxlength="20" v-mask="['(##) ####-####', '(##) #####-####']"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Celular</label>
                                        <input type="text" class="form-control" v-model="form.data.cellphone" maxlength="50" v-mask="['(##) ####-####', '(##) #####-####']"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>CEP</label>
                                        <input type="text" class="form-control" v-on:blur="findCep()" v-model="form.data.zip" maxlength="100" v-mask="['##.###-###']"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Rua</label>
                                        <input type="text" class="form-control" v-model="form.data.street" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Número</label>
                                        <input type="text" class="form-control" v-model="form.data.number" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Complemento</label>
                                        <input type="text" class="form-control" v-model="form.data.complement" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Bairro</label>
                                        <input type="text" class="form-control" v-model="form.data.district" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Estado</label>
                                        <select name="state" id="state" class="form-control" v-model="form.data.state">
                                            @foreach($uf as $state)
                                                <option value="{{$state}}">{{$state}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Cidade</label>
                                        <input type="text" class="form-control" v-model="form.data.city" maxlength="50"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Observação</label>
                                        <input type="text" class="form-control" v-model="form.data.obs" maxlength="255"/>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <hr>
                                        <label><input type="checkbox" class="form-check-input" v-model="form.data.active" value="S"> Ativo</label>
                                    </div>

                                </div>

                                <div id="entity">


                                </div>



                                {{--<div class="form-group col-md-4">--}}
                                    {{--<label>Senha <small v-show="form.data.id != undefined">(deixe em branco para manter a mesma)</small></label>--}}
                                    {{--<input type="password" class="form-control" v-model="form.data.password" maxlength="20" :required="form.data.id == undefined"/>--}}
                                {{--</div>--}}




                                {{--<fieldset class="col-md-12"><legend>Permissões</legend>--}}

                                    {{--<div class="row">--}}
                                        {{--<div class="col-md-4" v-for="item in permissoes">--}}
                                            {{--<label><input type="checkbox" name="permissoes[]" value="item.id"--}}
                                                          {{--:checked="form.data.permissoes.indexOf(item.id) != -1"--}}
                                                          {{--@change="onSelectPermissao(item.id)"> @{{ item.nome }} </label>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</fieldset>--}}



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
<script src="person.js"></script>