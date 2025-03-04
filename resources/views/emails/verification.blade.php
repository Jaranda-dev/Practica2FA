<!DOCTYPE html>
<html>
<head>
    <title>Verifica tu correo electrónico</title>
</head>
<body>
    <h1>Hola, {{ $user->name }}</h1>
    <p>Por favor verifica tu correo electrónico haciendo clic en el siguiente enlace:</p>
    <a href="{{ $url }}">Verificar correo electrónico</a>
</body>
</html>