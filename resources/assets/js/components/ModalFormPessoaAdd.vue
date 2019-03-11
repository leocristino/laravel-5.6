<template>
    <div id="modal_form_pessoa_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModalAddPessoa" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" @submit.prevent="submit_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Cadastro de Pessoa</h4>
                    </div>
                    <div class="modal-body">
                        <div class="clearfix">
                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">

                                <div class="form-group col-md-6" v-show="tipo_pessoa == 'C'">
                                    <label>Tipo de pessoa</label><br>
                                    <label><input type="radio" v-model="form.data.tipo" v-on:click="$forceUpdate();" value="F" > Pessoa Fisíca</label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" v-model="form.data.tipo" v-on:click="$forceUpdate();"  value="J" > Pessoa Jurídica</label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>{{ form.data.tipo == 'F' ? 'CPF' : 'CNPJ' }}</label>
                                    <input type="text" class="form-control" v-model="form.data.cpf_cnpj"
                                           v-mask="'###.###.###-##'"
                                           :required="tipo_pessoa == 'C'"/>
                                </div>
                                <div class="clearfix" v-show="tipo_pessoa == 'C'"></div>

                                <div class="form-group col-md-6" v-show="form.data.tipo == 'F' && tipo_pessoa == 'P'">
                                    <label>{{ form.data.tipo == 'F' ? 'R.G.' : 'Insc. Estadual' }}</label>
                                    <input type="text" class="form-control" v-model="form.data.rg_ie" maxlength="20"/>
                                </div>

                                <div class="clearfix">
                                    <div class="form-group col-md-12">
                                        <label>{{ form.data.tipo == 'F' ? 'Nome Completo' : 'Razão Social' }}</label>
                                        <input type="text" class="form-control" v-model="form.data.nome" maxlength="50" required autofocus/>
                                    </div>
                                    <div class="form-group col-md-6" v-show="form.data.tipo == 'F' && tipo_pessoa == 'P'">
                                        <label>Data de Nasc.</label>
                                        <input type="text" class="form-control" v-model="form.data.data_nasc"
                                               :required="form.data.tipo == 'F' && tipo_pessoa == 'P'"
                                               maxlength="20" v-mask="'##/##/####'"/>
                                    </div>

                                    <div class="form-group col-md-12" v-show="tipo_pessoa == 'C'">
                                        <label>Telefone /  Celular</label>
                                        <input type="text" class="form-control" :required="tipo_pessoa == 'C'" v-model="form.data.telefone1" maxlength="20" v-mask="masktelefone1"/>
                                    </div>

                                    <div class="form-group col-md-6" v-show="form.data.tipo == 'F' && tipo_pessoa == 'P'">
                                        <label>Sexo</label><br>
                                        <label><input type="radio" v-model="form.data.sexo" value="M"
                                                      :required="tipo_pessoa == 'P'"> Masculino</label>&nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" v-model="form.data.sexo" value="F"
                                                      :required="tipo_pessoa == 'P'"> Feminino</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 alert alert-warning" v-if="error_msg != ''">
                        {{ error_msg }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" v-on:click="hide" >Cancelar</button>
                        <button type="button" class="btn btn-primary" v-on:click="save">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from '../core/Form';
    export default {
        data: function () {
            return {

                fn_confirm: function () {},
                tipo_pessoa: 'P',

                form: new Form(),
                masktelefone1: "(##) #####-####",
                error_msg: ''
            }
        },
        watch: {
            'form.data.telefone1': function (val) {
                if(val != "") {
                    if (val != null && val.length > 1) {
                        if (val.length == 15) {
                            this.masktelefone1 = "(##) #####-####";
                        } else {
                            this.masktelefone1 = "(##) ####-####";
                        }
                    }
                }
            },
        },
        mounted() {
            this.form = new Form();
            this.form.data.ativo = true;
            this.form.data.tipo = 'F';
            this.$forceUpdate();
        },
        methods:{
            configModal(tipo_pessoa, txt, fn_confirm){
                this.form = new Form();
                this.form.data.ativo = true;
                this.form.data.tipo = 'F';

                if(isNaN(txt.replace('.', '').replace('-', ''))) {
                    this.form.data.nome = txt;
                }else{
                    this.form.data.cpf_cnpj = txt;
                }

                this.tipo_pessoa = tipo_pessoa;
                if(fn_confirm){
                    this.fn_confirm = fn_confirm;
                };
                this.$forceUpdate();
            },
            setConfirmFn(fn){
                this.fn_confirm = fn;
            },

            save(){
                try {
                    let url = '/pessoa';
                    if(this.tipo_pessoa == 'P') {
                        this.form.data.pessoa_tipo_pessoa = [4];
                    }else{
                        this.form.data.pessoa_tipo_pessoa = [3];
                    }
                    this.form.submit(url, this.onSuccess);
                }catch (e){
                    console.log(e);
                }
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        try {
                            this.fn_confirm(response.data.pessoa);
                            this.hide();
                        }catch (e){
                            console.log(e);
                        }
                    } else {
                        this.error_msg = response.data.msg;
                    }
                } catch (e) {
                    console.log(e);
                }
            },
            show () {
                $('#modal_form_pessoa_add').modal('show');
            },
            hide () {
                $('#modal_form_pessoa_add').modal('hide');
            },
        }
    }
</script>


