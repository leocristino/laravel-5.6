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
            this.$refs.name.focus()

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
                this.form.data.permissoes = JSON.parse(JSON.stringify(this.form.data.permissoes));
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

                        this.$refs.modal.configModal('Sucesso', 'Usuário cadastrado!', 'OK', '', function () {
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

if ($('body[view-name="userindex"]').length > 0) {
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

                        this.$refs.modal.configModal('Sucesso', 'Usuário cadastrado!', 'OK', '', function () {
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
            activeDisabled(id,type)
            {
                if(type == 1){
                    var msn = "Deseja desativar este registro?";
                    var btn = "Desativar";
                }else{
                    var msn = "Deseja ativar este registro?";
                    var btn = "Ativar";
                }

                let originalData = Object.assign({} , this);


                this.$refs.modal.configModal('Aviso', msn, btn, 'Cancelar', function () {
                    let url = window.baseUrl+'/user/activeDisabled';
                    originalData.form.post(url, {id: id, type: type}, originalData.onSuccessActiveDisabled);
                });
                this.$refs.modal.show();
            },

            onSuccessActiveDisabled(response)
            {
                try {
                    if (response.data.result == true){
                        this.$refs.modal.configModal('Sucesso', response.data.msg, 'OK', '', function () {
                            $('#modal').modal('hide');
                            if(response.data.type == 1){
                                $('#check'+response.data.id).removeClass('font-active-none');
                                $('#times'+response.data.id).addClass('font-active-none');

                                $('#btnCheck'+response.data.id).removeClass('font-active-none');
                                $('#btnTimes'+response.data.id).addClass('font-active-none');

                                $('#imgStatus'+response.data.id).removeClass('fas fa-times');
                                $('#imgStatus'+response.data.id).addClass('fas fa-check');

                                $('#table'+response.data.id).removeClass('danger');
                            }else{
                                $('#check'+response.data.id).addClass('font-active-none');
                                $('#times'+response.data.id).removeClass('font-active-none');

                                $('#btnTimes'+response.data.id).prop( "disabled", false );

                                $('#imgStatus'+response.data.id).removeClass('fas fa-check');
                                $('#imgStatus'+response.data.id).addClass('fas fa-times');


                                $('#btnCheck'+response.data.id).addClass('font-active-none');
                                $('#btnTimes'+response.data.id).removeClass('font-active-none');

                                $('#table'+response.data.id).addClass('danger');
                            }

                        });
                        this.$refs.modal.show();
                    } else {
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