<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('Connexion') }}</title>
        <link rel="icon" href="{{ asset('img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
        <link rel="stylesheet" href="{{ asset('style-login/style.css') }}">
        <link rel="stylesheet" href="{{ asset('style-login/style1.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    </head>
    <body>

        <!-- partial:index.partial.html -->
        @include('frontend.auth.layouts.main')
        <!-- partial -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script  src="{{ asset('style-login/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{ __($error) }}');
        @endforeach  
        @endif

        @if (session('success'))
            toastr.success('{{ __(session('success')) }}');
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');

            togglePassword.addEventListener('click', function () {
                // Alterner le type du champ entre "password" et "text"
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Alterner l'icône entre l'œil ouvert et fermé
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
            const registerPasswordField = document.getElementById('register_password');

            toggleRegisterPassword.addEventListener('click', function () {
                const type = registerPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
                registerPasswordField.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            const toggleRegisterPasswordConfirmation = document.getElementById('toggleRegisterPasswordConfirmation');
            const registerPasswordConfirmationField = document.getElementById('register_password_confirmation');

            toggleRegisterPasswordConfirmation.addEventListener('click', function () {
                const type = registerPasswordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
                registerPasswordConfirmationField.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
    <script>
        document.querySelector('form').addEventListener('submit', function () {
            this.querySelector('.spinner').style.display = 'inline-block';
        });

        document.querySelector('button[type="submit"]').addEventListener('click', function () {
            this.querySelector('.spinner').style.display = 'inline-block';
        });
    </script>
    </body>
</html>
