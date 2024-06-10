<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UNI-CHECK</title>
</head>
<body>
    <h1>Récupération de compte</h1>
    <p> Salut {{ $mailData['username'] }},</p>
    <div>
        Mot de passe oublié?
        Nous avions reçu une requête de changement de mot de passe pour votre compte

        Pour mettre à jour votre mot de passe, cliquez sur le bouton ci-dessous:
    </div>
    <a href="{{ route('reset-password', $mailData['token']) }}">Changer mon mot de passe</a>
    <div>
        Cordialement, {{ config('app.name') }}
    </div>
</body>
</html>
