@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <h1>Conta corrente [ @{{ form.data.id == undefined ? 'Novo' : form.originalData.name }} ]</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="hidden">
                        @{{ form.setData(<?= $data ?>) }}
                        @{{ selectBank(<?= $banks ?>) }}

                    </div>

                    <div class="box-body">

                        <form method="POST" id="person" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div id="formFields">
                                <div class="form-group col-md-6">
                                    <label >Nome</label>
                                    <input type="text" class="form-control" v-model="form.data.name" required maxlength="200"/>
                                </div>

                                <div class="form-group col-md-6">
                                    <label >Banco</label>
                                    <basic-select :options="bank"
                                                  :selected-option="bankSelected"
                                                  placeholder="Selecione ou digite"
                                                  @select="onSelectBank"
                                                 >
                                    </basic-select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label >Agência</label>
                                    <input type="text" class="form-control" v-model="form.data.agency" required maxlength="50"/>
                                </div>

                                <div class="form-group col-md-3">
                                    <label >Conta Corrente</label>
                                    <input type="text" class="form-control" v-model="form.data.account_current" required maxlength="200"/>
                                </div>

                                <div class="form-group col-md-3">
                                    <label >Saldo Inicial</label>
                                    <money class="form-control" v-model="form.data.current_balance" prefix="R$ " decimal="," thousands="." required />
                                </div>

                                <div class="form-group col-md-3">
                                    <label >Data do Saldo</label>
                                    <datepicker lang="en" format="dd/MM/yyyy" :editable="true" width="100%" input-class="form-control" required input-name="data_saida" v-model="form.data.balance_date"/>
                                </div>

                                <div class="form-group col-md-12">
                                    <fieldset>
                                        <legend>Informações para emissão de boleto</legend>

                                        <div class="form-group col-md-2">
                                            <label >Emite Boleto</label>
                                            <select class="form-control" v-model="form.data.bill_option">
                                                <option value="">Selecione uma opção</option>
                                                <option value="S">SIM</option>
                                                <option value="N">NÃO</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label >Carteira</label>
                                            <input type="text" class="form-control" v-model="form.data.wallet" required maxlength="50"/>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label >Cód. Especial</label>
                                            <input type="text" class="form-control" v-model="form.data.special_code" required maxlength="50"/>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Convênio (Perfil/Cód. Beneficiário)</label>
                                            <input type="text" class="form-control" v-model="form.data.pact" required maxlength="50"/>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label >Cód. Transmissão</label>
                                            <input type="text" class="form-control" v-model="form.data.transmission_code" required maxlength="50"/>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label >Complemento</label>
                                            <input type="text" class="form-control" v-model="form.data.complement" required maxlength="50"/>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label >Local de Pagto</label>
                                            <input type="text" class="form-control" v-model="form.data.local_pay" required maxlength="50"/>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label >Instrução</label>
                                            <input type="text" class="form-control" v-model="form.data.instruction" required maxlength="50"/>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label >Quem emite o Boleto?</label>
                                            <select class="form-control" v-model="form.data.who_send_ticket">
                                                <option value="">Selecione uma opção</option>
                                                <option value="Banco">Banco</option>
                                                <option value="Tatical">Tatical</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label >Valor de Emissão</label>
                                            <money class="form-control" v-model="form.data.price_of_send" prefix="R$ " decimal="," thousands="." required />
                                        </div>



                                    </fieldset>
                                </div>

                                <div class="form-group col-md-12">
                                    <hr>
                                    <label><input type="checkbox" class="form-check-input" v-model="form.data.active" value="S"> Ativo</label>
                                </div>

                            </div>

                            <div class="clearfix">
                                <div class="form-group col-md-6">
                                    <button type="button" class="btn btn-default btn-block" onclick="history.back(-1)">Cancelar</button>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
