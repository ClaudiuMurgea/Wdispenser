<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="{{ asset('css/coreui.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/coreui-style.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" integrity="sha512-n+g8P11K/4RFlXnx2/RW1EZK25iYgolW6Qn7I0F96KxJibwATH3OoVCQPh/hzlc4dWAwplglKX8IVNVMWUUdsw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        
    <title>{{ config('app.name', 'CMS Web') }}</title>
    {{--    @livewireStyles--}}
</head>
<body class="c-app">
    <div class="hidden" id="app-overlay">
        <div class='uil-ring-css' style='transform:scale(0.79);'>
          <div></div>
        </div>
    </div>
    @include('partials.sidebar')
    @include('partials.topnav')
</body>

<!-- Optional JavaScript -->
<!-- Popper.js first, then CoreUI JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/coreui.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/coreui-utils.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

{{--@livewireScripts--}}
@yield('scripts')
<script type="text/javascript">
    function showLoadingOverlay(){
        $( "#app-overlay" ).removeClass( "hidden" ).addClass( "loading" );
    }

    function hideLoadingOverlay(){
        $( "#app-overlay" ).removeClass( "loading" ).addClass( "hidden" );
    }

    @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif
</script>
</body>
</html>
