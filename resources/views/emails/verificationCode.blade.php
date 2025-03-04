<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación</title>
</head>
<body>
    <h1>Hola, {{ $user->name }}</h1>
    <p>Tu código de verificación es: <strong>{{ $code }}</strong></p>
    <p>Por favor, ingresa este código en la aplicación para completar la verificación.</p>
    <p>Si no solicitaste este código, ignora este mensaje.</p>
</body>
</html>