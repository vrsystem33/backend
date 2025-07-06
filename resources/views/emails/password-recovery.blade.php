{{-- @var string $url --}}
@component('mail::message')
# Recuperação de Senha

Você solicitou a recuperação da sua senha.

Clique no botão abaixo para redefinir:

@component('mail::button', ['url' => $url])
Redefinir Senha
@endcomponent

Se você não solicitou, ignore este e-mail.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
