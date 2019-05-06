import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'
import {mask} from 'vue-the-mask'
import Datepicker from 'vue2-datepicker';
import {Money} from 'v-money';
import moment from "moment";
import axios from 'axios';


if ($('body[view-name="payable_receivableform"]').length > 0) {
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
            objPayment_Type: {},

        },
        mounted() {
            this.form.data.due_date = moment(this.form.data.due_date, 'YYYY-MM-DD', true);
            this.form.data.payment_date = moment(this.form.data.payment_date, 'YYYY-MM-DD', true);
            this.form.data.chq_date_return = moment(this.form.data.chq_date_return, 'YYYY-MM-DD', true);
            this.verifyPaymentType_OnChange();

            var valuePaymentType = '';
            for(var i = 0; i < this.objPayment_Type.length; i++)
            {
                if (this.form.data.id_payment_type == this.objPayment_Type[i].id)
                {
                    valuePaymentType = this.objPayment_Type[i].type;
                    // console.log(valuePaymentType)
                }
            }
            $("#printBill").css('display','none');
            if (this.form.data.id != '')
            {
                if(valuePaymentType == 'B')
                {
                    $("#printBill").css('display','block');
                }
            }

            $("#printCheque").css('display','none');
            if (this.form.data.id != '')
            {
                if(valuePaymentType == 'C')
                {
                    $("#printCheque").css('display','block');
                }
            }

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
                $("#chq").hide();
                if (valueType == 'C')
                {
                    $("#chq").show('100');
                }
                else if (valueType == 'B')
                {
                    $("#chq").hide();
                }
            },
            submit_form() {
                let url = '/payable_receivable';

                this.form.submit(url, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Conta salva!', 'OK', '', function () {
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

if ($('body[view-name="payable_receivableindex"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
            Modal
        },
        data: {
            form: new Form(),
            modal: Modal,
        },
        mounted() {

        },
        updated(){

        },
        watch: {

        },
        methods: {
            deleteAccountReceivable(id)
            {
                let originalData = Object.assign({} , this);
                let url = window.baseUrl+'/payable_receivable/delete';

                this.$refs.modal.configModal('Aviso', 'Tem certeza que deseja excluir?', 'Confirmar', 'Cancelar', function () {
                    axios.post(url, {
                        id: id
                    })
                        .then(function (response) {

                            if (response.data.result == true) {

                                originalData.$refs.modal.configModal('Sucesso', 'Conta excluída!', 'OK', '', function () {
                                    $('#modal').modal('hide');
                                    location.reload();
                                });
                                originalData.$refs.modal.show(2500);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);

                        });
                });
                this.$refs.modal.show();


            },
        },
        onSuccessDeletado(response){
            try {
                if (response.data.result == true){
                    this.$refs.modal.configModal('Sucesso', 'excluido', 'OK', '', function () {
                        $('#modal').modal('hide');
                    });
                    this.$refs.modal.show(2500);
                } else {
                    this.$refs.modal.configModal('Aviso', 'erro', '', 'OK');
                    this.$refs.modal.show(2500);
                }
            } catch (e) {
                console.log(e);
            }
        },
    });
}
