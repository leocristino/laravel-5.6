import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'
import {mask} from 'vue-the-mask'
import Datepicker from 'vue2-datepicker';
import {Money} from 'v-money';
import moment from "moment";



if ($('body[view-name="account_receivableform"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal, BasicSelect, Datepicker
        },
        data: {
            form: new Form(),
            modal: Modal,
            bankSelected: "",
            bank: [],
            tipos_pessoa: [],
            objPayment_Type: {},

        },
        mounted() {
            this.form.data.due_date = moment(this.form.data.due_date, 'YYYY-MM-DD', true);
            this.form.data.payment_date = moment(this.form.data.payment_date, 'YYYY-MM-DD', true);
            this.form.data.chq_date_return = moment(this.form.data.chq_date_return, 'YYYY-MM-DD', true);

        },
        updated(){

        },
        watch: {

        },
        methods: {
            verifyPaymentType_OnChange(){

                for(var i = 0; i < this.objPayment_Type.length; i++)
                {
                    if(this.objPayment_Type[i].id == this.form.data.id_payment_type)
                    {
                        var valueType = this.objPayment_Type[i].type;
                    }
                }
                if (valueType == 'C')
                {
                    $("#chq").toggle('100');
                }
                else if (valueType == 'B')
                {
                    $("#chq").toggle('100');
                    $("#chq").hide();
                }
            },
            submit_form() {
                let url = '/account_receivable';

                if (isNaN(this.form.data.payment_date._i))
                {
                    this.$refs.modal.configModal('Campo obrigatório', 'Preencha o campo Data do Vencimento!', '', 'OK', function () {

                    });
                    this.$refs.modal.show(1500);
                    return;
                }

                if (this.form.data.value_bill == 0)
                {
                    this.$refs.modal.configModal('Campo obrigatório', 'Preencha o campo Valor a Pagar!', '', 'OK', function () {

                    });
                    this.$refs.modal.show(1500);
                    return;
                }





                // this.form.submit(url, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Conta corrente salva!', 'OK', '', function () {
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
        },
    });
}

if ($('body[view-name="account_receivableindex"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
            Modal, BasicSelect, Datepicker
        },
        data: {
            form: new Form(),
            modal: Modal,
            person: '',
            moment: '',
            namePerson: '',
        },
        mounted() {
            if(this.form.data.contact_time == null)
            {
                this.form.data.contact_time = new Date()
            }
            else
                this.form.data.contact_time = new Date(this.form.data.contact_time), 'yyyy-MM-dd'

            if (this.form.data.id_person != null){
                this.person = this.form.data.id_person
            }
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
                    let url = window.baseUrl+'/bank_account/activeDisabled';
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
            submit_form() {
                this.form.data.id_person = this.person
                let url = '/account_receivable';


                this.form.submit(url, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Histórico salvo!', 'OK', '', function () {
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
        },
    });
}
