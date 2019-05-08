@extends('base_layouts.base')

@section('main')
    <div class="login-box">
        <div class="login-logo text-center">
            <img src="{{asset('images/logotatical.png')}}" alt="Tatical Monitoramento" style="max-height: 120px">
        </div><!-- /.login-logo -->
        <div class="login-box-body">

            <h3 align="center">Conta corrente não configurada!!!</h3>
            <br>

            <a onclick="history.back(-1)">
                <button type="button" class="btn btn-block btn-warning">VOLTAR</button>
            </a>

        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

@endsection