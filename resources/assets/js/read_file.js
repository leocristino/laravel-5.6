import Form from './core/Form';
import Modal from './components/Modal.vue';
import Datepicker from "vue2-datepicker";
import {mask} from 'vue-the-mask'

if ($('body[view-name="invoices_nfsread_file"]').length > 0 ) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal, Datepicker,
        },
        data: {
            form: new Form(),
            modal: Modal,
            image: '',
            state: '',
            line_of_work: '',
            name_file: ''
        },
        mounted() {
            if(this.form.data.state != null){
                this.state = this.form.data.state;
            }

            if(this.form.data.id_line_of_work != null){
                this.line_of_work = this.form.data.id_line_of_work;
            }
        },
        updated(){
        },
        watch: {
        },
        methods: {
            //Para Salvar Imagem
            onFileChange(e) {
                var file = e.target.files || e.dataTransfer.files;

                //Pegar o nome do arquivo
                this.name_file = file[0].name;

                if (!file.length)
                    return;
                this.createFile(file[0]);
            },

            createFile(file) {
                //var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    //vm.image = e.target.result;
                    this.form.data.file_b64 = e.target.result;
                };

                reader.readAsDataURL(file);
            },

            submit(){
                // this.form.data.establishment_description = CKEDITOR.instances.establishment_description.getData();
                // this.form.data.state = this.state;
                // this.form.data.id_line_of_work = this.line_of_work;
                this.form.data.name_file = this.name_file;
                console.log(this.form.data.name_file);
                let url = window.baseUrl+'/read_file/reading';
                this.form.submit(url, this.onSuccess);
                $
            },

            onSuccess(response){
                try {
                    if (response.data.result == true) {
                        this.form.reset();

                        this.$refs.modal.configModal('Sucesso', response.data.msg, 'OK', '', function () {
                            window.location.href = window.baseUrl+'/read_file';
                        });
                        this.$refs.modal.show(2500);
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