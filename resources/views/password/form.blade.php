@extends('base_layouts.master')
@section('content')
    <head>
        <link rel="shortcut icon" type="image/png" href="{{asset('images/favicon2.png')}}"/>
    </head>
    <section class="content-header">
        <h1>Mudar Senha - {{auth()->user()->user}} </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">

                        <form method="POST" @submit.prevent="submit_form">
                            {{csrf_field()}}

                            <div class="col-md-12">

                                <div class="form-group col-md-4">
                                    <label>Senha atual</label>
                                    <input type="password"  v-model="form.data.password" class="form-control"  maxlength="50" required/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Nova senha</label>
                                    <input type="password" v-model="form.data.new_password" class="form-control"  maxlength="50" required/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Confirme a senha</label>
                                    <input type="password" v-model="form.data.confirm_password" class="form-control" maxlength="50" required/>
                                </div>

                                <div class="clearfix">
                                    <div class="form-group col-md-6">
                                        <button type="button" class="btn btn-default btn-block" onclick="history.back(-1)">Cancelar</button>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection