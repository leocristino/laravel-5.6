@extends('base_layouts.master')
@section('content')
    <head>
        <link rel="shortcut icon" type="image/png" href="{{asset('images/favicon2.png')}}"/>
    </head>
    <section class="content-header">
        <h1>Leitura de arquivo</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">


                    <div class="box-body">

                        <form method="POST" @submit.prevent="submit">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="" v-model="form.data.id">

                            <div class="col-md-12">




                                <div class="form-group col-md-12">
                                    <label>Arquivo do Retorno</label>
                                    <input type="file" class="form-control input-file" style="height: auto !important;" @change="onFileChange($event)" maxlength="200"/>
                                </div>
                                {{--<div v-if="form.data.profile_image != null && image == ''" class="form-group col-md-12">--}}
                                    {{--<img class="formt-image" :src="form.data.image_way" onerror="if (this.src != '../images/sem-image.png') this.src = '../images/sem-image.png';"/>--}}
                                {{--</div>--}}
                                {{--<div v-if="image" class="form-group col-md-12">--}}
                                    {{--<img class="formt-image" :src="image" onerror="if (this.src != '../images/sem-image.png') this.src = '../images/sem-image.png';"/>--}}
                                {{--</div>--}}
                                <input type="hidden" name="name_file" value="" v-model="form.data.name_file">



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