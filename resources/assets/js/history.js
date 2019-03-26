import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'
import {mask} from 'vue-the-mask'
import Datepicker from 'vue2-datepicker';
import moment from "moment";



if ($('body[view-name="historyform"]').length > 0) {
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
            // console.log(this.form.data.contact_time.toLocaleDateString('en'));
            // console.log(this.form.data.created_at);

            // this.form.data.contact_time = new Date(this.form.data.contact_time);
            // console.log(this.form.data.contact_time.toLocaleDateString('pt-br'));

            // if(this.form.data.contact_time == null)
            // {
            //     this.form.data.contact_time = new Date()
            // }
            // else {
               // this.form.data.contact_time = moment(this.form.data.contact_time.substr(0, 10), 'yyyy/MM/dd', true);
            // }

            if (this.form.data.id_person != null){
                this.person = this.form.data.id_person
            }
        },
        updated(){

        },
        watch: {

        },
        methods: {
            nomePessoa(pessoa)
            {
                for(var i =0; i < pessoa.length; i ++){
                    if(this.form.data.id_person == pessoa[i].id)
                    {
                        this.namePerson = pessoa[i].name_social_name
                    }
                }
            },
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
