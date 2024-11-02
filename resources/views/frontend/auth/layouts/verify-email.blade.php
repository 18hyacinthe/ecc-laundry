<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification de mail</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');
        body {
            background-image: radial-gradient(circle at 67% 83%, rgba(69,234,100, 0.05) 0%, rgba(69,234,100, 0.05) 1%,transparent 1%, transparent 5%,transparent 5%, transparent 100%),radial-gradient(circle at 24% 80%, rgba(69,234,100, 0.05) 0%, rgba(69,234,100, 0.05) 27%,transparent 27%, transparent 63%,transparent 63%, transparent 100%),radial-gradient(circle at 23% 5%, rgba(69,234,100, 0.05) 0%, rgba(69,234,100, 0.05) 26%,transparent 26%, transparent 82%,transparent 82%, transparent 100%),radial-gradient(circle at 21% 11%, rgba(69,234,100, 0.05) 0%, rgba(69,234,100, 0.05) 35%,transparent 35%, transparent 45%,transparent 45%, transparent 100%),radial-gradient(circle at 10% 11%, rgba(69,234,100, 0.05) 0%, rgba(69,234,100, 0.05) 21%,transparent 21%, transparent 81%,transparent 81%, transparent 100%),radial-gradient(circle at 19% 61%, rgba(69,234,100, 0.05) 0%, rgba(69,234,100, 0.05) 20%,transparent 20%, transparent 61%,transparent 61%, transparent 100%),radial-gradient(circle at 13% 77%, rgba(69,234,100, 0.05) 0%, rgba(69,234,100, 0.05) 63%,transparent 63%, transparent 72%,transparent 72%, transparent 100%),radial-gradient(circle at 30% 93%, rgba(69,234,100, 0.05) 0%, rgba(69,234,100, 0.05) 33%,transparent 33%, transparent 82%,transparent 82%, transparent 100%),linear-gradient(90deg, rgb(22, 176, 207),rgb(11,69,112));
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .logo-container img {
            transition: transform 0.3s ease;
        }
        .logo-container img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-sm" style="max-width: 500px; width: 100%;">
            <div class="logo-container text-center mb-4">
                <img src="{{ asset('img/logo/image.png') }}" alt="Logo" class="logo" style="max-width: 120px;">
            </div>

            <h2 class="text-center text-dark mb-4"><strong>{{ __('Vérifiez votre adresse email') }}</strong></h2>

            <div class="message text-center text-muted mb-4">
                {{ __('Merci pour votre inscription! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer. Si vous n\'avez pas reçu l\'email, nous vous en enverrons un autre.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="status-message text-center text-success font-weight-bold mb-4">
                    {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse email fournie lors de l\'inscription.') }}
                </div>
            @endif

            <div class="d-flex justify-content-center gap-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        {{ __('Renvoyer l\'email de vérification') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary ml-2">
                        {{ __('Se déconnecter') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
