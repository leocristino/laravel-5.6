import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'
import {mask} from 'vue-the-mask'

if ($('body[view-name="personform"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal,BasicSelect
        },
        data: {
            form: new Form(),
            modal: Modal,
            cidadeSelected: {},
            cidades: [],
            picked: '',

            cb_geral_tipo_pessoa: undefined,
            tipos_pessoa: [],

            instituicao: {},
            instituicaoSelected: {},
            instituicoes:[],
            cidadeInstituicaoSelected: {},
            cidadesInstituicao: [],

        },
        mounted() {
            this.changeUf();
            if(this.form.data.type != null){
                this.picked = this.form.data.type;

            }
        },
        updated(){

        },
        watch: {
            'picked' : function () {
                $("#formFields").hide()
                if(this.picked == "J")
                {
                    $("#formFields").toggle('100')
                }
                else if (this.picked == "F")
                {
                    $("#formFields").toggle('100')
                }
                this.$refs.name_social_name.focus()

            },

        },
        methods: {
            findCep(){
                let thisCopy = Object.assign({} , this);

                this.form.get('/cep/cep', {cep: this.form.data.zip}, function(response){
                    thisCopy.form.data.street = response.data[0].logradouro;
                    thisCopy.form.data.id_city= response.data[0].cidade_codigo;
                    thisCopy.form.data.city= response.data[0].cidade;
                    thisCopy.form.data.district = response.data[0].bairro;
                    if(thisCopy.form.data.state != response.data[0].uf) {
                        thisCopy.form.data.state = response.data[0].uf;
                        thisCopy.changeUf();
                    }
                    console.log(thisCopy.form.data.district)
                    if(thisCopy.form.data.district == null || thisCopy.form.data.district == ''){
                        thisCopy.$refs.district.focus();
                    }
                    else
                    {
                        thisCopy.$refs.street_number.focus();
                    }
                });
            },

            changeUf(){
                let thisCopy = Object.assign({} , this);
                let uf = this.form.data.state == undefined ? 'SP' : this.form.data.state;

                this.form.get('/cep/cidades', {uf: uf}, function(response){
                    thisCopy.setCidades(response.data);
                });
            },
            setCidades(cidades){
                this.cidades = cidades;
                this.cidadeSelected = util.findInArrayObject('value', this.form.data.id_city, cidades);
            },

            onSelectCidade(item){
                this.cidadeSelected = item;
                this.form.data.id_city = item.value;
                this.form.data.city = item.text;
            },

            submit_form() {
                let url = '/person';
                this.form.data.type = this.picked

                this.form.submit(url, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Pessoa cadastrada!', 'OK', '', function () {
                            util.goBack();
                        });
                        this.$refs.modal.show(1500);
                    } else {
                        // this.form.reset();
                        this.$refs.modal.configModal('Erro', response.data.msg, '', 'OK');
                        this.$refs.modal.show();
                    }
                } catch (e) {
                    console.log(e);
                }
            },
            activeDisabled(id, type){
                if(type == 1){
                    var msn = "Deseja desativar este registro?";
                    var btn = "Desativar";
                }else{
                    var msn = "Deseja ativar este registro?";
                    var btn = "Ativar";
                }

                let originalData = Object.assign({} , this);

                this.$refs.modal.configModal('Aviso', msn, btn, 'Cancelar', function () {
                    let url = window.baseUrl+'/post/activeDisabled';
                    originalData.form.post(url, {id: id, type: type}, originalData.onSuccessActiveDisabled);
                });
                this.$refs.modal.show();
            },

        },
    });
}

if ($('body[view-name="personindex"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
            Modal,BasicSelect
        },
        data: {
            form: new Form(),
            modal: Modal,
            cidadeSelected: {},
            cidades: [],
            picked: '',

            cb_geral_tipo_pessoa: undefined,
            tipos_pessoa: [],

            instituicao: {},
            instituicaoSelected: {},
            instituicoes:[],
            cidadeInstituicaoSelected: {},
            cidadesInstituicao: [],

        },
        mounted() {

        },
        updated(){

        },
        watch: {


        },
        methods: {
            activeDisabled(id,type)
            {
                if(type == 1){
                    var msn = "Deseja desativar este registro?";
                    var btn = "Desativar";
                }else{
                    var msn = "Deseja ativar este registro?";
                    var btn = "Ativar";
                }

                let originalData = Object.assign({} , this);


                this.$refs.modal.configModal('Aviso', msn, btn, 'Cancelar', function () {
                    let url = window.baseUrl+'/person/activeDisabled';
                    originalData.form.post(url, {id: id, type: type}, originalData.onSuccessActiveDisabled);
                });
                this.$refs.modal.show();
            },

            onSuccessActiveDisabled(response)
            {
                try {
                    if (response.data.result == true){
                        this.$refs.modal.configModal('Sucesso', response.data.msg, 'OK', '', function () {
                            $('#modal').modal('hide');

                            if(response.data.type == 1){
                                $('#check'+response.data.id).removeClass('font-active-none');
                                $('#times'+response.data.id).addClass('font-active-none');

                                $('#btnCheck'+response.data.id).removeClass('font-active-none');
                                $('#btnTimes'+response.data.id).addClass('font-active-none');

                                $('#table'+response.data.id).removeClass('danger');
                            }else{
                                $('#check'+response.data.id).addClass('font-active-none');
                                $('#times'+response.data.id).removeClass('font-active-none');

                                $('#btnTimes'+response.data.id).prop( "disabled", false );

                                $('#btnCheck'+response.data.id).addClass('font-active-none');
                                $('#btnTimes'+response.data.id).removeClass('font-active-none');

                                $('#table'+response.data.id).addClass('danger');
                            }

                        });
                        this.$refs.modal.show();
                    } else {
                        this.$refs.modal.configModal('Aviso', response.data.msg, '', 'OK');
                        this.$refs.modal.show();
                    }
                } catch (e) {
                    console.log(e);
                }
            },
        },
    });
}