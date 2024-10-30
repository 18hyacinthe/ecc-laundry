<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <title>{{ __('Connexion') }}</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
        <link rel="stylesheet" href="{{ asset('style-login/style.css') }}">
        <link rel="stylesheet" href="{{ asset('style-login/style1.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    </head>
    <body>

        <!-- partial:index.partial.html -->
        @include('frontend.auth.layouts.main')
        <!-- partial -->


    <script  src="{{ asset('style-login/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
              toastr.error('{{ $error }}');
            @endforeach  
        @endif
    </script>

    </body>
</html>
