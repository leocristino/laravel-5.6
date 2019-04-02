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
            id_contract: 0,
            service: '',
            form: new Form(),
            modal: Modal,
            // id_contract: '',
            valores: '',
            formAdd: {
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

                this.form.get('/service/', {service: this.service}, function (response) {
                    // thisCopy.form.data.street = response.data[0].logradouro;
                    // thisCopy.form.data.id_city = response.data[0].cidade_codigo;
                    // thisCopy.form.data.city = response.data[0].cidade;
                    // thisCopy.form.data.district = response.data[0].bairro;
                    // if (thisCopy.form.data.state != response.data[0].uf) {
                    //     thisCopy.form.data.state = response.data[0].uf;
                    //     thisCopy.changeUf();
                    // }
                    // console.log(thisCopy.form.data.district)
                    // if (thisCopy.form.data.district == null || thisCopy.form.data.district == '') {
                    //     thisCopy.$refs.district.focus();
                    // }
                    // else {
                    //     thisCopy.$refs.street_number.focus();
                    // }
                });
            },

            submit_form() {
                this.formAdd.id_service = this.formAdd.service;
                let url = '/contract/contract_service';
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

                this.form.data.push({
                    id_service: this.service,
                    value: this.formAdd.value,
                    addition_discount: this.formAdd.addition_discount,

                });
                this.service = '';
                this.formAdd.value = '';
                this.formAdd.addition_discount = '';
            },

            delValor(data){
                // console.log(data);
                data.active = false;
                this.$forceUpdate();
            }
        },
    });
}
