import Form from './core/Form';
import Modal from './components/Modal.vue';
import {Money} from 'v-money';
import Datepicker from 'vue2-datepicker';
import moment from "moment";

if ($('body[view-name="billingindex"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal, Datepicker
        },
        data: {
            service: '',
            id_contract: 0,
            form: new Form(),
            modal: Modal,
            // id_contract: '',
            valores: '',
            ifNameService: false,
            formAdd: {
                id_service: '',
                name: '',
                value: '',
                addition_discount: '',
            },
        },
        mounted() {
            // this.form.data.start_date = moment(this.form.data.start_date, 'YYYY-MM-DD', true);
            // this.form.data.end_date = moment(this.form.data.end_date, 'YYYY-MM-DD', true);
        },
        updated(){

        },
        watch: {

        },
        methods: {
            submit_form() {

                let url = '/billing';
                var start_date = this.form.data.start_date;
                var end_date = this.form.data.end_date;

                if(start_date ==  undefined)
                {
                    this.$refs.modal.configModal('Aviso', 'O Campo Data Inicial é obrigatório!', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }

                if(end_date ==  undefined)
                {
                    this.$refs.modal.configModal('Aviso', 'O Campo Data Final é obrigatório!', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }

                if(start_date.getTime() >= end_date.getTime())
                {
                    this.$refs.modal.configModal('Aviso', 'A Data Inicial não pode ser maior que a Data Final', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }

                if(this.form.data.id_ticket == undefined)
                {
                    this.$refs.modal.configModal('Aviso', 'O Campo Plano de Contas é obrigatório!', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }

                if(this.form.data.referenceDate == undefined)
                {
                    this.$refs.modal.configModal('Aviso', 'O Campo Mês / Ano Referência é obrigatório!', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }

                this.form.submit(url, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', response.data.qtd + ' contrato(s) foi(ram) faturado(s)!', 'OK', '', function () {
                            // util.goBack('/payable_receivable/?lote=' + response.data.lot);
                            window.location.href = '/payable_receivable/?lot=' + response.data.lot;
                        });

                        this.$refs.modal.show(1500);
                    } else {
                        this.$refs.modal.configModal('Erro', response.data.msg, '', 'OK');
                        this.$refs.modal.show();
                    }
                } catch (e) {
                    console.log(e);
                }
            },
            addValor(){
                if(this.service == '' ||
                    this.formAdd.value.value == '' ||
                    this.formAdd.addition_discount.value == '') {
                    this.$refs.modal.configModal('Aviso', 'Complete todos os campos', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }
                this.form.data.push({
                    service: this.formAdd.name,
                    value: Number.parseFloat(this.formAdd.value).toFixed(2),
                    addition_discount: this.formAdd.addition_discount,
                    id_service: this.formAdd.id_service,


                });
                this.service = '';
                this.formAdd.value = '';
                this.formAdd.addition_discount = '';
            },

            delValor(data){
                data.active = false;
                this.$forceUpdate();
            }
        },
    });
}
