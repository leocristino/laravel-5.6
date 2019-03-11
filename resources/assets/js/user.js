import Form from './core/Form';
import Modal from './components/Modal.vue';
import Multiselect from 'vue-multiselect'

if ($('body[view-name="userform"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal, Multiselect
        },
        data: {
            form: new Form(),
            modal: Modal,


            permissoes: null,
        },
        mounted() {

        },
        updated(){
        },
        watch: {
        },
        methods: {
            setPermissoes(permissoes){
                if(this.permissoes == null){
                    this.permissoes = permissoes;
                }
            },
            onSelectPermissao(item){
                if(this.form.data.permissoes.indexOf(item) == -1) {
                    this.form.data.permissoes.push(item);
                }else{
                    this.form.data.permissoes.splice(this.form.data.permissoes.indexOf(item), 1);
                }
            },

            submit_form() {
                let url = '/user';
                this.form.submit(url, this.onSuccess);
                $
            },

            onSuccess(response) {
                try {
                    if (response.data.result == "true") {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', 'Registro salvo!', 'OK', '', function () {
                            util.goBack();
                        });
                        this.$refs.modal.show(1500);
                    } else {
                        this.form.reset();
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