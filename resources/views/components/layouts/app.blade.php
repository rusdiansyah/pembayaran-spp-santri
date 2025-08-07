<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>
    @include('components.layouts.style')
    @include('components.layouts.script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <x-layouts.navbar></x-layouts.navbar>

        <x-layouts.sidebar></x-layouts.sidebar>
        <div class="content-wrapper">
            <x-layouts.content-header title="{{$title}}"></x-layouts.content-header>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <x-layouts.footer></x-layouts.footer>
    </div>

</body>

</html>
