<!DOCTYPE html>
<html>
<head>
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
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
        }
        p {
            color: #666666;
            line-height: 1.6;
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
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour {{ $user->name }},</h1>
        <p>Merci de vous être inscrit sur notre plateforme.</p>
        <p>Votre compte nécessite une activation par un administrateur. Veuillez contacter l'administrateur pour activer votre compte.</p>
        <a href="mailto:agbehyavargas@gmail.com" class="button">Contacter l'administrateur</a>
        <p class="footer">Merci!</p>
    </div>
</body>
</html>
