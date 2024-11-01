<!-- resources/views/emails/verifyUserMail.blade.php -->

@component('mail::message')
# {{ __('Vérifiez votre adresse e-mail') }}

{{ __('Cliquez sur le bouton ci-dessous pour vérifier votre adresse e-mail.') }}

@component('mail::button', ['url' => $url])
{{ __('Vérifiez votre adresse e-mail') }}
@endcomponent

{{ __('Si vous n\'avez pas créé de compte, aucune autre action n\'est requise.') }}

{{ __('Merci,') }}<br>
{{ config('app.name') }}
@endcomponent