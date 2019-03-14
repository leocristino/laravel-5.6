import Form from './core/Form';
import Modal from './components/Modal.vue';

if ($('body[view-name="login"]').length > 0) {

    window.vue = new Vue({
        el: '#app',

        components: {
            Modal
        },
        data: {
            form: new Form(),
            modal: Modal
        },
        mounted() {
            this.$refs.email.focus();
        },
        methods: {
            submit_form() {
                let url = '/login';
                this.form.submit(url, this.onSuccess);
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        if(response.data.redirect == ""){
                            window.location.href = window.baseUrl;
                        }else{
                            window.location.href = window.baseUrl+response.data.redirect;
                        }
                    } else {
                        this.form.reset();
                        this.$refs.modal.configModal('Aviso', response.data.msg, '', 'OK');
                        this.$refs.modal.show();
                    }
                } catch (e) {
                    console.log(e);
                }
            },
        },
    });
}