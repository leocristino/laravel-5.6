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
            id_contract: '',
            valores: '',
            formAdd: {
                model: '',
                license_plate: '',
                color: '',
                chassis: '',
                driver_license: '',

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
                let url = '/car';
                this.form.post(url, {id: this.id_contract, valores: this.form.data}, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Veículo salvo!', 'OK', '', function () {
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

                if(this.formAdd.model.value == '' ||
                    this.formAdd.license_plate.value == '' ||
                    this.formAdd.color.value == '' ||
                    this.formAdd.chassis.value == '' ||
                    this.formAdd.driver_license.value == '') {
                    this.$refs.modal.configModal('Aviso', 'Complete todos os campos', '', 'OK');
                    this.$refs.modal.show();
                    return;
                }

                this.form.data.push({
                    model: this.formAdd.model,
                    license_plate: this.formAdd.license_plate,
                    color: this.formAdd.color,
                    chassis: this.formAdd.chassis,
                    driver_license: this.formAdd.driver_license,

                });
            },

            delValor(data){
                console.log(data);
                data.active = false;
                this.$forceUpdate();
            }
        },
    });
}
