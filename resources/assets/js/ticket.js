import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'
import {mask} from 'vue-the-mask'

if ($('body[view-name="ticketform"]').length > 0) {
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

            submit_form() {
                let url = '/ticket';

                this.form.submit(url, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Conta cadastrada!', 'OK', '', function () {
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

if ($('body[view-name="ticketindex"]').length > 0) {
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
                    let url = window.baseUrl+'/ticket/activeDisabled';
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

                                $('#imgStatus'+response.data.id).removeClass('fas fa-times');
                                $('#imgStatus'+response.data.id).addClass('fas fa-check');

                                $('#table'+response.data.id).removeClass('danger');
                            }else{
                                $('#check'+response.data.id).addClass('font-active-none');
                                $('#times'+response.data.id).removeClass('font-active-none');

                                $('#btnTimes'+response.data.id).prop( "disabled", false );

                                $('#imgStatus'+response.data.id).removeClass('fas fa-check');
                                $('#imgStatus'+response.data.id).addClass('fas fa-times');


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