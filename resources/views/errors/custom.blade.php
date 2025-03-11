<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error {{ $code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-danger text-white">
                        <h3>¡Error {{ $code }}!</h3>
                    </div>
                    <div class="card-body text-center">
                        <p><strong>Mensaje:</strong> {{ $message }}</p>
                        <div class="mt-3">
                            <a href="{{ $redirect ?? url('/') }}" class="btn btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
