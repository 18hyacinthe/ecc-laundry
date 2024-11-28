<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord des statistiques</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Tableau de bord des statistiques</h1>
    <table>
        <thead>
            <tr>
                <th>URL</th>
                <th>Nombre de visites</th>
                <th>Dernière visite</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pageViews as $view)
                <tr>
                    <td>{{ $view->url }}</td>
                    <td>{{ $view->views }}</td>
                    <td>{{ $view->last_visited }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
