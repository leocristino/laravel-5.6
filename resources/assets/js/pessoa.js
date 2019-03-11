import Form from './core/Form';
import Modal from './components/Modal.vue';
import { BasicSelect } from 'vue-search-select'

if ($('body[view-name="pessoaform"]').length > 0) {
    window.vue = new Vue({
        el: '#app',
        components: {
           Modal,BasicSelect
        },
        data: {
            form: new Form(),
            modal: Modal,
            cidadeSelected: {},
            cidades: [],
            cpf_cnpj_mask: '',

            cb_geral_tipo_pessoa: undefined,
            tipos_pessoa: [],

            instituicao: {},
            instituicaoSelected: {},
            instituicoes:[],
            cidadeInstituicaoSelected: {},
            cidadesInstituicao: [],

            masktelefone1: "(##) #####-####",
            masktelefone2: "(##) #####-####",
            masktelefone3: "(##) #####-####"
        },
        mounted() {
            this.changeUf();
            this.updateFormTipoPessoa();
        },
        updated(){

        },
        watch: {
            'form.data.tipo': function(_new, old){
                this.cpf_cnpj_mask = this.form.data.tipo == 'F' ? '###.###.###-##' : '##.###.###/####-##';

                if(old != undefined) {
                    //se trocar o tipo, limpa o cpf/cnpj
                    this.form.data.cpf_cnpj = '';

                    this.updateFormTipoPessoa();
                }
            },
            
            'form.data.pessoa_tipo_pessoa': function () {
                this.updateFormTipoPessoa();
            },


            'form.data.telefone1': function (val) {
                if(val != "") {
                    if (val != null && val.length > 1) {
                        if (val.length == 15) {
                            this.masktelefone1 = "(##) #####-####";
                        } else {
                            this.masktelefone1 = "(##) ####-####";
                        }
                    }
                }
            },

            'form.data.telefone2': function (val) {
                if(val != "") {
                    if (val != null && val.length > 1 && val != "") {
                        if (val.length == 15) {
                            this.masktelefone2 = "(##) #####-####";
                        } else {
                            this.masktelefone2 = "(##) ####-####";
                        }
                    }
                }
            },

            'form.data.telefone3': function (val) {
                if(val != "(") {
                    if (val != null && val.length > 1 && val != "") {
                        if (val.length == 15) {
                            this.masktelefone3 = "(##) #####-####";
                        } else {
                            this.masktelefone3 = "(##) ####-####";
                        }
                    }
                }
            },

        },
        methods: {
            findCep(){
                let thisCopy = Object.assign({} , this);

                this.form.get('/cep/cep', {cep: this.form.data.cep}, function(response){
                    thisCopy.form.data.logradoro = response.data[0].logradouro;
                    thisCopy.form.data.id_cidade= response.data[0].cidade_codigo;
                    thisCopy.form.data.cidade= response.data[0].cidade;
                    thisCopy.form.data.bairro = response.data[0].bairro;
                    if(thisCopy.form.data.uf != response.data[0].uf) {
                        thisCopy.form.data.uf = response.data[0].uf;
                        thisCopy.changeUf();
                    }

                    if(thisCopy.form.data.bairro == null || thisCopy.form.data.bairro == ''){
                        thisCopy.$refs.bairro.focus();
                    }else{
                        thisCopy.$refs.numero.focus();
                    }
                });
            },

            changeUf(){
                let thisCopy = Object.assign({} , this);
                let uf = this.form.data.uf == undefined ? 'SP' : this.form.data.uf;

                this.form.get('/cep/cidades', {uf: uf}, function(response){
                    thisCopy.setCidades(response.data);
                });
            },

            setCidades(cidades){
                this.cidades = cidades;
                this.cidadeSelected = util.findInArrayObject('value', this.form.data.id_cidade, cidades);
            },

            onSelectCidade(item){
                this.cidadeSelected = item;
                this.form.data.id_cidade = item.value;
                this.form.data.cidade = item.text;
            },

            //pesquisa da instituição
            changeUfInstituicao(){
                let thisCopy = Object.assign({} , this);
                let uf = this.instituicao.uf == undefined ? 'SP' : this.instituicao.uf;

                this.form.get('/cep/cidades', {uf: uf}, function(response){
                    thisCopy.setCidadesInstituicao(response.data);
                });
            },

            setCidadesInstituicao(cidades) {
                this.cidadesInstituicao = cidades;

                try {
                    this.cidadeInstituicaoSelected = util.findInArrayObject('value', this.instituicao.id_cidade, cidades);
                    this.onSelectCidadeInstituicao(this.cidadeInstituicaoSelected);
                }catch (e){
                    console.log(e);
                }
            },

            onSelectCidadeInstituicao(item){
                let thisCopy = Object.assign({} , this);
                this.cidadeInstituicaoSelected = item;

                this.form.get('/cb_geral_instituicao/find', {id_cidade: item.value}, function(response){
                    thisCopy.setInstituicoes(response.data);
                });
            },

            setInstituicoes(instituicoes){
                this.instituicoes = instituicoes;
                this.instituicaoSelected = util.findInArrayObject('value', this.instituicao.id, instituicoes);
            },

            onSelectInstituicao(item){
                this.instituicaoSelected = item;
                this.form.data.id_cb_geral_instituicao = item.value;
            },

            setInstituicao(data){
                if(this.instituicao.uf == undefined){
                    if(data != undefined && data != null){
                        this.instituicao = data;
                        this.changeUfInstituicao();
                        this.instituicaoSelected = {value: data.id, text: data.nome};
                    }
                }
            },

            //tipos de pessoa
            setCbGeralTipoPessoa(data){
                if(this.cb_geral_tipo_pessoa == undefined){
                    if(data == null){
                        this.cb_geral_tipo_pessoa = [];
                    }else{
                        this.cb_geral_tipo_pessoa = data;
                    }
                }
            },

            updateFormTipoPessoa(){
                //transforma todos os ids em numero
                for(var i = 0; i < this.form.data.pessoa_tipo_pessoa.length; i++){
                    this.form.data.pessoa_tipo_pessoa[i] = parseInt(this.form.data.pessoa_tipo_pessoa[i]);
                }

                //console.log(this.form.data.pessoa_tipo_pessoa);
                this.tipos_pessoa = [];
                for(var i = 0; i < this.cb_geral_tipo_pessoa.length; i++){
                    var id = this.cb_geral_tipo_pessoa[i].id;
                    var tipo = this.cb_geral_tipo_pessoa[i].tipo;

                    //verifica se é pessoa juridica - não pode ser passageiro
                    if(this.form.data.pessoa_tipo_pessoa.indexOf(id) !== -1 && tipo == 'P' && this.form.data.tipo == 'J'){
                        this.form.data.pessoa_tipo_pessoa.pop(this.form.data.pessoa_tipo_pessoa.indexOf(id));
                    }

                    if(this.form.data.pessoa_tipo_pessoa.indexOf(id) !== -1 && this.tipos_pessoa.indexOf(tipo) === -1){
                        this.tipos_pessoa.push(tipo);
                    }
                }
            },

            submit_form() {
                let url = '/pessoa';
                this.form.submit(url, this.onSuccess);
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