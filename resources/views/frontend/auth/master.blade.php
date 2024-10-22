<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
        <link rel="stylesheet" href="{{ asset('style-login/style.css') }}">
        <link rel="stylesheet" href="{{ asset('style-login/style1.css') }}">


    </head>
    <body>

        <!-- partial:index.partial.html -->
        @include('frontend.auth.layouts.main')
        <!-- partial -->


    <script  src="{{ asset('style-login/script.js') }}"></script>

    </body>
</html>
