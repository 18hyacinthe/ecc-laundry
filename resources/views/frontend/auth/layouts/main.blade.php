<div class="container" id="container">
    <div class="form-container sign-up-container">
        <div class="logo-container" style="text-align: center; margin-bottom: -70px;margin-top: 5px">
            <img src="{{ asset('img/logo/image.png') }}" alt="Logo" class="logo" style="max-width: 100px;">
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h2>{{ __('Créer un compte') }}</h2>
            <input type="text" name="name" placeholder="{{ __('Nom') }}" value="{{ old('name') }}" />
            <input type="text" name="surname" placeholder="{{ __('Prénom') }}" value="{{ old('prenom') }}" />
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" />
            <input id="password" type="password" name="password" placeholder="{{ __('Mot de passe') }}" />
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="{{ __('Confirmer le mot de passe') }}" />
            <button type="submit">{{ __('S\'inscrire') }}</button>
        </form>
    </div>
    
    <div class="form-container sign-in-container">
        <div class="logo-container" style="text-align: center; margin-bottom: -100px;margin-top: 5px">
            <img src="{{ asset('img/logo/image.png') }}" alt="Logo" class="logo" style="max-width: 100px;">
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1 style="margin-bottom: 10px">{{ __('Se connecter') }}</h1>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" />
            <input id="password" type="password" name="password" placeholder="{{ __('Mot de passe') }}" />
            <button type="submit">{{ __('Se connecter') }}</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>{{ __('Revenez !') }}</h1>
                <br>
                <div class="loader"></div>
                <br>
                <p>{{ __('Connectez-vous pour réserver votre session!') }}</p>
                <button class="ghost" id="signIn">{{ __('Se connecter') }}</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>{{ __('Bienvenue !') }}</h1>
                <br>
                <div class="loader"></div>
                <br>
                <p>{{ __('Inscrivez-vous et réservez!') }}</p>
                <button class="ghost" id="signUp">{{ __('S\'inscrire') }}</button>
            </div>
        </div>
    </div>
</div>