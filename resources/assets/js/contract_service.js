import Form from './core/Form';
import Modal from './components/Modal.vue';
import {Money} from 'v-money';

if ($('body[view-name="contract_serviceindex"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal,
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


        },
        updated(){

        },
        watch: {

        },
        methods: {
            findValue() {
                let thisCopy = Object.assign({}, this);
                // console.log(this.service);
                this.form.get('/service/contract_service/', {service: this.service}, function (response) {
                    // console.log(response);
                    thisCopy.formAdd.value = response.data.price;
                    thisCopy.formAdd.name = response.data.name;
                    thisCopy.formAdd.id_service = response.data.id;

                });
            },

            submit_form() {
                // this.formAdd.id_service = this.formAdd.service;
                let url = '/contract/contract_service';
                // console.log(this.form.data);
                this.form.post(url, {id: this.id_contract, valores: this.form.data}, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Serviço salvo!', 'OK', '', function () {
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
                if(this.service == '' ||
                    this.formAdd.value.value == '' ||
                    this.formAdd.addition_discount.value == '') {
                    this.$refs.modal.configModal('Aviso', 'Complete todos os campos', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }
                // console.log(this.service);
                this.form.data.push({
                    service: this.formAdd.name,
                    value: this.formAdd.value,
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
