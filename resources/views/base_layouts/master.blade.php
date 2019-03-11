@extends('base_layouts.base')

@section('main')
    @include('base_layouts.header')

    @include('base_layouts.menu')

    <div class="content-wrapper">

        {{--<section class="content-header">
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>--}}

        <section class="content container-fluid">

            @yield('content')

        </section>

    </div>

    @include('base_layouts.footer')

@endsection