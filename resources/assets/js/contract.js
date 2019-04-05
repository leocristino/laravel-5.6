import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'
import {mask} from 'vue-the-mask'
import Datepicker from 'vue2-datepicker';
import moment from "moment";


if ($('body[view-name="contractform"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal, BasicSelect, Datepicker
        },
        data: {
            form: new Form(),
            modal: Modal,
            person: '',
            payment_type: '',
            service: '',
            namePerson: '',
            date: '',
            objPaymentType: {},
            current_account: '',
            optionPaymentType: [],
            boolPaymentType: false,
            ifBill: false
        },
        created(){
        },
        mounted() {

            this.form.data.end_date = moment(this.form.data.end_date, 'YYYY-MM-DD', true);

            if(this.form.data.start_date == null)
            {
                this.form.data.start_date = new Date()
            }
            else {
                this.form.data.start_date = moment(this.form.data.start_date, 'YYYY-MM-DD', true);
            }

            // alert(this.form.data.start_date);

            if (this.form.data.id_person != null){
                this.person = this.form.data.id_person
            }

            if (this.form.data.id_payment_type != null){
                this.payment_type = this.form.data.id_payment_type
            }

            if (this.form.data.id_service != null){
                this.service = this.form.data.id_service
            }
            if(this.form.data.id_bank_account != null){
                this.current_account = this.form.data.id_bank_account
                this.valuePaymentType();
            }
        },
        updated(){

        },
        watch: {

        },
        methods: {
            valuePaymentType()
            {
                for(var i = 0; i < this.optionPaymentType.length; i++)
                {
                    if(this.optionPaymentType[i].id == this.payment_type)
                    {
                        var value = this.optionPaymentType[i].type;
                    }
                }
                if(value == 'B')
                {
                    this.ifBill = true;
                }
                else
                {
                    this.current_account = '';
                    this.ifBill = false;
                }
            },
            functionPaymentType(res)
            {
                if(this.boolPaymentType == true)
                {
                    return;
                }
                this.boolPaymentType = true;
                this.optionPaymentType = res;



            },
            submit_form() {
                this.form.data.id_person = this.person;
                this.form.data.id_payment_type = this.payment_type;
                this.form.data.id_service = this.service;
                this.form.data.id_bank_account = this.current_account;
                let url = '/contract';


                this.form.submit(url, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Contrato salvo!', 'OK', '', function () {
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

if ($('body[view-name="contractindex"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
            Modal, BasicSelect, Datepicker
        },
        data: {
            form: new Form(),
            modal: Modal,
            person: '',
            namePerson: '',
        },
        mounted() {
        },
        updated(){

        },
        watch: {

        },
        methods: {

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
                    let url = window.baseUrl+'/contract/activeDisabled';
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
