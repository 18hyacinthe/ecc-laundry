<!-- resources/views/emails/verifyUserMail.blade.php -->
<style>
    .email-container {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
        border-radius: 10px;
        max-width: 600px;
        margin: auto;
    }
    .email-header {
        background-color: #0c9683;
        color: white;
        padding: 10px;
        border-radius: 10px 10px 0 0;
        text-align: center;
    }
    .email-body {
        background-color: white;
        padding: 20px;
        border-radius: 0 0 10px 10px;
    }
    .email-button {
        display: block;
        width: 200px;
        margin: 20px auto;
        padding: 10px;
        background-color: #0c9683;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
    }
    .email-footer {
        text-align: center;
        margin-top: 20px;
        color: #555;
    }
</style>

<div class="email-container">
    <div class="email-header">
        <h1>{{ __('Vérifiez votre adresse e-mail') }}</h1>
    </div>
    <div class="email-body">
        <p>{{ __('Cliquez sur le bouton ci-dessous pour vérifier votre adresse e-mail.') }}</p>
        <a href="{{ $url }}" class="email-button">{{ __('Vérifiez votre adresse e-mail') }}</a>
        <p>{{ __('Si vous n\'avez pas créé de compte, aucune autre action n\'est requise.') }}</p>
    </div>
    <div class="email-footer">
        <p>{{ __('Merci,') }}<br>{{ config('app.name') }}</p>
    </div>
</div>