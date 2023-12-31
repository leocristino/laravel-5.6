@extends('base_layouts.master')

@section('content')
    <section class="content-header" xmlns="http://www.w3.org/1999/html">
        <h1>Pessoa [ @{{ form.data.id == undefined ? 'Novo' : form.originalData.name_social_name }} ]</h1>
    </section>
    <section class="content" :json="form.setData({{ $data }})">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">

                        <form method="POST" id="person" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div class="form-group col-md-12">
                                    <label>Tipo: </label>

                                    <input type="radio" id="typeF" name="type" value="F" v-model="picked" required :disabled="form.data.id != undefined"/>
                                    <label for="typeF">Física</label>

                                    <input type="radio" id="typeJ" name="type"  value="J" v-model="picked" required :disabled="form.data.id != undefined"/>
                                    <label for="typeJ">Jurídica</label>
                                </div>

                                <br><br>

                                <div id="formFields" style="display:none;">
                                    <div>
                                        <div class="form-group" :class="picked=='F' ? 'col-md-12' : 'col-md-6'">
                                            <label v-if="picked == 'F'">Nome</label>
                                            <label v-else-if="picked == 'J'">Razão Social</label>
                                            <input type="text" class="form-control" v-model="form.data.name_social_name" required ref="name_social_name" maxlength="100"/>
                                        </div>

                                        <div class="form-group col-md-6" v-if="picked == 'J'">
                                            <label >Nome Fantasia</label>
                                            <input type="text" class="form-control" v-model="form.data.fantasy_name" required maxlength="100"/>
                                        </div>

                                    </div>


                                    <div class="form-group" :class="picked == 'J' ? 'col-md-6' : 'col-md-4'">
                                        <label v-if="picked == 'F'">CPF</label>
                                        <input v-if="picked == 'F'" type="tel"  class="form-control" v-model="form.data.cpf_cnpj " placeholder="999.999.999-99" required v-mask="['###.###.###-##']"/>
                                        <label v-if="picked == 'J'">CNPJ</label>
                                        <input v-if="picked == 'J'" type="tel"  class="form-control" v-model="form.data.cpf_cnpj " placeholder="99.999.999/9999-99" required v-mask="['##.###.###/####-##']"/>
                                    </div>

                                    <div  v-if="picked == 'F'" class="form-group col-md-4">
                                        <label>RG</label>
                                        <input type="tel" class="form-control" v-model="form.data.rg" maxlength="20"/>
                                    </div>

                                    <div v-if="picked == 'J'" class="form-group col-md-6">
                                        <label>Inscrição Estadual</label>
                                        <input type="tel" class="form-control" v-model="form.data.ie" maxlength="20"/>
                                    </div>

                                    <div  v-if="picked == 'F'" class="form-group col-md-4 type-date">
                                        <label>Data Nascimento</label>
                                        {{--<input type="date" class="form-control" v-model="form.data.date_birth" />--}}
                                        <datepicker lang="pt-br" format="dd/MM/yyyy" readonly="true" :editable="true" width="100%" input-class="form-control"
                                                    input-name="data_saida" v-model="form.data.date_birth" />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>E-mail</label>
                                        <input type="email" class="form-control" v-model="form.data.email" required maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Telefone Fixo</label>
                                        <input type="tel" class="form-control" v-model="form.data.fixed_telephone" placeholder="(99)9999-9999" maxlength="20" v-mask="['(##) ####-####', '(##) #####-####']"/>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Celular</label>
                                        <input type="tel" class="form-control" v-model="form.data.cellphone" maxlength="50" placeholder="(99)99999-9999" v-mask="['(##) ####-####', '(##) #####-####']"/>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>CEP</label>
                                        <input type="tel" class="form-control" v-on:blur="findCep()" v-model="form.data.zip" placeholder="99.999-999" maxlength="100"  v-mask="['##.###-###']"/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Logradouro</label>
                                        <input type="text" class="form-control" v-model="form.data.street" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Número</label>
                                        <input type="tel" class="form-control" v-model="form.data.street_number" ref="street_number" maxlength="30"/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Complemento</label>
                                        <input type="text" class="form-control" v-model="form.data.complement" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Bairro</label>
                                        <input type="text" class="form-control" v-model="form.data.district" maxlength="100"/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Estado</label>
                                        <select name="state" id="state" class="form-control" v-model="form.data.state" @change="changeUf">
                                            @foreach($uf as $state)
                                                <option value="{{$state}}">{{$state}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Cidade</label>
                                        <basic-select :options="cidades"
                                                      :selected-option="cidadeSelected"
                                                      placeholder="Selecione uma cidade"
                                                      @select="onSelectCidade"
                                                      :required="tipos_pessoa.indexOf('C') !== -1">
                                        </basic-select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Observação</label>
                                        <textarea type="text" class="form-control" v-model="form.data.obs" /></textarea>


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
