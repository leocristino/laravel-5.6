import Form from './core/Form';
import Modal from './components/Modal.vue';

if ($('body[view-name="carindex"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal,
        },
        data: {
            form: new Form(),
            modal: Modal,
            id_contract: '',
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

                this.form.submit(url, this.onSuccess);
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
        },
    });
}
