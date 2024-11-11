<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
        }
        p {
            color: #555555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #0c9683;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #066356;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour,</h1>
        <p>Voici vos informations de connexion :</p>
        <p><strong>Email :</strong> {{ $email }}</p>
        <p><strong>Mot de passe :</strong> {{ $password }}</p>
        <p>Veuillez vous connecter en utilisant les informations ci-dessus.</p>
        <a href="{{ url('/login') }}" class="button">Se connecter</a>
    </div>
</body>
</html>
