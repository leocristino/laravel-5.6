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
            namePerson: '',
            date: ''
        },
        created(){

        },
        mounted() {
            console.log(this.form.data.start_date);
            this.form.data.start_date = new Date(this.form.data.start_date);
            // if(this.form.data.start_date == null)
            // {
            //     this.form.data.start_date = new Date()
            // }
            // else {
            //     this.form.data.start_date = moment(this.form.data.start_date.substr(0, 10), 'DD/MM/YYYY', true);
            // }
            // if(this.form.data.start_date != null) {
            //     console.log( this.form.data.start_date);
            //    this.form.data.start_date =  moment(this.form.data.start_date.substr(0, 10), 'DD/MM/YYYY', true);
            // }

            if (this.form.data.id_person != null){
                this.person = this.form.data.id_person
            }

            if (this.form.data.id_payment_type != null){
                this.payment_type = this.form.data.id_payment_type
                // console.log(this.form.data.id_payment_type)
            }
        },
        updated(){

        },
        watch: {
        },
        methods: {
            // nomePessoa(pessoa)
            // {
            //     for(var i = 0; i < pessoa.length; i ++){
            //         if(this.form.data.id_person == pessoa[i].id)
            //         {
            //             this.namePerson = pessoa[i].name_social_name
            //         }
            //     }
            // },
            // objPayment_type(payment_type)
            // {
            //     for(var i = 0; i < payment_type.length; i ++){
            //         if(this.form.data.id_payment_type == payment_type[i].id)
            //         {
            //             this.payment_type = payment_type[i].name
            //             // console.log(this.payment_type)
            //         }
            //     }
            // },
            submit_form() {
                this.form.data.id_person = this.person
                this.form.data.id_payment_type = this.payment_type
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

if ($('body[view-name="historyindex"]').length > 0) {
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

            submit_form() {
                this.form.data.id_person = this.person
                let url = '/history';


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
