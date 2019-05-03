import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'
import {mask} from 'vue-the-mask'
import Datepicker from 'vue2-datepicker';
import {Money} from 'v-money';
import moment from "moment";
import axios from 'axios';


if ($('body[view-name="invoices_nfsindex"]').length > 0) {
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

        },
        updated(){

        },
        watch: {

        },
        methods: {

            sendLotToEmail(lot,id_bank_account)
            {
                $(".loading").css("display", "block");
                this.loading = true;
                let url = '/invoices_nfs/bill';

                axios({
                    method: "POST",
                    url: url,
                    data: {lot,id_bank_account}
                }).then(
                    result => {
                        this.loading = false;
                            this.onSuccess(result.data.result);
                    },
                    error => {
                        console.error(error);
                    }
                );

            },
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
            // submit_form() {
            //     let url = '/payable_receivable';
            //
            //     this.form.submit(url, this.onSuccess);
            // },

            onSuccess(response) {
                try {
                    $(".loading").css('display','none');

                    if (response == "true") {

                        this.$refs.modal.configModal('Sucesso', 'Email enviado com sucesso!','', 'OK');
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
