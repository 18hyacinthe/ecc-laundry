<div class="container" id="container">
    <div class="form-container sign-up-container">
        <div class="logo-container" style="text-align: center; margin-bottom: -10px;">
            <img src="{{ asset('img/logo/image.png') }}" alt="Logo" class="logo" style="max-width: 100px;">
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>{{ __('Créer un compte') }}</h1>
            <input type="text" name="name" placeholder="{{ __('Nom') }}" value="{{ old('name') }}" />
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" />
            <input id="password" type="password" name="password" placeholder="{{ __('Mot de passe') }}" />
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="{{ __('Confirmer le mot de passe') }}" />
            <button type="submit">{{ __('S\'inscrire') }}</button>
        </form>
    </div>
    
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1>{{ __('Se connecter') }}</h1>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" />
            <input id="password" type="password" name="password" value="{{ old('password') }}" placeholder="{{ __('Mot de passe') }}" />
            <button type="submit">{{ __('Se connecter') }}</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>{{ __('Bon retour!') }}</h1>
                <br>
                <div class="loader"></div>
                <br>
                <p>{{ __('Pour rester connecté avec nous, veuillez vous connecter avec vos informations personnelles') }}</p>
                <button class="ghost" id="signIn">{{ __('Se connecter') }}</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>{{ __('Bonjour, ami!') }}</h1>
                <br>
                <div class="loader"></div>
                <br>
                <p>{{ __('Entrez vos informations personnelles et commencez votre voyage avec nous') }}</p>
                <button class="ghost" id="signUp">{{ __('S\'inscrire') }}</button>
            </div>
        </div>
    </div>
</div>