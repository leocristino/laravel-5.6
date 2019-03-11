<template>
    <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{title}}</h4>
                </div>
                <div class="modal-body">
                    {{text}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" v-on:click="hide"   v-if="btn_cancel != ''">{{btn_cancel}}</button>
                    <button type="button" class="btn btn-primary" v-on:click="runConfirmFn"  v-if="btn_confirm != ''">{{btn_confirm}}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                title: 'title',
                text: 'text',
                btn_confirm: 'Confirm',
                btn_cancel: '',
                fn_confirm: function () {}
            }
        },
        mounted() {
        },
        methods:{
            configModal(title, text, btn_confirm, btn_cancel, fn_confirm){
                this.title = title;
                this.text = text;
                this.btn_confirm = btn_confirm;
                this.btn_cancel = btn_cancel;
                if(fn_confirm){
                    this.fn_confirm = fn_confirm;
                }
            },
            setConfirmFn(fn){
                this.fn_confirm = fn;
            },
            runConfirmFn(){
                try {
                    this.fn_confirm();
                }catch (e){
                    console.log(e);
                }
            },
            show (timeout) {
                $('#modal').modal('show');

                let thisCopy = Object.assign({} , this);
                if(!isNaN(timeout)){
                    setTimeout(function(){
                        thisCopy.runConfirmFn();
                    }, timeout);
                }
            },
            hide () {
                $('#modal').modal('hide');
            },
        }
    }
</script>


