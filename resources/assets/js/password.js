import Form from './core/Form';
import Modal from './components/Modal.vue';

if ($('body[view-name="passwordform"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal,
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

            submit_form() {
                let url = '/changePassword';

                if(this.form.data.new_password == this.form.data.confirm_password){
                    this.form.submit(url, this.onSuccess);
                    $
                }else{
                    this.$refs.modal.configModal('Aviso', 'Nova senha e senha confirmada não são as mesmas.', '', 'OK');
                    this.$refs.modal.show();
                }
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Registro salvo!', 'OK', '', function () {
                            window.location.reload();
                        });
                        this.$refs.modal.show(1500);
                    } else {

                        this.$refs.modal.configModal('Aviso', response.data.msg, 'OK', '', function () {
                            window.location.reload();
                        });
                        this.$refs.modal.show(1500);
                    }
                } catch (e) {
                    console.log(e);
                }
            },

        },
    });
}