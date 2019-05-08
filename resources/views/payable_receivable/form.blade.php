@extends('base_layouts.master')

@section('content')
    <section class="content-header">
        <?php
//            echo $ticket[0]->type;
//            echo $ticket;
            if($ticket[0]->type == 'R')
                $type = 'Receita';
            else
                $type = 'Despesa';
            ?>
        <h1>{{$type}} [ @{{ form.data.id == undefined ? 'Novo' : form.originalData.id }} ]</h1>
{{--            {{$data}}--}}
            @if($data->payment_date == '')
                <div align="right" id="printBill">
                    <a target="_blanck" href="{{ route('download',[md5($data['id'])])}}">
                        <button title="Imprimir boleto" class="btn btn-small btn-default"><i class="fas fa-print"></i></button>
                    </a>
                </div>
            @endif

            @if($data->payment_date == '' AND $data->payment_date == null)
                <div align="right" id="printCheque">
                    <a target="_blanck" href="{{ route('print_check',[md5($data['id'])])}}">
                        <button title="Imprimir cheque" class="btn btn-small btn-default"><i class="fas fa-print"></i></button>
                    </a>
                </div>
            @endif
        {{--<br><br>{{$data}}<br><br>--}}
{{--        {{$payment_type}}--}}
    </section>
    <section class="content" :json="[form.setData({{ $data }}), objPayment_Type = {{ $payment_type }}]">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">


                    <div class="box-body">

                        <form method="POST" id="account_recevaible" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div id="formFields">

                                <div class="form-group col-md-4">
                                    <label >Pessoa</label>
                                    <select name="" id="" v-model="form.data.id_person" class="form-control" required>
                                        <option value="">Selecione</option>
                                        @foreach($person as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_social_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label >Plano de Contas</label>
                                    <select name="" id="" v-model="form.data.id_ticket" class="form-control" required>
                                        <option value="">Selecione</option>
                                        @foreach($ticket as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label >Forma de Pagamento</label>
                                    <select name="" id="" v-model="form.data.id_payment_type" @change="verifyPaymentType_OnChange()" class="form-control" required>
                                        <option value="">Selecione</option>
                                        @foreach($payment_type as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label >Conta Corrente</label>
                                    <select name="" id="" v-model="form.data.id_bank_account" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($bank_account as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label >Descrição</label>
                                    <input type="text" class="form-control" v-model="form.data.description" maxlength="255"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label >Data de Vencimento</label>
                                    <datepicker lang="pt-br" format="dd/MM/yyyy" readonly="true" :editable="true" width="100%" input-class="form-control" required
                                                input-name="due_date" v-model="form.data.due_date" />
                                </div>

                                <div class="form-group col-md-4">
                                    <label >Valor a Pagar</label>
                                    <money class="form-control" v-model="form.data.value_bill" prefix="R$ " decimal="," thousands="." required />
                                </div>

                                <div class="form-group col-md-4">
                                    <label >Data do Pagamento</label>
                                    <datepicker lang="pt-br" format="dd/MM/yyyy" readonly="true" :editable="true" width="100%" input-class="form-control"
                                                 input-name="payment_date" v-model="form.data.payment_date" />
                                </div>

                                <div class="form-group col-md-4">
                                    <label >Valor Pago</label>
                                    <money class="form-control" v-model="form.data.amount_paid" prefix="R$ " decimal="," thousands="." />
                                </div>
                                
                                <div class="form-group col-md-12" id="chq" style="display: none;">
                                    <fieldset>
                                        <legend>Dados do cheque</legend>
                                        <div class="form-group col-md-4">
                                            <label >Banco</label>
                                            <input type="text" class="form-control" v-model="form.data.chq_bank" maxlength="11"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label >Agência</label>
                                            <input type="text" class="form-control" v-model="form.data.chq_agency" maxlength="255"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label >Conta Corrente</label>
                                            <input type="text" class="form-control" v-model="form.data.chq_current_account" maxlength="255"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label >Número</label>
                                            <input type="text" class="form-control" v-model="form.data.chq_number" maxlength="255"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label >Motivo da Devolução</label>
                                            <input type="text" class="form-control" v-model="form.data.chq_reason_return" maxlength="255"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label >Data da Devolução</label>
                                            <datepicker lang="pt-br" format="dd/MM/yyyy" readonly="true" :editable="true" width="100%" input-class="form-control"
                                                        input-name="chq_date_return" v-model="form.data.chq_date_return" />
                                        </div>

                                    </fieldset>
                                </div>
                                @if($type == 'Receita')
                                    <div class="form-group col-md-6">
                                        <label >Descrição do retorno</label>
                                        <input type="text" readonly class="form-control" v-model="form.data.description_bank_return" maxlength="255"/>
                                    </div>
                                @endif



                                <div class="form-group col-md-12">
                                    <hr>
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
