<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .error-code {
            font-size: 3rem;
            margin: 0;
        }

        .error-message {
            font-size: 1.5rem;
            margin: 1rem 0;
        }

        .back-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">Error :(</h1>
        <p class="error-message">Lo sentimos, ha ocurrido un error con su petición</p>
        <p>Por favor, inténtelo de nuevo <a class="back-link" href="{{ back()->getTargetUrl() }}"">regresar</a>.</p>
        <p>Si el error continúa, consulte a los desarrolladores :v</p>
    </div>
</body>
</html>
