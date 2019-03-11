<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}}</title>

    <base href="{{URL::to('/')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" type="image/png" href="{{asset('images/logotatical.png')}}"/>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <script>
        window.baseUrl = '{{ URL::to('/') }}';
        // {{--{{ was converting & into &amp; }}--}}
        window.previousUrl = '<?= URL::previous() ?>';
    </script>
</head>

<body class="hold-transition skin-black sidebar-mini" view-name="{{$view_name}}">

<div class="wrapper" id="app">

    <Modal ref="modal"></Modal>

    <div class="loading" v-show="form && form.loading"></div>

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('main')

</div>


<!-- REQUIRED JS SCRIPTS -->
<script src="{{asset('js/app.js')}}?{{config('app.version')}}"></script>

</body>
</html>