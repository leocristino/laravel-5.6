<!DOCTYPE html>
<html>
<head>
    <title>Aloha Viagens</title>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
</head>
<body>

<table width="500" align="center" style="margin: 50px auto;font-family: arial;">
    <tr>
        <td style="text-align: center">
            {{--<img src="{{url('img/logo_home.png')}}" style="width: 150px">--}}
            <img src="http://sistema.alohaviagens.com.br/images/logoaloha.png" style="width: 150px">
        </td>
    </tr>
    <tr>
        <td>
            <div style="height: 1px; background: #ccc; margin: 0px 0px 0 0px"></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 0 15px 0; text-align: center; ">
            <div style="font-weight: bold; font-size: 25px; color: #444">{{$titulo or ''}} </div>
        </td>
    </tr>
    <tr>
        <td>
            <div style="height: 1px; background: #ccc; margin: 0px 0px 0 0px"></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 15px 0">
            <div style="font-size: 14px; color: #888888">Mensagem:</div>
            <div style="color: #444; font-size: 12px">{{$mensagem or ''}}</div>
        </td>
    </tr>
    <tr>
        <td style="padding: 15px 0">
            <div style="font-size: 14px; color: #888888">Link:</div>
            <div style="color: #444; font-size: 12px"><a href="{{$link or ''}}" target="_black"> sistema.alohaviagens.com.br</div>
        </td>
    </tr>
    <tr>
        <td>
            <div style="height: 1px; background: #ccc; margin: 15px 30px 0 30px"></div>
        </td>
    </tr>

</table>

</body>
</html>