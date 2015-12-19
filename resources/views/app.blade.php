<!DOCTYPE HTML>
<html lang="zh-Hant-TW">
    <head>
        {{-- Metatag --}}
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Title --}}
        <title>@if (trim($__env->yieldContent('title'))) @yield('title') - @endif偽批吸轟</title>

        {{-- CSS --}}
        {!! Html::style('//maxcdn.bootstrapcdn.com/bootswatch/3.3.6/readable/bootstrap.min.css') !!}}
        {!! Html::style('//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') !!}
        @yield('css')
    </head>
    <body>
        {{-- Content --}}
        <div class="container-fluid">
            @yield('content')
        </div>

        {{-- js --}}
        {!! Html::script('//code.jquery.com/jquery-2.1.4.min.js') !!}
        {!! HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') !!}
        @yield('js')
    </body>
</html>
