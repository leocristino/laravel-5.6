<!DOCTYPE html>
<html>
<head>
    <title>{{  $title }}</title>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
</head>
<body>

<table width="500" align="center" style="margin: 50px auto;font-family: arial;">
    <tr>
        <td style="text-align: center">
            <img src="{{asset('images/logotatical.png')}}" style="width: 45px">
            {{--<img src="http://sistema.alohaviagens.com.br/images/logoaloha.png" style="width: 150px">--}}
        </td>
    </tr>
    <tr>
        <td>
            <div style="height: 1px; background: #ccc; margin: 0px 0px 0 0px"></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 0 15px 0; text-align: center; ">
            <div style="font-weight: bold; font-size: 25px; color: #444">{{$title or ''}} </div>
        </td>
    </tr>
    <tr>
        <td>
            <div style="height: 1px; background: #ccc; margin: 0px 0px 0 0px"></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 15px 0">
            <div style="color: #444; font-size: 12px">{{$message1}}</div>
            <br>
            <div style="color: #444; font-size: 12px">{{$message2}}</div>
            <div style="color: #444; font-size: 12px">{{$message3}}</div>
            <div style="color: #444; font-size: 12px">{{$message4}}</div>
            <br>
            <div style="color: #444; font-size: 12px">{{$message5}}<a href="{{$path or ''}}" target="_black">{{$message6}}</a></div>
            <br>
            <div style="color: #444; font-size: 12px">{{$bottom1}}</div>
            <div style="color: #444; font-size: 12px">{{$bottom2}}</div>

        </td>
    </tr>
    {{--<tr>--}}
        {{--<td style="padding: 15px 0">--}}
            {{--<div style="font-size: 14px; color: #888888">Link do boleto:</div>--}}
            {{--<div style="color: #444; font-size: 12px"><a href="{{$path or ''}}" target="_black"> taticalmonitoramento.com.br</div>--}}
        {{--</td>--}}
    {{--</tr>--}}
    <tr>
        <td>
            <div style="height: 1px; background: #ccc; margin: 15px 30px 0 30px"></div>
        </td>
    </tr>

</table>

</body>
</html>