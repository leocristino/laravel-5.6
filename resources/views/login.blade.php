@extends('base_layouts.base')

@section('main')
    <div class="login-box">
        <div class="login-logo text-center">
            <img src="{{asset('images/logotatical.png')}}" alt="Aloha Viagens" style="max-height: 120px">
        </div><!-- /.login-logo -->
        <div class="login-box-body">

            <p class="login-box-msg">Sistema Administrativo Tatical</p>
            <form @submit.prevent="submit_form(this)">

                {{csrf_field()}}

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="E-mail" name="email" v-model="form.data.email" ref="email" autofocus required/>
                    <span class="fa fa-user form-control-feedback"></span>
                    <span class="help is-danger" v-if="form.errors.has('email')">@{{form.errors.get('email')}}</span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Senha" name="password" v-model="form.data.password" required/>
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                    </div><!-- /.col -->
                </div>
            </form>

        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

@endsection