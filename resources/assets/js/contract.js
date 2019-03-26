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

            if (this.form.data.id_person != null){
                this.person = this.form.data.id_person
            }

            if (this.form.data.id_payment_type != null){
                this.payment_type = this.form.data.id_payment_type
            }
        },
        updated(){

        },
        watch: {
        },
        methods: {
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


        },
    });
}
