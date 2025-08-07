<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login {{ $title ?? config('app.name') }}</title>
    @include('components.layouts.style')
    @php
        $x = App\Models\Setting::where('id',1)->first();
        if($x)
        {
            $background = 'storage/'.$x->logo_login;
        }else{
            $background = '';
        }
    @endphp

    <style>
        body {
            background-image: url({{$background}});
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            height: 100%;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        {{ $slot }}
    </div>
    @include('components.layouts.script')
</body>

</html>
