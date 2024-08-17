<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Confirmación</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .code-section {
            background-color: #f2f2f2;
            padding: 15px;
            text-align: center;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Instituto Universitario De Estudios México</h1>
            <h2>CÓDIGO DE CONFIRMACIÓN</h2>
        </div>
        <p>¡Saludos!</p>
        <p>Has recibido este correo electrónico porque estás a punto de confirmar tu dirección de correo electrónico.</p>
        <div class="code-section">
            <p>El código para validar tu dirección de correo electrónico es el siguiente:</p>
            <p class="code">{{$codigo}}</p>
            <p>No compartas este código con nadie. Este código es confidencial y se utiliza para asegurarnos de que la dirección de correo electrónico proporcionada te pertenece.</p>
        </div>
        <p>Si no solicitaste esta confirmación, puedes ignorar este correo electrónico. Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>
        <p>Gracias por ser parte de nuestra comunidad.</p>
        <div class="footer">
            <p>Atentamente,<br>El Instituto Universitario De Estudios México</p>
        </div>
    </div>
</body>
</html>
