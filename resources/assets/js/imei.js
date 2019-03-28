import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'
import {mask} from 'vue-the-mask'
import Datepicker from 'vue2-datepicker';



if ($('body[view-name="imeiindex"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal,
        },
        data: {
            id_contract: 0,
            form: new Form(),
            modal: Modal,
            valores: '',
            formAdd: {
                number: '',
                description: '',
            },
        },
        mounted() {

        },
        updated(){

        },
        watch: {

        },
        methods: {
            submit_form() {
                // alert(this.id_contract);
                let url = '/imei';
                this.form.post(url, {id: this.id_contract, valores: this.form.data}, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'IMEI salvo!', 'OK', '', function () {
                            util.goBack();
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
                if(this.formAdd.number.value == '' ||
                    this.formAdd.description.value == '') {
                    this.$refs.modal.configModal('Aviso', 'Complete todos os campos', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }

                this.form.data.push({
                    number: this.formAdd.number,
                    description: this.formAdd.description,

                });
                this.formAdd.number = '';
                this.formAdd.description = '';
            },

            delValor(data){
                console.log(data);
                data.active = false;
                this.$forceUpdate();
            }
        },
    });
}
